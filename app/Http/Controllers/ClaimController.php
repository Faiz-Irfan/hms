<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimType;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ClaimService;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;

class ClaimController extends Controller
{
    protected $claimService;

    public function __construct(ClaimService $claimService){
        $this->claimService = $claimService;
    }

    public function index(Request $request){
        $user_id = $request->session()->get('user_id');
        $claims = DB::table('claims')
            ->join('users', 'claims.staff_id', '=', 'users.id')
            ->where('users.id', '=', $user_id)
            ->select(
            'claims.id as claim_id',
            'claims.details',
            'claims.category',
            'claims.amount',
            'claims.plate_number',
            'claims.status',
            'claims.date',
            'claims.payment_date',
            'users.name as user_name',
            )
            ->orderByDesc('claims.date')
            ->get();

        return view('claim.index')->with('claims', $claims);
    }

    public function create(){
        $fleet = Fleet::all();
        $claimType = ClaimType::all();
        // dd($fleet);
       return view('claim.createnew', compact('fleet','claimType'));
    }

    public function store(Request $request){
        // Validate the request
        $validated = $request->validate([
            'category' => 'required|max:255',
            'details' => 'required|max:255',
            'staff_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'plate_number' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'rental_id' => 'nullable|exists:rentals,id',
            'filepond.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8000',
        ]);

        // Handle file uploads (store paths as JSON if multiple files)
        $filePaths = [];
        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $file) {
                $filename = 'claims/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('claims'), $filename);
                $filePaths[] = $filename;
            }
            // Store as JSON in the receipt column
            $validated['receipt'] = json_encode($filePaths);
        }

        $claim = Claim::create($validated);

        return redirect()->route('claim.index')
        ->with('success', 'Claim created successfully.');
    }

    public function show($id){
        // dd('show');
        $claim = Claim::find($id);
        // $rental_id = $claim->rental_id;
        // return response()->json($claim);

        // switch($category){
        //     case 'members':{
        //         $claim = $this->claimService->getMember($rental_id);
        //         $claim = $claim[0];
        //         $customer_id = $claim->customer_id;
        //         $customer = $this->claimService->getCustomer($customer_id);
        //         // return response()->json($claim);
        //         return view('claim.show', compact('claim','customer','category'));
        //     }
        //     case 'claims':
        //         return view('claim.show', compact('claim','category'));
        //     case 'extra':
        //         return view('claim.show', compact('claim','category'));
        //     case 'depo':
        //         return view('claim.show', compact('claim','category'));
        // };
       
        // dd($claim);
        // $fileUrl = asset($claim->receipt);
        // $extension = pathinfo($claim->receipt, PATHINFO_EXTENSION);

        // $claim->extension = $extension;

        return view('claim.show', compact('claim'));
    }

    public function edit($id)
    {
        $claim = Claim::findOrFail($id);
        $fleet = Fleet::all();
        $claimType = ClaimType::all();
        return view('claim.edit', compact('claim', 'fleet', 'claimType'));
    }

    public function update(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);
        $validated = $request->validate([
            'details' => 'required|max:255',
            'plate_number' => 'nullable|string',
            'date' => 'required|date',
            'amount' => 'nullable|numeric',
            'filepond.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8000',
        ]);

        // Handle file uploads (replace if new files uploaded)
        if ($request->hasFile('filepond')) {
            // Optionally: delete old files
            if ($claim->receipt) {
                $oldFiles = json_decode($claim->receipt, true);
                if (is_array($oldFiles)) {
                    foreach ($oldFiles as $oldFile) {
                        $oldPath = public_path($oldFile);
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                } elseif ($claim->receipt) {
                    $oldPath = public_path($claim->receipt);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }
            $filePaths = [];
            foreach ($request->file('filepond') as $file) {
                $filename = 'claims/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('claims'), $filename);
                $filePaths[] = $filename;
            }
            $validated['receipt'] = json_encode($filePaths);
        }
        // If no new files, keep the old receipt
        else {
            $validated['receipt'] = $claim->receipt;
        }

        $claim->update($validated);
        return redirect()->route('claim.index')->with('success', 'Claim updated successfully.');
    }

    public function destroy($id){
        $claim = Claim::find($id);

        if ($claim->receipt) {
            // Get the full path to the image
            $imagePath = public_path($claim->receipt);

            // Check if file exists before attempting to delete
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $claim->delete();
        return redirect()->route('claim.index')
        ->with('success', 'Claim deleted successfully');
    }

    //Admin functions

    public function updateStatus(Claim $claim)
    {
        $claim->status = $claim->status === 'approved' ? 'declined' : 'approved';
        $currentDate = Carbon::now();
        // echo $currentDate;
        // exit;
        $claim->payment_date = $currentDate;
        $claim->save();

        return redirect()->back()->with('success', 'Claim status updated successfully.');
    }

    public function indexAdmin(){
         $claims = DB::table('claims')
            ->join('users', 'claims.staff_id', '=', 'users.id')
            ->select(
                'claims.id as claim_id',
                'claims.details',
                'claims.amount',
                'claims.category',
                'claims.plate_number',
                'claims.status',
                'claims.date',
                'claims.payment_date',
                'users.name as user_name',
            )
            ->orderByDesc('claims.date')
            ->get();

            // return response()->json($claims);
        return view('claim.admin.index')->with('claims', $claims);
    }
}
