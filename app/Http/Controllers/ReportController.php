<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use App\Models\TopUp;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ReportController extends Controller
{
    protected $projects;
    protected $payments;
    protected $expense;
    protected $deposit;
    protected $top_up;
    protected $withdraw;

    public function __construct()
    {
        $this->projects = new Project();
        $this->payments = new Payment();
        $this->expense = new Expense();
        $this->deposit = new Deposit();
        $this->withdraw = new Withdraw();
    }

    public function paymentReport()
    {
        $projects = $this->projects->where('is_approve', 1)->where('status', 0)->latest()->get();
        $payments = $this->payments->where('is_approve', 1)->latest()->get();
        return view('admin.report.payment', compact('payments', 'projects'));
    }


    public function paymentReportFilter(Request $request)
    {
        $projectIds = $this->projects->where('is_approve', 1)->where('status', 0)->pluck('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $paymentsQuery = $this->payments->where('is_approve', 1)
            ->with('project', 'user')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        if ($request->filled('projectId')) {
            $paymentsQuery->where('project_id', $request->projectId);
        } elseif ($projectIds->isNotEmpty()) {
            $paymentsQuery->whereIn('project_id', $projectIds);
        }

        $payments = $paymentsQuery->get();
        return response()->json($payments);
    }




    public function profitLoss(Request $request)
    {
        $projects = $this->projects->where('is_approve', 1)->where('status', 0)->latest()->get();
        return view('admin.report.profit-loss', compact('projects'));
    }



    public function profitLossFilter(Request $request)
    {
        $dateRange = explode(' - ', $request->input('date_range'));
        $start_date = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();
        $projects = $this->projects->latest()->get();
        $project = $this->projects->where('id', $request->project_id)->where('is_approve', '=', 1)->where('status', 0)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->first();

        if ($project) {
            $projectList = $this->projects->where('is_approve', '=', 1)->where('status', 0)->with('user', 'created_by', 'lead')->where('id', $project->id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $projectCustomer = $project->customer_name;
            $projectName = $project->project_name;
            $projectValue = $project->project_value;

            $currentPaid = $project->paid;



            $expense = $this->expense->where('project_id', $project->id)->where('is_approve', '=', 1)
                ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
                ->with('project')
                ->get();
            $expenseTotal = $expense->sum('amount');
            $profitLoss = $currentPaid - $expenseTotal;

            $profitLossLabel = $profitLoss >= 0 ? 'Profit' : 'Loss';
            $profitLossValue = number_format(abs($profitLoss), 2);

            return view('admin.report.profit-loss', compact(
                'projectList', 'projects', 'project', 'currentPaid', 'expenseTotal', 'start_date', 'end_date', 'projectValue', 'projectCustomer', 'projectName', 'profitLossLabel', 'profitLossValue'
            ));
        }

        // Return view with empty $projectList if no project found
        return view('admin.report.profit-loss', compact('projects', 'start_date', 'end_date'))->with('projectList', []);
    }



    public function allIncome()
    {
        return view('admin.report.all-income');
    }


    public function incomeFilter(Request $request)
    {
        $dateRange = explode(' - ', $request->input('date_range'));
        $start_date = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();
        $project = $this->projects->where('is_approve', '=', 1)->where('status', 0)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $projectAdvance = $project->sum('advance');
        $payment = $this->payments->where('is_approve', '=', 1)
            ->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)
            ->latest()
            ->get();
        $paymentAmount = $payment->sum('amount');

        $deposit = $this->deposit->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $depositAmount = $deposit->sum('amount');


        $totalIncome = $projectAdvance + $paymentAmount + $depositAmount;

        return view('admin.report.all-income', compact(
            'project','projectAdvance', 'paymentAmount', 'depositAmount', 'start_date', 'end_date', 'totalIncome'
        ));
    }


    public function allExpense()
    {
        return view('admin.report.all-expense');
    }


    public function expenseFilter(Request $request)
    {
        $dateRange = explode(' - ', $request->input('date_range'));
        $start_date = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();

        $expense = $this->expense->where('is_approve', '=', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->get();
        $expenseAmount = $expense->sum('amount');

        $withdraw = $this->withdraw->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $withdrawAmount = $withdraw->sum('amount');


        $totalExpense = $expenseAmount + $withdrawAmount;

        return view('admin.report.all-expense', compact(
            'expense','expenseAmount', 'withdrawAmount', 'start_date', 'end_date', 'totalExpense'
        ));
    }


    public function allProfitLoss()
    {
        return view('admin.report.all-profit-loss');
    }


    public function allProfitLossFilter(Request $request)
    {
        $dateRange = explode(' - ', $request->input('date_range'));
        $start_date = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();

        $project = $this->projects->where('is_approve', '=', 1)->where('status', 0)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $projectAdvance = $project->sum('advance');
        $payment = $this->payments->where('is_approve', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->latest()->get();
        $paymentAmount = $payment->sum('amount');

        $deposit = $this->deposit->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $depositAmount = $deposit->sum('amount');

        $totalIncome = $projectAdvance + $paymentAmount + $depositAmount;

        $expense = $this->expense->where('is_approve', '=', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->get();
        $expenseAmount = $expense->sum('amount');

        $withdraw = $this->withdraw->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $withdrawAmount = $withdraw->sum('amount');

        $totalExpense = $expenseAmount + $withdrawAmount;
        $profitLoss = $totalIncome - $totalExpense;
        $profitLossLabel = $profitLoss >= 0 ? 'Profit' : 'Loss';
        $profitLossValue = number_format(abs($profitLoss), 2);


        return view('admin.report.all-profit-loss', compact(
            'project',  'start_date', 'end_date', 'totalExpense', 'totalIncome', 'profitLossLabel', 'profitLossValue'
        ));
    }
}
