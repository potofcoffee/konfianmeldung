<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'token', 'zip', 'city', 'email'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
