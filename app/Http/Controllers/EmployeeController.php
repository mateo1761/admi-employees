<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Deparment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a Listing of then resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->paginate(10);
        $deparments = Deparment::all();

        return Inertia::render('Employees/Index', ['employees' => $employees , 'deparments' => $deparments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employees/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect('employees');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function employeeByDeparment()
    {
        $data = Employee::with('department')
                        ->select(DB::raw('count(employees.id) AS count, departments.name'))
                        ->groupBy('departments.name')
                        ->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports() 
    {
        $employees = Employee::with('department')->get();
        $deparments = Deparment::all();

        return Inertia::render('Employees/Reports', ['employees' => $employees , 'deparments' => $deparments]);
    }


}
