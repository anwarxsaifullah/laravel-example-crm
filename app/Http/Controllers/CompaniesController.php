<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $companies = Companies::paginate(10);

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
    public function show(Companies $companies)
    {
        //
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
