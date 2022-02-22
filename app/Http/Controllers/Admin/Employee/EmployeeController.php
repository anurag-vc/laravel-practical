<?php

namespace App\Http\Controllers\Admin\Employee;

use Exception;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var Company
     */
    protected $company;
    
    /**
     * EmployeeController constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee, Company $company)
    {
        $this->employee = $employee;
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = [];

        try {
            $employees = $this->employee->with('company')->orderBy('id', 'DESC')->simplePaginate(10);
            
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return view('backend.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = [];

        try {
            $companies = $this->company->pluck('name', 'id');

        } catch (Exception $ex) {
            Log::error($ex);
        }

        return view('backend.employee.create',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $data = $request->all();

            $this->employee->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'company_id' => $data['company'] ?? "",
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null
            ]);
            
            return redirect()->route('employee.index')->withFlashSuccess(trans('messages.employee.store'));

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
        $companies = [];
        $employee = [];

        try {
            $companies = $this->company->pluck('name', 'id');
            $employee = $this->employee->where('id', $id)->firstOrFail();
    
        } catch (Exception $ex) {
            Log::error($ex);
            abort('404');
        }

        return view('backend.employee.edit', compact('companies', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $data = $request->all();
            $employee = $this->employee->find($id);
            
            $employee->update([
                'first_name' => $data['first_name'] ?? $employee->first_name,
                'last_name' => $data['last_name'] ?? $employee->last_name,
                'company_id' => $data['company'] ?? $employee->company,
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);
            
            return redirect()->route('employee.index')->withFlashSuccess(trans('messages.employee.update'));

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
            $employee = $this->employee->find($id);
            
            if ($employee) { 
                $employee->delete();
                return redirect()->back()->withFlashSuccess(trans('messages.employee.delete'));
                
            } else {
                return redirect()->back()->withFlashDanger(trans('messages.common.something_went_wrong'));
            }

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}
