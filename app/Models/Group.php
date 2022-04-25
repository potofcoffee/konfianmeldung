<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'group_id', 'church_id'];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }
}
