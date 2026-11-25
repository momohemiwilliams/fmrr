<style>
    .header ul li.active a, 
    .header ul li.active {
        color: #C79D51 !important;
        font-weight: 600;
    }

    /* Profile Dropdown Styling */
    .profile-dropdown-container {
        position: relative;
        display: inline-flex;
        align-items: center;
        margin-right: 4px;
        margin-top: 6px;
        margin-bottom: 6px;
    }

    .profile-dropdown-trigger {
        cursor: pointer;
        user-select: none;
        outline: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-width: 92px;
        height: 46px;
        padding: 0 18px;
        background: linear-gradient(135deg, #0c2b70 0%, #17337f 100%);
        border: 1.5px solid #d5a73b;
        border-radius: 24px;
        box-shadow: 0 3px 10px rgba(12, 43, 112, 0.22);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .profile-dropdown-trigger:hover,
    .profile-dropdown-container.active .profile-dropdown-trigger {
        background: linear-gradient(135deg, #103282 0%, #1d3c94 100%);
        box-shadow: 0 4px 16px rgba(213, 167, 59, 0.35);
        border-color: #f4d078;
    }

    .profile-initials-text {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        font-weight: 700;
        font-size: 15.5px;
        color: #ffffff;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .profile-arrow-circle {
        width: 24px;
        height: 24px;
        min-width: 24px;
        border-radius: 50%;
        border: 1.5px solid #d5a73b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease;
    }

    .profile-dropdown-container:hover .profile-arrow-circle,
    .profile-dropdown-container.active .profile-arrow-circle {
        transform: rotate(180deg);
        border-color: #f4d078;
    }

    .profile-dropdown-menu {
        position: absolute;
        top: calc(100% + 14px);
        right: 0;
        width: 250px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 16px 40px -4px rgba(12, 43, 112, 0.22), 0 4px 14px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(29, 50, 109, 0.12);
        z-index: 1050;
        padding: 8px;
        visibility: hidden;
        opacity: 0;
        transform: translateY(-6px);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        box-sizing: border-box;
    }

    /* Invisible hover bridge */
    .profile-dropdown-menu::before {
        content: '';
        position: absolute;
        top: -14px;
        left: 0;
        right: 0;
        height: 14px;
    }

    /* Upward caret pointer pointing directly under button arrow */
    .profile-dropdown-menu::after {
        content: '';
        position: absolute;
        top: -6px;
        right: 24px;
        width: 12px;
        height: 12px;
        background: #ffffff;
        transform: rotate(45deg);
        border-top: 1px solid rgba(29, 50, 109, 0.12);
        border-left: 1px solid rgba(29, 50, 109, 0.12);
        z-index: 2;
    }

    .profile-dropdown-container:hover .profile-dropdown-menu,
    .profile-dropdown-container.active .profile-dropdown-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .profile-dropdown-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px 12px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 6px;
        position: relative;
        z-index: 3;
    }

    .profile-avatar-circle {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(12, 43, 112, 0.25);
        border: 1.5px solid #d5a73b;
    }

    .profile-user-text {
        min-width: 0;
        flex: 1;
    }

    .profile-dropdown-user-name {
        font-size: 14px;
        font-weight: 700;
        color: #0c2b70;
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-dropdown-user-email {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-dropdown-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .profile-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 12px;
        font-size: 13.5px;
        font-weight: 500;
        color: #334155;
        text-decoration: none !important;
        border-radius: 10px;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }

    .profile-dropdown-item:hover {
        background-color: #f8fafc;
        color: #0c2b70;
    }

    .profile-item-icon {
        width: 36px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #64748b;
        transition: color 0.15s ease;
    }

    .profile-dropdown-item:hover .profile-item-icon {
        color: #0c2b70;
    }

    .profile-item-label {
        flex: 1;
        font-size: 13.5px;
        font-weight: 500;
        line-height: 1;
    }

    .profile-dropdown-divider {
        height: 1px;
        background-color: #f1f5f9;
        margin: 6px 4px;
    }

    .profile-dropdown-item.item-danger {
        color: #dc2626;
    }

    .profile-dropdown-item.item-danger .profile-item-icon {
        color: #ef4444;
    }

    .profile-dropdown-item.item-danger:hover {
        background-color: #fef2f2;
        color: #b91c1c;
    }

    .profile-dropdown-item.item-danger:hover .profile-item-icon {
        color: #b91c1c;
    }
</style>
<header class="header-container">
    <div class="header">
        <a href="{{ url('/') }}"><img src="{{ asset('public/users/assets/FMDQ-logo.png') }}" alt="FMDQ Logo" /></a>
        <ul>
    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ url('/') }}">Home</a>
    </li>

    @php
        $navbar = \App\Models\Category::where('status', 1)->where('display_on_menu', 1)->get();
        $currentSlug = request()->route('slug');
    @endphp

    @foreach ($navbar as $menu)
        @php
            $isActive = request()->is('category/' . $menu->slug . '*') || 
                        (request()->is('subCategory/*') && $menu->subcategories->contains('slug', $currentSlug)) ||
                        (request()->is('subCategory/ceased/*') && $menu->subcategories->contains('slug', $currentSlug)) ||
                        (request()->is('category/ceased/' . $menu->slug . '*'));
        @endphp
        <li class="nav-flex {{ $isActive ? 'active' : '' }}">
            <a href="{{ route('categorypages', $menu->slug) }}">{{ $menu->name }} </a>

            @if ($menu->subcategories->where('status', 1)->isNotEmpty())
                <img src="{{ asset('public/users/assets/Arrow - Down.svg') }}" alt="arrow down" />
                <div class="dropdown-card">
                    @foreach ($menu->subcategories->where('status', 1) as $subcategory)
                        <a href="{{ url('/subCategory/' . $subcategory->slug) }}">
                            <div class="dc-items">
                                <div class="dc-items-title">{{ $subcategory->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </li>
    @endforeach

    <li class="{{ request()->routeIs('news') || request()->routeIs('newsalert') ? 'active' : '' }}">
        <a href="{{ route('newsalert') }}">News</a>
    </li>
  
    <li class="{{ request()->routeIs('feedback') ? 'active' : '' }}">
        <a href="{{ route('feedback') }}">Feedback</a>
    </li>

    @if (Auth::check())
        @php
            $hasTeamEligiblePlan = \App\Models\Subscription::where('user_id', Auth::id())
                ->where('status', 1)
                ->where('end_date', '>=', \Carbon\Carbon::now())
                ->whereHas('subscriptionPlan', function($q) {
                    $q->where('seat_limit', '>', 1)
                      ->orWhere('name', 'like', '%Institutional Academic%');
                })
                ->exists();
        @endphp
        @if ($hasTeamEligiblePlan)
            <li class="{{ request()->routeIs('institutionalMember.*') ? 'active' : '' }}">
                <a href="{{ route('institutionalMember.index') }}" style="color: #c79d51 !important; font-weight: 700;">
                    Manage Team (Seats)
                </a>
            </li>
        @endif
    @endif

    <li>
        <a href="{{ route('user.manual') }}" target="_blank">User Manual</a>
    </li>
           
        </ul>
        @if (Auth::check())
            @php
                $nameParts = explode(' ', trim(Auth::user()->name ?? 'U'));
                $userInitials = strtoupper(substr($nameParts[0] ?? 'U', 0, 1));
                if (count($nameParts) > 1) {
                    $userInitials .= strtoupper(substr(end($nameParts), 0, 1));
                }
            @endphp
            <div class="profile-dropdown-container" id="profileDropdownContainer">
                <div class="profile-dropdown-trigger" id="profileDropdownTrigger" role="button" tabindex="0" title="Account Menu">
                    <span class="profile-initials-text">{{ $userInitials }}</span>
                    <span class="profile-arrow-circle">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#d5a73b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </span>
                </div>

                <div class="profile-dropdown-menu">
                    <div class="profile-dropdown-user-info">
                        <div class="profile-avatar-circle">
                            {{ $userInitials }}
                        </div>
                        <div class="profile-user-text">
                            <div class="profile-dropdown-user-name">{{ Auth::user()->name ?? 'Account' }}</div>
                            <div class="profile-dropdown-user-email">{{ Auth::user()->email ?? '' }}</div>
                        </div>
                    </div>

                    <div class="profile-dropdown-list">
                        @if (Auth::user()->usertype == 'internal')
                            <a href="{{ route('dashboard') }}" class="profile-dropdown-item">
                                <span class="profile-item-icon">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </span>
                                <span class="profile-item-label">Dashboard</span>
                            </a>
                        @endif

                        <a href="{{ route('profile') }}" class="profile-dropdown-item">
                            <span class="profile-item-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            <span class="profile-item-label">Settings</span>
                        </a>

                        <a href="{{ route('user.manual') }}" target="_blank" class="profile-dropdown-item">
                            <span class="profile-item-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </span>
                            <span class="profile-item-label">User Manual</span>
                        </a>

                        <div class="profile-dropdown-divider"></div>

                        <a href="{{ route('logout') }}" class="profile-dropdown-item item-danger">
                            <span class="profile-item-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </span>
                            <span class="profile-item-label">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}">
                <div class="button-container">
                    <div class="gradient-buttons">
                        <div class="gradient-button-content">
                            <div>Log in</div>
                            <img src="{{ asset('public/users/assets/Arrow - Right.svg') }}" alt="Right Arrow" />
                        </div>
                    </div>
                </div>
            </a>
        @endif

    </div>
</header>

<script>
    (function () {
        function initProfileDropdown() {
            var dropdownContainer = document.getElementById('profileDropdownContainer');
            var dropdownTrigger = document.getElementById('profileDropdownTrigger');
            if (dropdownContainer && dropdownTrigger && !dropdownTrigger.dataset.initialized) {
                dropdownTrigger.dataset.initialized = "true";
                dropdownTrigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdownContainer.classList.toggle('active');
                });

                document.addEventListener('click', function (e) {
                    if (!dropdownContainer.contains(e.target)) {
                        dropdownContainer.classList.remove('active');
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        dropdownContainer.classList.remove('active');
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initProfileDropdown);
        } else {
            initProfileDropdown();
        }
    })();
</script>
