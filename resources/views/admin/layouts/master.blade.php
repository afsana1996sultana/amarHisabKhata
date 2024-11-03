<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
     @include('admin.layouts.partial.styles')
    <title>{{ $setting->site_title ?? ""}}</title>
    @if(!empty($setting) && !empty($setting->fav_icon))
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset($setting->fav_icon) }}" />
    @endif
    <style>
        .custom-img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 3px;
            width: 75px;
            height: 70px;
        }
    </style>
</head>

<body>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    @include('admin.layouts.partial.header')
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    @include('admin.layouts.partial.sidebar')
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        @yield('main-content')
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        @include('admin.layouts.partial.footer')
        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
@include('admin.layouts.partial.scripts')
@stack('js')
<script>
    @if(session('message'))
    Swal.fire({
        title: @json(session('alert-type') === 'success' ? 'Success!' : 'Error!'),
        text: @json(session('message')),
        icon: @json(session('alert-type')),
        confirmButtonText: 'OK'
    });
    @endif
</script>
<script type="text/javascript">
    $(function(){
        $(document).on('click','#delete',function(e){
            e.preventDefault();
            var link = $(this).attr("href");

            Swal.fire({
                title: 'Are you sure?',
                text: "Delete This Data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link
                    Swal.fire(
                        'Deleted!',
                        'This Data has been deleted Successfully!!.',
                        'success'
                    )
                }
            })

        });
    });
</script>
{{--    @if (Session::has('success'))--}}
{{--        <script>--}}
{{--            toastr.options = {--}}
{{--                'progressBar': true,--}}
{{--                'closeButton': true,--}}
{{--                'positionClass': 'toast-bottom-right', // Set position to bottom-right--}}
{{--                'preventDuplicates': true, // Prevent duplicate toasts--}}
{{--            };--}}
{{--            toastr.success("{{ Session::get('success') }}", 'Success!', {--}}
{{--                timeout: 120000--}}
{{--            });--}}
{{--        </script>--}}
{{--    @elseif(Session::has('error'))--}}
{{--        <script>--}}
{{--            toastr.options = {--}}
{{--                'progressBar': true,--}}
{{--                'closeButton': true,--}}
{{--                'positionClass': 'toast-bottom-right',--}}
{{--            }--}}
{{--            toastr.error("{{ Session::get('error') }}");--}}
{{--        </script>--}}
{{--    @endif--}}

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                @foreach ($errors->all() as $error)
                    toastr.options = {
                    'progressBar': true,
                    'closeButton': true,
                    'positionClass': 'toast-bottom-right',
                }
                toastr.error('{{ $error }}');
                @endforeach
            });
        </script>
    @endif
<script>
    $(function() {
        // Get the existing value
        var existingValue = $('input[name="permit_validity_period"]').val();

        // Parse the existing value to extract start and end dates
        var startDate, endDate;
        if (existingValue) {
            var dates = existingValue.split(' - ');
            startDate = moment(dates[0], 'DD-MM-YYYY');
            endDate = moment(dates[1], 'DD-MM-YYYY ');
        } else {
            startDate = moment().startOf('hour');
            endDate = moment().startOf('hour').add(32, 'hour');
        }

        // Initialize the date range picker
        $('input[name="permit_validity_period"]').daterangepicker({
            timePicker: true,
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'DD-MM-YYYY' // Ensure the format includes time
            }
        });
    });
</script>


</body>

</html>
