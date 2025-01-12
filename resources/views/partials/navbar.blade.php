@php
    $menus = [
        [
            'name' => 'Dashboard',
            'icon' => 'bi bi-house',
            'isActive' => Request::is('/'),
            'route' => '/category',
        ],
        [
            'name' => 'Usulan',
            'icon' => 'bi bi-file-text',
            'isActive' => Request::is('usulan*'),
            'route' => '/category',
        ],
        [
            'name' => 'Arsip',
            'icon' => 'bi bi-archive',
            'isActive' => Request::is('arsip*'),
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
                    <i class="{{ $menu['icon'] }}{{ !$menu['isActive'] ? '' : '-fill' }}"></i>
                    <span>{{ $menu['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

</aside><!-- End Sidebar-->
