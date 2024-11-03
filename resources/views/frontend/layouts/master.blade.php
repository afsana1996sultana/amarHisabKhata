<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $setting->site_title ?? ""}}</title>
    @if(!empty($setting) && !empty($setting->fav_icon))
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset($setting->fav_icon) }}" />
    @endif
    @include('frontend.layouts.partial.styles')

</head>
<body>
<!-- header start -->
@include('frontend.layouts.partial.header')
<!-- header end -->

<!-- form start -->
@yield('main-content')
<!-- slider end -->

<!-- copyright start -->
@include('frontend.layouts.partial.footer')
<!-- copyright end -->

@include('frontend.layouts.partial.scripts')
@if (Session::has('success'))
    <script>
        toastr.options = {
            'progressBar': true,
            'closeButton': true,
            'positionClass': 'toast-bottom-right', // Set position to bottom-right
            'preventDuplicates': true, // Prevent duplicate toasts
        };
        toastr.success("{{ Session::get('success') }}", 'Success!', {
            timeout: 120000
        });
    </script>
@elseif(Session::has('error'))
    <script>
        toastr.options = {
            'progressBar': true,
            'closeButton': true,
            'positionClass': 'toast-bottom-right',
        }
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif

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
</body>
</html>
