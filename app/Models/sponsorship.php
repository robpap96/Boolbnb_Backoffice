<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sponsorship extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function apartments(){
        return $this->belongsToMany(Apartment::class);
    }
}
