<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Rental extends Model
{
    use HasFactory;
    use LogsActivity;

      protected $fillable = [
        'customer_id',
        'staff_id',
        'fleet_id',
        'depo_id',
        'payment_id',
        'pickup_date',
        'return_date',
        'pickup_time',
        'return_time',
        'pickup_location',
        'return_location',
        'destination',
        'payment_status',
        'rental_amount',
        'addon_amount',
        'total_amount',
        'note',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(function(string $eventName) {
                $customerName = $this->customer ? $this->customer->name : 'Unknown Customer';
                return "Rental (ID: {$this->id}, Customer: {$customerName}) has been {$eventName}";
            });
    }

     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

     public function staff()
    {
        return $this->belongsTo(User::class);
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'depo_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function inspection()
    {
        return $this->hasMany(Inspection::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($rental) {
            $rental->deposit()->delete();
        });
    }
}
