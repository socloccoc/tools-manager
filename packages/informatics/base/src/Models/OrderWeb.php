<?php

namespace Informatics\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Informatics\Users\Models\User;

class OrderWeb extends Model
{
    protected $table = 'order_webs';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
