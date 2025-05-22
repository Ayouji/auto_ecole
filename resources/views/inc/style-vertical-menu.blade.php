<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CORK Admin - Multipurpose Bootstrap Dashboard Template</title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .layout-boxed {
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar-wrapper {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 270px;
            background: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        /* Mini sidebar styles */
        .sidebar-wrapper.mini {
            width: 70px;
        }

        .sidebar-wrapper.mini .sidebar-brand img {
            width: 40px !important;
            transition: width 0.3s;
        }

        .sidebar-wrapper.mini .menu-text {
            display: none;
        }

        .sidebar-wrapper.mini .menu-item {
            justify-content: center;
            padding: 0.75rem 0;
        }

        .sidebar-wrapper.mini .menu-item i {
            margin-right: 0;
            font-size: 1.5rem;
        }

        .sidebar-wrapper.mini .user-profile-text {
            display: none;
        }

        .sidebar-wrapper.mini .sidebar-footer {
            text-align: center;
        }

        .sidebar-wrapper.mini .logout-text {
            display: none;
        }

        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand img {
            transition: width 0.3s;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem;
        }

        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            color: #495057;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 0.25rem 1rem;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(13, 110, 253, 0.05);
            color: #0d6efd;
        }

        .menu-item i {
            font-size: 1.2rem;
            margin-right: 1rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s;
        }

        .menu-text {
            transition: opacity 0.3s;
        }

        /* Main Content Styles */
        .main-container {
            margin-left: 270px;
            flex: 1;
            transition: margin-left 0.3s;
        }

        .main-container.expanded {
            margin-left: 70px;
        }

        /* Navbar Styles */
        .header-container {
            width: calc(100% - 270px);
            position: fixed;
            right: 0;
            top: 0;
            z-index: 999;
            transition: width 0.3s;
        }

        .header-container.expanded {
            width: calc(100% - 70px);
        }

        .header {
            background: #fff;
            height: 70px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            justify-content: space-between;
        }

        /* Other styles remain unchanged */
        .notification-dropdown .dropdown-menu {
            width: 400px;
            padding: 0;
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-height: 500px;
            overflow-y: auto;
        }

        .notification-header {
            padding: 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .notification-item {
            padding: 1rem;
            border-bottom: 1px solid #f1f1f1;
            transition: all 0.2s;
        }

        .notification-item:hover {
            background: #f8f9fa;
        }

        .notification-item.unread {
            border-left: 3px solid #0d6efd;
        }

        /* User Profile Styles */
        .user-profile {
            display: flex;
            align-items: center;
            padding: 0.5rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
            border: 2px solid #eaeaea;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            height: 18px;
            width: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar {
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                width: 0;
                transform: translateX(-100%);
            }

            .sidebar-wrapper.active {
                width: 270px;
                transform: translateX(0);
            }

            .sidebar-wrapper.active.mini {
                width: 70px;
            }

            .main-container {
                margin-left: 0;
            }

            .header-container {
                width: 100%;
            }
        }
    </style>
</head>

<body class="layout-boxed">
    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <!-- Logo/Brand -->
        <div class="sidebar-brand">
            <img src="/qvct-consulting.png" width="210px">
        </div>

        <!-- Menu Items -->
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 text-primary"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="{{ route('series.index') }}"
                class="menu-item {{ request()->routeIs('series.*') ? 'active' : '' }}">
                <i class="bi bi-tags text-primary"></i>
                <span class="menu-text">Series</span>
            </a>
            <a href="{{ route('monitor.questions.index') }}"
                class="menu-item ">
                <i class="bi bi-tags text-primary"></i>
                <span class="menu-text">Questions</span>
            </a>
            <a href="{{route('monitor.courses.index')}}"
                class="menu-item ">
                <i class="bi bi-tags text-primary"></i>
                <span class="menu-text">Courses</span>
            </a>
            <a href="{{ route('profile.edit') }}"
                class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-gear text-primary"></i>
                <span class="menu-text">Paramètres</span>
            </a>
        </div>

        <!-- User Profile in Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    <img src="/user-logo.png" alt="User Profile">
                </div>
                <div class="user-profile-text">
                    <h6 class="mb-0">
                        {{ Auth::check() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : 'Guest' }}</h6>
                    <small class="text-muted">{{ Auth::user()->role ?? 'No Role Assigned' }}</small>
                </div>
            </div>
            <div class="d-grid gap-2 mt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> <span class="logout-text">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="main-container">
        <!-- Your main content here -->
    </div>
</body>

</html>
