@extends('admin.layouts.top')
@section('title', $title)
@include('admin.layouts.navbar')

<div class="container mt-5">
    <div class="row g-3">
        <h2 class="fw-bold"><i class="bi bi-list-task"></i> Tugas</h2>
        <div class="col-lg-6">
            <div class="card mt-3" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-header" style="background-color: #4D4C7D; color: white;">
                    <h5 class="mb-0">Jadwal</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Fitur Jadwal</h5>
                    <p class="card-text">
                        Fitur yang berfungsi untuk menampilkan bahwasanya toko sudah buka/tutup, jangan lupa agar fitur ini segera dilaksanakan.
                    </p>
                    <div class="form-check form-switch d-flex align-items-center">
                        <input 
                            class="form-check-input me-2" 
                            type="checkbox" 
                            id="statusSwitch" 
                            {{ $store->is_open ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusSwitch">
                            {{ $store->is_open ? 'Buka' : 'Tutup' }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mt-3" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-header" style="background-color: #1B1A55; color: white;">
                    <h5 class="mb-0">Pengatur Arus Listrik</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Fitur ON/OFF</h5>
                    <p class="card-text">
                        Fitur yang berfungsi untuk menyalakan/mematikan sumber daya listrik.
                    </p>
                    <div class="form-check form-switch d-flex align-items-center">
                        <input 
                            class="form-check-input me-2" 
                            type="checkbox" 
                            id="statusSwitchrelay" 
                            {{ $status ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusSwitchrelay">
                            {{ $status ? 'Nyala' : 'Mati' }}
                        </label>
                    </div>

                    <div class="mb-3">  
                        <label for="scheduleTime" class="form-label">Jadwal (jam:menit:detik) :</label>  
                        <input type="text" id="scheduleTime" class="form-control" placeholder="HH:MM:SS">  
                        <div id="countdownDisplay" class="mb-3"></div>
                    </div>  
                    <button class="btn" id="setSchedule" style="background-color: #1B1A55; color: white;">Atur Jadwal</button>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- Modal for Notifications -->  
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content">  
            <div class="modal-header">  
                <h5 class="modal-title" id="notificationModalLabel">Nontifikasi</h5>  
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
            </div>  
            <div class="modal-body" id="modalMessage">  
                <!-- Message will be set dynamically -->  
            </div>  
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
            </div>  
        </div>  
    </div>  
</div>

<script>
// Function to show modal with custom message  
function showNotification(message) {  
    document.getElementById('modalMessage').textContent = message;  
    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));  
    modal.show();  
}  

// Toggle Toko  
document.getElementById('statusSwitch').addEventListener('change', function() {  
    const isChecked = this.checked;  
    const confirmChange = confirm(`Yakin ${isChecked ? 'membuka' : 'menutup'} toko?`);  

    if (!confirmChange) {  
        this.checked = !isChecked;  
        return;  
    }  

    fetch("{{ route('toggle.status') }}", {  
        method: "POST",  
        headers: {  
            "Content-Type": "application/json",  
            "X-CSRF-TOKEN": "{{ csrf_token() }}"  
        },  
        body: JSON.stringify({ status: isChecked })  
    })  
    .then(response => response.json())  
    .then(data => {  
        if (data.success) {  
            document.querySelector('label[for="statusSwitch"]').textContent =   
                data.status === 'buka' ? 'Buka' : 'Tutup';  
            showNotification(`Status toko berhasil diperbarui ke: ${data.status === 'buka' ? 'Buka' : 'Tutup'}`);  
        } else {  
            showNotification(data.message);  
            this.checked = !isChecked;  
        }  
    })  
    .catch(error => {  
        console.error('Error:', error);  
        this.checked = !isChecked;  
    });  
});  

// Toggle Relay  
document.getElementById('statusSwitchrelay').addEventListener('change', function() {  
    const isChecked = this.checked;  
    const confirmChange = confirm(`Yakin ingin ${isChecked ? 'menyalakan' : 'mematikan'} relay?`);  

    if (!confirmChange) {  
        this.checked = !isChecked;  
        return;  
    }  

    fetch("{{ route('actuator.toggle') }}", {  
        method: 'POST',  
        headers: {  
            'Content-Type': 'application/json',  
            'X-CSRF-TOKEN': "{{ csrf_token() }}"  
        },  
        body: JSON.stringify({ status: isChecked ? 1 : 0 })  
    })  
    .then(response => response.json())  
    .then(data => {  
        if (data.success) {  
            const label = document.querySelector('label[for="statusSwitchrelay"]');  
            label.textContent = isChecked ? 'Nyala' : 'Mati';  
            this.checked = data.status;  
            showNotification(data.message); // Show notification modal  
        } else {  
            showNotification(data.message);  
            this.checked = !isChecked;  
        }  
    })  
    .catch(error => {  
        console.error('Error:', error);  
        showNotification("Terjadi kesalahan saat mengubah status relay!");  
        this.checked = !isChecked; // Kembalikan state jika ada error  
    });  
});



let countdownTimer; // Variabel untuk menyimpan countdown timer  

// Fungsi untuk menghentikan countdown   
function stopCountdown() {  
    if (countdownTimer) {  
        clearTimeout(countdownTimer);  
        countdownTimer = null;  
    }  
}  

// Fungsi untuk memperbarui tampilan hitung mundur  
function updateCountdownDisplay(seconds) {  
    const display = document.getElementById('countdownDisplay');  
    const hours = Math.floor(seconds / 3600);  
    const minutes = Math.floor((seconds % 3600) / 60);  
    const sec = seconds % 60;  

    display.textContent = `Sisa waktu: ${hours} jam ${minutes} menit ${sec} detik.`;  
}  

// Fungsi untuk mengatur jadwal  
document.getElementById('setSchedule').addEventListener('click', function() {  
    const timeInput = document.getElementById('scheduleTime').value.trim();  
    
    const timeParts = timeInput.split(':');  
    if (timeParts.length !== 3) {  
        showNotification("Format waktu tidak valid! Gunakan HH:MM:SS.");  
        return;  
    }  

    const hours = parseInt(timeParts[0]);  
    const minutes = parseInt(timeParts[1]);  
    const seconds = parseInt(timeParts[2]);  

    // Hitung total detik  
    const totalSeconds = hours * 3600 + minutes * 60 + seconds;  

    // Mulai countdown  
    stopCountdown(); // Hentikan jika ada countdown sebelumnya  
    startCountdown(totalSeconds);  
});  

// Fungsi untuk memulai countdown  
function startCountdown(totalSeconds) {  
    let secondsLeft = totalSeconds;  
    updateCountdownDisplay(secondsLeft);  

    countdownTimer = setInterval(() => {  
        secondsLeft--;  
        updateCountdownDisplay(secondsLeft);  
        if (secondsLeft <= 0) {  
            clearInterval(countdownTimer);  
            countdownTimer = null;  

            // Toggle status ON/OFF   
            const currentStatus = document.getElementById('statusSwitchrelay').checked;  

            // Simulasikan pengiriman ke server  
            const newStatus = !currentStatus;  
            document.getElementById('statusSwitchrelay').checked = newStatus;  

            const label = document.querySelector('label[for="statusSwitchrelay"]');  
            label.textContent = newStatus ? 'Nyala' : 'Mati';  
            
            // Kirim status baru ke server  
            fetch("{{ route('actuator.toggle') }}", {  
                method: 'POST',  
                headers: {  
                    'Content-Type': 'application/json',  
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"  
                },  
                body: JSON.stringify({ status: newStatus ? 1 : 0 })  
            })  
            .then(response => response.json())  
            .then(data => {  
                if (!data.success) {  
                    showNotification(data.message);  
                } else {  
                    showNotification(data.message);  
                }  
            })  
            .catch(error => {  
                console.error('Error:', error);  
                showNotification("Terjadi kesalahan saat mengubah status relay!");  
            });  
        }  
    }, 1000); // Perbarui setiap detik  
}
</script>

@include('admin.layouts.bot')