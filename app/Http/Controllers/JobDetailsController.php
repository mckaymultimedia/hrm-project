<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobDetail;
use App\Models\JobProfile;
use App\Models\Employee;

class JobDetailsController extends Controller
{
 function index()
 {     
        $jobDetails = JobDetail::orderBy('id', 'desc')->get();
        return view('job-details.index', compact('jobDetails'));
 }
 public function create()
 {
         $employee   = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $jobProfiles = JobProfile::get();
      
         return view('job-details.create',compact('employee','jobProfiles'));
   
 }
 public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(), [
                    'profile' => 'required',
                    'location' => 'required',
                    'rate' => 'required|numeric|min:0',
                    'platform' => 'required',
                    'stack' => 'required',
                    'applied_at' => 'required',
                    'link' => 'required|url',
                    'client' => 'required',
                    'payment_type' => 'required',
                ]
            );
            if ($validator->fails()) {
                
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $jobDetails = new JobDetail();
            $jobDetails->user_id = $request->user_id;
            $jobDetails->profile = $request->profile;
            $jobDetails->location = $request->location;
            $jobDetails->rate = $request->rate;
            $jobDetails->stack = $request->stack;    
            $jobDetails->platform = $request->platform;
            $jobDetails->applied_at = $request->applied_at;
            $jobDetails->link = $request->link;
            $jobDetails->client = $request->client;
            $jobDetails->payment_type = $request->payment_type;
            $jobDetails->status = $request->status;

            $jobDetails->save();
            return redirect()->route('job-details.index')->with('success', __('Job Details successfully created.'));
     
    }
    public function edit($id)
    {
            $jobDetail = JobDetail::find($id);
            $jobProfiles = JobProfile::get();
            return view('job-details.edit', compact('jobDetail','jobProfiles'));
    
    }
    public function update(Request $request, $id)
    {
        $jobDetails = JobDetail::find($id);
        
    
        if (!$jobDetails) {
            // Handle the case where JobDetail with the given ID is not found
            return redirect()->back()->with('error', __('Job Detail not found.'));
        }
        $validator = \Validator::make($request->all(), [
            'profile' => 'required',
            'location' => 'required',
            'rate' => 'required|numeric|min:0',
            'platform' => 'required',
            'applied_at' => 'required',
            'link' => 'required|url',
            'client' => 'required',
            'payment_type' => 'required',
        ]);
    
        if ($validator->fails()) {
            
            $messages = $validator->getMessageBag();

            return redirect()->back()->withInput()->with('error', $messages->first());
        }
    
        $jobDetails->profile = $request->profile;
        $jobDetails->location = $request->location;
        $jobDetails->user_id = $request->user_id;   
        $jobDetails->rate = $request->rate;
        $jobDetails->stack = $request->stack;
        $jobDetails->platform = $request->platform;
        $jobDetails->applied_at = $request->applied_at;
        $jobDetails->link = $request->link;
        $jobDetails->client = $request->client;
        $jobDetails->payment_type = $request->payment_type;
        
        $jobDetails->status = $request->status;
        $jobDetails->save();

    
        return redirect()->route('job-details.index')->with('success', __('Job Details successfully updated.'));
    }
    
    public function destroy($id)
    {
            $jobDetails = JobDetail::find($id);
            $jobDetails->delete();
            return redirect()->route('job-details.index')->with('success', __('Job Details successfully deleted.'));
    }


}