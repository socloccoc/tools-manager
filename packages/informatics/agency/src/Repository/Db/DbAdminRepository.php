<?php

namespace Informatics\Agency\Repository\Db;

use App\Helpers\BasicHelper;
use Informatics\Base\Repositories\Interfaces\BaseOperationsInterface;
use DB;
use Permission;

class DbAdminRepository implements BaseOperationsInterface
{
    /**
     * Function to insert a new record into the system
     *
     * @param type $data
     * @author Toinn
     */
    public function insert($data)
    {

    }

    /**
     * Function to update a row in the system
     *
     * @param type $data
     * @param type $id
     * @author Toinn
     */
    public function update($data, $id)
    {

    }

    /**
     * Function to delete a row
     *
     * @param type $id
     * @author Toinn
     */
    public function delete($id)
    {

    }

    /**
     * Function to find a row
     *
     * @param type $id
     * @author Toinn
     */
    public function find($id)
    {

    }

    /**
     * This function returns the list of agents,admin and super admin according permissions.
     * @return object $query
     * @author Toinn
     */
    public function getUserList()
    {
        $query = DB::table('users')
            ->Join('role_users as usrRoles', 'usrRoles.user_id', '=', 'users.id')
            ->Join('roles as roleName', 'roleName.id', '=', 'usrRoles.role_id')
            ->select('users.id', 'roleName.name as role', 'users.email', 'users.name as full_name', 'users.last_login', 'users.type')
            ->where(function ($que) {
                $que->where('usrRoles.role_id', 3);
                if (Permission::isAgency()) {
                    $user = BasicHelper::getUserDetails();
                    $que->where('users.parent_id', $user->id);
                }
            })
            ->groupBy('users.id');

        return $query;
    }


}