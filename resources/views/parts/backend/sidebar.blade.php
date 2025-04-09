<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    @include('parts.backend.menu_item', [
        'name' => 'orders',
        'title' => 'Đơn hàng',
        'lists' => route('admin.orders.index'),
    ])
    @include('parts.backend.menu_item', [
        'name' => 'users',
        'title' => 'Người dùng',
        'lists' => route('admin.users.index'),
        'add' => route('admin.users.create'),
    ])
    @include('parts.backend.menu_item', [
        'name' => 'categories',
        'title' => 'Danh mục',
        'lists' => route('admin.categories.index'),
    ])
    @include('parts.backend.menu_item', [
        'name' => 'products',
        'title' => 'Sản phẩm',
        'lists' => route('admin.products.index'),
        'add' => route('admin.products.create'),
    ])


   

</ul>