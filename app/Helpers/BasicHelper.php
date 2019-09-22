<?php


namespace App\Helpers;

use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
use Sentinel;
use Session;
use Input;
use URL;
use RangeException;

class BasicHelper
{
    protected static $dbDateFormat = 'Y-m-d H:i:s';
    protected static $userDateFormat = 'm/d/Y';
    protected static $userDateTimeFormat = 'm/d/Y H:i:s';

    public static $translate = array(
        'street_number'               => 'street_number',
        'route'                       => 'route',
        'locality'                    => 'city',
        'administrative_area_level_3' => 'area',
        'administrative_area_level_2' => 'county',
        'administrative_area_level_1' => 'state',
        'country'                     => 'country',
        'postal_code'                 => 'zip',
    );

    /**
     * This function will return logged in user details from session(if not
     * present in session than from database and set values into session also).
     *
     * @param void
     * @return array $userDetails
     * @author Toinn
     */
    public static function getUserDetails()
    {
        $userDetail = array();
        //checking user values in session
        if (Sentinel::check() && (!Session::has('userDetail') || empty(Session::get('userDetail')))) {
            //setting user details in session
            $userRepo = new UserRepo();
            $userRepo->setUserDetailInSession();
        }

        if (Session::has('userDetail')) {
            $userDetail = Session::get('userDetail');
        }


        return $userDetail;
    }

    /**
     * This function will be used for getting current user roles.
     *
     * @param array $data
     * @return array $data
     * @author Toinn
     */
    public static function getCurrentUserRole()
    {
        $roles = [];

        if (Sentinel::check()) {
            $roles = Sentinel::getUser()
                ->roles
                ->toArray();
        }

        return $roles;
    }

    /**
     * This function will be used for setting date, user, ip in array in case of
     * inserting database row.
     *
     * @param array $data
     * @return array $data
     * @author Toinn
     */
    public static function addInsertionDetail($data = array())
    {

        $date = date(self::$dbDateFormat);

        //setting creation and updation dates
        $data['created_at'] = $date;
        $data['updated_at'] = $date;

        //Setting logged in user ID
        if (Sentinel::check()) {
            $data['user_created'] = Sentinel::getUser()->id;
            $data['user_updated'] = Sentinel::getUser()->id;
        } else {
            $data['user_created'] = 0;
            $data['user_updated'] = 0;
        }

        return $data;
    }

    /**
     * This function will be used for setting date, user, ip in array in case
     * of updating database
     *
     * @param array $data
     * @return array $data
     * @author Toinn
     */
    public static function addUpdationDetail($data = array())
    {

        $date = date(self::$dbDateFormat);

        //setting updation dates
        $data['updated_at'] = $date;

        //setting client Ip Address
        $data['updated_ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;

        //Setting logged in user ID
        if (Sentinel::check()) {
            $data['user_updated'] = Sentinel::getUser()->id;
        } else {
            $data['user_updated'] = 0;
        }

        return $data;
    }

    /**
     * This function will be used for setting date, user, in array in case of
     * inserting database row.
     *
     * @param array $data
     * @return array $data
     * @author Toinn
     */
    public static function addInsertNormal($data = array())
    {
        $date = date(self::$dbDateFormat);

        //setting creation and updation dates
        $data['created_at'] = $date;
        $data['updated_at'] = $date;

        return $data;
    }

    public static function getSortableColumnOnArray($array, $prefix = '')
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumn($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    /**
     * Function to get query string
     *
     * @return string
     */
    public static function getQueryString($prefix = '')
    {
        // Temp array
        $arr = array();
        // Array to ignore the parameters from the query string
        $ignore = array('page', 'dir', 'sort', $prefix . 'page', $prefix . 'sort', $prefix . 'dir');

        // Get the desired array
        foreach (Input::all() as $key => $value) {
            if (!in_array($key, $ignore)) {
                $arr[] = $key . "=" . $value;
            }
        }

        // If the query string is present if not present
        if (count($arr) > 0) {
            return implode("&", $arr);
        } else {
            return "";
        }
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumn($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<span class="fa fa-arrow-up"></span>';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<span class="fa fa-arrow-down"></span>';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a href="?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

    /**
     * Function to get the user profile link
     * @param $userObj
     * @param $redirectRoute
     * @return mixed
     */
    public static function userProfileLink($userObj, $redirectRoute)
    {
        // Create an array of name
        $name = [
            'full_name',
        ];
        // create temp array
        $nameTemp = [];
        foreach ($name as $value) {
            if (isset($userObj->{$value}) && !empty($userObj->{$value})) {
                $nameTemp[] = $userObj->{$value};
            }
        }
        $name = trim(implode('-', $nameTemp));
        // encode name
        $name = urlencode($name);
        // create link
        $route = URL::to($redirectRoute, [$userObj->id, $name]);
        return $route;
    }


    public static function lookupAddress($string)
    {
        $string = str_replace(" ", "+", ($string));
        //dd($string);
        $apikey = config('custom.GoogleAPIKey');
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?" . ($apikey ? "key=" . $apikey . "&" : "") . "address=" . $string;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            return null;
        }

        $address_components = array();
        foreach ($response['results'][0]['address_components'] as $component) {
            if (isset(self::$translate[$component['types'][0]])) {
                $address_components[self::$translate[$component['types'][0]]] = $component['short_name'];
            }
        }
        $geometry = $response['results'][0]['geometry'];

        $array = array();
        $array['geo'] = array(
            'longitude' => $geometry['location']['lng'],
            'latitude'  => $geometry['location']['lat'],
            'location'  => $geometry['location'],
        );
        $array['address'] = $address_components;
        return $array;
    }

    /**
     * function set time whene update data
     * function use vendor rating
     * @param array $data
     * @return array
     */
    public static function updateAt($data = array())
    {

        $date = date(self::$dbDateFormat);

        //setting creation and updation dates
        $data['updated_at'] = $date;

        return $data;
    }

    /**
     * Encrypt a password
     * @param string $password ( password to encrypt )
     * @param string $key ( encryption key )
     * @return string
     * @throws \Exception
     */
    public static function safeEncrypt(string $password): string
    {
        $key = file_get_contents('secret.key');
        if (mb_strlen($key, '8bit') !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
            throw new RangeException('Key is not the correct size.');
        }
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $cipher = base64_encode(
            $nonce .
            sodium_crypto_secretbox(
                $password,
                $nonce,
                $key
            )
        );
        return $cipher;
    }

    /**
     * Decrypt a password
     *
     * @param string $encrypted ( password encrypted with safeEncrypt function )
     * @param string $key ( encryption key )
     * @return string
     * @throws \Exception
     */
    public static function safeDecrypt(string $encrypted): string
    {
        $key = file_get_contents('secret.key');
        $decoded = base64_decode($encrypted);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        $plain = sodium_crypto_secretbox_open(
            $ciphertext,
            $nonce,
            $key
        );
        if (!is_string($plain)) {
            throw new \Exception('Invalid MAC');
        }
        return $plain;
    }

    public static function conditionHandle($request)
    {
        $conditions = [];
        if (isset($request['code']) && !empty($request['code'])) {
            array_push($conditions, ['code', 'like', "%{$request['code']}%"]);
        }
        if (isset($request['account']) && !empty($request['account'])) {
            array_push($conditions, ['account', 'like', "%{$request['account']}%"]);
        }
        if (isset($request['gems'])) {
            if ($request['gems'] == 0) {
                array_push($conditions, ['count_gems', '=', 0]);
            } else {
                array_push($conditions, ['count_gems', '>', 0]);
            }
        }
        if (isset($request['jewels'])) {
            if ($request['jewels'] == 0) {
                array_push($conditions, ['count_jewels', '=', 0]);
            } else {
                array_push($conditions, ['count_jewels', '>', 0]);
            }
        }
        if (isset($request['rank']) && !empty($request['rank'])) {
            array_push($conditions, ['rank_id', '=', $request['rank']]);
        }
        if (isset($request['status']) && !empty($request['status'])) {
            array_push($conditions, ['account_status_id', '=', $request['status']]);
        }

        if (isset($request['price_range']) && $request['price_range'] != '') {
            $maxPrice = 0;
            $minPrice = 0;
            switch ($request['price_range']) {
                case 0:
                    $maxPrice = 50000;
                    break;
                case 1:
                    $maxPrice = 200000;
                    $minPrice = 50000;
                    break;
                case 2:
                    $maxPrice = 500000;
                    $minPrice = 200000;
                    break;
                case 3:
                    $maxPrice = 1000000;
                    $minPrice = 500000;
                    break;
                case 4:
                    $minPrice = 1000000;
                    break;
                case 5:
                    $minPrice = 3000000;
                    break;
                case 6:
                    $minPrice = 5000000;
                    break;
                default:
                    $maxPrice = 0;
                    $minPrice = 0;
                    break;
            }
            if ($minPrice != 0) {
                array_push($conditions, ['price_atm', '>=', $minPrice]);
            }
            if ($maxPrice != 0) {
                array_push($conditions, ['price_atm', '<=', $maxPrice]);
            }
        }
        return $conditions;
    }


}