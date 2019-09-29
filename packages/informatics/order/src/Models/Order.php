<?php

namespace Informatics\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Informatics\Users\Models\User;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
