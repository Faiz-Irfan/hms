<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FleetController extends Controller
{     

    public function index(){
        $fleet = Fleet::get();

        return view('fleet.index')->with('fleets', $fleet);
    }

    public function create()
    {
        $fleet = Fleet::all();
       return view('fleet.create', compact('fleet'));
    }

    public function store(Request $request){

        // $request->validate([
        // 'details' => 'required|max:255',
        // 'amount' => 'required',
        // 'plate_number' => 'required',
        // 'date' => 'required',
        // 'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        // ]);

        $data = $request->all();

        $claim = new Fleet();
        $claim->brand = $request->brand;
        $claim->model = $request->model;
        $claim->year = $request->year;
        $claim->license_plate = $request->license_plate;
        $claim->color = $request->color;
        $claim->transmission = $request->transmission;
        $claim->status = $request->status;
        $claim->save();

        return redirect()->route('fleet.index')
        ->with('success', 'Fleet created successfully.');
    }

    public function show($id){
        $fleet = Fleet::find($id);
        return view('fleet.show', compact('fleet'));
    }

    public function edit($id){
        $fleet = Fleet::find($id);
        $maintenance = MaintenanceRecord::where('fleet_id', $id)->get();

        return view('fleet.edit', compact('fleet','maintenance'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'brand' => 'required|max:255',
            'model' => 'required|max:255',
            'year' => 'required|max:255',
            'plate_number' => 'required',
        ]);

        $fleet = Fleet::find($id);
        $fleet->update($request->all());
        return redirect()->route('fleet.index')
        ->with('success', 'Fleet updated successfully.');
    }

    public function destroy($id){
        $fleet = Fleet::find($id);
        $fleet->delete();
        return redirect()->route('fleet.index')
        ->with('success', 'Fleet deleted successfully');
    }

    public function getAvailableVehicles(Request $request)
    {
        // Validate the request
        $request->validate([
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'pickup_time' => 'required|date_format:H:i', // Ensure time is in HH:MM format
            'return_time' => 'required|date_format:H:i', // Ensure time is in HH:MM format
        ]);

        // Parse the input date and time
        $pickupDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->pickup_date . ' ' . $request->pickup_time);
        $returnDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->return_date . ' ' . $request->return_time);

        // Log the parsed datetime values for debugging
        // Log::info('Pickup DateTime: ' . $pickupDateTime);
        // Log::info('Return DateTime: ' . $returnDateTime);

        // Get all fleets
        $allFleets = Fleet::pluck('license_plate', 'id');
        // $allFleets = Fleet::all();
        // Get rented fleet IDs within the selected time range
        $rentedFleetIds = Rental::where(function ($query) use ($pickupDateTime, $returnDateTime) {
            $query->whereRaw("CONCAT(pickup_date, ' ', pickup_time) <= ?", [$returnDateTime->format('Y-m-d H:i:s')])
                ->whereRaw("CONCAT(return_date, ' ', return_time) >= ?", [$pickupDateTime->format('Y-m-d H:i:s')]);
        })->pluck('fleet_id');

        // Filter out rented fleets
        $availableFleets = $allFleets->except($rentedFleetIds->toArray());
        // $availableFleets = $allFleets->whereNotIn('id', $rentedFleetIds)
        // ->mapWithKeys(function ($fleet) {
        //     return [$fleet->id => [
        //         'model' => $fleet->model,
        //         'license_plate' => $fleet->license_plate
        //     ]];
        // });

        // Return the available fleets as JSON
        return response()->json($availableFleets);
    }

    public function getFleetDetails($id)
    {
        $fleet = Fleet::findOrFail($id);
        return response()->json($fleet);
    }

    public function toggleStatus($id)
    {
        $fleet = Fleet::findOrFail($id);
        $fleet->status = !$fleet->status;
        $fleet->save();

        return response()->json([
            'success' => true,
            'status' => $fleet->status
        ]);
    }

}
