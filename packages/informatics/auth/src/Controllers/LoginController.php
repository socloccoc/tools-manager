<?php

namespace Informatics\Auth\Controllers;

use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Informatics\Users\Models\User;
use URL;
use Session;
use Input;
use Redirect;
use Sentinel;
use Socialite;
use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Log;

class LoginController extends Controller
{
    /**
     *  Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $previousUrl = URL::previous();
        if (strpos($previousUrl, '/user/') !== false || strpos($previousUrl, '/logout') !== false || strpos($previousUrl, '/reset-password') !== false) {
            Session::forget('previousUrl');
        } else {
            Session::put('previousUrl', $previousUrl);
        }
        return view('auth::login.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $input = Input::only('username', 'password');

        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ], [
            'username.required' => 'Chưa nhập tài khoản',
            'username.exists' => 'Tài khoản không tồn tại',
            'password.required' => 'Chưa nhập mật khẩu'
        ]);
        try {
            // authentication
            Sentinel::authenticate($input, Input::has('remember'));
        } catch (NotActivatedException $e) {
            return Redirect::back()->withInput()->withErrors(array('User Not Activated.'));
        } catch (ThrottlingException $e) {
            return Redirect::back()->withInput()->withErrors(array('Your account has been suspended due to 5 failed attempts. Try again after 15 minutes.'));
        }
        // check for the login
        if (Sentinel::check()) {
            return $this->afterLoginProcess();
        } else {
            return Redirect::back()
                ->withInput()
                ->withErrors(array('Tài khoản hoặc mật khẩu không chính xác'));
        }
    }

    /**
     * Function to process the after login process
     * @return mixed
     */
    public function afterLoginProcess()
    {
        //setting user details in session
        $userRepo = new UserRepo();
        $userRepo->setUserDetailInSession();
        if (Session::has('previousUrl') && (URL::route('login-post') != Session::get('previousUrl'))) {
            $url = session::get('previousUrl');
            Session::forget('previousUrl');
            return Redirect::to($url);
        }
        if(PermissionHelper::isSuperAdmin()){
            return Redirect::intended('manager/admin');
        } elseif (PermissionHelper::isAgency()){
            return Redirect::intended('manager/user');
        }else{

        }
    }

    /**
     * Function to logout user
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        Sentinel::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return Redirect::to('/login');
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
            //->scopes($this->accessToken)
            ->redirect();
    }


    /**
     * Obtain the user information from provider.
     * @param $provider
     * @return mixed
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        $activeUserid = $authUser->id;
        if (!empty($activeUserid)) {
            $setUser = Sentinel::findById($activeUserid);
            Sentinel::login($setUser);
            return $this->afterLoginProcess();
        }
    }


    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param $user
     * @param $provider
     * @return mixed
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where($provider, $user->getId())->first();
        if ($authUser) {
            return $authUser;
        }
        $user = User::updateOrCreate([
            'email' => $user->getEmail(),
        ], [
            'name' => $user->getName(),
            $provider => $user->getId(),
            'avatar' => $user->getAvatar(),
            'username' => $user->getId() . '@' . $provider . '.com'
        ]);
        if (!empty($user->id)) {
            $getUserById = Sentinel::findById($user->id);
            $activation = Activation::create($getUserById);
            $checkActivate = Activation::exists($getUserById);
            $activationComplete = Activation::complete($getUserById, $checkActivate->code);
            $this->afterRegistrationProcess($user);
            return $user;
        }
    }

    public function afterRegistrationProcess($user) {
        $role = Sentinel::findRoleById(3);
        $role->users()->attach($user);
        // Save log
        Log::info('A user has been created', array('ItemID' => $user->id, 'Module' => 'Users'));
    }

}
