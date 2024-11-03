<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopUpController extends Controller
{
    protected $topUp;
    protected $project;

    public function __construct()
    {
        $this->topUp = new TopUp();
        $this->project = new Project();
    }


    public function requestindex()
    {
        $topUps = $this->topUp->where('status', 0)->latest()->get();
        return view('admin.topUpRequest.index', compact('topUps'));
    }

    public function index()
    {
        $topUps = $this->topUp->where('status', 1)->latest()->get();
        return view('admin.topUp.index', compact('topUps'));
    }

    public function create()
    {
        $projects = $this->project->where('is_approve', 1)->where('status', '=', 0)->latest()->get();
        return view('admin.topUp.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'project_name' => 'required|exists:projects,project_name',
            'purpose' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $this->topUp->create([
            'project_id' => $request->project_id,
            'project_name' => $request->project_name,
            'purpose' => $request->purpose,
            'amount' => $request->amount,
            'status' => 0,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('top-up.request-list')->with([
            'message' => 'Top UP Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit($id)
    {
        $projects = $this->project->where('is_approve', 1)->where('status', 0)->latest()->get();
        $topUps = $this->topUp->find($id);
        // return $topUps;
        return view('admin.topUpRequest.edit', compact('topUps', 'projects'));
    }


    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'project_name' => 'required|exists:projects,project_name',
                'purpose' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
            ]);

            $topUpRequest = $this->topUp->find($id);

            if (!$topUpRequest) {
                return redirect()->route('top-up.request-list')->with([
                    'message' => 'Top-up request not found',
                    'alert-type' => 'error'
                ]);
            }

            $projectId = trim($request->input('project_id'));
            $projectName = trim($request->input('project_name'));
            $purpose = trim($request->input('purpose'));
            $amount = (float) $request->input('amount');

            DB::transaction(function () use ($topUpRequest, $projectId, $projectName, $purpose, $amount) {
                $topUpRequest->update([
                    'project_id' => $projectId,
                    'project_name' => $projectName,
                    'purpose' => $purpose,
                    'amount' => $amount,
                    'status' => 0,
                ]);
            });

            return redirect()->route('top-up.request-list')->with([
                'message' => 'Top-up request updated successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('top-up.request-list')->with([
                'message' => 'An error occurred while updating the top-up request',
                'alert-type' => 'error'
            ]);
        }
    }

    public function destroy($id)
    {
        $topUps = $this->topUp->find($id);
        $topUps->delete();
        return redirect()->back();
    }

    public function active($id)
    {
        $topUps = $this->topUp->find($id);
        $topUps->status = 1;
        $topUps->save();

        return redirect()->route('top-up.index')->with([
            'message' => 'Top UP Request Approved Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function inactive($id)
    {
        $topUps = $this->topUp->find($id);
        $topUps->status = 0;
        $topUps->save();

        return redirect()->back()->with([
            'message' => 'Top UP Request Pending Successfully',
            'alert-type' => 'success'
        ]);
    }
}
