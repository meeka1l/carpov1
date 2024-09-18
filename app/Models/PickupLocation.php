<?php

// In PickupLocation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupLocation extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'ride_id', 'pickup_location'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    

}
