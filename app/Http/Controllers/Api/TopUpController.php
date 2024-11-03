<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TopUpController extends Controller
{
    protected $topUp;
    protected $project;

    public function __construct()
    {
        $this->topUp = new TopUp();
        $this->project = new Project();
    }

    public function topUpRequest()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $topUps = $this->topUp->where('status', 0)->latest()->get();
            if (!$topUps) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'top_up_request_list' => $topUps,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $topUps = $this->topUp->where('status', 1)->latest()->get();
            if (!$topUps) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'top_up_lists' => $topUps,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'project_id' => 'required|exists:projects,id',
                        'purpose' => 'required|string|max:255',
                        'amount' => 'required|numeric|min:0',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    $project = $this->project->find($request->project_id);
                    if (($project->status != 0) || ($project->is_approve != 1)) {
                        return response()->json([
                            'message' => 'The project status is Completed Or Not approved. Please check project status or approval. Otherwise no new top up is created for this project!'
                        ], 403);
                    }

                    $topUp = $this->topUp->create([
                        'project_id' => $project->id,
                        'project_name' => $project->project_name,
                        'purpose' => $request->purpose,
                        'amount' => $request->amount,
                        'status' => 0,
                        'created_by' => Auth::user()->id,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Top Up data store successfully!',
                        'top_up' => $topUp,
                    ], 201);
                }
                else {
                    return response()->json([
                        'status'=>false,
                        'message'=>'Only authorised user can access to create this data!!!',
                    ], 401);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Token",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $projects = $this->project->latest()->get();
            $topUps = $this->topUp->find($id);
            if (!$topUps) {
                return response()->json([
                    'status' => false,
                    'message' => 'Top Up not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'top_up' => $topUps,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->isMethod('put')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'project_id' => 'required|exists:projects,id',
                        'purpose' => 'required|string|max:255',
                        'amount' => 'required|numeric|min:0',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    $project = $this->project->find($request->project_id);
                    if (($project->status != 0) || ($project->is_approve != 1)) {
                        return response()->json([
                            'message' => 'The project status is Completed Or Not approved. Please check project status or approval. Otherwise no new top up is created for this project!'
                        ], 403);
                    }

                    $topUpRequest = $this->topUp->find($id);

                    if (!$topUpRequest) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Top Up not found!',
                        ], 404);
                    }

                    $projectId = trim($project->id);
                    $projectName = trim($project->project_name);
                    $purpose = trim($request->input('purpose'));
                    $amount = (float) $request->input('amount');

                    DB::transaction(function () use ($topUpRequest, $projectId, $projectName, $purpose, $amount) {
                        $topUpRequest->update([
                            'project_id' => $projectId,
                            'project_name' => $projectName,
                            'purpose' => $purpose,
                            'amount' => $amount,
                            'status' => 0,
                            'created_by' => Auth::user()->id,
                        ]);
                    });

                    if (!$topUpRequest->save()) {
                        return response()->json(['error' => 'Failed to update withdraw'], 500);
                    }

                    return response()->json([
                        'status' => true,
                        'message' => 'Top Up data update successfully!',
                        'data' => $topUpRequest,
                    ], 200);
                }
                else {
                    return response()->json([
                        'status'=>false,
                        'message'=>'Only authorised user can access to Update this data!!!',
                    ], 401);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Token",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->isMethod('delete')) {
                $user = Auth::user();

                if ($user) {
                    $topUps = $this->topUp->find($id);
                    if (!$topUps) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Top Up not found!',
                        ], 404);
                    }
                    $topUps->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Top Up data deleted successfully!',
                        'top_up'=>$topUps,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to delete this data!!!!',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid HTTP Method",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $topUps = $this->topUp->find($id);
            if (!$topUps) {
                return response()->json([
                    'status' => false,
                    'message' => 'Top Up not found!',
                ], 404);
            }
            $topUps->status = 1;
            $topUps->save();

            return response()->json([
                'status' => true,
                'message' => 'Top UP data Approved successfully!',
                'data' => $topUps,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $topUps = $this->topUp->find($id);
            if (!$topUps) {
                return response()->json([
                    'status' => false,
                    'message' => 'Top Up not found!',
                ], 404);
            }
            $topUps->status = 0;
            $topUps->save();

            return response()->json([
                'status' => true,
                'message' => 'Top UP data pending successfully!',
                'data' => $topUps,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function indexRequest()
    {
        $topUps = $this->topUp->latest()->get();
        return response()->json($topUps);
    }
}
