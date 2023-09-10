<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        $companies = Companies::when($searchTerm, function($query, $searchTerm){
            return $query->where('name', 'like', '%' . $searchTerm .'%');
        })->paginate(10);

        // if (isset($_GET['search']) && (strlen($_GET['search']) !== 0)) {
        //     $companies = Companies::where('name', 'like', '%' . $_GET['search'] . '%')->paginate(10);
        // } else {
        //     $companies = Companies::paginate(10);
        // }

        return view('companies.index', ["companies" => $companies, "request" => $request]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            'name' => 'required|unique:companies|max:64',
            'email' => 'required|email|max:64',
            'website' => 'required|max:64',
            'logo' => 'required|dimensions:min_width=100,min_height=100',
        ]);

        $company = new Companies;

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        $fileName = time() . '.' . $request->logo->extension();
        $company->logo = $fileName;
        $request->logo->move(public_path('images'), $fileName);

        if($company->save()){
            $request->session()->flash('status', 'Company successfully added!');
        };

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

        $employeesQuery = Employees::where('company_id', '=', $id)
            ->join('companies', 'employees.company_id', '=', 'companies.id')
            ->select('employees.*', 'companies.name as company_name');

        if (!empty($searchQuery)) {
            $employeesQuery->where('first_name', 'like', '%' . $_GET['search'] . '%');
        }

        $employees = $employeesQuery->paginate(10);

        // $employees = Employees::where('company_id', '=', $id)
        //     ->join('companies', 'employees.company_id', '=', 'companies.id')
        //     ->select('employees.*', 'companies.name as company_name')
        //     ->paginate(10);

        $company_name = Companies::find($id)->name;
        $companies = Companies::all('id','name');

        // dd($employees);
        return view('employees.index', ["employees" => $employees, "detail" => true, "company_name" => $company_name, "companies" => $companies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $company = Companies::find($id);

        return view('companies.edit', [
            "company" => $company,
            "request" => $request,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->email);
        $request->validate([
            'name' => [
                //'required|unique:companies|max:64'
                'required',
                'max:64',
                Rule::unique('companies')->ignore($id)
            ],
            'email' => 'required|email|max:64',
            'website' => 'required|max:64',
            'logo' => 'dimensions:min_width=100,min_height=100',
        ]);

        // dd('WOWWWWWWWWWWWWWWWWWWWWWOOOOOOOOOOOOOOOOOOOOOOO');

        $company = Companies::find($id);

        if (NULL !== $request->logo) {
            File::delete(public_path('images') . '/' . $company->logo);

            $fileName = time() . '.' . $request->logo->extension();
            $company->logo = $fileName;
            $request->logo->move(public_path('images'), $fileName);
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if($company->save()){
            $request->session()->flash('status', 'Company has been saved!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $company = Companies::find($id);
        if($company->delete()){
            $request->session()->flash('status', 'Company has been deleted.');
        }
        File::delete(public_path('images') . '/' . $company->logo);

        return redirect(route('companies.index'));
    }
}
