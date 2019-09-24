<?php

namespace Informatics\Base\Models;

use Illuminate\Database\Eloquent\Model;

class UserApp extends Model
{
    public $timestamps = true;
    protected $fillable = ['user_id', 'tool_id', 'key', 'total_point'];
}
