<style>
    a {
        text-decoration: none;
    }

    .sb-item.active {
        /* Keep your existing active CSS here */
        /* Example:
        background: #f0f4ff;
        color: #4f46e5;
        */
    }
</style>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-top">
        <a href="{{ url('admin/dashboard') }}">
            <div class="sb-brand">
                <div class="sb-brand-ic">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <div class="sb-brand-text">MERIT</div>
                    <span class="sb-brand-sub">Admin Portal</span>
                </div>
            </div>
        </a>
    </div>

    <div class="sidebar-body">

        {{-- ================= MAIN ================= --}}
        <div class="sb-section">Main</div>

        <a href="{{ url('admin/dashboard') }}">
            <div class="sb-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </div>
        </a>


        {{-- ================= PEOPLE ================= --}}
        <div class="sb-section">People</div>

        <a href="{{ route('admin.free.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.free.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>All Trial</span>
            </div>
        </a>

        <a href="{{ route('contact-messages.index') }}">
            <div class="sb-item {{ request()->routeIs('contact-messages.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </div>
        </a>

        <a href="{{ route('user.index') }}">
            <div class="sb-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>All Users</span>
            </div>
        </a>


        {{-- ================= ACADEMIC MANAGEMENT ================= --}}
        <div class="sb-section">Academic</div>

        <a href="{{ route('admin.teachers.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </div>
        </a>

        <a href="{{ route('admin.parents.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.parents.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i>
                <span>Parents</span>
            </div>
        </a>

        <a href="{{ route('admin.students.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </div>
        </a>

        <a href="{{ route('admin.lessons.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.lessons.*') && ! request()->routeIs('admin.lessons.timetable') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i>
                <span>Lessons</span>
            </div>
        </a>

        <a href="{{ route('admin.lessons.timetable') }}">
            <div class="sb-item {{ request()->routeIs('admin.lessons.timetable') ? 'active' : '' }}">
                <i class="fas fa-calendar-week"></i>
                <span>Timetable</span>
            </div>
        </a>

        <a href="{{ route('admin.progress.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.progress.*', 'admin.lessons.report') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Progress Reports</span>
            </div>
        </a>

        <a href="{{ route('admin.resources.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i>
                <span>Learning Resources</span>
            </div>
        </a>

        <a href="{{ route('admin.lookups.index', 'branches') }}">
            <div class="sb-item {{ request()->routeIs('admin.lookups.*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i>
                <span>Academic Settings</span>
            </div>
        </a>


        {{-- ================= OPERATIONS ================= --}}
        <div class="sb-section">Operations</div>

        <a href="{{ route('admin.category.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Category Index</span>
            </div>
        </a>

        <a href="{{ route('admin.category.create') }}">
            <div class="sb-item {{ request()->routeIs('admin.category.create') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Category Create</span>
            </div>
        </a>


        {{-- ================= PRICE CATEGORIES ================= --}}
        <div class="sb-section">Price Categories</div>

        <a href="{{ route('admin.fees-category.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.fees-category.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Price Category Index</span>
            </div>
        </a>

        <a href="{{ route('admin.fees-category.create') }}">
            <div class="sb-item {{ request()->routeIs('admin.fees-category.create') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Price Category Create</span>
            </div>
        </a>


        {{-- ================= PLAN CATEGORIES ================= --}}
        <div class="sb-section">Plan Categories</div>

        <a href="{{ route('admin.plans.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Plan Index</span>
            </div>
        </a>

        <a href="{{ route('admin.plans.create') }}">
            <div class="sb-item {{ request()->routeIs('admin.plans.create') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Plan Create</span>
            </div>
        </a>


        {{-- ================= CONTENT ================= --}}
        <div class="sb-section">Content</div>

        <a href="{{ route('admin.blogs.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span>News & Articles</span>
            </div>
        </a>

        <a href="{{ route('admin.blogs.create') }}">
            <div class="sb-item {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span>News & Articles Create</span>
            </div>
        </a>


        {{-- ================= SYSTEM ================= --}}
        <div class="sb-section">System</div>

        <a href="{{ route('admin.seo.update') }}">
            <div class="sb-item {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                <i class="fas fa-search"></i>
                <span>SEO Settings</span>
            </div>
        </a>

        <a href="{{ route('admin.company-information.index') }}">
            <div class="sb-item {{ request()->routeIs('admin.company-information.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </a>

        <a href="{{ route('subscriptions.index') }}">
            <div class="sb-item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Subscriptions User</span>
            </div>
        </a>

        <a href="{{ route('transactions.index') }}">
            <div class="sb-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Transactions</span>
            </div>
        </a>

        <a href="{{ route('admin.social.update') }}">
            <div class="sb-item {{ request()->routeIs('admin.social.*') ? 'active' : '' }}">
                <i class="fas fa-share-alt"></i>
                <span>Social Media</span>
            </div>
        </a>

    </div>


    {{-- ================= FOOTER ================= --}}
    <div class="sidebar-footer">

        <div class="sb-admin-row">
            <div class="sb-admin-av">SA</div>

            <div>
                <div class="sb-admin-name">Super Admin</div>
                <div class="sb-admin-role">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>

        <a class="sb-logout-btn" href="{{ route('admin.logout') }}">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sb-logout-text">Sign Out</span>
        </a>

    </div>

</aside>