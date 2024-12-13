<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
      function updateTotal(price, quantityInput, totalCell, form) {
        const quantity = parseInt(quantityInput.value);
        const total = price * quantity;
        totalCell.textContent = `Rp${total.toLocaleString("id-ID", {
          minimumFractionDigits: 2,
        })}`;

        // Automatically submit the form to update quantity in the database
        form.submit();

        // After submission, update the grand total
        updateGrandTotal();
      }

      function updateGrandTotal() {
        const rows = document.querySelectorAll("tbody tr");
        let grandTotal = 0;

        rows.forEach((row) => {
          const totalCell = row.querySelector('td[id^="total"]'); // Select the total cell
          const totalText = totalCell.textContent
            .replace("Rp", "")
            .replace(".", "")
            .replace(",", "."); // Clean the currency format
          grandTotal += parseFloat(totalText); // Convert to float and add to grand total
        });

        // Update the total price displayed at the bottom
        document.getElementById(
          "grandTotal"
        ).textContent = `Rp${grandTotal.toLocaleString("id-ID", {
          minimumFractionDigits: 2,
        })}`;
      }
      
    </script>
    <style>
      td {
        vertical-align: middle; /* Center text vertically */
        height: 100px; /* Set height for vertical centering */
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">

      @if(session('success'))  
      <div class="position-fixed top-0 end-0 p-3" style="z-index: 5; {{ $isMobile ? 'width: 80%;' : '' }}"    >  
          <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
              <div class="toast-header bg-dark text-white">  
                  <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">  
                  <strong class="me-auto">Perubahan Produk</strong>  
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>  
              </div>  
              <div class="toast-body">  
                  {{ session('success') }}  
              </div>  
          </div>  
      </div>  
      @endif  

      <nav
        class="navbar navbar-expand-lg"
        style="background-color: #068fff"
        data-bs-theme="dark"
      >
        <div class="container-fluid">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="collapse navbar-collapse"
            id="navbarNavAltMarkup"
            style="font-weight: 600"
          >
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="#"
                ><i class="bi bi-cart-check-fill"> Keranjang Belanja</i></a
              >
              <a class="nav-link" href="{{ route('client.profil') }}"
                ><i class="bi bi-person-circle"> Biodata</i></a
              >
              <form action="{{ route('client.logout') }}" method="POST">  
                @csrf  
                <button class="nav-link" type="submit">
                  <i class="bi bi-box-arrow-right"> Logout</i></button>  
              </form>  
              <a class="nav-link" href="/kanjeng-mami/products"
                ><i class="bi bi-back"> Kembali ke Daftar Produk</i></a
              >
            </div>
          </div>
          <img
            src="{{ asset('img/Logo KM white.png') }}"
            alt=""
            width="{{ $isMobile ? '70px' : '20px' }}"
          />
        </div>
      </nav>
      <h1>Keranjang Belanja</h1>
      <div class="text-end">
        <h4 id="grandTotal">
          Total Harga: Rp{{ number_format($totalPrice, 2) }}
        </h4>
      </div>
      @if ($cartItems->isEmpty())
      <p class="text-center text-muted mt-4">Keranjang Anda kosong.</p>
      <a href="{{ route('mitra.products') }}" class="btn btn-primary"
        >Mulai Belanja</a
      >
      @else
      <table class="table mt-4">
        <thead>
          <tr>
            <th>Image</th>
            <th>Produk</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cartItems as $item)
          <tr>
            <td>
              <img
                src="{{ asset('storage/' . $item->product->image) }}"
                alt="{{ $item->product->name }}"
                style="max-width: 100px; max-height: 100px"
              />
            </td>
            <td>
              <span style="font-weight: bold; font-size: 18px">
                <a
                  href="{{ route('mitra.product.detail', $item->product->id) }}"
                  style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}; text-decoration: none;"
                >
                  {{ $item->product->name }}
                </a>
              </span>
              <br /><span
                class="text-muted"
                style="font-weight: normal; font-size: "
                >stok {{ $item->product->stock->quantity ?? 0 }}</span
              >
            </td>
            <td>Rp{{ number_format($item->product->selling_price, 2) }}</td>

            
            <td>
              <form
                action="{{ route('cart.update', $item->id) }}"
                method="POST"
                class="d-inline-block"
              >
                @csrf
                <input
                  type="number"
                  name="quantity"
                  value="{{ $item->quantity }}"
                  min="1"
                  max="{{ $item->product->stock->quantity ?? 0 }}"
                  class="form-control d-inline-block"
                  style="width: 80px"
                  onchange="updateTotal({{ $item->product->selling_price }}, this, total{{ $item->id }}, this.form)"
                />
                <button type="submit" class="btn btn-sm btn-success d-none">
                  Update
                </button>
              </form>
            </td>


            
            <td id="total{{ $item->id }}">
              Rp{{ number_format($item->product->selling_price *
              $item->quantity, 2) }}
            </td>
            <td>
              <form
                action="{{ route('cart.remove', $item->id) }}"
                method="POST"
              >
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>


      <form id="payment-form" method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        <button type="button" id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
      </form>
      @endif
      {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> --}}

    </div>
    <script>
      document.getElementById('pay-button').addEventListener('click', function () {
          fetch('{{ route('cart.checkout') }}', {
              method: 'POST',
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => {
              snap.pay(data.snapToken, {
                  onSuccess: function(result) {
                      alert('Pembayaran berhasil!');
                      location.reload();
                  },
                  onPending: function(result) {
                      alert('Menunggu pembayaran.');
                  },
                  onError: function(result) {
                      alert('Pembayaran gagal.');
                  }
              });
          })
          .catch(error => {
              console.error('Error:', error);
          });
      });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous">
  </script>
  </body>
</html>