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
    public function index(Request $request)
    {
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

        $employeesQuery = Employees::join('companies', 'employees.company_id', '=', 'companies.id')
            ->select('employees.*', 'companies.name as company_name');

        if (!empty($searchQuery)) {
            $employeesQuery->where('first_name', 'like', '%' . $searchQuery . '%')
                           ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                           ->orWhere('companies.name', 'like', '%' . $searchQuery . '%')
                           ->orWhere('employees.email', 'like', '%' . $searchQuery . '%')
                           ->orWhere('phone', 'like', '%' . $searchQuery . '%');
        }

        $employees = $employeesQuery->paginate(10);
        $companies = Companies::all(['id', 'name']);
        // if (isset($_GET['search']) && (strlen($_GET['search']) !== 0)) {
        //     $employees = Employees::where('first_name', 'like', '%' . $_GET['search'] . '%')->join('companies', 'employees.company_id', '=', 'companies.id')
        //         ->select('employees.*', 'companies.name as company_name')
        //         ->paginate(10);;
        // } else {
        //     $employees = Employees::join('companies', 'employees.company_id', '=', 'companies.id')
        //         ->select('employees.*', 'companies.name as company_name')
        //         ->paginate(10);
        // }

        return view('employees.index', ["employees" => $employees, "companies"=>$companies, "request" => $request]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
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
            'company_id' => 'required|exists:companies,id|max:64',
            'email' => 'required|email|max:64',
            'phone' => 'required|max:64',
        ]);

        $employee = new Employees;

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        return back()->with('status', 'Employee added successfully.');
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
            'company_id' => 'required|exists:companies,id|max:64',
            'email' => 'required|email|max:64',
            'phone' => 'required|max:64',
        ]);

        $employee = Employees::find($id);

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->update();

        return back()->with('status', 'Employee updated successfully.');
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
