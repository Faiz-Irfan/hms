<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use DateTime;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\RentalService;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    protected $rentalService;

    public function __construct(RentalService $rentalService){
        $this->rentalService = $rentalService;
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
    public function create($id)
    {
        $rental = $this->rentalService->getRentalById($id);
      
        $pdf = Pdf::loadView('rental.invoice', ['rental' => $rental])->setPaper('a4', 'portrait');;
        return $pdf->stream('invoice.pdf');

        // return view('rental.invoice', ['rental' => $rental]);
    }

    public function createAgreement($id)
    {
        $rental = $this->rentalService->getRentalById($id);

        $pickupDateTime = new DateTime($rental->pickup_date . $rental->pickup_time);  // Pickup time
        $returnDateTime = new DateTime($rental->return_date . $rental->return_time);  // Return time
        $interval = $pickupDateTime->diff($returnDateTime);

        // dd($interval->h);
        // return view('rental.agreement-form', ['rental' => $rental, 'duration' => $interval]);

        $pdf = Pdf::loadView('rental.agreement-form', ['rental' => $rental, 'duration' => $interval])->setPaper('a4', 'portrait');
        return $pdf->stream('agreement.pdf');

        // return view('rental.invoice', ['rental' => $rental]);
    }

    public function createInspection()
    {
        $path = storage_path('app/public/inspection-form.pdf');
        return Response::file($path);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
 
    public function download(Request $request) {
        $data = $request->all();
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
        return view('rental.invoice', ['data' => $data]);
        // $pdf = Pdf::loadView('rental.invoice', ['data' => $data]);
        // return $pdf->download();
        return $pdf->stream();

    }
}
