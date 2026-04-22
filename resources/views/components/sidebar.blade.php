<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
          
            <span class="app-brand-text demo menu-text fw-bold ms-2">FeedTan Pay</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Payments -->
        <li class="menu-item {{ request()->routeIs('payments*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div class="text-truncate" data-i18n="Payments">Payments</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('payments.initiate') ? 'active' : '' }}">
                    <a href="{{ route('payments.initiate') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Initiate Payment">Initiate Payment</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('payments.history') ? 'active' : '' }}">
                    <a href="{{ route('payments.history') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Payment History">Payment History</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Payouts -->
        <li class="menu-item {{ request()->routeIs('payouts*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                <div class="text-truncate" data-i18n="Payouts">Payouts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('payouts.initiate') ? 'active' : '' }}">
                    <a href="{{ route('payouts.initiate') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Initiate Payout">Initiate Payout</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('payouts.history') ? 'active' : '' }}">
                    <a href="{{ route('payouts.history') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Payout History">Payout History</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- BillPay -->
        <li class="menu-item {{ request()->routeIs('billpay*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div class="text-truncate" data-i18n="BillPay">BillPay</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('billpay.all') ? 'active' : '' }}">
                    <a href="{{ route('billpay.all') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="All Bills">All Bills</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('billpay.create') ? 'active' : '' }}">
                    <a href="{{ route('billpay.create') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Create Bill">Create Bill</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Report -->
        <li class="menu-item {{ request()->routeIs('report*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-chart"></i>
                <div class="text-truncate" data-i18n="Report">Report</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('report.overview') ? 'active' : '' }}">
                    <a href="{{ route('report.overview') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Overview">Overview</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('report.balance') ? 'active' : '' }}">
                    <a href="{{ route('report.balance') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Balance">Balance</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('report.statement') ? 'active' : '' }}">
                    <a href="{{ route('report.statement') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Statement">Statement</div>
                    </a>
                </li>
            </ul>
        </li>

            <!-- Account Settings -->
      
        <li class="menu-item {{ request()->routeIs('account-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="My Profile">My Profile</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('account-settings.notifications') ? 'active' : '' }}">
                    <a href="{{ route('account-settings.notifications') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('security') ? 'active' : '' }}">
                    <a href="{{ route('security') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Security">Security</div>
                    </a>
                </li>
            </ul>
        </li>

        </li>

        <!-- System Settings -->
        
        <li class="menu-item {{ request()->routeIs('system-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate" data-i18n="System Settings">System Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('system-settings.general') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.general') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="General Settings">General Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.payment') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.payment') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Payment Settings">Payment Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.security') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.security') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Security Settings">Security Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.notification') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.notification') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Notification Settings">Notification Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.user') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.user') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="User Settings">User Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.integration') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.integration') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Integration Settings">Integration Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.maintenance') ? 'active' : '' }}">
                    <a href="{{ route('system-settings.maintenance') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="System Maintenance">System Maintenance</div>
                    </a>
                </li>
            </ul>
        </li>

        </ul>
</aside>
<!-- / Menu -->
