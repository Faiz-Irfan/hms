<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Inspection extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'parts',
        'image',
        'mileage',
        'fuel',
        'remarks',
        'PIC',
        'staff_id',
        'rental_id',
        'img_front',
        'img_back',
        'img_left',
        'img_right',
        'img_add1',
        'img_add2',

    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->setDescriptionForEvent(function(string $eventName) {
            $rentalId = $this->rental_id ?? 'unknown';
            return "Inspection for rental ID {$rentalId} has been {$eventName}";
        });
    }

}
