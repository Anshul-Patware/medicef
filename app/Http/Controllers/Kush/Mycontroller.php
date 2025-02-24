<?php

namespace App\Http\Controllers\Kush;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kush_forms_data1;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class Mycontroller extends Controller
{
    public $email;
    public function index()
    {
        return view('Kush/email');
    }

    public function update(Request $request)
    {
        $email = $request->query('email');
        $data = DB::table('kush_forms_data1s')->where('email',$email)->get();
        // dd($data);
        return view('Kush/index', compact('email','data'));
    }
    public function email_save(Request $request)
    {
        global $email;
        $email = $request->input('email');
        kush_forms_data1::updateorCreate(
            ['email' => $email],
            [
                'email' => $email
            ]
        );
        $data = DB::table('kush_forms_data1s')->where('email',$email)->get();
        // dd($data);
        return view('Kush/index', compact('email','data'));
        
    }

    public function save_steps(Request $request, $id)
    {        
        Log::info($request->all());
        if ($id[0] == "1") {
            Log::info('This is first Id call');

            // Batch upload files and save data
            $profilePicsPaths = [];
            if ($request->hasFile('profilePic')) {
                foreach ($request->file('profilePic') as $file) {
                    // $profilePicsPaths[] = $file->store('uploads/profile_pics', 'public');
                    try {
                        $path = $file->store('uploads', 'public');
                        $file->move(public_path('uploads'), $file);
                        $profilePicsPaths[] = $path;
                    } catch (\Exception $e) {
                        Log::error("File upload error: " . $e->getMessage());
                    }
                }
            }

            Log::info('This is profile picture paths controls');

            // Save user data to the database
            kush_forms_data1::updateorCreate(
                ['email' => $request->input('email')],
                [
                    'first_name' => $request->input('firstName'),
                    'last_name' => $request->input('lastName'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'depart' => $request->input('depart'),
                    'course' => $request->input('course'),
                    'rollno' => $request->input('rollno'),
                    'contact' => $request->input('contact'),
                    'branch' => $request->input('branch'),
                    'category' => $request->input('category'),
                    'profile_pics' => json_encode($profilePicsPaths),
                ]
            );
            Log::info('This is form saving data paths controls');

            return response()->json(['message' => 'Data saved successfully!']);
        }

        if ($id[0] == "2") {
            Log::info('This is second Id call');
            try {
                // $validated = $request->validate([
                //     'comp_name' => 'required|string|max:255',
                //     'join_date' => 'required|date|max:255',
                //     'job' => 'required|string',
                //     'experience' => 'required|string',
                //     'skill' => 'required|string',
                //     'attachment.*' => 'mimes:jpeg,png,jpg,pdf,txt',
                // ]);


                // Batch upload files and save data
                $profilePicsPaths = [];
                if ($request->hasFile('attachment')) {
                    foreach ($request->file('attachment') as $file) {
                        // $profilePicsPaths[] = $file->store('uploads/profile_pics', 'public');
                        try {
                            $path = $file->store('uploads/attachment', 'public');
                            $profilePicsPaths[] = $path;
                        } catch (\Exception $e) {
                            Log::error("File upload error: " . $e->getMessage());
                        }
                    }
                }

                // Save user data to the database
                kush_forms_data1::updateorCreate(
                    ['email' => $request->input('email')],
                    [
                        'company_name' => $request->input('comp_name'),
                        'join_date' => $request->input('join_date'),
                        'job_type' => $request->input('job'),
                        'experience' => $request->input('experience'),
                        'skill' => $request->input('skill'),
                        'attachment' => json_encode($profilePicsPaths),
                    ]
                );
                return response()->json(['message' => 'Data saved2 successfully!']);
            } catch (Exception $e) {
                return response()->json(['message' => 'some error occurs ' . $e]);
            }
        }

        if ($id[0] == "3") {             
            try {
                // $validated = $request->validate([
                //     'comp_name' => 'required|string|max:255',
                //     'join_date' => 'required|date|max:255',
                //     'job' => 'required|string',
                //     'experience' => 'required|string',
                //     'skill' => 'required|string',
                //     'attachment.*' => 'mimes:jpeg,png,jpg,pdf,txt',
                // ]);


                // Batch upload files and save data
                $profilePicsPaths = [];
                if ($request->hasFile('attachment')) {
                    foreach ($request->file('attachment') as $file) {
                        // $profilePicsPaths[] = $file->store('uploads/profile_pics', 'public');
                        try {
                            $path = $file->store('uploads/attachment', 'public');
                            $profilePicsPaths[] = $path;
                        } catch (\Exception $e) {
                            Log::error("File upload error: " . $e->getMessage());
                        }
                    }
                }

                // Save user data to the database
                kush_forms_data1::updateorCreate(
                    ['email' => $request->input('email')],
                    [
                        'company_name' => $request->input('comp_name'),
                        'join_date' => $request->input('join_date'),
                        'job_type' => $request->input('job'),
                        'experience' => $request->input('experience'),
                        'skill' => $request->input('skill'),
                        'attachment' => json_encode($profilePicsPaths),
                    ]
                );
                return response()->json(['message' => 'Data saved2 successfully!']);
            } catch (Exception $e) {
                return response()->json(['message' => 'some error occurs ' . $e]);
            }
        }
    }

    public function dash(Request $request)
    {
        // Generate a unique token
        // $uniqueToken = uniqid('form_', true);

        // // Store token in session
        // $request->session()->put('form_token', $uniqueToken);
        $all_data = DB::table('kush_forms_data1s')->get()->all();  
        // dd($all_data);     
        return view('Kush/dashboard',compact('all_data'));
    }
}
