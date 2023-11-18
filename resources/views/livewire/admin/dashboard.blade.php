@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard-page.css') }}">
@endpush


<div class="content-body admin-dashboard">
    <div class="container">
        <div class="page-title">
            <h1 id="verify-page-title">Admin Dashboard</h1>
        </div>

        <div class="content-card-wrapper">
            <div class="page-content-card bar-card">
                <div class="chart-container">
                    <div class="canvas-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="page-content-card">
                <div class="chart-container">
                    <div class="canvas-container">
                        <canvas id="umkmPerDistrictChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="page-content-card">
                <div class="chart-container">
                    <div class="canvas-container">
                        <canvas id="koperasiPerDistrictChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('script')
<script>

const countByLocation = (sub_district, labels) => {
    let count = []
    labels.forEach(label => {
        count.push(sub_district[label].length)
    });

    return count
}

const createDoughnut = (title, ctx_id, sub_district_data, label) => {
    const ctx = $(ctx_id);
    new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: label,
        datasets: [{
        label: 'Jumlah',
        data: countByLocation(sub_district_data, label),
        borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                display: false,
            },
            y: {
                display: false,
            }
        },
        plugins: {
            title: {
                display: true,
                text: title,
                color: '#2A2A2A',
                font: {
                    size: 20,
                    weight: 'bold',
                    lineHeight: 1.2,
                },
            }
        }
    }
    });
}

const createBarChart = (ctx_id, labels, data) => {
    const bar_ctx = $(ctx_id);
    new Chart(bar_ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'jumlah',
            data: data,
            borderWidth: 1,
            backgroundColor: [
                '#1EBFD1',
                '#1ED189',
            ],
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Koperasi / UMKM Aktif',
                color: '#2A2A2A',
                font: {
                    size: 20,
                    weight: 'bold',
                    lineHeight: 1.2,
                },
            },
            legend: {
                position: 'top'
            },
        },
        indexAxis: 'y',
    }
    });
}

$(document).ready(() => {
    createBarChart('#barChart', ['UMKM', 'Koperasi'], [@this.umkm_count, @this.koperasi_count])
    createDoughnut('UMKM Aktif per Kecamatan', '#umkmPerDistrictChart', @this.umkm_sub_district, @this.umkm_sub_district_label)
    createDoughnut('Koperasi Aktif per Kecamatan', '#koperasiPerDistrictChart', @this.koperasi_sub_district, @this.koperasi_sub_district_label)
})

    
</script>
@endpush