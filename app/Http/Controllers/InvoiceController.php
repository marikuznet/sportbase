<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function download(Request $request)
    {
        $services = $request['services'];
        $total = $request['total'];

        $pdf = PDF::loadView('invoice', ['services' => $services], ['total' => $total])
            ->setPaper('letter', 'portrait');
        $ff = $pdf->output();

        $path = Storage::disk('public')->exists('deal/' . $request['deal_id']);
        if (!$path) {
            Storage::disk('public')->makeDirectory('deal/' . $request['deal_id']);
        }

        file_put_contents(Storage::disk('public')->path('deal/' . $request['deal_id']) . '/' . $request['est_id'] . '.pdf', $ff);
    }

    public function paymentDownload(Request $request)
    {
        $customer = $request['customer'];
        $services = $request['services'];
        $total = $request['total'];
        $dealId = $request['deal_id'];
        $estimate = Estimate::findOrFail($request['est_id']);

        $fileName = 'payment_invoice_' . $request['est_id'] . '.pdf';

        $pdf = PDF::loadView('paymentInvoice', ['services' => $services, 'total' => $total, 'customer' => $customer, 'estimate' => $request['estimate']])
            ->setPaper('letter');
        $pdfContent = $pdf->output();

        $directoryPath = 'deal/' . $dealId;
        $pathExists = Storage::disk('public')->exists($directoryPath);
        if (!$pathExists) {
            Storage::disk('public')->makeDirectory($directoryPath);
        }
        file_put_contents(Storage::disk('public')->path($directoryPath . '/' . $fileName), $pdfContent);
    }
}
