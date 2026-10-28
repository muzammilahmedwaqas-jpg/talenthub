<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StorePaymentRequest;


class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request, Invoice $invoice)
{
    $invoice->payments()->create($request->validated());

    $invoice->refreshStatus();

    return redirect()->route('invoices.show', $invoice)->with('success', 'Payment recorded.');
}
}
