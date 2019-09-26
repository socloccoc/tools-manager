<?php

namespace Informatics\Tool\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = ['name', 'max_point', 'fee'];
}
