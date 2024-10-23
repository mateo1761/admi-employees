<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deparment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeparmentController extends Controller
{
    /**
     * Display a Listing of then resource.
     */
    public function index()
    {
        $deparments = Deparment::all();

        return Inertia::render('Deparments/Index', ['deparments' => $deparments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Deparments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100']);

        $deparment = new Deparment($request->input());

        $deparment->save();

        return redirect('deparments');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deparment $deparment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deparment $deparment)
    {
        return Inertia::render('Deparments/Edit', ['deparment' => $deparment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deparment $deparment)
    {
        $request->validate(['name' => 'required|max:100']);

        $deparment->update($request->input());

        return redirect('deparments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deparment $deparment)
    {
        $deparment->delete();
        return redirect('deparments');
    }
}
