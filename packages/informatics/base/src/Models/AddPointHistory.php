<?php

namespace Informatics\Base\Models;

use Illuminate\Database\Eloquent\Model;

class AddPointHistory extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'tool_id', 'point', 'key'];
}
