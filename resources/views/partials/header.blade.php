<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="/logo.png" alt="">
            <span class="d-none d-lg-block">PUPR Arsip</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <!-- Notifikasi -->
            <li class="nav-item dropdown pe-3 d-flex" style="gap: 12px">
                <button class="btn position-relative" id="notifDropdown" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span id="notif-count"
                        class="position-absolute translate-middle badge rounded-pill bg-danger d-none"
                        style="font-size: 10px; top: 4px; right: -4px">0</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="notif-list"
                    style="min-width: 400px">
                    <li><button class="dropdown-item text-center fw-bold" id="mark-all-read">Tandai Semua
                            Dibaca</button></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><span class="dropdown-item text-center">Loading...</span></li>
                </ul>
            </li>

            <!-- Profile Dropdown -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->role }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchNotifications() {
                $.ajax({
                    url: "{{ url('/notif') }}",
                    method: "GET",
                    success: function(response) {
                        if (response.success) {
                            let notifications = response.notifications;
                            let unreadCount = notifications.filter(n => !n.read).length;

                            $("#notif-count").toggleClass("d-none", unreadCount === 0).text(
                                unreadCount);

                            let notifList = $("#notif-list");
                            notifList.empty();
                            notifList.append(
                                '<li><button class="dropdown-item text-center fw-bold" id="mark-all-read">Tandai Semua Dibaca</button></li><li><hr class="dropdown-divider"></li>'
                            );

                            if (notifications.length > 0) {
                                notifications.forEach(notif => {
                                    let bgClass = notif.read ? "bg-white" : "bg-light-primary";

                                    let notifItem = $(`
                                            <li class="dropdown-item d-flex align-items-center ${bgClass}" 
                                                style="gap: 12px; padding: 8px; cursor: pointer;" 
                                                onclick="window.location.href='/${notif.link}'"
                                            >
                                                <div style="flex-grow: 1;">
                                                    <a href="/${notif.link}" style="text-decoration: none; color: inherit;">
                                                        <h6 class="mb-0" style="color:black">${notif.title}</h6>
                                                        <small class="text-muted">${notif.text}</small>
                                                    </a>
                                                </div>
                                            </li>
                                        `);

                                    if (!notif.read) {
                                        let markReadButton = $(`<button class="btn btn-sm btn-outline-primary" 
                                            style="font-size: 10px; padding: 2px 4px; margin-left: auto;">
                                            Tandai Dibaca
                                        </button>`);

                                        // Tambahkan event click langsung ke elemen sebelum di-append
                                        markReadButton.on("click", function(event) {
                                            event
                                                .stopPropagation(); // Hindari trigger klik ke <li>

                                            $.get(`/notif/${notif.id}/read`,
                                                function() {
                                                    fetchNotifications
                                                        (); // Refresh daftar notifikasi
                                                });
                                        });

                                        notifItem.append(
                                            markReadButton
                                        );
                                    }
                                    notifList.append(
                                        notifItem
                                    );
                                    notifList.append(
                                        `<li><hr class="dropdown-divider"></li>`
                                    );
                                });
                            } else {
                                notifList.append(
                                    '<li><span class="dropdown-item text-center">No Notifications</span></li>'
                                );
                            }
                        }
                    }
                });
            }

            $(document).on("click", "#mark-all-read", function() {
                $.get("{{ url('/notif/read-all') }}", function() {
                    fetchNotifications();
                });
            });

            fetchNotifications();
            setInterval(fetchNotifications, 30000);
        });
    </script>
@endpush
