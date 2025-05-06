<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Rental;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Services\InspectionService;

class InspectionController extends Controller
{
    protected $inspectionService;

    public function __construct(InspectionService $inspectionService){
        $this->inspectionService = $inspectionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id, $type)
    {
        
        $pickup_time = Rental::where('id', $id)->value('pickup_time');
        
        return view('rental.inspection.form', compact('id', 'type','pickup_time'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $createdData = $this->inspectionService->addInspection($data);
        // dd($createdData);
        return redirect()->route('rental.index')->with('success','Inspection Created');   
    }

    /**
     * Display the specified resource.
     */
    public function show($rentalId, $type)
    {
        $inspection = $this->inspectionService->getInspectionById($rentalId, $type);
        $id = $rentalId;

        $depositId = Rental::where('id', $id)->value('depo_id');
        $depo =  Deposit::find($depositId);
        // dd($depositId);

        if($type == 'post'){
            $preinspection = $this->inspectionService->getInspectionById($rentalId, 'pre');
            // dd($preinspection);
        }else{
            $preinspection = null;
        }
        
        // $gambar = json_decode($inspection->image);
        // $keys = ['front', 'back', 'right', 'left', 'add1', 'add2'];
        // foreach ($keys as $key) {
        //     if (!isset($gambar->$key)) {
        //         $gambar->$key = 'null'; // Replace with your desired default value
        //     }
        // }
        return response()->json($inspection);
        // return response()->json($gambar);
        return view('rental.inspection.show', compact('depo','depositId','id','preinspection','inspection','type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        $id = $inspection->rental_id;
        $type = $inspection->type;
        return view('rental.inspection.edit', compact('inspection', 'id', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection)
    {
        $data = $request->all();
        $updatedData = $this->inspectionService->updateInspection($inspection, $data);
        return redirect()->route('rental.index')->with('success', 'Inspection Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        //
    }
}
