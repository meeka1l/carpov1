<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{

    use SoftDeletes;

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
        'status',
        'start_time',
        'end_time',
        'duration',
        'user_name',
        'distance_km',
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

    public function join(User $user, $pickupLocation)
    {
        $this->commuters()->attach($user, ['pickup_location' => $pickupLocation]);
    }

    public function end()
    {
        $this->commuters()->detach();
        $this->delete();
    }

    public function locate($location)
    {
        $this->update(['current_location' => $location]);
    }

public function messages()
{
    return $this->hasMany(Message::class);
}

    
}
