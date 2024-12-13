<footer class="text-light pt-5" style="background-color: #000000; {{ $isMobile ? '' : '' }}">
    <div class="container{{ $isMobile ? '' : ' px-5' }}" style="{{ $isMobile ? '' : '' }}">
      <div class="row" style="{{ $isMobile ? 'widht: 300%; justify-content: center;' : '' }}">
        <div class="col-6 col-lg-4" style="{{ $isMobile ? ' font-size: 1.5rem;' : '' }}">
          <div class="botfoot" style="border-bottom: 3px solid white; border-radius: 10px; border-bottom-right-radius: 0px;">
            <h3 class="fw-bold coblue botfoot" style="{{ $isMobile ? ' font-size: 2.6rem;' : '' }} ">Kanjeng Mami</h3>
          </div>
          <p class="pt-2">Tentang kami</p>
          <p class="mb-2">+62 838-0627-1629</p>
        </div>
        <div class="col">
          <div style="border-bottom: 3px solid white; border-radius: 10px; border-bottom-right-radius: 0px;">
            <h4 class="coblue " style="{{ $isMobile ? ' font-size: 2.3rem;' : '' }}">Menu</h4>
          </div>
          <ul class="list-unstyled pt-2" style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">
            <li class="py-1">Home</li>
            <li class="py-1">About</li>
            <li class="py-1">Contact</li>
          </ul>
        </div>
        <div class="col">
          <h4 class="coblue" style="{{ $isMobile ? ' font-size: 2.3rem;' : '' }}">More</h4>
          <ul class="list-unstyled pt-2" style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">
            <li class="py-1">Landing Pages</li>
            <li class="py-1">FAQs</li>
          </ul>
        </div>
        <div class="col">
          <h4 class="coblue" style="{{ $isMobile ? ' font-size: 2.3rem;' : '' }}">Categories</h4>
          <ul class="list-unstyled pt-2" style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">
            <li class="py-1">Navbars</li>
            <li class="py-1">Cards</li>
            <li class="py-1">Buttons</li>
          </ul>
        </div>
        <div class="col-6 col-lg-3 text-lg-end">
          <h4 class="coblue" style="{{ $isMobile ? ' font-size: 2.3rem;' : '' }}">Social Media Links</h4>
          <div class="social-media pt-2">
            <a href="#" class="text-light {{ $isMobile ? 'fs-1 me-3' : 'fs-2 me-3' }}"
              ><i class="bi bi-facebook"></i
            ></a>
            <a href="#" class="text-light {{ $isMobile ? 'fs-1 me-3' : 'fs-2 me-3' }}"
              ><i class="bi bi-pinterest"></i
            ></a>
            <a href="#" class="text-light {{ $isMobile ? 'fs-1 me-3' : 'fs-2 me-3' }}" 
              ><i class="bi bi-instagram"></i
            ></a>
          </div>
        </div>
      </div>
      <hr />
      <div class="d-sm-flex justify-content-between py-1">
        <p style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">Kelompok 4</p>
        <p style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">
          <a href="#" class="text-light text-decoration-none pe-4"
            >D3 TI 2C</a
          >
          <a href="#" class="text-light text-decoration-none" style="{{ $isMobile ? ' font-size: 1.5rem;' :'' }}">Polindra</a>
        </p>
      </div>
    </div>
  </footer>