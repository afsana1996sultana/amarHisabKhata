<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="{{ route('dashboard') }}">{{ $setting->site_name ?? "" }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">

                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @if (asset(Auth()->user()->image))
                            <img src="{{ asset(Auth()->user()->image ?? '') }}" alt="" class="user-avatar-md rounded-circle">
                        @else
                            <img src="{{asset('images/no-image.png')}}" alt="">
                        @endif

                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name ?? ''}} </h5>
                            </div>

                            <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-cog mr-2"></i>Setting</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            <form action="{{ route('logout') }}" id="logout-form" method="post" class="d-none">@csrf</form>

                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
