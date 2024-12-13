@extends('admin.layouts.top')
@section ('title', $title)
@include('admin.layouts.navbar')
<div class="container mt-5" style="{{ $isMobile ? ' margin-left: 15%;' : '' }}">  
    <h2 style="font-weight: 900;">Selamat Datang Admin 😸😸😸</h2>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 5; {{ $isMobile ? 'width: 80%;' : '' }}">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-white">
                <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">
                <strong class="me-auto">Kanjeng Mami</strong>
                <small></small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello admin, Jangan lupa untuk mengecek tugas untuk membuka/menutup toko
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, { autohide: false });
    });
    toastList.forEach(toast => toast.show());
    });
</script>
@include('admin.layouts.bot')