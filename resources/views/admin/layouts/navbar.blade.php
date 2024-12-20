    <div class="wrapper">
        <aside id="sidebar" style="{{ $isMobile ? 'height: 48.3rem; overflow: none;' : '' }}">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Kanjeng Mami</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link aniva1">
                        <i class="lni lni-user"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.task') }}" class="sidebar-link aniva2">
                        <i class="bi bi-list-task"></i>
                        <span>Tugas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown aniva3" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="bi bi-box-seam" ></i>
                        <span>Paket</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.packages.index') }}" class="sidebar-link">Paket</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.packages.create') }}" class="sidebar-link">Buat Paket</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown aniva4" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="bi bi-stickies"></i>
                        <span>Database</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                Data
                            </a>
                            <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.products.read') }}" class="sidebar-link">Data Produk</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/dashboard/create" class="sidebar-link">Tambah Data Produk</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.carts.index') }}" class="sidebar-link aniva5">
                        <i class="bi bi-person-vcard " ></i> 
                        <span>Informasi Akun Client</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.monitoring.index') }}" class="sidebar-link aniva6">
                        <i class="bi bi-clipboard2-pulse"></i>
                        <span>Monitoring</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link aniva6">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li> --}}
            </ul>
            <div class="sidebar-footer">
                <div class="sidebar-link lognav">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link aniva7">
                            <i class="lni lni-exit"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>        
        </aside>