<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    protected $deposit;

    public function __construct()
    {
        $this->deposit = new Deposit();
    }


    public function requestIndex()
    {
        $deposits = $this->deposit->where('status', 0)->latest()->get();
        return view('admin.depositRequest.index', compact('deposits'));
    }

    public function index()
    {
        $deposits = $this->deposit->where('status', 1)->latest()->get();
        return view('admin.deposit.index', compact('deposits'));
    }

    public function create()
    {
        return view('admin.deposit.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'purpose' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $this->deposit->create([
            'date' => $request->date,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'status' => 0,
        ]);

        return redirect()->route('deposit.request-list')->with([
            'message' => 'Deposit Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit($id)
    {
        $deposit = $this->deposit->find($id);
        return view('admin.depositRequest.edit', compact('deposit'));
    }


    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'date' => 'required',
                'purpose' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
            ]);

            $deposit = $this->deposit->find($id);
            if (!$deposit) {
                return redirect()->back()->withErrors(['error' => 'Deposit not found.']);
            }

            $deposit->update([
                'date' => $request->date,
                'amount' => $request->amount,
                'purpose' => $request->purpose,
                'status' => 0,
            ]);

            return redirect()->route('deposit.request-list')->with([
                'message' => 'Deposit Update Successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'error' => 'An error occurred while updating the deposit. Please try again.'
            ]);
        }
    }

    public function destroy($id)
    {
        $deposit = $this->deposit->find($id);
        $deposit->delete();
        return redirect()->back();
    }

    public function active($id)
    {
        $deposit = $this->deposit->find($id);
        $deposit->status = 1;
        $deposit->save();

        return redirect()->route('deposit.index')->with([
            'message' => 'Deposit Request Approved Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function inactive($id)
    {
        $deposit = $this->deposit->find($id);
        $deposit->status = 0;
        $deposit->save();

        return redirect()->back()->with([
            'message' => 'Deposit Request Pending Successfully',
            'alert-type' => 'success'
        ]);
    }
}
