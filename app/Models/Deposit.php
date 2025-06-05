<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Deposit extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'amount', 
        'date', 
        'status', 
        'fuel', 
        'late', 
        'others', 
        'others_amount', 
        'extend', 
        'extend_status', 
        'proof',
        'return_date', 
        'return_amount', 
        'remarks',
        'return_remark',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->setDescriptionForEvent(function(string $eventName) {
            $rental = $this->rentals;
            $customerName = $rental && $rental->customer ? $rental->customer->name : 'Unknown Customer';
            $rentalId = $rental ? $rental->id : 'Unknown Rental';
            return "Deposit for {$customerName} (Rental ID: {$rentalId}) has been {$eventName}";
        });
    }

    public function rentals()
    {
        return $this->hasOne(Rental::class, 'depo_id');
    }
}
