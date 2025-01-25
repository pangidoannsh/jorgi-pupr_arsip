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
            'isActive' => Request::is('usulan*'),
            'route' => '/usulan',
        ],
        [
            'name' => 'Riwayat Usulan',
            'icon' => 'bi bi-clock-history',
            'iconNoFilled' => true,
            'isActive' => Request::is('riwayat*'),
            'route' => '/riwayat-usulan',
        ],
        [
            'name' => 'Arsip',
            'icon' => 'bi bi-archive',
            'isActive' => Request::is('arsip*'),
            'route' => '/arsip',
        ],
    ];
@endphp
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menus as $menu)
            <li class="nav-item">
                <a class="nav-link {{ !$menu['isActive'] ? 'collapsed' : '' }}" href="{{ $menu['route'] }}">
                    <i
                        class="{{ $menu['icon'] }}{{ !$menu['isActive'] ? '' : (isset($menu['iconNoFilled']) && $menu['iconNoFilled'] ? '' : '-fill') }}"></i>
                    <span>{{ $menu['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

</aside><!-- End Sidebar-->
