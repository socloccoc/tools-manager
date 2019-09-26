<?php

namespace Informatics\Admin\Repository\Db;

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
    public function insert($data) {

    }

    /**
     * Function to update a row in the system
     *
     * @param type $data
     * @param type $id
     * @author Toinn
     */
    public function update($data, $id) {

    }

    /**
     * Function to delete a row
     *
     * @param type $id
     * @author Toinn
     */
    public function delete($id) {

    }

    /**
     * Function to find a row
     *
     * @param type $id
     * @author Toinn
     */
    public function find($id) {

    }

    /**
     * This function returns the list of agents,admin and super admin according permissions.
     * @param array $filters
     * @param array $sortInfo
     * @return object $query
     * @author Toinn
     */
    public function getUserList($filters = array(), $sortInfo = array()) {
        $query = DB::table('users')
            ->Join('role_users as usrRoles', 'usrRoles.user_id', '=', 'users.id')
            ->Join('roles as roleName', 'roleName.id', '=', 'usrRoles.role_id')
            ->select('users.id', 'roleName.name as role', 'users.email', 'users.name as full_name', 'users.last_login')
            ->where(function($que) use ( $filters ) {
                if (isset($filters['Keyword']) && !empty($filters['Keyword'])) {
                    $que->Where(function($que) use ( $filters ) {
                        $que->orWhere('users.name', 'like', '%' . trim($filters['Keyword']) . '%');
                        $que->orWhere('users.email', 'like', '%' . trim($filters['Keyword']) . '%');
                    });
                }
            })
            ->where(function($que) {
                if (Permission::isSuperAdmin()) {
                    $que->orWhere('usrRoles.role_id', 2);
                } elseif (Permission::isAgency()) {
                    $user = BasicHelper::getUserDetails();
                    $que->where('usrRoles.role_id', 3);
                    $que->where('users.parent_id', $user->id);
                }
            })
            ->groupBy('users.id')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ? $sortInfo['column'] : 'users.created_at', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'desc' );

        return $query;
    }


}