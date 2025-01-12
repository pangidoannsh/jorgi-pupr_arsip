@php
    $menus = [
        // [
        //     'name' => 'Dashboard',
        //     'icon' => 'bi bi-grid',
        //     'isActive' => Request::is('/'),
        //     'route' => '/',
        // ],
        [
            'name' => 'Kategori',
            'icon' => 'bi bi-menu-button-wide',
            'isActive' => Request::is('category*'),
            'route' => '/category',
        ],
        [
            'name' => 'Laporan',
            'icon' => 'bi bi-journal-text',
            'isActive' => Request::is('report*'),
            'route' => '/report',
        ],
    ];
@endphp
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menus as $menu)
            <li class="nav-item">
                <a class="nav-link {{ !$menu['isActive'] ? 'collapsed' : '' }}" href="{{ $menu['route'] }}">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span>{{ $menu['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

</aside><!-- End Sidebar-->
