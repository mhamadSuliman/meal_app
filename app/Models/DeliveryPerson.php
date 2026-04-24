<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPerson extends Model
{
    protected $fillable = ['user_id', 'is_available', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
