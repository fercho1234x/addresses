<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeAddresses($query, int $limit, int $page)
    {
        $offset = ($page - 1) * $limit;
        return $query->limit($limit)
            ->offset($offset);
    }

    public function scopeCode($query, $code)
    {
        if ($code)
            return $query->where('code', $code);
    }

    public function scopeMunicipality($query, $municipality)
    {
        if ($municipality)
            return $query->where('municipality', $municipality);
    }

    public function scopeCity($query, $city)
    {
        if ($city)
            return $query->where('city', $city);
    }
}
