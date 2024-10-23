<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Deparment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
        /**
     * Display a Listing of then resource.
     */
    public function index()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name AS department')
                        ->join('departments', 'departments.id', '=', 'employees.department_id')
                        ->paginate(10);
            
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:150',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);

        $employee = new Employee($request->input());

        $employee->save();

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
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:150',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);

        $employee->update($request->input());

        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deparment $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function employeeByDeparment()
    {
        $data = Employee::select(DB::raw('count(employees.id) AS count, departments.name'))
                            ->join('departments', 'departments.id', '=', 'employees.department_id')
                            ->groupBy('departments.name')->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports() 
    {
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name AS department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->get();

        $deparments = Deparment::all();

        return Inertia::render('Employees/Reports', ['employees' => $employees , 'deparments' => $deparments]);
    }


}
