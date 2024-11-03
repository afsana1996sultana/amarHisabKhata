<?php

namespace App\Http\Controllers\Api;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ReportApiController extends Controller
{
    protected $payments;
    protected $projects;
    protected $expense;
    protected $deposit;
    protected $withdraw;

    public function __construct()
    {
        $this->projects = new Project();
        $this->payments = new Payment();
        $this->expense = new Expense();
        $this->deposit = new Deposit();
        $this->withdraw = new Withdraw();
    }


    public function paymentReportFilter(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $projectId = $request->input('projectId');


            if ($projectId) {
                $projectIds = is_array($projectId) ? $projectId : [$projectId];
            } else {
                $projectIds = $this->projects->where('is_approve', '=', 1)->where('status', '=', 0)->pluck('id');
            }


            $paymentsQuery = $this->payments->with('project', 'user')->where('is_approve', 1)
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate);


            if ($projectIds) {
                $paymentsQuery->whereIn('project_id', $projectIds);
            }

            $payments = $paymentsQuery->get();


            $reportData = $payments->map(function ($payment, $index) {
                return [
                    'Sl No' => $index + 1,
                    'Customer_Name' => $payment->customer_name ?? 'N/A',
                    'Customer_Phone' => $payment->customer_phone ?? 'N/A',
                    'Project_Name' => $payment->project_name ?? 'N/A',
                    'Project_Value' => (int) $payment->project_value ?? 0,
                    'Paid' => $payment->paid,
                    'Previous_Due' => $payment->due,
                    'Current_Amount' => $payment->amount,
                    'Current_Due' => $payment->next_due,
                    'Note' => $payment->note ?? '',
                    'Date' => $payment->date,
                    'Created_By' => $payment->user->name ?? '',
                ];
            });


            if ($request->query('export') === 'excel') {
                return Excel::download(new PaymentsExport($reportData), 'payments_report.xlsx');
            }

            return response()->json([
                'success' => true,
                'payment_report' => $reportData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function profitLossReportFilter(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $project_id = $request->input('project_id');

            $project = $this->projects->where('id', $project_id)->where('is_approve', '=', 1)->where('status', '=', 0)
                ->whereDate('date', '>=', $start_date)
                ->whereDate('date', '<=', $end_date)
                ->first();

            if ($project) {
                $currentPaid = $project->paid;

                $expenseTotal = $this->expense->where('project_id', $project->id)->where('is_approve', '=', 1)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->sum('amount');

                $start_date_time = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
                $end_date_time = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();

                $report_date = $start_date_time->format('Y-m-d H:i:s') . ' - ' . $end_date_time->format('Y-m-d H:i:s');

                $profitLoss = $currentPaid - $expenseTotal;
                $profitLossLabel = $profitLoss >= 0 ? 'Profit' : 'Loss';
                $profitLossValue = abs($profitLoss);


                $project_wise_profit_loss_report = [
                    'heading' => 'Project Wise Profit/Loss Report',
                    'report_date' => $report_date,
                    'projectName' => $project->project_name,
                    'projectCustomer' => $project->customer_name,
                    'projectValue' => $project->project_value ?? 0,
                    'sales' => $currentPaid ?? 0,
                    'total_cost' => $expenseTotal ?? 0,
                    "$profitLossLabel" => $profitLossValue ?? 0,
                ];

                return response()->json([
                    'status' => true,
                    'project_wise_profit_loss_report' => $project_wise_profit_loss_report
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No project found!!',
            ], 404);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function allIncomeReportFilter(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');


            $project = $this->projects->where('is_approve', '=', 1)->where('status', '=', 0)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $projectAdvance = $project->sum('advance');

            $payment = $this->payments->where('is_approve', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->latest()->get();
            $paymentAmount = $payment->sum('amount');

            $deposit = $this->deposit->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $depositAmount = $deposit->sum('amount');

            $totalIncome = $projectAdvance + $paymentAmount + $depositAmount;

            $start_date_time = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
            $end_date_time = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();

            $report_date = $start_date_time->format('Y-m-d H:i:s') . ' - ' . $end_date_time->format('Y-m-d H:i:s');

            $all_income_report = [
                'heading' => 'All Income Report',
                'report_date' => $report_date,
                'advance' => $projectAdvance ?? 0,
                'payment' => $paymentAmount ?? 0,
                'deposit' => $depositAmount ?? 0,
                'total_income' => $totalIncome ?? 0,
            ];

            return response()->json([
                'status' => true,
                'all_income_report' => $all_income_report
            ], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function allExpenseReportFilter(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');


            $expense = $this->expense->where('is_approve', '=', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->get();
            $expenseAmount = $expense->sum('amount');

            $withdraw = $this->withdraw->where('status', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
            $withdrawAmount = $withdraw->sum('amount');


            $totalExpense = $expenseAmount + $withdrawAmount;

            $start_date_time = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
            $end_date_time = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();

            $report_date = $start_date_time->format('Y-m-d H:i:s') . ' - ' . $end_date_time->format('Y-m-d H:i:s');


            $all_expense_report = [
                'heading' => 'All Expense Report',
                'report_date' => $report_date,
                'expense' => $expenseAmount ?? 0,
                'withdraw' => $withdrawAmount ?? 0,
                'total_expense' => $totalExpense ?? 0,
            ];

            return response()->json([
                'status' => true,
                'all_expense_report' => $all_expense_report
            ], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function allProfitLossReportFilter(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');



            $project = $this->projects->where('is_approve', '=', 1)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
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
            $profitLossValue = abs($profitLoss);

            $start_date_time = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
            $end_date_time = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();

            $report_date = $start_date_time->format('Y-m-d H:i:s') . ' - ' . $end_date_time->format('Y-m-d H:i:s');


            $all_profit_loss_report = [
                'heading' => 'All Profit Loss Report',
                'report_date' => $report_date,
                'total_income' => $totalIncome ?? 0,
                'total_expense' => $totalExpense ?? 0,
                "$profitLossLabel" => $profitLossValue ?? 0,
            ];

            return response()->json([
                'status' => true,
                'all_profit_loss_report' => $all_profit_loss_report
            ], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }





}
