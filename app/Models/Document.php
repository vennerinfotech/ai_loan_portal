<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'customer_name',
        'aadhar_card_number',
        'aadhar_card_image',
        'aadhar_card_otp',
        'aadhar_card_otp_expired',
        'pan_card_number',
        'pan_card_image',
        'pan_card_otp',
        'pan_card_otp_expired',
        'cibil_score',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
