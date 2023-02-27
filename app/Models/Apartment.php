<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apartment extends Model
{
    use HasFactory;

    protected $guarded = ['user_id', 'image', 'latitude', 'longitude', 'is_visible', 'full_address', 'slug'];

    // To get the full URL of the uploaded images
    protected $appends = ['image_url'];

    protected function getImageUrlAttribute() {
        return $this->image ? asset("storage/$this->image") : '';
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function views() {
        return $this->hasMany(View::class);
    }

    public function sponsorships() {
        return $this->belongsToMany(sponsorship::class)->withPivot('sponsor_start', 'sponsor_end');
    }

    public function getNextId() 
    {

        $statement = DB::select("show table status like 'apartments'");

        return $statement[0]->Auto_increment;
    }
}
