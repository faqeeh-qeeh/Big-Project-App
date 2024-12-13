@extends('layouts.app')  

@section('content')  
<div class="container-fluid"> 
    <div class="container mt-5">  
        <div class="text-center mb-4">  
            <h1 class="display-4 text-primary"><i class="fas fa-bolt"></i> Pengeluaran Energi</h1>  
            <p id="currentDate" class="lead text-secondary">Monitor biaya energi Anda secara real-time</p>  
        </div>  

        <div class="row">  
            <div class="col-md-4">  
                <div class="card shadow-sm">  
                    <div class="card-body text-center">  
                        <h5 class="card-title text-warning"><i class="fas fa-stopwatch"></i> Per Menit</h5>  
                        <p id="latestMinuteCost" class="card-text font-weight-bold text-muted">Loading...</p>  
                    </div>  
                </div>  
            </div>  

            <div class="col-md-4">  
                <div class="card shadow-sm">  
                    <div class="card-body text-center">  
                        <h5 class="card-title text-success"><i class="fas fa-clock"></i> Per Jam</h5>  
                        <p id="latestHourlyCost" class="card-text font-weight-bold text-muted">Loading...</p>  
                    </div>  
                </div>  
            </div>  

            <div class="col-md-4">  
                <div class="card shadow-sm">  
                    <div class="card-body text-center">  
                        <h5 class="card-title text-info"><i class="fas fa-calendar-day"></i> Per Hari</h5>  
                        <p id="latestDailyCost" class="card-text font-weight-bold text-muted">Loading...</p>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div> 
    <br><br><br>
    <!-- Baris 1: Voltage dan Current -->  
    <div class="row mb-4">  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Voltage Monitor</div>  
                <div class="card-body">  
                    <canvas id="voltageChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Voltage:</strong>   
                    <span id="currentVoltage" class="badge bg-primary">- V</span>  
                </div>  
            </div>  
        </div>  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Current Monitor</div>  
                <div class="card-body">  
                    <canvas id="currentChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Amperage:</strong>   
                    <span id="currentAmperage" class="badge bg-success">- A</span>  
                </div>  
            </div>  
        </div>  
    </div>  

    <!-- Baris 2: Power dan Energy -->  
    <div class="row mb-4">  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Power Monitor</div>  
                <div class="card-body">  
                    <canvas id="powerChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Power:</strong>   
                    <span id="currentPower" class="badge bg-danger">- W</span>  
                </div>  
            </div>  
        </div>  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Energy Monitor</div>  
                <div class="card-body">  
                    <canvas id="energyChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Energy:</strong>   
                    <span id="currentEnergy" class="badge bg-warning">- Wh</span>  
                </div>  
            </div>  
        </div>  
    </div>  

    <!-- Baris 3: Frequency dan Power Factor -->  
    <div class="row mb-4">  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Frequency Monitor</div>  
                <div class="card-body">  
                    <canvas id="frequencyChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Frequency:</strong>   
                    <span id="currentFrequency" class="badge bg-info">- Hz</span>  
                </div>  
            </div>  
        </div>  
        <div class="col-md-6">  
            <div class="card h-100">  
                <div class="card-header">Power Factor Monitor</div>  
                <div class="card-body">  
                    <canvas id="powerFactorChart"></canvas>  
                </div>  
                <div class="card-footer">  
                    <strong>Current Power Factor:</strong>   
                    <span id="currentPowerFactor" class="badge bg-secondary">-</span>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection  

@push('scripts')  
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
<script>  
document.addEventListener('DOMContentLoaded', function() {  
    // Fungsi untuk membuat chart (sama seperti sebelumnya)  
    function createChart(chartId, label, borderColor) {  
        const ctx = document.getElementById(chartId).getContext('2d');  
        return new Chart(ctx, {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: label,  
                    data: [],  
                    borderColor: borderColor,  
                    tension: 0.1,  
                    fill: false  
                }]  
            },  
            options: {  
                responsive: true,  
                maintainAspectRatio: false,  
                scales: {  
                    y: {  
                        beginAtZero: true  
                    }  
                }  
            }  
        });  
    }  

    // Buat chart untuk setiap jenis data (sama seperti sebelumnya)  
    const voltageChart = createChart('voltageChart', 'Voltage', 'blue');  
    const currentChart = createChart('currentChart', 'Current', 'green');  
    const powerChart = createChart('powerChart', 'Power', 'red');  
    const energyChart = createChart('energyChart', 'Energy', 'purple');  
    const frequencyChart = createChart('frequencyChart', 'Frequency', 'orange');  
    const powerFactorChart = createChart('powerFactorChart', 'Power Factor', 'brown');  

    // Array dari chart dan elemen untuk update (sama seperti sebelumnya)  
    const chartConfigs = [  
        { chart: voltageChart, labelId: 'currentVoltage', key: 'voltage', unit: 'V' },  
        { chart: currentChart, labelId: 'currentAmperage', key: 'current', unit: 'A' },  
        { chart: powerChart, labelId: 'currentPower', key: 'power', unit: 'W' },  
        { chart: energyChart, labelId: 'currentEnergy', key: 'energy', unit: 'Wh' },  
        { chart: frequencyChart, labelId: 'currentFrequency', key: 'frequency', unit: 'Hz' },  
        { chart: powerFactorChart, labelId: 'currentPowerFactor', key: 'power_factor', unit: '' }  
    ];  

    // Fungsi fetch data (sama seperti sebelumnya)  
    function fetchData() {  
    axios.get('/sensor-data')  
        .then(response => {  
            const data = response.data.data;  
            const latest = response.data.latest;  

            // Update setiap chart  
            chartConfigs.forEach(config => {  
                // Format label waktu hanya untuk jam  
                config.chart.data.labels = data.map(item => {  
                    const date = new Date(item.timestamp);  
                    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });  
                });  
                config.chart.data.datasets[0].data = data.map(item => item[config.key]);  
                config.chart.update();  

                // Update current value  
                const currentValue = latest[config.key];  
                document.getElementById(config.labelId).textContent =   
                    `${currentValue.toFixed(2)} ${config.unit}`;  
            });  
        });  
}

    // Fetch data setiap 5 detik  
    fetchData();  
    setInterval(fetchData, 3000);  
});  
</script>  
<script>  
    function formatFullDate(dateTime) {  
        const date = new Date(dateTime);  
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };  
        return date.toLocaleDateString('id-ID', options);  
    }  

    function updateCurrentDate() {  
        const today = new Date();  
        const formattedDate = formatFullDate(today);  
        $('#currentDate').text(`Monitor biaya energi. ${formattedDate}`);  
    }  

    function formatTime(dateTime) {  
        const date = new Date(dateTime);  
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });  
    }  

    function formatDate(dateTime) {  
        const date = new Date(dateTime);  
        return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });  
    }  

    function updateLatestMinuteCost() {  
        $.get('/energy-cost/minute-costs', function(data) {  
            if (data.length > 0) {  
                let latestMinute = data[0];  
                $('#latestMinuteCost').text(`${formatTime(latestMinute.interval_start)}: ${latestMinute.total_energy_cost} IDR`);  
            }  
        });  
    }  

    function updateLatestHourlyCost() {  
        $.get('/energy-cost/hourly-costs', function(data) {  
            if (data.length > 0) {  
                let latestHour = data[0];  
                $('#latestHourlyCost').text(`${formatTime(latestHour.interval_start)}: ${latestHour.total_energy_cost} IDR`);  
            }  
        });  
    }  

    function updateLatestDailyCost() {  
        $.get('/energy-cost/daily-costs', function(data) {  
            if (data.length > 0) {  
                let latestDay = data[0];  
                $('#latestDailyCost').text(`${formatDate(latestDay.interval_start)}`);  
            }  
        });  
    }  

    // Update tanggal setiap hari  
    updateCurrentDate();  

    // Update biaya energi  
    setInterval(updateLatestMinuteCost, 60000);  
    setInterval(updateLatestHourlyCost, 3600000);  
    setInterval(updateLatestDailyCost, 86400000);  

    // Panggil fungsi saat halaman dimuat  
    updateLatestMinuteCost();  
    updateLatestHourlyCost();  
    updateLatestDailyCost();  
</script>  
@endpush