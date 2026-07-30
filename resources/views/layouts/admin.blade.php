<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ARVEN PARFUME')</title>
    <!-- Gunakan font yang sama dengan aplikasi utama -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --admin-bg: #111111;
            --admin-surface: #1a1a1a;
            --admin-primary: #d4af37; /* Gold khas Arven */
            --admin-text: #ffffff;
            --admin-text-muted: #888888;
            --admin-sidebar-width: 260px;
            --admin-header-height: 70px;
            --admin-border: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--admin-bg);
            color: var(--admin-text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background-color: var(--admin-surface);
            border-right: 1px solid var(--admin-border);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            height: var(--admin-header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            font-size: 20px;
            font-weight: 700;
            color: var(--admin-primary);
            border-bottom: 1px solid var(--admin-border);
            letter-spacing: 2px;
        }

        .sidebar-nav {
            padding: 24px 0;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--admin-text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .nav-item:hover, .nav-item.active {
            color: var(--admin-text);
            background: rgba(212, 175, 55, 0.1);
            border-right: 3px solid var(--admin-primary);
        }

        .nav-icon {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .admin-main {
            flex-grow: 1;
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .admin-header {
            height: var(--admin-header-height);
            background-color: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid var(--admin-primary);
            color: var(--admin-primary);
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: var(--admin-primary);
            color: #000;
        }

        /* Content Area */
        .admin-content {
            padding: 30px;
            flex-grow: 1;
            background-color: var(--admin-bg);
        }

        /* Card Styles */
        .admin-card {
            background-color: var(--admin-surface);
            border-radius: 12px;
            border: 1px solid var(--admin-border);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--admin-border);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            ARVEN ADMIN
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                Dashboard
            </a>
            <!-- Tambahkan menu lain di sini ke depannya -->
            <a href="{{ route('admin.brands.index') }}" class="nav-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <span class="nav-icon">🏷️</span>
                Brand
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span>
                Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="nav-icon">🛒</span>
                Pesanan
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <span class="nav-icon">📩</span>
                Pesan Masuk
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                Kelola User
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-title">
                @yield('header-title', 'Dashboard')
            </div>
            <div class="header-user">
                <div class="user-name">Hello, {{ auth()->check() ? explode(' ', auth()->user()->full_name)[0] : 'Admin' }}</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

</body>
</html>
