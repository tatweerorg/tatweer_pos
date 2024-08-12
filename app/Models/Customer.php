<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) {
            // Delete related payments
            $customer->payments()->each(function ($payment) {
                // Delete related invoices
                $payment->invoice()->delete();
                $payment->delete();
            });
        });
    }
}
