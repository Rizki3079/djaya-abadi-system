<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\IncomeCategory;
use App\Models\PaymentMethod;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $outlets = Outlet::latest()->get();

    return view('outlets.index', compact('outlets'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $incomeCategories = IncomeCategory::where('status', true)->get();
        $paymentMethods = PaymentMethod::where('status', true)->get();

        return view(
            'outlets.create',
            compact('incomeCategories', 'paymentMethods')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:outlets,code',
            'status' => 'required',
        ]);

        $outlet = Outlet::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        $outlet->incomeCategories()->sync(
            $request->income_categories ?? []
        );

        $outlet->paymentMethods()->sync(
            $request->payment_methods ?? []
        );

        return redirect()
            ->route('outlets.index')
            ->with('success', 'Outlet berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outlet $outlet)
    {
        $incomeCategories = IncomeCategory::where('status', true)->get();
        $paymentMethods = PaymentMethod::where('status', true)->get();

        return view(
            'outlets.edit',
            compact(
                'outlet',
                'incomeCategories',
                'paymentMethods'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:outlets,code,' . $outlet->id,
            'status' => 'required',
        ]);

        $outlet->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        $outlet->incomeCategories()->sync(
            $request->income_categories ?? []
        );

        $outlet->paymentMethods()->sync(
            $request->payment_methods ?? []
        );

        return redirect()
            ->route('outlets.index')
            ->with('success', 'Outlet berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
