<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Claim;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Fleet;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function getDashboardData()
    {
        // Get current date and time in KL timezone
        $currentDate = Carbon::now('Asia/Kuala_Lumpur')->toDateString();
        $currentTime = Carbon::now('Asia/Kuala_Lumpur')->toTimeString();

        // Get counts and sums
        $customer = Customer::count();
        $claim = Claim::count();
        $rental = Rental::whereMonth('pickup_date', Carbon::now('Asia/Kuala_Lumpur')->month)
                ->whereYear('pickup_date', Carbon::now('Asia/Kuala_Lumpur')->year)
                ->count();
        $sales = Payment::whereMonth('payment_date', Carbon::now('Asia/Kuala_Lumpur')->month)
                ->whereYear('payment_date', Carbon::now('Asia/Kuala_Lumpur')->year)
                ->sum('rental_amount');

        // Get today's rentals and returns
        $rentalToday = Rental::where('pickup_date', '=', $currentDate)->get();
        $returnToday = Rental::where('return_date', '=', $currentDate)->get();

        // Get available cars
        $car = Fleet::whereDoesntHave('rentals', function ($query) use ($currentDate) {
            $query->where(function ($query) use ($currentDate) {
            $query->where('pickup_date', '<=', $currentDate)
                ->where('return_date', '>=', $currentDate)
                ->where('pickup_time', '<=', '23:59:59')
                ->where('return_time', '>=', '00:00:00');
            });
        })->get();

        return [
            'customer' => $customer,
            'claim' => $claim,
            'rental' => $rental,
            'sales' => $sales,
            'returnToday' => $returnToday,
            'car' => $car,
            'rentalToday' => $rentalToday
        ];
    }

    public function dashboard()
    {
        $data = $this->getDashboardData();
        // dd($data['rentalToday']);
        return view('dashboard', compact('data'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'return_time' => 'required',
        ]);

        $pickupDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->pickup_date . ' ' . $request->pickup_time);
        $returnDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->return_date . ' ' . $request->return_time);
  
        $rentedFleetIds = Rental::where(function ($query) use ($pickupDateTime, $returnDateTime) {
            $query->whereRaw("CONCAT(pickup_date, ' ', pickup_time) <= ?", [$returnDateTime->format('Y-m-d H:i:s')])
                ->whereRaw("CONCAT(return_date, ' ', return_time) >= ?", [$pickupDateTime->format('Y-m-d H:i:s')]);
        })->pluck('fleet_id');

        // Get available fleets
        $availableFleets = Fleet::whereNotIn('id', $rentedFleetIds)->get();

        // Get all data needed for dashboard
        $data = $this->getDashboardData();
        
        return view('dashboard', compact('availableFleets', 'data'));
    }

    public function test(){
        $customer = Customer::count();
        dd($customer);
    }
}
