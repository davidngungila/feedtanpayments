<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center me-auto">
            <div class="nav-item d-flex align-items-center">
                <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none" placeholder="Search..." aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
            <!-- Notifications -->
            <li class="nav-item navbar-dropdown dropdown-notifications dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="icon-base bx bx-bell icon-md"></i>
                    <span class="badge rounded-pill bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">Notifications</li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm bg-label-success rounded-circle">
                                        <i class="bx bx-dollar"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Payment Received</h6>
                                    <small class="text-muted">You received $250.00 from John Doe</small>
                                </div>
                                <small class="text-muted">5 min ago</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm bg-label-warning rounded-circle">
                                        <i class="bx bx-file"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Bill Due Soon</h6>
                                    <small class="text-muted">Electric bill due in 3 days</small>
                                </div>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm bg-label-danger rounded-circle">
                                        <i class="bx bx-shield"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Security Alert</h6>
                                    <small class="text-muted">New login from unknown device</small>
                                </div>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('system-settings.notification') }}">
                            <i class="icon-base bx bx-cog icon-md me-3"></i><span>Manage Notifications</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Notifications -->

            
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown ms-3">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ Auth::user()->name ?? 'John Doe' }}</h6>
                                    <small class="text-body-secondary">{{ Auth::user()->role ?? 'Admin' }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('account-settings') }}">
                            <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('security') }}">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i>
                                <span class="flex-grow-1 align-middle">Billing Plan</span>
                                <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left; padding: 0.5rem 1rem; cursor: pointer;">
                                <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->
