<?php

namespace App\Http\Controllers\Admin\Company;

use Exception;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    /**
     * @var Company
     */
    protected $company;

    /**
     * CompanyController constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = [];

        try {
            $companies = $this->company->orderBy('id', 'DESC')->simplePaginate(10);
        
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return view('backend.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            $data = $request->all();
            $logo = "";

            if(!empty($request['logo'])) {
                $imageName = uploadImage($request, 'logo', '/logos/');
                $logo = $imageName['image_name'] ?? "";
            }

            $this->company->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'website' => $data['website'],
                'logo' => $logo,
            ]);
            
            return redirect()->route('company.index')->withFlashSuccess(trans('messages.company.store'));

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = [];

        try {
            $company = $this->company->where('id', $id)->firstOrFail();
    
        } catch (Exception $ex) {
            Log::error($ex);
            abort('404');
        }

        return view('backend.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateCompanyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $data = $request->all();
            $company = $this->company->find($id);

            if(!empty($request['logo'])) {
                $imageName = uploadImage($request, 'logo', '/logos/');
                $logo = $imageName['image_name'] ?? "";
            } else {
                $logo = $company->logo ?? "";
            }

            $company->update([
                'name' => $data['name'] ?? $company->name,
                'email' => $data['email'] ?? $company->email,
                'website' => $data['website'] ?? $company->website,
                'logo' => $logo,
            ]);
            
            return redirect()->route('company.index')->withFlashSuccess(trans('messages.company.update'));

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $company = $this->company->find($id);
            
            if ($company) { 
                $company->delete();
                return redirect()->back()->withFlashSuccess(trans('messages.company.delete'));
                
            } else {
                return redirect()->back()->withFlashDanger(trans('messages.common.something_went_wrong'));
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}
