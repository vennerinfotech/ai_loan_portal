<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'pan_card_number',
        'reference_code',
        'm_pin',
        'otp',
        'otp_expired',
        'date_of_birth',
        'gender',
        'marital_status',
        'address',
        'address_type',
        'user_type',
        'email_verified_at',
        'password',
        'remember_token',
    ];
}
