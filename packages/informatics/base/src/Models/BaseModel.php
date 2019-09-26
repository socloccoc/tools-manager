<?php

namespace Informatics\Base\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeSortOrder($query, $direction = 'DESC')
    {
        return $query->orderBy('sort_order', $direction)->orderBy('id', 'DESC');
    }

    public function scopeWhereActive($query)
    {
        return $query->where('active', 1);
    }
}