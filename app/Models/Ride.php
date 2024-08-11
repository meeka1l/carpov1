<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'vehicle_color',
        'vehicle_model',
        'navigator_id',
        'start_location',
        'end_location',
        'description',
        'email',
    ];

    public function navigator()
    {
        return $this->belongsTo(User::class, 'navigator_id');
    }

    public function commuters()
    {
        return $this->belongsToMany(User::class, 'ride_user')
                    ->withPivot('pickup_location')
                    ->withTimestamps();
    }
}
