<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Deparment;
use Illuminate\Http\Request;
use App\Mail\EmployeeCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;

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
        $employee = Employee::create($request->validated());

        $this->sendEmailCreateEmployee($employee);

        return redirect()->route('employees.index')->with('success', 'Empleado creado exitosamente.');
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

        return redirect()->route('employees.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Empleado eliminado exitosamente.');
    }

    public function employeeByDeparment()
    {
        $data = Deparment::select('id', 'name')
        ->withCount('employees')
        ->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports() 
    {
        $employees = Employee::with('department')->get();
        $deparments = Deparment::all();

        return Inertia::render('Employees/Reports', ['employees' => $employees , 'deparments' => $deparments]);
    }

    public function sendEmailCreateEmployee($employee){
        $email = Auth::user()->email;

        try {
            Mail::to($email)->send(new EmployeeCreated($employee));
        } catch (\Exception $e) {
            Log::error('Error al enviar correo: ' . $e->getMessage());
        }

        return true;
    }

}
