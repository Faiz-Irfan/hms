<?php

namespace App\Http\Controllers;
use App\Models\Deposit;
use App\Exports\ExportDeposit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepositController extends Controller
{
    private function getPending(){
        $pending = Deposit::where('return_status', 'pending')->get();
        return $pending;
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'return_status' => 'required|string|max:255',
        ]);

        $depo = Deposit::find($id);
        if (!$depo) {
            return redirect()->route('deposit.index')
                ->with('error', 'Deposit not found.');
        }

        $depo->return_status = $request->return_status;
        $depo->save();

        return redirect()->route('deposit.index', $id)
            ->with('success', 'Deposit status updated successfully.');
    }

    public function index(){
        $deposit = Deposit::with('rentals.payment')
        ->join('rentals', 'deposits.id', '=', 'rentals.depo_id')
        ->orderBy('rentals.pickup_date', 'desc')
        ->select('deposits.*')
        ->get();

        // dd($deposit);

        $pending = $this->getPending();
        // return response()->json($pending);
        return view('deposit.index')->with(compact('deposit', 'pending'));
    }

    public function create()
    {
        $deposit = Deposit::all();
    }

    public function store(Request $request){
        // $request->validate([
        // 'details' => 'required|max:255',
        // 'amount' => 'required',
        // 'plate_number' => 'required',
        // 'date' => 'required',
        // 'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        // ]);

        // $data = $request->all();

        // $claim = new Fleet();
        // $claim->brand = $request->brand;
        // $claim->model = $request->model;
        // $claim->year = $request->year;
        // $claim->license_plate = $request->license_plate;
        // $claim->color = $request->color;
        // $claim->transmission = $request->transmission;
        // $claim->status = $request->status;
        // $claim->save();

        return redirect()->route('fleet.index')
        ->with('success', 'Fleet created successfully.');
    }

    public function show($id){
        $depo = Deposit::find($id);
        // return response()->json($id);
        return view('deposit.show', compact('depo'));
    }

    // public function edit($id){
    //     $depo = Deposit::find($id);
    //     return view('deposit.edit', compact('depo'));
    // }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'fuel' => 'required|max:255',
            'extend_status' => 'required',
            'late' => 'required|max:255',
            'extend' => 'required|max:255',
            'return_date' => 'nullable',
            'return_remark' => 'nullable',
            'return_amount' => 'nullable|numeric',
            'remarks' => 'nullable|max:255',
            'return_status' => 'required|in:pending,approve,decline',
            'filepond.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8000',
            'updated_by' => 'nullable|max:255',
        ]);
        // dd('hm');
        $depo = Deposit::find($id);

         // Handle file uploads (store paths as JSON if multiple files)
        $filePaths = [];
        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $file) {
                $filename = 'deposit/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('deposit'), $filename);
                $filePaths[] = $filename;
            }
            // Store as JSON in the receipt column
            $validated['return_proof'] = json_encode($filePaths);
        }

        $depo->update($validated);

        // return redirect()->route('deposit.show',$id)
        return redirect()->back()
        ->with('success', 'Deposit updated successfully.');
    }

    public function destroy($id){
        $depo = Deposit::find($id);
        if ($depo->receipt) {
            // Get the full path to the image
            $imagePath = public_path($claim->receipt);

            // Check if file exists before attempting to delete
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $depo->delete();
        return redirect()->route('deposit.index')
        ->with('success', 'Deposit deleted successfully');
    }

    public function export(){
        // dd('hm');
        return Excel::download(new ExportDeposit, 'deposit.xlsx');
    }
}
