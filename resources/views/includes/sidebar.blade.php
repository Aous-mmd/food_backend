<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href =#>
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Restaurant-Dashboard</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-utensils"></i>
                <span>Food List</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href = {{ route('admin.categories.index') }}>Categories</a>
                    <a class="collapse-item" href = {{ route('admin.foods.index') }}>Foods</a>
                    <a class="collapse-item" href = {{ route('admin.extra-categories.index') }}>Extra Categories</a>
                    <a class="collapse-item" href = {{ route('admin.extras.index') }}>Extras</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages2">
                <i class="fas fa-wrench"></i>
                <span>Website Settings</span>
            </a>
            <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href = {{ route('admin.restaurants.index') }}>Restaurant Info</a>
                    <a class="collapse-item" href = {{ route('admin.blogs.index') }}>Blogs Info</a>
{{--                    <a class="collapse-item" href = {{ route('admin.footers.index') }}>Footers Info</a>--}}
                    <a class="collapse-item" href = {{ route('admin.policies.index') }}>Policies Privacy</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href = {{ route('admin.delivery-addresses.index') }}>
                <i class="fas fa-truck"></i>
                <span>Delivery Addresses</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href = {{ route('admin.discounts.index') }}>
                <i class="fas fa-percent"></i>
                <span>Discounts</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href = {{ route('admin.orders.index') }}>
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Orders</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href = {{ route('admin.users.index') }}>
                <i class="fas fa-user"></i>
                <span>Users</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href = {{ route('admin.feedbacks.index') }}>
                <i class="fas fa-comments"></i>
                <span>Feedback</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</div>