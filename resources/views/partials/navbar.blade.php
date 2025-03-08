@php
    $menus = [
        [
            'name' => 'Dashboard',
            'icon' => 'bi bi-house',
            'isActive' => Request::is('/'),
            'route' => '/',
        ],
        [
            'name' => 'Usulan',
            'icon' => 'bi bi-file-text',
            'isActive' => Request::is('usulan*') || Request::is('riwayat-usulan'),
            'route' => '/usulan',
        ],
        // [
        //     'name' => 'Riwayat Usulan',
        //     'icon' => 'bi bi-clock-history',
        //     'iconNoFilled' => true,
        //     'isActive' => Request::is('riwayat*'),
        //     'route' => '/riwayat-usulan',
        // ],
        [
            'name' => 'Arsip',
            'icon' => 'bi bi-archive',
            'isActive' => Request::is('arsip*'),
            'route' => '/arsip',
            'access' => ['admin'],
        ],
    ];

    $adminMenus = [
        [
            'name' => 'Klasifikasi',
            'icon' => 'bi bi-collection',
            'isActive' => Request::is('klasifikasi*'),
            'route' => '/klasifikasi',
        ],
        [
            'name' => 'Unit Kerja',
            'icon' => 'bi bi-building',
            'isActive' => Request::is('unit*'),
            'route' => '/unit',
        ],
        [
            'name' => 'Jabatan Penandatangan',
            'icon' => 'bi bi-person-badge',
            'isActive' => Request::is('jabatan*'),
            'route' => '/jabatan',
        ],
        [
            'name' => 'User',
            'icon' => 'bi bi-people',
            'isActive' => Request::is('users*'),
            'route' => '/users',
        ],
    ];
@endphp
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menus as $menu)
            @if (empty($menu['access']) || in_array(Auth::user()->role, $menu['access']))
                <li class="nav-item">
                    <a class="nav-link {{ !$menu['isActive'] ? 'collapsed' : '' }}" href="{{ $menu['route'] }}">
                        <i
                            class="{{ $menu['icon'] }}{{ !$menu['isActive'] ? '' : (isset($menu['iconNoFilled']) && $menu['iconNoFilled'] ? '' : '-fill') }}"></i>
                        <span>{{ $menu['name'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
    @if (Auth::user()->role == 'admin')
        <hr>
        <ul class="sidebar-nav" id="sidebar-nav">
            @foreach ($adminMenus as $menu)
                <li class="nav-item">
                    <a class="nav-link {{ !$menu['isActive'] ? 'collapsed' : '' }}" href="{{ $menu['route'] }}">
                        <i
                            class="{{ $menu['icon'] }}{{ !$menu['isActive'] ? '' : (isset($menu['iconNoFilled']) && $menu['iconNoFilled'] ? '' : '-fill') }}"></i>
                        <span>{{ $menu['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

</aside><!-- End Sidebar-->
