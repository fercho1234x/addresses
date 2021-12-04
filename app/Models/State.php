<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeStates($query, int $limit, int $page)
    {
        $offset = ($page - 1) * $limit;
        return $query->limit($limit)
            ->offset($offset);
    }
}
