<?php

namespace Informatics\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Models\User;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
}
