<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobProfile;

class JobProfileController extends Controller
{
    public function index()
    {
            $jobProfiles = JobProfile::get();
            return view('job-profiles.index', compact('jobProfiles'));
        
    }
    public function create()
    {
            return view('job-profiles.create');
    }
    public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(), [
                    'profile_name' => 'required',
                    'stack' => 'required',
                    'platform' => 'required',
                    'email' => 'required',

                ]
            );
            if ($validator->fails()) {
                
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
                // return redirect()->back()->withInput()->withErrors($validator);
            }

            $jobProfile = new JobProfile();
            $jobProfile->profile_name = $request->profile_name;
            $jobProfile->stack = $request->stack;
            $jobProfile->platform = $request->platform;
            $jobProfile->email = $request->email;
            $jobProfile->contact = $request->contact;
            $jobProfile->linkdin = $request->linkdin;
            $jobProfile->github = $request->github;


            $jobProfile->save();
            return redirect()->route('job-profile.index')->with('success', __('Job Profile successfully created.'));
      
    }
    public function edit($id)
    {
            $jobProfile = JobProfile::find($id);
            return view('job-profiles.edit', compact('jobProfile'));
       
    }
    public function update(Request $request, $id)
    {
            $validator = \Validator::make(
                $request->all(), [
                    'profile_name' => 'required',
                    'stack' => 'required',
                    'platform' => 'required',
                    'email' => 'required',

                ]
            );
            if ($validator->fails()) {
                
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $jobProfile = JobProfile::find($id);
            $jobProfile->profile_name = $request->profile_name;
            $jobProfile->stack = $request->stack;
            $jobProfile->platform = $request->platform;
            $jobProfile->email = $request->email;
            $jobProfile->contact = $request->contact;
            $jobProfile->linkdin = $request->linkdin;
            $jobProfile->github = $request->github;
            $jobProfile->save();
            return redirect()->route('job-profile.index')->with('success', __('Job Profile successfully updated.'));
        
    }
    public function destroy($id)
    {
            $jobProfile = JobProfile::find($id);
            $jobProfile->delete();
            return redirect()->route('job-profile.index')->with('success', __('Job Profile successfully deleted.'));
    }

}
