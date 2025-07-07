<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Exports\ExportDeposit;
use App\Exports\ExportRental;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function exportDeposit()
    {
        return Excel::download(new ExportDeposit, 'deposits.xlsx');
    }

    public function exportRental(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Pass the dates to the ExportRental export class
        return Excel::download(new ExportRental($startDate, $endDate), 'rentals.xlsx');
    }
}