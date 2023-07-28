<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        if(isset($_GET['search'])){
            $query = $_GET['search'];
            if( strlen($query) === 0){
                $companies = Companies::paginate(10);
            }else{
                $companies = Companies::where('name', 'like', '%'.$query.'%')->paginate(10);
            }
        }else{
            $companies = Companies::paginate(10);
        }
        
        return view('companies.index', ["companies"=>$companies, "request"=>$request]);
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
            'email' => 'required|email:dns|max:64',
            'website' => 'required|max:64',
            'logo' => 'required|dimensions:min_width=100,min_height=100',
        ]);

        $company = new Companies;

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        $fileName = time().'.'.$request->logo->extension();
        $company->logo = $fileName;
        $request->logo->move(public_path('images'), $fileName);

        $company->save();

        return redirect(route('companies.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = Employees::where('company_id', '=', $id)
                        ->join('companies', 'employees.company_id', '=', 'companies.id')
                        ->select('employees.*', 'companies.name as company_name')
                        ->paginate(10);

        return view('employees.index', ["employees"=>$employees, "detail"=>true]);
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
        $request->validate([
            'name' => 'required|unique:companies|max:64',
            'email' => 'required|email:dns|max:64',
            'website' => 'required|max:64',
            'logo' => 'dimensions:min_width=100,min_height=100',
        ]);

        $company = Companies::find($id);

        if(NULL !== $request->logo){
            File::delete(public_path('images').'/'.$company->logo);
            
            $fileName = time().'.'.$request->logo->extension();
            $company->logo = $fileName;
            $request->logo->move(public_path('images'), $fileName);
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        $company->save();

        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Companies::find($id);
        $company->delete();
        File::delete(public_path('images').'/'.$company->logo);

        return redirect(route('companies.index'));
    }
}
