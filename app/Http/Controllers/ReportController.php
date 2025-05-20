<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Claim;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Fleet;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        
       $sales_by_month = Rental::join('payments', 'rentals.payment_id', '=', 'payments.id')
        ->selectRaw('
            YEAR(rentals.pickup_date) as year,
            MONTH(rentals.pickup_date) as month_number,
            MONTHNAME(rentals.pickup_date) as month,
            SUM(payments.rental_amount) as total
        ')
        ->whereYear('rentals.pickup_date', Carbon::now()->year)
        ->groupBy('year', 'month_number', 'month')
        ->orderBy('year')
        ->orderBy('month_number')
        ->get();


        $sales_by_car = Rental::join('payments', 'rentals.payment_id', '=', 'payments.id')
        ->join('fleets', 'rentals.fleet_id', '=', 'fleets.id')
        ->selectRaw('fleets.id, fleets.model, fleets.license_plate, SUM(payments.rental_amount) as total')
        ->whereYear('payments.created_at', Carbon::now()->year)
        ->groupBy('fleets.id', 'fleets.model', 'fleets.license_plate') // Added fleets.id to GROUP BY
        ->get();

        return view('report.index',compact( 'sales_by_month', 'sales_by_car'));
    }

    public function byfleet($id)
    {
        // $rentals = Rental::where('fleet_id', $id)->get();
        $fleet = Fleet::where('id', $id)->select('model', 'license_plate')->first();
        $rentals = Rental::with(['customer', 'payment'])
        ->where('fleet_id', $id)
        ->select('id', 'customer_id', 'payment_id', 'pickup_date', 'pickup_time', 'fleet_id')
        ->get()
        ->map(function ($rental) {
            return [
                'customer_name' => $rental->customer->name,
                'pickup_date' => Carbon::parse($rental->pickup_date)->format('d/m/Y'),
                'pickup_time' => Carbon::parse($rental->pickup_time)->format('H:i A'),
                'rental_amount' => $rental->payment->rental_amount,
            ];
        });
        // return response()->json($fleet);
        return view('report.byfleet', compact('rentals', 'fleet'));

    }
}
