<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PerformanceForm;
use App\Models\PerformanceReview;
use App\Models\Indicator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\Utility;

class PerformanceFormController extends Controller
{
    function uploadAndDeleteIfExists($request, $fileName, $dir)
    {
        if ($request->hasFile('team_lead_signature')) {
            $filenameWithExt = $request->file('team_lead_signature')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = str_replace(' ', '_', $filename); // Replace spaces with underscores
            $extension = $request->file('team_lead_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension; // Append timestamp
            $dir = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
        
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        
            $pathlead = Utility::upload_file($request, 'team_lead_signature', $fileNameToStore, $dir, []);
            $url_lead = 'uploads/signature/' . $fileNameToStore;
        }
        
    
        return null;
    }
 
    private function sendPerformanceFormEmail($employee, $ticket_description)
    {
        
        $uArr = [
            'ticket_name' => $employee->name,
            'ticket_title' => 'Three month performance review',
            // 'url' => $link,
            'ticket_description' => $ticket_description,
        ];
        
        $hr = User::where('type', 'hr')->first();
        $company = User::where('type', 'company')->first();
    
        Utility::sendEmailTemplate('new_performance', [$hr->email], $uArr);
        Utility::sendEmailTemplate('new_performance', [$company->email], $uArr);
    }


    public function index()
    {
        

        $user = \Auth::user();
        if ($user->type == 'employee') {
            $employee = Employee::where('user_id', $user->id)->first();
            $performance_forms = PerformanceForm::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
            if ($performance_forms->count() == 0) {
                $performance_forms = [];
                $user_id = \Auth::user()->id;
                $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
                foreach ($employees as $employee) {
                    // Fetch all performance forms for each employee
                    $employee_forms = PerformanceForm::where('employee_id', $employee->id)
                        ->orderBy('created_at', 'desc')->get();
                    // Add fetched forms to the performance_forms array
                    foreach ($employee_forms as $form) {
                        $performance_forms[] = $form;
                    }
                }
            }
            
            
            return view('performance.index', compact('performance_forms'));
        }
        
        
        else {
            $employees = Employee::select('id', 'name')->get();
            $performance_forms = PerformanceForm::orderBy('created_at', 'desc')->get();

            
            return view('performance.index', compact('employees', 'performance_forms'));
        }
    }

    public function create()
    { 
        $user_id = \Auth::user()->id;
        $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
        if(\Auth::user()->type != 'employee'){
            $employees = Employee::select('id', 'name')->get();
        }
        if($employees->count() == 0){
            $employees = Employee::select('id', 'name')->get();
        }
        $indicators = Indicator::where('first_month', 1)->get();
        return view('performance.create', compact('employees', 'indicators'));
    }

 

    public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
    ]);
    $indicator = [];
    foreach ($request->all() as $key => $value) {
        if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature') {
            $indicator[$key] = $value;
        }
    }
    
    if($request->hasFile('team_lead_signature'))
    {
   
        $filenameWithExt = $request->file('team_lead_signature')->getClientOriginalName();
        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension       = $request->file('team_lead_signature')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $dir        = 'uploads/signature';
        $image_path = $dir . '/' . $request->profile;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $pathlead = Utility::upload_file($request,'team_lead_signature',$fileNameToStore,$dir,[]);
        
        $url_lead = 'uploads/signature/'.$fileNameToStore;

    }
    if($request->hasFile('employee_signature'))
    {
   
        $filenameWithExt = $request->file('employee_signature')->getClientOriginalName();
        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension       = $request->file('employee_signature')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $dir        = 'uploads/signature';
        $image_path = $dir . '/' . $request->profile;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $path = Utility::upload_file($request,'employee_signature',$fileNameToStore,$dir,[]);
        
        $url = 'uploads/signature/'.$fileNameToStore;

    }
    $form_name = $request->form_name ? 'year':'first_month';
    
    $employee = Employee::find($request->employee_id);
    $form = PerformanceForm::create([
        'employee_id' => $request->employee_id,
        'department' => $employee->getDepartment($employee->department_id),
        'designation' => $employee->getDesignation($employee->designation_id),
        'overall_evaluation' => $request->overall_evaluation,
        'meta' => json_encode($indicator),
        'team_lead_signature' => $url_lead??'',
        'employee_signature' => $url ?? '',
        'form_name' => $form_name,
        
    ]);

$ticket_description = "I hope this email finds you well. Team lead has submitted {$employee->name}'s performance form.";

$this->sendPerformanceFormEmail($employee, $ticket_description);

    PerformanceReview::where('employee_id', $request->employee_id)
        ->update(['status' => 'completed', 'review_date' => Carbon::now()]);
    return redirect()->route('PerformanceTable')
            ->with('success', 'Performance Form created successfully.');
}
public function edit($id)
{
    $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    if($employees->count() == 0){
        $employees = Employee::select('id', 'name')->get();
    }
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('first_month', 1)->get();
    
    return view('performance.edit', compact('performance_form', 'employees', 'indicators'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'employee_id' => 'required',
    ]);
    $employee = Employee::find($request->employee_id);
    
    $performance_form = PerformanceForm::find($id);
    $indicator = [];
    foreach ($request->all() as $key => $value) {
        if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature' & $key !== 'approved_status') {
            $indicator[$key] = $value;
        }
    }

    $url_lead = '';
    $url = '';


if($request->hasFile('team_lead_signature'))
{

    $filenameWithExt = $request->file('team_lead_signature')->getClientOriginalName();
    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    $extension       = $request->file('team_lead_signature')->getClientOriginalExtension();
    $fileNameToStore = $filename . '_' . time() . '.' . $extension;

   
        $dir        = 'uploads/signature';
     
    $image_path = $dir . '/' . $request->profile;
    if (File::exists($image_path)) {
        File::delete($image_path);
    }
    $pathlead = Utility::upload_file($request,'team_lead_signature',$fileNameToStore,$dir,[]);
    
    $url_lead = 'uploads/signature/'.$fileNameToStore;

}
if($request->hasFile('employee_signature'))
{

    $filenameWithExt = $request->file('employee_signature')->getClientOriginalName();
    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    $extension       = $request->file('employee_signature')->getClientOriginalExtension();
    $fileNameToStore = $filename . '_' . time() . '.' . $extension;

   
        $dir        = 'uploads/signature';
     
    $image_path = $dir . '/' . $request->profile;
    if (File::exists($image_path)) {
        File::delete($image_path);
    }
    $path = Utility::upload_file($request,'employee_signature',$fileNameToStore,$dir,[]);
    
    $url = 'uploads/signature/'.$fileNameToStore;

}
    $performance_form->employee_id = $request->employee_id;
    $performance_form->department = $employee->getDepartment($employee->department_id);
    $performance_form->designation = $employee->getDesignation($employee->designation_id);
    $performance_form->overall_evaluation = $request->overall_evaluation;
    $performance_form->meta = json_encode($indicator);
    $performance_form->status = $request->approved_status;
    if($url_lead){
        $performance_form->team_lead_signature = $url_lead;
    }
    if($url){
        $performance_form->employee_signature = $url;
    }
    $performance_form->save();

    $user_type = \Auth::user()->type;
    if ($user_type == 'employee') {
        $ticket_description = "I hope this email finds you well. Team lead has updated {$employee->name}'s performance form.";
    } elseif ($user_type == 'hr') {
        $ticket_description = "I hope this email finds you well. HR has updated {$employee->name}'s performance form.";
    } else {
        $ticket_description = "I hope this email finds you well. CEO has updated {$employee->name}'s performance form.";
    }
    
    $this->sendPerformanceFormEmail($employee, $ticket_description);


    return redirect()->route('PerformanceTable')
        ->with('success', 'Performance Form updated successfully.');
}


    public function show($id)
    {
        $employees = Employee::select('id', 'name')->get();
        $performance_form = PerformanceForm::find($id);
        
        $indicators = Indicator::where('first_month', 1)->get();
        return view('performance.show', compact('performance_form' , 'employees', 'indicators'));
    }
    public function Yearshow($id)
    {
        $user_id = \Auth::user()->id;
        $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
        if(\Auth::user()->type != 'employee'){
            $employees = Employee::select('id', 'name')->get();
        }
        $performance_form = PerformanceForm::find($id);
        
        $indicators = Indicator::where('year', 1)->get();
        return view('performance.yearly_performance_form_show', compact('performance_form' , 'employees', 'indicators'));
    }

 

    public function destroy($id)
    {
        $performance_form = PerformanceForm::find($id);
        $performance_form->delete();
        return redirect()->route('PerformanceTable')
            ->with('success', 'Performance Form deleted successfully.');
    }
    public function oneyearCreate()
    {  
        $user_id = \Auth::user()->id;
        $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
        if(\Auth::user()->type != 'employee'){
            $employees = Employee::select('id', 'name')->get();
        }
        if($employees->count() == 0){
            $employees = Employee::select('id', 'name')->get();
        }
        $indicators = Indicator::where('year', 1)->get();
        return view('performance.oneYear-create', compact('employees', 'indicators'));
    }

    public function createFromHome($id){
        $user_id = \Auth::user()->id;
        // $employees = Employee::select('id', 'name')->get();
        $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
        if($employees->count() == 0){
            $employees = Employee::select('id', 'name')->get();
        }
        $ID = $id;
        return view('performance.createFromHome', compact('ID','employees'));

    }
    public function getTeamLead($employeeId)
    {
        $employee = Employee::find($employeeId);
        $department= Department::find($employee->department_id);
        if ($employee) {
            $leadId = $employee->team_lead;
            $leadName = $leadId ? User::find($leadId)->name : '';
            $leadDepartment = $department->name ?? '';
            return response()->json(['team_lead' => $leadName, 'department' => $leadDepartment]);
        }
        return response()->json(['error' => 'Employee not found'], 404);
    }
    public function yearDataStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);
        $indicator = [];
        foreach ($request->all() as $key => $value) {
            if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature') {
                $indicator[$key] = $value;
            }
        }
        if($request->hasFile('team_lead_signature'))
        {
       
            $filenameWithExt = $request->file('team_lead_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('team_lead_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $pathlead = Utility::upload_file($request,'team_lead_signature',$fileNameToStore,$dir,[]);
            
            $url_lead = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('employee_signature'))
        {
       
            $filenameWithExt = $request->file('employee_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('employee_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request,'employee_signature',$fileNameToStore,$dir,[]);
            
            $url = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('hr_signature'))
        {
       
            $filenameWithExt = $request->file('hr_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('hr_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $pathlead = Utility::upload_file($request,'hr_signature',$fileNameToStore,$dir,[]);
            
            $hr_url = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('ceo_signature'))
        {
       
            $filenameWithExt = $request->file('ceo_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('ceo_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request,'ceo_signature',$fileNameToStore,$dir,[]);
            
            $ceo_url = 'uploads/signature/'.$fileNameToStore;
    
        }
    
        
        $employee = Employee::find($request->employee_id);
     $form = PerformanceForm::create([
            'employee_id' => $request->employee_id,
            'department' => $employee->getDepartment($employee->department_id),
            'designation' => $employee->getDesignation($employee->designation_id),
            'overall_evaluation' => $request->overall_evaluation,
            'team_lead_signature' => $url_lead??'',
            'employee_signature' => $url ?? '',
            'hr_signature' => $hr_url ?? '',
            'ceo_signature' => $ceo_url ?? '',
            'form_name' => 'year',
            'meta' => json_encode($indicator),
        ]);
        
    $ticket_description = "I hope this email finds you well. Team lead has submitted {$employee->name}'s performance form.";
    
    $this->sendPerformanceFormEmail($employee, $ticket_description);
    
    
        PerformanceReview::where('employee_id', $request->employee_id)
            ->update(['status' => 'completed', 'review_date' => Carbon::now()]);
        return redirect()->route('PerformanceTable')
                ->with('success', 'Performance Form created successfully.');
    }

    function Yearedit($id)
    {
        // $employees = Employee::select('id', 'name')->get();
        $user_id = \Auth::user()->id;
        $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
        if(\Auth::user()->type != 'employee'){
            $employees = Employee::select('id', 'name')->get();
        }
        if($employees->count() == 0){
            $employees = Employee::select('id', 'name')->get();
        }
        $performance_form = PerformanceForm::find($id);
        
        $indicators = Indicator::where('year', 1)->get();
        
        return view('performance.yearEdit', compact('performance_form', 'employees', 'indicators'));
    }
    function Yearupdate(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);
        $employee = Employee::find($request->employee_id);
        $performance_form = PerformanceForm::find($id);
        $indicator = [];
        foreach ($request->all() as $key => $value) {
            if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature') {
                $indicator[$key] = $value;
            }
        }
        $url_lead = '';
        $url = '';
        $hr_url = '';
        $ceo_url = '';
        
        if($request->hasFile('team_lead_signature'))
        {
       
            $filenameWithExt = $request->file('team_lead_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('team_lead_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $pathlead = Utility::upload_file($request,'team_lead_signature',$fileNameToStore,$dir,[]);
            
            $url_lead = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('employee_signature'))
        {
       
            $filenameWithExt = $request->file('employee_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('employee_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request,'employee_signature',$fileNameToStore,$dir,[]);
            
            $url = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('hr_signature'))
        {
       
            $filenameWithExt = $request->file('hr_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('hr_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $pathlead = Utility::upload_file($request,'hr_signature',$fileNameToStore,$dir,[]);
            
            $hr_url = 'uploads/signature/'.$fileNameToStore;
    
        }
        if($request->hasFile('ceo_signature'))
        {
       
            $filenameWithExt = $request->file('ceo_signature')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('ceo_signature')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir        = 'uploads/signature';
            $image_path = $dir . '/' . $request->profile;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = Utility::upload_file($request,'ceo_signature',$fileNameToStore,$dir,[]);
            
            $ceo_url = 'uploads/signature/'.$fileNameToStore;
    
        }
    
       
        $performance_form->employee_id = $request->employee_id; 
        $performance_form->department = $employee->getDepartment($employee->department_id);
        $performance_form->designation = $employee->getDesignation($employee->designation_id);
        $performance_form->overall_evaluation = $request->overall_evaluation;
        
        if($url_lead){
            $performance_form->team_lead_signature = $url_lead;
        }
        if($url){
            $performance_form->employee_signature = $url;
        }
        if($hr_url){
            $performance_form->hr_signature = $hr_url;
        }
        if($ceo_url){
            $performance_form->ceo_signature = $ceo_url;
        }
        $performance_form->meta = json_encode($indicator);
        $performance_form->save();
        $user_type = \Auth::user()->type;
        if ($user_type == 'employee') {
            $ticket_description = "I hope this email finds you well. Team lead has updated {$employee->name}'s performance form.";
        } elseif ($user_type == 'hr') {
            $ticket_description = "I hope this email finds you well. HR has updated {$employee->name}'s performance form.";
        } else {
            $ticket_description = "I hope this email finds you well. CEO has updated {$employee->name}'s performance form.";
        }
        
    $this->sendPerformanceFormEmail($employee, $ticket_description);    
        return redirect()->route('PerformanceTable')
            ->with('success', 'Performance Form updated successfully.');
    }
    function bdPerformance(){

        $employees = Employee::select('id', 'name')->where('department_id', 4)->get();
        $indicators = Indicator::where('first_month', 1)->get();
        //$indicators = Indicator::all();
        return view('performance.bdPerformance', compact('employees', 'indicators'));
    }
    function bdstore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);
        $indicator = [];
        foreach ($request->all() as $key => $value) {
            if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature') {
                $indicator[$key] = $value;
            }
        }
        $employee = Employee::find($request->employee_id);
        PerformanceForm::create([
            'employee_id' => $request->employee_id,
            'department' => $employee->getDepartment($employee->department_id),
            'designation' => $employee->getDesignation($employee->designation_id),
            'overall_evaluation' => $request->overall_evaluation,
            'meta' => json_encode($indicator), 
            'form_name' => 'bd_performance'
        ]);

        $ticket_description = "I hope this email finds you well. Team lead has submitted {$employee->name}'s performance form.";
    $this->sendPerformanceFormEmail($employee, $ticket_description);
        PerformanceReview::where('employee_id', $request->employee_id)
            ->update(['status' => 'completed', 'review_date' => Carbon::now()]);
        return redirect()->route('PerformanceTable')
                ->with('success', 'Performance Form created successfully.');
    }

function bdedit($id)
{
    
    $employees = Employee::select('id', 'name')->where('department_id', 4)->get();
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('first_month', 1)->get();
    
    return view('performance.bdEdit', compact('performance_form', 'employees', 'indicators'));
}

function bdupdate(Request $request, $id)
{
    $request->validate([
        'employee_id' => 'required',
    ]);
    $employee = Employee::find($request->employee_id);
    $performance_form = PerformanceForm::find($id);
    $indicator = [];
    foreach ($request->all() as $key => $value) {
        if ($key !== 'employee_id' && $key !== '_token' && $key !== 'team_lead_signature' && $key !== 'employee_signature') {
            $indicator[$key] = $value;
        }
    }

    $performance_form->update([
        'employee_id' => $request->employee_id,
        'department' => $employee->getDepartment($employee->department_id),
        'designation' => $employee->getDesignation($employee->designation_id),
        'overall_evaluation' => $request->overall_evaluation,
        'meta' => json_encode($indicator),
    ]);
    $user_type = \Auth::user()->type;
    if ($user_type == 'employee') {
        $ticket_description = "I hope this email finds you well. Team lead has updated {$employee->name}'s performance form.";
    } elseif ($user_type == 'hr') {
        $ticket_description = "I hope this email finds you well. HR has updated {$employee->name}'s performance form.";
    } else {
        $ticket_description = "I hope this email finds you well. CEO has updated {$employee->name}'s performance form.";
    }
    

    $this->sendPerformanceFormEmail($employee, $ticket_description);
    return redirect()->route('PerformanceTable')
        ->with('success', 'Performance Form updated successfully.');
     
}
function bdshow($id)
{
    $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('first_month', 1)->get();
    
    return view('performance.bd_performance_form_view', compact('performance_form' , 'employees', 'indicators'));
}

public function review_edit($id)
{  $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('first_month', 1)->get();
    
    return view('performance.review', compact('performance_form', 'employees', 'indicators'));
}

public function monthlyPerformance()
{
    $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    $indicators = Indicator::where('six_month', 1)->get();
    return view('performance.monthlyPerformance', compact('employees', 'indicators'));
}
public function monthlyStore(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
    ]);
    $indicator = [];
    foreach ($request->all() as $key => $value) {
        if ($key !== 'employee_id' && $key !== '_token') {
            $indicator[$key] = $value;
        }
    }
    $employee = Employee::find($request->employee_id);
    PerformanceForm::create([
        'employee_id' => $request->employee_id,
        'department' => $employee->getDepartment($employee->department_id),
        'designation' => $employee->getDesignation($employee->designation_id),
        'overall_evaluation' => $request->overall_evaluation,
        'meta' => json_encode($indicator),
        'form_name' => 'six_month'
    ]);

    $ticket_description = "I hope this email finds you well. Team lead has submitted {$employee->name}'s performance form.";
    $this->sendPerformanceFormEmail($employee, $ticket_description);
    PerformanceReview::where('employee_id', $request->employee_id)
        ->update(['status' => 'completed', 'review_date' => Carbon::now()]);
    return redirect()->route('PerformanceTable')
            ->with('success', 'Performance Form created successfully.');
}
public function monthlyedit($id)
{
   
    $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('six_month', 1)->get();
    
    return view('performance.monthlyEdit', compact('performance_form', 'employees', 'indicators'));

}
public function monthlyupdate(Request $request, $id)
{
    $request->validate([
        'employee_id' => 'required',
    ]);
    $employee = Employee::find($request->employee_id);
    $performance_form = PerformanceForm::find($id);
    $indicator = [];
    foreach ($request->all() as $key => $value) {
        if ($key !== 'employee_id' && $key !== '_token' && $key !== 'approved_status') {
            $indicator[$key] = $value;
        }
    }

    $performance_form->update([
        'employee_id' => $request->employee_id,
        'department' => $employee->getDepartment($employee->department_id),
        'designation' => $employee->getDesignation($employee->designation_id),
        'overall_evaluation' => $request->overall_evaluation,
        'status' => $request->approved_status,
        'meta' => json_encode($indicator),
    ]);
    $user_type = \Auth::user()->type;
    if ($user_type == 'employee') {
        $ticket_description = "I hope this email finds you well. Team lead has updated {$employee->name}'s performance form.";
    } elseif ($user_type == 'hr') {
        $ticket_description = "I hope this email finds you well. HR has updated {$employee->name}'s performance form.";
    } else {
        $ticket_description = "I hope this email finds you well. CEO has updated {$employee->name}'s performance form.";
    }
    
    $this->sendPerformanceFormEmail($employee, $ticket_description);
    return redirect()->route('PerformanceTable')
        ->with('success', 'Performance Form updated successfully.');
}
public function monthlyshow($id)
{
    
    $user_id = \Auth::user()->id;
    $employees = Employee::select('id', 'name')->where('team_lead', $user_id)->get();
    if(\Auth::user()->type != 'employee'){
        $employees = Employee::select('id', 'name')->get();
    }
    $performance_form = PerformanceForm::find($id);
    
    $indicators = Indicator::where('six_month', 1)->get();
    
    return view('performance.monthly_performance_form_show', compact('performance_form' , 'employees', 'indicators'));
}





}