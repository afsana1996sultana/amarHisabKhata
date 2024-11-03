<header class="border-bottom border-black">
    <div style="background:#0E0C28">
        <div class="container">
            <div class="row p-2 align-items-center">
                <div class="col-8">
                    <div class="d-flex gap-2 align-items-center">
                        <a href="{{ route('index') }}" class="text-decoration-none text-white"
                            target="_blank">A Sister</a>
                        <a href="{{ route('index') }}" class="text-decoration-none text-white"
                            target="_blank">
                            Concern of Classic IT</a>
                    </div>
                </div>
                <div class="col-4 text-end d-none">
                    <a href="{{ route('frontend.login') }}" class="btn login_btn border ">Login</a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-area p-2">
        <div class="container">
            <div class="row align-items-center p1 pt-2">
                <div class="col-md-2 col-3">
                    <div class="logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset($setting->header_logo) }}" style="width: 150px" alt="Header Logo" />
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-9">
                    <h6 class="text-center m-0 fs-6">
                        Interior Management System Web Services
                    </h6>
                </div>
                <div class="col-md-2 text-end d-none">
                    <a href="{{ route('frontend.login') }}" class="btn login_btn">Login</a>
                </div>
            </div>
        </div>
    </div>
</header>
