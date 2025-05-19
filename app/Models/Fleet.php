<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Fleet extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'license_plate',
        'color',
        'transmission',
        'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->setDescriptionForEvent(fn(string $eventName) => "Fleet has been {$eventName}");
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Rental::class, 'fleet_id', 'id', 'id', 'payment_id');
    }
}
