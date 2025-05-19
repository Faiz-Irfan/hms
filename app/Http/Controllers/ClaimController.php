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
            ->get();
     
            $claims = $claims->sortByDesc('date');

        return view('claim.index')->with('claims', $claims);
    }

    public function create(){
        $fleet = Fleet::all();
        $claimType = ClaimType::all();
        // dd($fleet);
       return view('claim.create', compact('fleet','claimType'));
    }

    public function store(Request $request, $id){
        $claim_type_id = $request->input('claim_type_id');
        // dd($claim_type_id);

        if($id == 'members'){
            // $data = $request->all();
           
            $data = $request->validate([
                'rental_id' => 'required|exists:rentals,id',
                'details' => 'required',
                'staff_id' => 'required',
                'date' => 'required',
            ]);

            $data['category'] = 'members';
            $claim = $this->claimService->storeClaimMember($data);

        }
        if($id == 'extra'){
            $data = $request->all();
            $date = $data['date-extra'];
            $time = $data['time'];
            $data['date'] = $date.' '. $time;
            $data['category'] = 'extra';

            $claim = $this->claimService->storeClaimMember($data);
        }
        if($id == 'depo'){
             $request->validate([
                'rental_id' => 'required|exists:rentals,id',
                'amount' => 'required',
                'date' => 'required',
                'details' => 'required',
            ]);

            $data = $request->all();
            $data['category'] = 'depo';
            $claim = $this->claimService->storeClaimMember($data);
        }
        if($id == 'claim'){

            $request->validate([
                'details' => 'required|max:255',
                'amount' => 'required',
                'plate_number' => 'required',
                'date-claim' => 'required',
                'receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8000',
            ]);

            $data = $request->all();
            
            $data['category'] = 'claims';

            $file = $request->file('receipt');

            $claim = $this->claimService->storeClaim($data, $file);
        }

        return redirect()->route('claim.index')
        ->with('success', 'Claim created successfully.');
    }

    // public function show($id,$category){
    //     dd('show');
    //     $claim = Claim::find($id);
    //     $rental_id = $claim->rental_id;
    //     // return response()->json($claim);

    //     switch($category){
    //         case 'members':{
    //             $claim = $this->claimService->getMember($rental_id);
    //             $claim = $claim[0];
    //             $customer_id = $claim->customer_id;
    //             $customer = $this->claimService->getCustomer($customer_id);
    //             // return response()->json($claim);
    //             return view('claim.show', compact('claim','customer','category'));
    //         }
    //         case 'claims':
    //             return view('claim.show', compact('claim','category'));
    //         case 'extra':
    //             return view('claim.show', compact('claim','category'));
    //         case 'depo':
    //             return view('claim.show', compact('claim','category'));
    //     };
       
    //     // dd($claim);
    //     // $fileUrl = asset($claim->receipt);
    //     // $extension = pathinfo($claim->receipt, PATHINFO_EXTENSION);

    //     // $claim->extension = $extension;

    //     // return view('claim.show', compact('claim'));
    // }

    public function edit($id){
        // dd('hm');
        $claim = Claim::find($id);
        return view('claim.edit', compact('claim'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'details' => 'required',
            'plate_number' => 'required',
        ]);

        $claim = Claim::find($id);
        $claim->update($request->all());
        return redirect()->route('claim.index')
        ->with('success', 'Claim updated successfully.');
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
            ->get();

            // return response()->json($claims);
        return view('claim.admin.index')->with('claims', $claims);
    }
}
