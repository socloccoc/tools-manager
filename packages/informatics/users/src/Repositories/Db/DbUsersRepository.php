<?php


namespace Informatics\Users\Repositories\Db;

use Informatics\Base\Repositories\Interfaces\BaseOperationsInterface;
use Informatics\Users\Models\User;
use Sentinel;
use DB;
use Session;

class DbUsersRepository implements BaseOperationsInterface
{
    public function insert($data)
    {
        // register user using Sentnel
        $user = Sentinel::registerAndActivate($data);
        return $user;
    }

    public function update($data, $id)
    {
        // Find the user using id
        $user = Sentinel::findById($id);
        // Update the user using Sentinel
        $users = Sentinel::update($user, $data);
        return $users;
    }

    public function delete($id)
    {
        $user = User::findOrNew($id);
        $user->delete();
        return 1;
    }

    public function find($id)
    {
        // Find the user
        $users = User::find($id);
        return $users;
    }

    /**
     * This function will be used to user Details in  session.
     *
     * @param void
     * @return void
     * @author Toinn
     */
    public function setUserDetailInSession()
    {
        //By default it will provide with the logged in user detail
        $userDetail = $this->getUserDetail();
        // incresase login count
        if (!empty($userDetail->roles)) {
            $userDetail->roles = explode(',', $userDetail->roles);
        }
        Session::put('userDetail', $userDetail);
    }

    /**
     * This function will be used to get user details.
     *
     * @param int $userId
     * @return array $userDetail
     * @author Toinn
     */
    public function getUserDetail($userId = 0)
    {
        if (!$userId) {
            $userId = Sentinel::getUser()->id;
        }
        $userDetail = DB::table('users')
            ->leftJoin('role_users as usrRoles', 'usrRoles.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'usrRoles.role_id')
            ->select('users.id', 'users.username', 'users.email', 'users.avatar as avatar', 'users.name as full_name', 'users.last_login',  DB::raw('group_concat(distinct roles.slug) as roles'), 'roles.id as role_id', 'users.created_at')
            ->where('users.id', $userId)
            ->groupBy('users.id')
            ->first();
        return $userDetail;
    }


    /**
     * This Function is used to increase login count of user.
     * @param $userId
     * @param $numLogin
     * @return mixed
     */
    public function increaseLoginCount($userId, $numLogin)
    {
        $data['num_login'] = isset($numLogin) && !empty($numLogin) ? $numLogin + 1 : 1;
        $user = $this->find($userId);
        //$data = Helper::addUpdationDetail($data);
        $user->fill($data);
        $user->save();
        return $user;
    }

    /**
     * This function will be used to get the agents detail listig.
     * @param int $userId
     * @return mixed
     */
    public function getUserDetailById($userId = 0)
    {
        $query = DB::table('users')
            ->join('role_users as usrRole', 'usrRole.user_id', '=', 'users.id')
            ->select('users.id', 'users.username', 'users.email', 'users.avatar as avatar', 'users.name as full_name', 'users.last_login', 'users.password', 'usrRole.role_id as role')
            ->where('users.id', '=', $userId)
            ->orderBy('users.created_at', 'desc')->first();
        return $query;
    }

    /**
     * Function to check for the email exist
     * @param type $email
     * @return type
     */
    public function checkEmailForRegistration($email)
    {
        return DB::table('users')
                ->Join('role_users as usrRoles', 'usrRoles.user_id', '=', 'users.id')
                ->select('users.id', 'usrRoles.role_id')
                ->where('usrRoles.role_id', '=', 1)
                ->where('users.email', $email)
                ->exists();
    }
}