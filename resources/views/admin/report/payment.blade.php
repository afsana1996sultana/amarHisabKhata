@extends('admin.layouts.master')
@section('main-content')
    <style>
        .active-projects thead tr th {
            text-align: start;
        }

        .styled-selects {
            border: 1px solid lightgray;
            width: 40% !important;
            padding-top: 3px;
            padding-bottom: 5px;
            margin-right: 5px;
        }
    </style>
    <script>
        function invoiceFunction(el) {
            let restorePage = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = restorePage;
            location.reload()
        }
    </script>

    <div class="page-titles">
        <ol class="breadcrumb">
            <li>
                <h5 class="bc-title">Report</h5>
            </li>
        </ol>
    </div>

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row card p-2">
            <div class="col-12 col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <div class="box box-primary no-print">
                    <h3 class="text-center mt-3">Payment Report</h3>
                    <form action="javascript:void(0);" id="searchForm">
                        <div class="invoice-basic-information no-print d-flex items-center">

                            <select id="projectSelect" class="styled-selects projectId" required name="project_id">
                                <option disabled value="">Select Project</option>
                                <option selected value="">All</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->project_name ?? ''}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="date_range" value="" class="form-control "
                                   style="display: inline-block;" placeholder="Date Range" />
                            <button type="submit" class="btn btn-success btn-sm action__button"
                                    style="padding: 4.5px 10px;display:flex; align-items:center;background:#5969ff"><i
                                    class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row card p-2">
            <div class="col-lg-12">
                <div class="no-print mb-2" style="text-align: right;">
                    <button id="exportExcel" class="btn btn-success btn-sm action__button" style="background: #5969ff"><i
                            class="fa fa-file-o"></i></i> <span id="loader" style="display: none;">Loading...</span>
                        Excel
                        Report</button>
                    <button class="btn btn-success btn-sm action__button" style="background: #5969ff"
                            onclick="invoiceFunction('invoice_print')">
                        <i class="fa fa-print"></i> Print Payment
                    </button>
                </div>

                <div id="invoice_print">
                    <table
                        class="display table-hover table-striped table table-responsive-sm table-bordered  active-projects style-1"
                        id="printTable">
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Project Name</th>
                            <th>Project Value</th>
                            <th>Paid</th>
                            <th>Previous Due</th>
                            <th>Current Amount</th>
                            <th>Current Due</th>
                            <th>Note</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                        </thead>
                        <tbody id="paymentData">

                        </tbody>
                    </table>
                </div>

                <div id="noRecords" style="display: none; text-align: center; font-weight: bold;">Opps!! no record found
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Date Range Picker -->
        <script>
            $(function() {
                $('input[name="date_range"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                });


            });

            $(document).ready(function() {
                $('#projectSelect').on('change', function() {
                    //console.log('hello....');
                    var projectId = $(this).val();
                    //console.log('branch',branchId);
                    //console.log('success');
                    $.ajax({
                        url: "/report/payment-date-filter",
                        type: 'GET',
                        data: { leadId: projectId },
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(xhr) {
                            //console.error(xhr.responseText);
                        }
                    });
                });
            });

            var responseData = '';
            // Date Search Input
            $(document).on("submit", "#searchForm", function(e) {
                //console.log('hello bd');

                e.preventDefault();
                const projectId = $('.projectId').val();
                var formData = {
                    start_date: $('input[name="date_range"]').data('daterangepicker').startDate.format(
                        'YYYY-MM-DD'),
                    end_date: $('input[name="date_range"]').data('daterangepicker').endDate.format(
                        'YYYY-MM-DD'),
                    projectId: projectId
                }
                // console.log('sdgfh', formData);


                $.ajax({
                    url: '/report/payment-date-filter',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        //console.log(response);

                        if (response.length > 0) {
                            showPaymentData(response);
                            responseData = response;
                            $('#noRecords').hide();
                        } else {
                            $('#paymentData').empty();
                            $('#noRecords').show();
                        }
                    },
                });
            });
            // Display sales data
            function showPaymentData(data) {
                var html = '';
                let totalNetTotal = 0;
                let totalPaid = 0;
                let totalDue = 0;
                let totalAmount = 0;
                let totalNextDue = 0;
                $.each(data, function(index, row) {

                    totalNetTotal += parseFloat(row?.project_value) || 0;
                    totalPaid += parseFloat(row?.paid) || 0;
                    totalDue +=  parseFloat(row?.due) || 0;
                    totalAmount +=  parseFloat(row?.amount) || 0;
                    totalNextDue +=  parseFloat(row?.next_due) || 0;

                    html += '<tr>';
                    html += '<td>' + (index + 1) + '</td>';
                    html += '<td>' + (row.customer_name ?? "N/A") + '</td>';
                    html += '<td>' + (row.customer_phone ?? "N/A") + '</td>';
                    html += '<td>' + (row.project_name ?? "N/A") + '</td>';
                    html += '<td>' + row.project_value + '</td>';
                    html += '<td>' + row.paid + '</td>';
                    html += '<td>' + row.due + '</td>';
                    html += '<td>' + row.amount + '</td>';
                    html += '<td>' + row.next_due + '</td>';
                    html += '<td>' + row.note + '</td>';
                    html += '<td>' + row.date + '</td>';
                    html += '<td>' + row.user?.name + '</td>';
                    html += '</tr>';
                });

                html += '<tr>';
                html += '<td colspan="4" style="text-align: end">Total:</td>';
                html += '<td> ' + totalNetTotal + '</td>';
                html += '<td>' + totalPaid + '</td>';
                html += '<td>' + totalDue + '</td>';
                html += '<td>' + totalAmount + '</td>';
                html += '<td colspan="4">' + totalNextDue + '</td>';
                html += '</tr>';
                $('#paymentData').html(html);

                html += '<tr>';
                html += '<td colspan="6" style="text-align: end">PaidTotal( Total Paid + Total Current Amount ):</td>';
                html += '<td colspan="6">' + (totalPaid + totalAmount) + '</td>';
                html += '</tr>';
                $('#paymentData').html(html);
            }


            const excelHeader = [
                "Customer Name",
                "Customer Phone",
                "Project Name",
                "Project Value",
                "Paid",
                "Previous Due",
                "Current Amount",
                "Current Due",
                "Note",
                "Date",
                "Created By"
            ];

            const loader = document.getElementById("loader");
            const exportExcelButton = document.getElementById("exportExcel");

            exportExcelButton.addEventListener("click", async () => {
                loader.style.display = "block"; // Show the loader

                try {
                    const response = Array.isArray(responseData) ? responseData.map(res => ({
                        CustomerName: res?.project?.customer_name,
                        CustomerPhone: res?.project?.customer_phone,
                        ProjectName: res?.project?.project_name,
                        ProjectValue: res?.project?.project_value,
                        Paid: res?.paid,
                        Due: res?.due,
                        Amount: res?.amount,
                        NextDue: res?.next_due,
                        Note: res?.note,
                        Date: res?.date,
                        CreatedBy: res?.user?.name
                    })) : [];



                    const XLSX = await import("https://cdn.sheetjs.com/xlsx-0.19.2/package/xlsx.mjs");

                    const worksheet = XLSX.utils.json_to_sheet(response);

                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, "export");

                    XLSX.utils.sheet_add_aoa(worksheet, [excelHeader], {
                        origin: "A1"
                    });

                    const wscols = excelHeader.map(header => ({
                        wch: header.length + 5
                    }));
                    worksheet["!cols"] = wscols;

                    XLSX.writeFile(workbook, "Sale Report.xlsx", {
                        compression: true
                    });
                } catch (error) {
                    //console.error("Error exporting to Excel:", error);
                } finally {
                    loader.style.display = "none"; // Hide the loader
                }
            });
        </script>
    @endpush
@endsection

