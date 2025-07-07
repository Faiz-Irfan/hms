<?php

namespace App\Exports;

use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRental implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Assuming $this->startDate and $this->endDate are set via constructor
        $rentals = DB::table('rentals')
            ->join('customers', 'rentals.customer_id', '=', 'customers.id')
            ->join('payments', 'rentals.payment_id', '=', 'payments.id')
            ->join('fleets', 'rentals.fleet_id', '=', 'fleets.id')
            ->select(
                'rentals.pickup_date',
                'rentals.pickup_time',
                'rentals.return_date',
                'rentals.return_time',
                'rentals.pickup_location',
                'rentals.return_location',
                'rentals.destination',
                'customers.name as customer_name',
                'customers.ic',
                'customers.matric',
                'customers.race',
                'customers.college',
                'customers.faculty',
                'customers.bank',
                'fleets.model',
                'fleets.license_plate',
            )
            ->whereBetween('pickup_date', [$this->startDate, $this->endDate])
            ->get();
        return $rentals;
    }

    public function headings(): array
    {
        return [
            'Pickup Date',
            'Pickup Time',
            'Return Date',
            'Return Time',
            'Pickup Location',
            'Return Location',
            'Destination',
            'Customer Name',
            'IC Number',
            'Matric Number',
            'Race',
            'College',
            'Faculty',
            'Bank',
            'Fleet Model',
            'License Plate',
        ];
    }
}
