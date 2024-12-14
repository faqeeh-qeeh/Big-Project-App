@extends('admin.layouts.top') @section ('title', $title)
@include('admin.layouts.navbar')
<div
  class="container-fluid py-4"
  style="padding-left: 6rem; padding-right: 6rem"
>
  <h2 class="fw-bold"><i class="bi bi-boxes"></i> Dafrtar Paket</h2>

  <div class="card">
    <div
      class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
    >
      <h3 class="mb-0">
        <i class="fas fa-box-open me-2"></i>
      </h3>
      <a href="{{ route('admin.packages.create') }}" class="btn btn-light">
        <i class="fas fa-plus me-2"></i>Buat Paket Baru
      </a>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover" id="packagesTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nama Paket</th>
              <th>Produk</th>
              <th>Total Harga</th>
              <th>Tanggal Dibuat</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($packages as $package)
            <tr>
              <td>{{ $package->id }}</td>
              <td>{{ $package->name }}</td>
              <td>
                <span
                  class="badge badge-primary"
                  style="background-color: #4e4feb"
                >
                  {{ $package->products->count() }} Produk
                </span>
              </td>
              <td>
                Rp {{ number_format($package->total_price, 0, ',', '.') }}
              </td>
              <td>{{ $package->created_at->format('d M Y') }}</td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a
                  href="{{ route('admin.packages.show', $package) }}"
                  class="btn btn-sm btn-info me-1"
                  title="Lihat Detail"
                >
                  <i class="fas fa-eye"></i>
                </a>
{{-- 
                  <a  
                      href="#"  
                      class="btn btn-sm btn-info me-1 show-package"  
                      data-id="{{ $package->id }}"  
                      title="Lihat Detail"  
                  >  
                      <i class="fas fa-eye"></i>  
                  </a> --}}
                  <a
                    href="{{ route('admin.packages.edit', $package) }}"
                    class="btn btn-sm btn-warning me-1"
                    title="Edit Paket"
                  >
                    <i class="fas fa-edit"></i>
                  </a>
                  <button
                    class="btn btn-sm btn-danger delete-package"
                    data-id="{{ $package->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    title="Hapus Paket"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p>Belum ada paket yang dibuat</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
        </h5>
        <button
          type="button"
          class="btn-close btn-close-white"
          data-bs-dismiss="modal"
        ></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-question-circle fa-3x text-danger mb-3"></i>
        <p>Apakah Anda yakin ingin menghapus paket ini?</p>
        <small class="text-muted">Tindakan ini tidak dapat dibatalkan</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-2"></i>Batal
        </button>
        <form id="deleteForm" action="" method="POST" style="display: inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-2"></i>Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@if(session('deletedPackage'))
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
        </h5>
        <button
          type="button"
          class="btn-close btn-close-white"
          data-bs-dismiss="modal"
        ></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-question-circle fa-3x text-danger mb-3"></i>
        <p>Apakah Anda yakin ingin menghapus paket ini?</p>
        <small class="text-muted">Tindakan ini tidak dapat dibatalkan</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-2"></i>Batal
        </button>
        <form id="delete-form" action="" method="POST" style="display: inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-2"></i>Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif {{-- JS Dependencies --}}
{{-- 
<!-- Show Package Modal -->  
<div class="modal fade" id="showPackageModal" tabindex="-1" aria-labelledby="showPackageModalLabel" aria-hidden="true">  
  <div class="modal-dialog modal-lg">  
      <div class="modal-content">  
          <div class="modal-header">  
              <h5 class="modal-title" id="showPackageModalLabel">Detail Paket</h5>  
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
          </div>  
          <div class="modal-body">  
              <!-- Content will be loaded here via ajax -->  
              <div id="packageDetails"></div>  
          </div>  
      </div>  
  </div>  
</div> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
      @if(session('deletedPackage'))
          $('#deletedPackageModal').modal('show');
      @endif
  });
</script>
<script>
  $(document).ready(function () {
    let packageIdToDelete = null;

    $(".delete-package").on("click", function () {
      packageIdToDelete = $(this).data("id");
      const actionUrl = `/admin/packages/${packageIdToDelete}`;
      $("#deleteForm").attr("action", actionUrl);
    });

    $(".confirm-delete").on("click", function () {
      if (packageIdToDelete) {
        $.ajax({
          url: `/admin/packages/${packageIdToDelete}`,
          type: "DELETE",
          data: {
            _token: "{{ csrf_token() }}",
          },
          success: function (response) {
            Swal.fire({
              icon: "success",
              title: "Berhasil!",
              text: "Paket telah dihapus.",
              timer: 1500,
            }).then(() => {
              location.reload();
            });
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Gagal",
              text: "Tidak dapat menghapus paket.",
            });
          },
        });
        $("#deleteModal").modal("hide");
      }
    });
  });
</script>

{{-- <script>  
  $(document).ready(function () {  
      $(".show-package").on("click", function () {  
          const packageId = $(this).data("id");  
          const url = `/admin/packages/${packageId}`;  
  
          // Make an AJAX GET request to fetch the package details  
          $.get(url, function (data) {  
              // Assuming the server returns the HTML for the package details  
              $("#packageDetails").html(data);  
              $("#showPackageModal").modal("show");  
          }).fail(function () {  
              alert("Terjadi kesalahan saat memuat detail paket.");  
          });  
      });  
  });  
  </script> --}}
@include('admin.layouts.bot')