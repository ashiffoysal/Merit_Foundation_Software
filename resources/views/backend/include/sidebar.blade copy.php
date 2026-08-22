<style>
    a {
        /* color: rgba(var(--bs-link-color-rgb), var(--bs-link-opacity, 1)); */
        text-decoration: none;
    }
</style>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
        <a href="{{ url('admin/dashboard') }}">
            <div class="sb-brand">
                <div class="sb-brand-ic"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="sb-brand-text">MERIT</div>
                    <span class="sb-brand-sub">Admin Portal</span>
                </div>
            </div>
        </a>
    </div>
    <div class="sidebar-body">
        <div class="sb-section">Main</div>
        <a href="{{ url('admin/dashboard') }}">
            <div class="sb-item active"><i class="fas fa-th-large"></i><span>Dashboard</span></div>
        </a>
        <div class="sb-section">People</div>
        {{-- <div class="sb-item" onclick="showView('students',this)"><i class="fas fa-user-graduate"></i><span>Students</span><span class="sb-badge">124</span></div>
      <div class="sb-item" onclick="showView('tutors',this)"><i class="fas fa-chalkboard-teacher"></i><span>Tutors</span></div> --}}

        <a href="{{ route('admin.free.index') }}">
            <div class="sb-item">
                <i class="fas fa-envelope"></i>
                <span>All Trial</span>
            </div>
        </a>
        <a href="{{ route('contact-messages.index') }}">
            <div class="sb-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </div>
        </a>
        <a class="sb-item" href="{{ route('user.index') }}">
            <i class="fas fa-users"></i>
            <span>All Users</span>
        </a>
        <div class="sb-section">Operations</div>
        <a href="{{ route('admin.category.index') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Category Index</span>

            </div>
        </a>
        <a href="{{ route('admin.category.create') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Category Create</span>

            </div>
        </a>
        <div class="sb-section">Price Categories</div>
        <a href="{{ route('admin.fees-category.index') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Price Category Index</span>

            </div>
        </a>
        <a href="{{ route('admin.fees-category.create') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Price Category Create</span>

            </div>
        </a>


        <div class="sb-section">Plan Categories</div>
        <a href="{{ route('admin.plans.index') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Plan Index</span>

            </div>
        </a>
        <a href="{{ route('admin.plans.create') }}">
            <div class="sb-item">
                <i class="fas fa-graduation-cap"></i>
                <span>Plan Create</span>

            </div>
        </a>
        <div class="sb-section">Content</div>
        <a href="{{ route('admin.blogs.index') }}">
            <div class="sb-item"><i class="fas fa-newspaper"></i><span>News & Articles</span></div>
        </a>
        <a href="{{ route('admin.blogs.create') }}">
            <div class="sb-item"><i class="fas fa-newspaper"></i><span>News & Articles Create</span></div>
        </a>

        <div class="sb-section">System</div>
        <a href="{{ route('admin.seo.update') }}">
            <div class="sb-item">
                <i class="fas fa-search"></i>
                <span>SEO Settings</span>
            </div>
        </a>
        <a href="{{ route('admin.company-information.index') }}">
            <div class="sb-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </a>

        <a href="{{ route('subscriptions.index') }}">
            <div class="sb-item">
                <i class="fas fa-cog"></i>
                <span>Subscriptions User</span>
            </div>
        </a>


        <a href="{{ route('transactions.index') }}">
            <div class="sb-item">
                <i class="fas fa-cog"></i>
                <span>Transactions</span>
            </div>
        </a>

        <a href="{{ route('admin.social.update') }}">
            <div class="sb-item">
                <i class="fas fa-share-alt"></i>
                <span>Social Media</span>
            </div>
        </a>
    </div>
    <div class="sidebar-footer">
        <div class="sb-admin-row">
            <div class="sb-admin-av">SA</div>
            <div>
                <div class="sb-admin-name">Super Admin</div>
                <div class="sb-admin-role">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <a class="sb-logout-btn" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt"></i><span
                class="sb-logout-text">Sign Out</span></a>
    </div>
</aside>
