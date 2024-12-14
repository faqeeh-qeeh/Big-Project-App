@include('mitra.layouts.top')
@include('mitra.layouts.nav')

{{-- {{ $isMobile ? 'mobile-' : '' }} --}}
    <div class="img1">
      <img src="img/kelas 1/fototempat{{ $isMobile ? 'mobile' : '' }}.jpg" alt="Gambar 1" />
    </div>
    <div class="kelas1" style="{{ $isMobile ? 'padding: 10px;' : '' }}">
      <br>
      <div class="container px-4 text-left isi1">
        <div class="row gx-5 posawal" >
          <div class="col">
            <div class="p-3 animaqeeh" id="kelas1">
              <div class="jumbotron" style="{{ $isMobile ? ' margin-left: -140px;' : '' }}">
                <h1 style="{{ $isMobile ? 'font-size: 3rem;' : '' }}">
                  Kanjeng Mami Siap Membantu Anda Mewujudkan Ide-ide Kreatif!
                </h1>
                <p style="{{ $isMobile ? 'font-size: 1.5rem;' : '' }}">
                  Sebagai tempat fotocopy, kami menyediakan alat dan barang yang
                  anda perlukan
                </p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="p-3 animaqeeh" id="kelas1part2">
              <div class="card" style="{{ $isMobile ? ' width: 25rem; margin-right: -150px;' : 'width: 18rem' }}">
                <div class="card-body">
                  <h5 class="card-title" style="{{ $isMobile ? 'font-size: 2rem;' : '' }}">
                    Bingung untuk menentukan apa saja ?
                  </h5>
                  <p class="card-text" style="{{ $isMobile ? 'font-size: 1.4rem;' : '' }}">
                    kami mempunyai banyak barang dan alat kantor, sekolah, dll yang anda cari sesuai
                    kebutuhan anda.<br /> <br>
                    barang dan alat yang tersedia bisa
                  </p>
                  <a href="/kanjeng-mami/products" class="btn btn-primary" style="{{ $isMobile ? 'font-size: 1.4rem;' : '' }}">Coba disini</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div id="carouselExampleWhite" class="carousel carousel-white slide animaqeeh">
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleWhite"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleWhite"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleWhite"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleWhite"
          data-bs-slide-to="3"
          aria-label="Slide 4"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
          <img src="img/kelas 1/img1.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block jasa text-dark">

            <h5 style="{{ $isMobile ? 'font-size: 4rem;' : '' }}">Jasa yang kami sediakan</h5>
            <img src="img/Logo KM.png" width="45" alt="" />
            <h6 style="{{ $isMobile ? 'font-size: 2rem;' : '' }}">Kami menyediakan beberapa jasa</h6>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="img/kelas 1/img2.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block jasa text-dark">

            <h5 style="{{ $isMobile ? 'font-size: 5rem;' : '' }}">Jasa Mengetik</h5>
            <h6 style="{{ $isMobile ? 'font-size: 2rem;' : '' }}">Kami juga menyediakan jasa mengetik dan editing foto</h6>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/kelas 1/img3.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block jasa text-dark">
            <h5 style="{{ $isMobile ? 'font-size: 5rem;' : '' }}">Jasa Printer</h5>
            <h6 style="{{ $isMobile ? 'font-size: 2rem;' : '' }}">
              Sama halnya seperti fotokopi lain, kami juga ada jasa printer dan
              disertai laminating
            </h6>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/kelas 1/img4.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block jasa text-dark">
            <h5 style="{{ $isMobile ? 'font-size: 5rem;' : '' }}">Jasa Updrag Foto</h5>
            <h6 style="{{ $isMobile ? 'font-size: 2rem;' : '' }}">
              Kami juga menyediakan updrag foto sesuai kebutuhan Anda dengan
              berbagai ukuran
            </h6>
          </div>
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleWhite"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleWhite"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <br>

    <div class="jadwal animaqeeh" id="carouselExampleOpacity">
      <div class="container px-4 text-left isi2">
        <div class="row gx-5">
          <div class="col">
            <div class="p-3 animaqeeh" id="jadwal" style="{{ $isMobile ? ' margin-left: -150px;' : '' }}">
              <h1 class="coblue">Jadwal buka</h1>
              <h3 class="pt-2">
                Kami buka setiap hari buka mulai pagi sampai malam hari <br />
                Tepatnya di jam
              </h3>
              <span class="jam"><center>08.00 - 17.00 WIB</center></span>
              <h3 class="pt-2">
                Untuk saat ini kami sedang
              </h3>
              <h3 class="pt-2 waktu">{{ $store->is_open ? 'Buka' : 'Tutup' }} </h3>
            </div>
          </div>
          <div class="col">
            <div class="p-3 animaqeeh" id="lokasi" style="{{ $isMobile ? ' margin-right: -150px;' : '' }}">
              <h2 class="coblue">Lokasi Kami</h2>
              <div class="col">
                <div class="card">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1231.7286623540456!2d108.29501033752449!3d-6.503104663893717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec5ce40536677%3A0xebe6ec70200ff2d8!2sToko%20Kanjeng%20Mami!5e0!3m2!1sid!2sid!4v1727277204579!5m2!1sid!2sid"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                  ></iframe>
                  <div class="card-body">
                    <h5 class="card-title">Lokasi Lengkap</h5>
                    <p class="card-text">
                      Kami berlokasi di ds.Tegalgirang, blok.Barat, Kecamatan Bangodua, jln.Wanasari <br>
                      Lokasi patokan kami di dekat Kecamatan
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br> <br>
    
{{-- 
    <div class="container text-center animaqeeh profil">
      <div class="row">
        <div class="col-md-4">
          <h1 class="coblue">Profil Penjual</h1>
        </div>
        <div class="col-md-4 ms-auto">
          <h1 class="coblue">Identitas</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 ms-md-auto"><img src="img/kelas 1/profilpenjual.png" alt=""></div>
        <div class="col-md-3 ms-md-auto" style="text-align: left">
          <h5>Nama : Gifar</h5>
          <h5>Umur : 20</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-auto me-auto">.col-auto .me-auto</div>
        <div class="col-auto">.col-auto</div>
      </div>
    </div> --}}

    
    @extends('mitra.layouts.footer')

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script>  
        const animaqeehs = document.querySelectorAll(".animaqeeh"); // Mengambil semua elemen dengan kelas 'carousel'  
        let observers = [];  
    
        function observeAnimaqeeh(animaqeeh) {  
            let isVisible = false;  
            const observer = new IntersectionObserver(  
                (entries) => {  
                    entries.forEach((entry) => {  
                        if (entry.isIntersecting) {  
                            if (!isVisible) {  
                                isVisible = true;  
                                setTimeout(() => {  
                                    animaqeeh.classList.add("animate");  
                                }, 0);  
                            }  
                        } else {  
                            isVisible = false;  
                            animaqeeh.classList.remove("animate");  
                        }  
                    });  
                },  
                { threshold: 0.1, rootMargin: "-20px" }  
            );  
    
            observer.observe(animaqeeh);  
            observers.push(observer); // Simpan observer jika perlu, tapi di sini mungkin tidak diperlukan  
        }  
    
        animaqeehs.forEach(animaqeeh => {  
            observeAnimaqeeh(animaqeeh); // Memanggil fungsi pada setiap carousel yang ditemukan  
        });  
    </script>
  </body>
</html>