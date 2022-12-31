<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('img/lgulopezquezon.png')}}" alt="LGU Kalibo Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.client', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('access-dashboard')
                <li class="nav-item keychainify-checked">
                    <a href="{{route('home')}}" class="nav-link {{ request()->is('home') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @endcan

                {{-- <li class="nav-header"><i class="right fas fa-database"></i> Assessor</li> --}}
                @can('access-assessor')
                <li class="nav-item keychainify-checked">
                    <a href="#" class="nav-link {{ request()->is('assessor/account-verification')
                     || request()->is('assessor/ledger-entry')
                     || request()->is('assessor/assessment-roll')
                         ? 'active' : ''}}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Assessor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display:{{ request()->is('assessor/account-verification')
                        || request()->is('assessor/ledger-entry')
                        || request()->is('assessor/assessment-roll') ? 'block' : '' }}">
                        @can('manage-assessment_roll')
                        <li class="nav-item">
                            <a href="{{route('assessor_assessment_roll')}}" class="nav-link
                            {{ request()->is('assessor/assessment-roll')
                                 ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Assessment Roll</p>
                            </a>
                        </li>
                        @endcan
                        @can('manage-account_verification')
                        <li class="nav-item">
                            <a href="{{route('assessor_account_verification')}}" class="nav-link
                            {{ request()->is('assessor/account-verification')
                                 ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Verification</p>
                            </a>
                        </li>
                        @endcan
                        {{-- <li class="nav-item">
                            <a href="{{route('assessor_ledger_entry')}}" class="nav-link
                            {{ request()->is('assessor/ledger-entry')
                                 ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ledger Entry</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                @endcan

                {{-- <li class="nav-header"><i class="right fas fa-database"></i> Real Property Tax</li> --}}
                @can('access-rpt')
                <li class="nav-item">
                    <a href="#" class="nav-link keychainify-checked
                        {{ request()->is('rpt/ledger/collection') || request()->is('rpt/ledger/accounts')
                        || request()->is('rpt/ledger/delinquency') || request()->is('rpt_delinquency_accounts')
                        || request()->is('rpt/ledger/barangay-masterlist')
                         ? 'active' : ''}}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Real Property Tax
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display:{{ request()->is('rpt/ledger/collection')
                        || request()->is('rpt/ledger/accounts')
                        || request()->is('rpt/ledger/delinquency') || request()->is('rpt_delinquency_accounts')
                        || request()->is('rpt/ledger/barangay-masterlist') ? 'block' : 'none' }}">
                        @can('manage-collection')
                        <li class="nav-item">
                            <a href="{{route('rpt_collection_accounts')}}"
                                class="nav-link {{ request()->is('rpt/ledger/collection') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Collection</p>
                            </a>
                        </li>
                        @endcan
                        {{-- <li class="nav-item">
                            <a href="{{route('rpt_ledger_accounts')}}"
                                class="nav-link {{ request()->is('rpt/ledger/accounts') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ledger Entry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('rpt_delinquency_accounts')}}"
                                class="nav-link {{ request()->is('rpt/ledger/delinquency') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Statement of Delinquency</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('rpt_barangay_masterlists')}}"
                                class="nav-link {{ request()->is('rpt/ledger/barangay-masterlist') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barangay Masterlist</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                @endcan

                {{-- <li class="nav-header"><i class="right fas fa-database"></i> Revenue Collection System</li> --}}
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link keychainify-checked">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Revenue Collection
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link keychainify-checked">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Forms</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('form_52')}}" class="nav-link keychainify-checked">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Accoutable Form No. 52</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('form_53')}}" class="nav-link keychainify-checked">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Accoutable Form No. 53</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('form_57')}}" class="nav-link keychainify-checked">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Accoutable Form No. 57</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('form_58')}}" class="nav-link keychainify-checked">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Accoutable Form No. 58</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('form_0017')}}" class="nav-link keychainify-checked">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>BIR Form No. 0017</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{route('collection-abstract')}}"
                                class="nav-link {{ request()->is('collection-abstract') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>

                    </ul>
                </li> --}}
                @can('access-settings')
                <li class="nav-item keychainify-checked">
                    <a href="#" class="nav-link
                    {{request()->is('settings/address')
                    ||request()->is('settings/taxtables')
                    ||request()->is('settings/users')
                    ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display:{{ request()->is('settings/address')
                        || request()->is('settings/taxtables')
                        || request()->is('settings/users')
                        ? 'block' : 'none' }}">
                        @can('manage-address')
                        <li class="nav-item">
                            <a href="{{route('settings_address')}}" class="nav-link
                                {{ request()->is('settings/address')
                                ? 'active' : ''}}">
                                <i class="nav-icon fas fa-map-marked"></i>
                                <p>Address</p>
                            </a>
                        </li>
                        @endcan
                        @can('manage-tax_table')
                        <li class="nav-item">
                            <a href="{{route('settings_taxtables')}}" class="nav-link
                                {{ request()->is('settings/taxtables')
                                ? 'active' : ''}}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Tax Table</p>
                            </a>
                        </li>
                        @endcan
                        @can('manage-user')
                        <li class="nav-item">
                            <a href="{{route('settings_users')}}" class="nav-link
                                {{ request()->is('settings/users')
                                ? 'active' : ''}}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('access-reports')
                <li class="nav-item keychainify-checked">
                    <a href="{{route('reports')}}" class="nav-link
                    {{request()->is('reports') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Reports </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
