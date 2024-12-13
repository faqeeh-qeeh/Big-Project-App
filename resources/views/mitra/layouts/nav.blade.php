<nav class="navbar sticky-top navbar-expand-lg" style="background-color: #000000" data-bs-theme="dark">  
    <div class="container-fluid">  
      <a class="navbar-brand" href="#">  
        <img src="{{ asset('img/Logo KM.png') }}" width="{{ $isMobile ? '70px' : '20px' }}" alt="" />  
      </a>  
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">  
        <span class="navbar-toggler-icon"></span>  
      </button>  
      <div class="collapse navbar-collapse" id="navbarSupportedContent" style="{{ $isMobile ? 'font-size: 250%;' : '' }}">  
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">  
          <li class="nav-item">  
            <a class="nav-link {{ ($slug === 'home') ? 'active' : '' }}" aria-current="page" href="/kanjeng-mami" >Home</a>  
          </li>  
          <li class="nav-item">  
            <a class="nav-link {{ ($slug === 'products') ? 'active' : '' }}" href="/kanjeng-mami/products">Produk kami</a>  
          </li>  
  
          {{-- Menu dropdown hanya muncul jika slug adalah 'home' --}}  
          @if($slug === 'home')  
          <li class="nav-item dropdown" >  
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">  
              Profil Kami  
            </a>  
            <ul class="dropdown-menu" style="{{ $isMobile ? 'font-size: 100%;' : '' }}">
              <li><a class="dropdown-item" href="#posawal">Tentang kami</a></li>  
              <li><a class="dropdown-item" href="#jadwal">Jadwal Kami</a></li>  
              <li><hr class="dropdown-divider" /></li>  
              <li>  
                <a class="dropdown-item" href="#footer">footer</a>  
              </li>  
            </ul>  
          </li>  
          @endif  
  
          {{-- <li class="nav-item">  
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>  
          </li>   --}}
        </ul>  
        @if (!$isMobile)
        @if ( $slug==='products')
        <form class="d-flex" role="search" method="GET" action="{{ route('mitra.products') }}">  
          <input id="searchInput2" style="{{ $isMobile ? 'font-size: 100%;' : '' }}" class="form-control me-2" name="search" type="text" placeholder="Cari Produk..." aria-label="Search" />  
          <button class="btn btn-outline-primary" type="submit" style="{{ $isMobile ? 'font-size: 100%;' : '' }}">Cari</button>  
        </form>  
        @endif
        @endif
      </div> 
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">  
        <ul class="navbar-nav ms-auto">  
            @guest('client')  
                <li class="nav-item">  
                    <a class="nav-link" href="{{ route('client.login') }}">Login</a>  
                </li>  
                <li class="nav-item">  
                    <a class="nav-link" href="{{ route('client.register') }}">Register</a>  
                </li>  
            @else  

                <li class="nav-item dropdown">
                  <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, {{ Auth::guard('client')->user()->username }}!
                  </button>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="#">Biodata</a></li>
                    <li>
                      <form action="{{ route('client.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">  
                  <a class="nav-link" href="{{ route('cart.index') }}">  
                    <i class="bi bi-cart3"></i> <span class="badge bg-primary">{{ Auth::guard('client')->user()->carts->count() }}</span>  
                  </a>  
                </li>  
            @endguest  
        </ul>  
    </div>
    </div>  
  </nav>  
  


<nav class="navbar logo1" style="background-color: {{ $store->is_open ? '#4e4feb' : '#2C394B' }}" data-bs-theme="dark">  
  <div class="container-fluid" style="justify-content: center; align-items: center">  
    <a class="navbar-brand" href="#" style=" {{ $isMobile ? 'font-size: 250%;' : '' }}">  
      <img src="{{ asset('img/Logo KM white.png') }}" alt="Logo" width="auto" height="{{ $isMobile ? '50px' : '24px' }}" class="d-inline-block align-text-top" />  
      kami saat ini sedang {{ $store->is_open ? 'Buka' : 'Tutup' }}  
    </a>  
  </div>
</nav>