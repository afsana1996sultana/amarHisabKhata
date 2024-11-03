<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa fa-desktop" aria-hidden="true"></i> Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->user_role == 1 ||(is_array(json_decode(Auth::user()->staff->role->permissions))
                    &&(in_array('9', json_decode(Auth::user()->staff->role->permissions)) ||in_array('13', json_decode(Auth::user()->staff->role->permissions)))))
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#leads" aria-controls="lead" aria-expanded="{{ Request::routeIs('lead*') || Request::routeIs('customer*') ? 'true' : 'false' }}">
                            <i class="fa fa-fw fa-user-circle"></i>Leads <span class="badge badge-success">6</span>
                        </a>
                        <div id="leads" class="collapse {{ Request::routeIs('lead*') || Request::routeIs('customer*') ? 'show' : '' }}">
                            <ul class="nav flex-column">
                                @if(Auth::user()->user_role == 1 ||
                                    (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                    in_array('9', json_decode(Auth::user()->staff->role->permissions))))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::routeIs('lead*index') ? 'active' : '' }}" href="{{ route('lead.index') }}">
                                            <i class="fa fa-cog" aria-hidden="true"></i> Lead List
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::user()->user_role == 1 ||
                                    (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                    in_array('13', json_decode(Auth::user()->staff->role->permissions))))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::routeIs('customer*index') ? 'active' : '' }}" href="{{ route('customer.index') }}">
                                            <i class="fa fa-cog" aria-hidden="true"></i> Customer List
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif


                    @if(Auth::user()->user_role == 1 ||(is_array(json_decode(Auth::user()->staff->role->permissions))
                    &&(in_array('17', json_decode(Auth::user()->staff->role->permissions)) ||in_array('18', json_decode(Auth::user()->staff->role->permissions)))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#project" aria-controls="project" aria-expanded="{{ Request::routeIs('project*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>Projects <span class="badge badge-success">6</span>
                            </a>
                            <div id="project" class="collapse {{ Request::routeIs('project*') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('18', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('project*create') ? 'active' : '' }}" href="{{ route('project.create') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Project Create
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('17', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('project*index') ? 'active' : '' }}" href="{{ route('project.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Project List
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('project*request-list') ? 'active' : '' }}" href="{{ route('project.request-list') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Project Request List
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif


                    @if(Auth::user()->user_role == 1 ||(is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('37', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#expense" aria-controls="expense" aria-expanded="{{ Request::routeIs('expense-head*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>Expenses <span class="badge badge-success">6</span>
                            </a>
                            <div id="expense" class="collapse {{ Request::routeIs('expense-head*') || Request::routeIs('expense-sub-head*') || Request::routeIs('expense.index*') || Request::routeIs('expense*request.list') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('29', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('expense-head*index') ? 'active' : '' }}" href="{{ route('expense-head.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Expense Head
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('33', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('expense-sub-head*index') ? 'active' : '' }}" href="{{ route('expense-sub-head.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Expense Sub-Head
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('37', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('expense.index*') ? 'active' : '' }}" href="{{ route('expense.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Expense List
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('expense*request.list') ? 'active' : '' }}" href="{{ route('expense.request.list') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Expense Request List
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif


                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && (in_array('21', json_decode(Auth::user()->staff->role->permissions)) ||
                        in_array('25', json_decode(Auth::user()->staff->role->permissions)))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#staff" aria-controls="project" aria-expanded="{{ Request::routeIs('staff*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>Staffs <span class="badge badge-success">6</span>
                            </a>
                            <div id="staff" class="collapse {{ Request::routeIs('staff*') || Request::routeIs('roles*') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('21', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('staff*index') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> All Staff
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('25', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('roles*index') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Staff Permissions
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif


                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && (in_array('45', json_decode(Auth::user()->staff->role->permissions)) ||
                        in_array('46', json_decode(Auth::user()->staff->role->permissions)))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#payment" aria-controls="project" aria-expanded="{{ Request::routeIs('payment*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>Payment <span class="badge badge-success">6</span>
                            </a>
                            <div id="payment" class="collapse {{ Request::routeIs('payment*') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('46', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('payment*create') ? 'active' : '' }}" href="{{ route('payments.create') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Payment Create
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                                        in_array('45', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('payment*index') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Payment List
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('payment*request-list') ? 'active' : '' }}" href="{{ route('payment.request-list') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Payment Request List
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) &&
                        (in_array('41', json_decode(Auth::user()->staff->role->permissions)))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#topup" aria-controls="project" aria-expanded="{{ Request::routeIs('top-up*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>TopUp <span class="badge badge-success">6</span>
                            </a>
                            <div id="topup" class="collapse {{ Request::routeIs('top-up*') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 ||
                                        (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('41', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('top-up.index') ? 'active' : '' }}" href="{{ route('top-up.index') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> TopUp List
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('top-up.request-list') ? 'active' : '' }}" href="{{ route('top-up.request-list') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> TopUp Request List
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && (in_array('48', json_decode(Auth::user()->staff->role->permissions)) ||
                        in_array('52', json_decode(Auth::user()->staff->role->permissions)))))
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#accounts" aria-controls="project" aria-expanded="">
                            <i class="fa fa-fw fa-user-circle"></i>Accounts <span class="badge badge-success">6</span>
                        </a>

                        <div id="accounts" class="collapse {{ Request::routeIs('deposit.index*') || Request::routeIs('withdraw.index*') || Request::routeIs('cashbook.index*') ? 'show' : '' }}">
                            <ul class="nav flex-column">
                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('48', json_decode(Auth::user()->staff->role->permissions))))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#deposit" aria-controls="project" aria-expanded="{{ Request::routeIs('deposit*') || Request::routeIs('customer*') ? 'true' : 'false' }}">
                                            <i class="fa fa-fw fa-user-circle"></i>Deposit <span class="badge badge-success">6</span>
                                        </a>
                                        <div id="deposit" class="collapse {{ Request::routeIs('deposit.index*') || Request::routeIs('deposit.request-list*') ? 'show' : '' }}">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ Request::routeIs('deposit*index') ? 'active' : '' }}" href="{{ route('deposit.index') }}">
                                                        <i class="fa fa-cog" aria-hidden="true"></i> Deposit List
                                                    </a>
                                                </li>

                                                @if(Auth::user()->user_role == 1)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ Request::routeIs('deposit.request-list*') ? 'active' : '' }}" href="{{ route('deposit.request-list') }}">
                                                            <i class="fa fa-cog" aria-hidden="true"></i> Deposit Request List
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('52', json_decode(Auth::user()->staff->role->permissions))))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#withdraw" aria-controls="project" aria-expanded="{{ Request::routeIs('withdraw.index*') || Request::routeIs('withdraw.request-list*') ? 'true' : 'false' }}">
                                            <i class="fa fa-fw fa-user-circle"></i>Withdraw <span class="badge badge-success">6</span>
                                        </a>
                                        <div id="withdraw" class="collapse {{ Request::routeIs('withdraw.index*') || Request::routeIs('withdraw.request-list*') ? 'show' : '' }}">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ Request::routeIs('withdraw.index*') ? 'active' : '' }}" href="{{ route('withdraw.index') }}">
                                                        <i class="fa fa-cog" aria-hidden="true"></i> Withdraw List
                                                    </a>
                                                </li>

                                                @if(Auth::user()->user_role == 1)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ Request::routeIs('withdraw.request-list*') ? 'active' : '' }}" href="{{ route('withdraw.request-list') }}">
                                                            <i class="fa fa-fw fa-user-circle" aria-hidden="true"></i> Withdraw Request List
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if(Auth::user()->user_role == 1)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::routeIs('cashbook.index*') ? 'active' : '' }}" href="{{ route('account.ledger.list') }}">
                                            <i class="fa fa-cog" aria-hidden="true"></i> Cashbook
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && (in_array('56', json_decode(Auth::user()->staff->role->permissions)) ||
                        in_array('57', json_decode(Auth::user()->staff->role->permissions)) || in_array('58', json_decode(Auth::user()->staff->role->permissions)) || in_array('59', json_decode(Auth::user()->staff->role->permissions))
                        || in_array('60', json_decode(Auth::user()->staff->role->permissions)))))
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#payment-report" aria-controls="project" aria-expanded="{{ Request::routeIs('report.payment*') || Request::routeIs('report.project-wise.profit-loss*')
                            || Request::routeIs('report.all-income*') || Request::routeIs('report.all-expense*') || Request::routeIs('report.all-profit-loss*') ? 'true' : 'false' }}">
                                <i class="fa fa-fw fa-user-circle"></i>Report <span class="badge badge-success">6</span>
                            </a>
                            <div id="payment-report" class="collapse {{ Request::routeIs('report.payment*') || Request::routeIs('report.project-wise.profit-loss*') || Request::routeIs('report.all-income*')
                            || Request::routeIs('report.all-expense*') || Request::routeIs('report.all-profit-loss*') ? 'show' : '' }}">
                                <ul class="nav flex-column">
                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('60', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('report.payment*') ? 'active' : '' }}" href="{{ route('report.payment') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Payment Report
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('58', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('report.project-wise.profit-loss*') ? 'active' : '' }}" href="{{ route('report.project-wise.profit-loss') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Project wise profit/loss
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('56', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('report.all-income*') ? 'active' : '' }}" href="{{ route('report.all-income') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> All Income
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('57', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('report.all-expense*') ? 'active' : '' }}" href="{{ route('report.all-expense') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> All Expense
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('59', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::routeIs('report.all-profit-loss*') ? 'active' : '' }}" href="{{ route('report.all-profit-loss') }}">
                                                <i class="fa fa-cog" aria-hidden="true"></i> Profit Loss
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if(Auth::user()->user_role == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('setting*') ? 'active' : '' }}" href="{{ route('setting.index') }}">
                                <i class="fa fa-cog" aria-hidden="true"></i> Setting
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
