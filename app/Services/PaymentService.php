<?php

namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;

class PaymentService
{
    /**
     * Store a new Rental.
     *
     * @param array $data
     * @return \App\Models\Payment
     */
    public function storePayment($data, $file)
    {
        if ($file) {
            $filename = 'payment/' . time() . '.' . $file->getClientOriginalExtension();
            $file->move('payment', $filename);
        } else {
            $filename = null;
        }

        $invoiceId = $this->generateInvoiceNumber();

        // dd($invoiceId);

        return Payment::create([
            'invoice_id' => $invoiceId,
            'payment_status' => $data['payment_status'],
            'rental_amount' => $data['rental_amount'],
            'proof' => $filename,
        ]);
    }

    function generateInvoiceNumber()
    {
        $year = Carbon::now()->year; // Get the current year
        $prefix = 'RENTAL-MY'; // Fixed prefix

        // Get the last created payment to determine the next incremental number
        $lastPayment = Payment::orderBy('id', 'desc')->first();
        // dd($lastPayment->invoice_id);

        // If there is no last payment, start from 1
        $lastInvoiceNumber = $lastPayment ? intval(substr($lastPayment->invoice_id, -6)) : 0;
        // dd($lastInvoiceNumber);

        // Increment the number
        $nextInvoiceNumber = str_pad($lastInvoiceNumber + 1, 6, '0', STR_PAD_LEFT); // Zero pad to 6 digits
        // dd($nextInvoiceNumber);

        // Combine everything to form the invoice number
        return $year . '-' . $prefix . '-' . $nextInvoiceNumber;
    }
}