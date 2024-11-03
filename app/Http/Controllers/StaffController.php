<?php

namespace App\Http\Controllers;

use App\Helper\UploadImage;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use App\Models\Staff;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $user;
    protected $staff;
    protected $setting;
    protected $roles;
    protected $projects;
    public function __construct()
    {
        $this->staff = new Staff();
        $this->setting = new Setting();
        $this->user = new User();
        $this->roles = new Roles();
        $this->projects = new Project();
    }

    public function index()
    {
        if (Auth::user()->user_role == 1 || in_array('21', json_decode(Auth::user()->staff->role->permissions))) {
            $staffs = $this->staff->latest()->get();
            return view('admin.staff.index', compact('staffs'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->user_role == 1 || in_array('22', json_decode(Auth::user()->staff->role->permissions))) {
            $roles = $this->roles->all();
            return view('admin.staff.create', compact('roles'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'numeric|digits:11|unique:users,phone',
            'password' => 'required|min:8',
        ]);

        $users = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_role' => 2,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'image' => UploadImage::imageUpload($request->file('image'), 'backend/assets/images/staff/'),
        ]);

        $staffs = $this->staff->create([
            'user_id' => $users->id,
            'roles_id' => $request->roles_id,
        ]);

        return redirect()->route('staff.index')->with([
            'message' => 'Staff Created Successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles = $this->roles->all();
        $staff = $this->staff->find($id);
        $setting = $this->setting->first();
        $projects = $this->projects->where('created_by', $staff->user->id)->get();
        return view('admin.staff.view', compact('staff', 'roles', 'setting', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->user_role == 1 || in_array('23', json_decode(Auth::user()->staff->role->permissions))) {
            $roles = $this->roles->all();
            $staffs = $this->staff->find($id);
            return view('admin.staff.edit', compact('staffs', 'roles'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staffs = $this->staff->find($id);
        $user = $staffs->user;

        // Delete the old image if it exists
        if ($user->image) {
            File::delete($user->image);
        }

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'numeric',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_role' => 2,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $userData['image'] = UploadImage::imageUpload($request->file('image'), 'backend/assets/images/staff/');
        }

        $user->update($userData);
        $staffs->update([
            'user_id' => $user->id,
            'roles_id' => $request->roles_id,
        ]);

        return redirect()->route('staff.index')->with([
            'message' => 'Staff Updated Successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(string $id)
    {
        if (Auth::user()->user_role == 1 || in_array('24', json_decode(Auth::user()->staff->role->permissions))) {
            $staffs = $this->staff->findOrFail($id);
            $user = $staffs->user;

            $image = public_path($user->image);
            if (File::exists($image)) {
                File::delete($image);
            }

            if ($user) {
                $user->delete();
            }

            $staffs->delete();
            return redirect()->route('staff.index');
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }
}
