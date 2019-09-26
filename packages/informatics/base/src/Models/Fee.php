<?php

namespace Informatics\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Models\User;

class Fee extends Model
{
    protected $table = 'fees';
    protected $guarded = [];

    public function tool(){
        return $this->hasOne(Tool::class, 'id', 'tool_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
