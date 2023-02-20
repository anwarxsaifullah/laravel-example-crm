<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employees::paginate(10);

        return view('employees.index', ["employees" => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Companies::all('name');

        return view('employees.create', ["companies" => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:64',
            'last_name' => 'required|max:64',
            'company' => 'required|exists:companies,name|max:64',
            'email' => 'required|email:dns|max:64',
            'phone' => 'required|max:64',
        ]);

        $employee = new Employees;

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        return redirect(route('employees.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employees::find($id);
        $companies = Companies::all('name');

        return view('employees.edit', ["employee" => $employee, "companies" => $companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|max:64',
            'last_name' => 'required|max:64',
            'company' => 'required|exists:companies,name|max:64',
            'email' => 'required|email:dns|max:64',
            'phone' => 'required|max:64',
        ]);

        $employee = Employees::find($id);

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company = $request->company;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->update();

        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Employees::find($id);
        $company->delete();
        
        return redirect(route('employees.index'));
    }
}
