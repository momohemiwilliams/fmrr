<!-- sidebar @s -->
<style>
    .nk-sidebar.fmdq-sidebar {
        border-right: none !important;
        box-shadow: 4px 0 24px rgba(8, 22, 58, 0.14) !important;
    }

    .nk-sidebar.fmdq-sidebar .nk-sidebar-head {
        background: #ffffff;
        border-bottom: 2px solid rgba(213, 167, 59, 0.35);
        height: 66px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
    }

    .nk-sidebar.fmdq-sidebar .fmdq-sidebar-body {
        background: linear-gradient(180deg, #0c2b70 0%, #132c6b 55%, #091d4a 100%) !important;
        height: calc(100vh - 66px);
    }

    .nk-sidebar.fmdq-sidebar .nk-menu {
        padding: 14px 0 28px;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-heading {
        padding: 14px 22px 6px !important;
        margin-top: 4px;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-heading:first-child {
        padding-top: 4px !important;
        margin-top: 0;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-heading .overline-title {
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(244, 208, 120, 0.72) !important;
        margin: 0;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu > .nk-menu-item {
        padding: 2px 12px;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu > .nk-menu-item > .nk-menu-link {
        border-radius: 10px;
        padding: 9px 14px;
        color: rgba(255, 255, 255, 0.86) !important;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        align-items: center;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu > .nk-menu-item > .nk-menu-link:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu > .nk-menu-item.active > .nk-menu-link,
    .nk-sidebar.fmdq-sidebar .nk-menu > .nk-menu-item.current-page > .nk-menu-link {
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: inset 3px 0 0 #d5a73b, 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-icon {
        color: rgba(255, 255, 255, 0.78) !important;
        width: 30px;
        font-size: 18px;
        transition: color 0.2s ease;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-link:hover .nk-menu-icon {
        color: #ffffff !important;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-item.active > .nk-menu-link .nk-menu-icon,
    .nk-sidebar.fmdq-sidebar .nk-menu-item.current-page > .nk-menu-link .nk-menu-icon {
        color: #f4d078 !important;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-text {
        color: inherit !important;
        font-size: 13.5px;
        font-weight: 500;
        letter-spacing: 0.1px;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-item.has-sub > .nk-menu-toggle::after {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 12px;
        right: 12px;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-sub {
        padding: 4px 0 6px 26px !important;
        margin: 4px 0 4px 20px;
        border-left: 1.5px solid rgba(255, 255, 255, 0.16);
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-sub .nk-menu-item {
        padding: 1px 0;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-sub .nk-menu-link {
        padding: 6px 12px !important;
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.76) !important;
        font-size: 13px !important;
        transition: all 0.2s ease;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-sub .nk-menu-link:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-sub .nk-menu-item.active > .nk-menu-link {
        background: rgba(213, 167, 59, 0.18) !important;
        color: #f4d078 !important;
        font-weight: 600;
    }

    .nk-sidebar.fmdq-sidebar .nk-menu-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 10px 20px;
        list-style: none;
    }
</style>

<div class="nk-sidebar nk-sidebar-fixed is-light fmdq-sidebar" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{ url('dashboard') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img logo-img-lg" src="{{ asset('public/admin/images/FMDQlogo.svg') }}"
                    srcset="{{ asset('public/admin/images/FMDQlogo.svg') }}" alt="FMDQ Logo">
                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('public/admin/images/FMDQlogo.svg') }}"
                    srcset="{{ asset('public/admin/images/FMDQlogo.svg') }}" alt="FMDQ Logo">
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->

    <div class="nk-sidebar-element fmdq-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <!-- Overview -->
                    <li class="nk-menu-heading">
                        <h6 class="overline-title">Overview</h6>
                    </li>
                    <li class="nk-menu-item {{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Access & Administration -->
                    @canany(['user-list', 'role-list', 'group-list'])
                        <li class="nk-menu-heading">
                            <h6 class="overline-title">Access &amp; Administration</h6>
                        </li>
                    @endcanany

                    @can('user-list')
                        @php $isUsersActive = request()->is('admin_users*', 'eternal_users*', 'users*', 'deactivated*'); @endphp
                        <li class="nk-menu-item has-sub {{ $isUsersActive ? 'active current-page' : '' }}">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Users</span>
                            </a>
                            <ul class="nk-menu-sub" style="{{ $isUsersActive ? 'display: block;' : '' }}">
                                <li class="nk-menu-item {{ request()->is('admin_users*') ? 'active' : '' }}">
                                    <a href="{{ url('admin_users') }}" class="nk-menu-link">
                                        <span class="nk-menu-text">Internal Users</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item {{ request()->is('eternal_users*') ? 'active' : '' }}">
                                    <a href="{{ url('eternal_users') }}" class="nk-menu-link">
                                        <span class="nk-menu-text">External Users</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('role-list')
                        <li class="nk-menu-item {{ request()->is('roles*') ? 'active current-page' : '' }}">
                            <a href="{{ url('roles') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-shield-star"></em></span>
                                <span class="nk-menu-text">Roles &amp; Permissions</span>
                            </a>
                        </li>
                    @endcan

                    @can('group-list')
                        <li class="nk-menu-item {{ request()->is('groups*') ? 'active current-page' : '' }}">
                            <a href="{{ url('groups') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span>
                                <span class="nk-menu-text">Group Management</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Content & Repository -->
                    @canany(['Market-Product-Tag-list', 'category-list', 'entity-list', 'news-list', 'document-list'])
                        <li class="nk-menu-heading">
                            <h6 class="overline-title">Content &amp; Repository</h6>
                        </li>
                    @endcanany

                    @can('document-list')
                        <li class="nk-menu-item {{ request()->is('regulations*') ? 'active current-page' : '' }}">
                            <a href="{{ url('regulations') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                                <span class="nk-menu-text">Documents</span>
                            </a>
                        </li>
                    @endcan

                    @can('category-list')
                        @php $isCategoryActive = request()->is('categories*', 'subcategories*'); @endphp
                        <li class="nk-menu-item has-sub {{ $isCategoryActive ? 'active current-page' : '' }}">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-folder-list"></em></span>
                                <span class="nk-menu-text">Category Management</span>
                            </a>
                            <ul class="nk-menu-sub" style="{{ $isCategoryActive ? 'display: block;' : '' }}">
                                <li class="nk-menu-item {{ request()->is('categories*') ? 'active' : '' }}">
                                    <a href="{{ url('categories') }}" class="nk-menu-link">
                                        <span class="nk-menu-text">Categories</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item {{ request()->is('subcategories*') ? 'active' : '' }}">
                                    <a href="{{ url('subcategories') }}" class="nk-menu-link">
                                        <span class="nk-menu-text">Sub Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('Market-Product-Tag-list')
                        <li class="nk-menu-item {{ request()->is('market-product-tags*') ? 'active current-page' : '' }}">
                            <a href="{{ url('market-product-tags') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-tag"></em></span>
                                <span class="nk-menu-text">Markets &amp; Products</span>
                            </a>
                        </li>
                    @endcan

                    @can('entity-list')
                        <li class="nk-menu-item {{ request()->is('entities*') ? 'active current-page' : '' }}">
                            <a href="{{ url('entities') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-building"></em></span>
                                <span class="nk-menu-text">Entity</span>
                            </a>
                        </li>
                    @endcan

                    @can('news-list')
                        <li class="nk-menu-item {{ request()->is('news*') ? 'active current-page' : '' }}">
                            <a href="{{ url('news') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                                <span class="nk-menu-text">News Alert</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Subscriptions & Compliance -->
                    @canany(['subscription-list', 'subscription-tier-list', 'student-verification-list', 'Audit-log', 'Disclaimer-History'])
                        <li class="nk-menu-heading">
                            <h6 class="overline-title">Subscriptions &amp; Compliance</h6>
                        </li>
                    @endcanany

                    @canany(['subscription-list', 'subscription-tier-list', 'student-verification-list'])
                        @php $isSubActive = request()->is('subscription-tiers*', 'subscription-sub-tiers*', 'subcription_plan*', 'subscribers*', 'student-verification*'); @endphp
                        <li class="nk-menu-item has-sub {{ $isSubActive ? 'active current-page' : '' }}">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                                <span class="nk-menu-text">Subscription Management</span>
                            </a>
                            <ul class="nk-menu-sub" style="{{ $isSubActive ? 'display: block;' : '' }}">
                                @can('subscription-tier-list')
                                    <li class="nk-menu-item {{ request()->routeIs('subscription-tiers.*') ? 'active' : '' }}">
                                        <a href="{{ route('subscription-tiers.index') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Subscription Tiers</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item {{ request()->routeIs('subscription-sub-tiers.*') ? 'active' : '' }}">
                                        <a href="{{ route('subscription-sub-tiers.index') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Subscription Sub-Tiers</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('subscription-list')
                                    <li class="nk-menu-item {{ request()->is('subcription_plan*') ? 'active' : '' }}">
                                        <a href="{{ url('subcription_plan') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Subscription Plans</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item {{ request()->is('subscribers*') ? 'active' : '' }}">
                                        <a href="{{ url('subscribers') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Subscribers</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('student-verification-list')
                                    <li class="nk-menu-item {{ request()->routeIs('studentVerification.*') ? 'active' : '' }}">
                                        <a href="{{ route('studentVerification.index') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Academic Verification</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    @can('Audit-log')
                        <li class="nk-menu-item {{ request()->is('logActivity*') ? 'active current-page' : '' }}">
                            <a href="{{ url('logActivity') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-activity-round"></em></span>
                                <span class="nk-menu-text">Audit Logs</span>
                            </a>
                        </li>
                    @endcan

                    @can('Disclaimer-History')
                        <li class="nk-menu-item {{ request()->routeIs('admin.disclaimers.*') ? 'active current-page' : '' }}">
                            <a href="{{ route('admin.disclaimers.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-file-check"></em></span>
                                <span class="nk-menu-text">Disclaimer History</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Account & Portal -->
                    <li class="nk-menu-divider"></li>
                    <li class="nk-menu-heading">
                        <h6 class="overline-title">Account &amp; Portal</h6>
                    </li>
                    <li class="nk-menu-item {{ request()->routeIs('admin.profile') ? 'active current-page' : '' }}">
                        <a href="{{ route('admin.profile') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-account-setting-alt"></em></span>
                            <span class="nk-menu-text">Profile Settings</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('home') }}" target="_blank" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span>
                            <span class="nk-menu-text">View Frontend</span>
                        </a>
                    </li>
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->
