<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        Service::create($request->validated());

        return redirect()->route('services.index')->with('success', 'Service created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
            return view('services.show', compact('service'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return redirect()->route('services.index')->with('success', 'Service updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->invoices()->exists()) {
            return back()->with('error', 'This service is used on invoices and cannot be deleted.');
        }
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted');
    }
}
