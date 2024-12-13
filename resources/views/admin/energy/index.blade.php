<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Real-Time Energy Monitoring</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4 text-primary"><i class="fas fa-bolt"></i> Pengeluaran Energi</h1>
            <p id="currentDate" class="lead text-secondary">Monitor biaya energi Anda secara real-time</p>
        </div>

        <!-- Biaya Listrik -->
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

        <br><br><br>

        <!-- Data Sensor -->
        <div id="sensor-data-section">
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
    </div>
    <script>  
        // Inisialisasi Chart.js  
        const voltageChart = new Chart(document.getElementById('voltageChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Voltage (V)',  
                    data: [],  
                    borderColor: 'blue',  
                    tension: 0.4,  
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
    
        const currentChart = new Chart(document.getElementById('currentChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Current (A)',  
                    data: [],  
                    borderColor: 'green',  
                    tension: 0.4,  
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
    
        const powerChart = new Chart(document.getElementById('powerChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Power (W)',  
                    data: [],  
                    borderColor: 'red',  
                    tension: 0.4,  
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
    
        const energyChart = new Chart(document.getElementById('energyChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Energy (Wh)',  
                    data: [],  
                    borderColor: 'orange',  
                    tension: 0.4,  
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
    
        const frequencyChart = new Chart(document.getElementById('frequencyChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Frequency (Hz)',  
                    data: [],  
                    borderColor: 'purple',  
                    tension: 0.4,  
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
    
        const powerFactorChart = new Chart(document.getElementById('powerFactorChart'), {  
            type: 'line',  
            data: {  
                labels: [],  
                datasets: [{  
                    label: 'Power Factor',  
                    data: [],  
                    borderColor: 'brown',  
                    tension: 0.4,  
                    fill: false  
                }]  
            },  
            options: {  
                responsive: true,  
                maintainAspectRatio: false,  
                scales: {  
                    y: {  
                        min: 0,  
                        max: 1  
                    }  
                }  
            }  
        });  
    
        // Fungsi untuk memperbarui biaya  
        const updateCosts = () => {  
            axios.get('/api/cost-data')  
                .then(response => {  
                    const data = response.data;  
                    document.getElementById('latestMinuteCost').innerText =   
                        data.minute.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });  
                    document.getElementById('latestHourlyCost').innerText =   
                        data.hour.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });  
                    document.getElementById('latestDailyCost').innerText =   
                        data.day.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });  
                })  
                .catch(error => {  
                    console.error('Error fetching cost data:', error);  
                });  
        };  
    
        // Fungsi untuk memperbarui grafik dan nilai real-time  
        const updateCharts = () => {  
    axios.get('/api/sensor-data')  
        .then(response => {  
            const data = response.data;  

            // Debug: Log raw data untuk pemeriksaan  
            console.log('Raw Sensor Data:', data);  
    
            // Tambahkan validasi data  
            if (!data.chart || data.chart.labels.length === 0) {  
                console.warn('Tidak ada data grafik yang diterima');  
                return;  
            }  
    
            // Update grafik dengan validasi tambahan  
            const updateChartData = (chart, labels, dataValues) => {  
                if (labels.length > 0 && dataValues.length > 0) {  
                    chart.data.labels = labels;  
                    chart.data.datasets[0].data = dataValues;  
                    chart.update();  
                } else {  
                    console.warn('Data grafik tidak valid');  
                }  
            };  
    
            updateChartData(voltageChart, data.chart.labels, data.chart.voltage);  
            updateChartData(currentChart, data.chart.labels, data.chart.current);  
            updateChartData(powerChart, data.chart.labels, data.chart.power);  
            updateChartData(energyChart, data.chart.labels, data.chart.energy);  
            updateChartData(frequencyChart, data.chart.labels, data.chart.frequency);  
            updateChartData(powerFactorChart, data.chart.labels, data.chart.power_factor);  
    
            // Update nilai real-time dengan validasi  
            const updateBadgeValue = (elementId, value, suffix) => {  
                const element = document.getElementById(elementId);  
                if (element && !isNaN(value)) {  
                    element.innerText = `${value.toFixed(2)} ${suffix}`;  
                }  
            };  
    
            updateBadgeValue('currentVoltage', data.latest.voltage, 'V');  
            updateBadgeValue('currentAmperage', data.latest.current, 'A');  
            updateBadgeValue('currentPower', data.latest.power, 'W');  
            updateBadgeValue('currentEnergy', data.latest.energy, 'Wh');  
            updateBadgeValue('currentFrequency', data.latest.frequency, 'Hz');  
            
            const powerFactorElement = document.getElementById('currentPowerFactor');  
            if (powerFactorElement && !isNaN(data.latest.power_factor)) {  
                powerFactorElement.innerText = data.latest.power_factor.toFixed(2);  
            }  
        })  
        .catch(error => {  
            console.error('Error fetching sensor data:', error);  
            // Tambahkan notifikasi error yang lebih informatif  
            alert('Gagal mengambil data sensor. Periksa koneksi atau server.');  
        });  
};
    
        // Memperbarui data setiap 3 detik  
        setInterval(() => {  
            updateCosts();  
            updateCharts();  
        }, 3000);  
    
        // Panggil fungsi pertama kali saat halaman dimuat  
        updateCosts();  
        updateCharts();  
    
        // Tambahan: Menampilkan tanggal saat ini  
        document.getElementById('currentDate').innerText =   
            new Date().toLocaleDateString('id-ID', {   
                weekday: 'long',   
                year: 'numeric',   
                month: 'long',   
                day: 'numeric'   
            });  
    </script>

</body>
</html>
