<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    protected $role;

    public function __construct()
    {
        $this->role = new Roles();
    }

    public function index()
    {
        if(Auth::user()->user_role == 1 || in_array('10', json_decode(Auth::user()->staff->role->permissions))) {
            $roles = $this->role->all();
            return view('admin.role.index', compact('roles'));
        }
        else{
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }

    }

    public function create()
    {
        if(Auth::user()->user_role == 1 || in_array('9', json_decode(Auth::user()->staff->role->permissions))) {
            return view('admin.role.create');
        }
        else{
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $roles = $this->role->create([
            'name' => $request->name,
            'permissions' => json_encode($request->permissions),
        ]);

        return redirect()->route('roles.index')->with([
            'message' => 'Role And Permission has been created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(string $id)
    {
        if(Auth::user()->user_role == 1 || in_array('11', json_decode(Auth::user()->staff->role->permissions))) {
            $roles = $this->role->findOrFail($id);
            return view('admin.role.edit',compact('roles'));
        }
        else{
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }

    }


    public function update(Request $request, string $id)
    {
        $roles = $this->role->findOrFail($id);
        $roles->update([
            'name' => $request->name,
            'permissions' => json_encode($request->permissions),
        ]);

        return redirect()->route('roles.index')->with([
            'message' => 'Role And Permission has been Updated Successfully!',
            'alert-type' => 'success'
        ]);
    }


    public function destroy(string $id)
    {
        if(Auth::user()->user_role == 1 || in_array('12', json_decode(Auth::user()->staff->role->permissions))) {
            $roles = $this->role->findOrFail($id);
            $roles->delete();
            return redirect()->route('roles.index')->with([
                'message' => 'Role Deleted Successfully!',
                'alert-type' => 'success'
            ]);
        }
        else{
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

}
