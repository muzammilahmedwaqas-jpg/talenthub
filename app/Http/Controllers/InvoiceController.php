<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Service;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['client', 'service'])->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoice = new Invoice([
        'invoice_number' => 'INV-' . str_pad((Invoice::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT),
        'issue_date' => now(),
        'due_date' => now()->addDays(30),
        'status' => 'unpaid',
        ]);

        $clients = Client::orderBy('company_name')->get();
        $services = Service::orderBy('name')->get();

        return view('invoices.create', compact('invoice', 'clients', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
         Invoice::create($request->validated());
         return redirect()->route('invoices.index')->with('success', 'Invoice created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'service', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('company_name')->get();
        $services = Service::orderBy('name')->get();
        return view('invoices.edit', compact('invoice', 'clients', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return redirect()->route('invoices.index')->with('success', 'Invoice updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->payments()->exists()) {
            return back()->with('error', 'This invoice has payments and cannot be deleted.');
        }
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }

    public function pdf(Invoice $invoice)
    {
    $invoice->load(['client', 'service', 'payments']);

    return Pdf::loadView('invoices.pdf', compact('invoice'))
        ->download($invoice->invoice_number . '.pdf');
    }

}
