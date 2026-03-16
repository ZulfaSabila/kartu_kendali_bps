<nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-3" style="background-color: var(--bps-blue); border-bottom: 4px solid var(--bps-green);">
    <div class="container">
        <!-- Logo & Brand -->
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-bps.png') }}" 
                 alt="Logo BPS" width="40" class="me-2"
                 onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg/1200px-Lambang_Badan_Pusat_Statistik_%28BPS%29_Indonesia.svg.png'">
            <span class="d-none d-sm-inline">KARTU KENDALI BMN</span>
            <span class="d-inline d-sm-none">BMN</span>
        </a>

        <!-- Toggler for Mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links & User Dropdown -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active fw-bold border-bottom' : '' }}" 
                       href="{{ route('dashboard') }}">
                       <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('barangs.*') ? 'active fw-bold border-bottom' : '' }}" 
                       href="{{ route('barangs.index') }}">
                       <i class="bi bi-box-seam me-1"></i> Inventaris
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('users.*') ? 'active fw-bold border-bottom' : '' }}" 
                       href="{{ route('users.index') }}">
                       <i class="bi bi-people me-1"></i> Kelola Pegawai
                    </a>
                </li>
                @endif
            </ul>

            <!-- Right side: User Profile -->
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle border-0 d-flex align-items-center gap-2 px-3" 
                        type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li class="px-3 py-2 small text-muted border-bottom">
                        {{ Auth::user()->email }}
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
