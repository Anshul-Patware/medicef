@extends('frontend.layout.main')

@section('container')
<br>

<style>
    .record-analytics-heading {
        display: flex;
        align-items: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #eca035; 
        margin-bottom: 20px;
        padding: 15px; 
        border: 2px solid #eca035; 
        border-radius: 10px; 
        text-align: center;
    }

    .record-analytics-heading i {
        margin-right: 10px;
        color: #eca035;
    }

    .card-text {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .process-count {
        display: inline-block;
        background-color: #eca035;
        color: rgb(12, 11, 11);
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        margin-left: 10px;
    }

    .chart-btn {
        margin-bottom: 10px;
    }
</style>

<div class="container" style="max-width: 1769px;">
    <h3 class="record-analytics-heading">
        <i class="fas fa-chart-bar"></i> KPI Analytics
    </h3>

    <div class="tab-pane fade show active" id="pendingTrainingPie" role="tabpanel" aria-labelledby="home-tab">
        <div class="card border-0">
            <div class="card-body">
                {{-- <h5 class="process-count">{{$label}} Stage wise Distribution</h5> --}}
              
                
                <div class="col-12 col-md-8 mb-4">
                    <!-- Buttons to change chart type -->
                    <button class="btn btn-outline-secondary chart-btn me-2" data-chart="pie" title="Pie Chart">
                        <i class="bi bi-pie-chart"></i> 
                    </button>
                    <button class="btn btn-outline-secondary chart-btn me-2" data-chart="bar" title="Bar Chart">
                        <i class="bi bi-bar-chart"></i> 
                    </button>
                    <button class="btn btn-outline-secondary chart-btn me-2" data-chart="line" title="Line Chart">
                        <i class="bi bi-graph-up"></i> 
                    </button>
                    <button class="btn btn-outline-secondary chart-btn" data-chart="scatter" title="Scatter Chart">
                        <i class="bi bi-cloud"></i> 
                    </button>

                      <!-- Refresh Button -->
                    <button class="btn btn-outline-secondary chart-btn" onclick="location.reload()" title="Refresh Page" style="background-color: #eca035; border-color: #eca035; color: rgb(7, 6, 6);">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>

                <div class="tab-pane fade show active" id="pendingTrainingPie" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                <span class="process-count"><i class="bi bi-pie-chart me-2"></i> {{$label}} Stage wise Distribution</span> 
                            </h5>
                            <div class="d-flex justify-content-center align-items-center" style="display: none;">
                                <div id="loadingSpinner" class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
            
                <!-- Chart container -->
                <div class="card-text d-flex justify-content-center align-items-center h-100" id="chartContainer">
                </div>             
            </div>
            
        </div>
    </div>
</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Render Chart Function
    function renderChart(type, seriesData, labels) {
    Highcharts.chart('chartContainer', {
        chart: {
            type: type === 'bar' ? 'column' : type, // Change bar to column for vertical bars
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Count: <b>{point.count}</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %<br>Count: {point.count}',
                    connectorColor: 'silver'
                },
                showInLegend: true,
                point: {
                    events: {
                        click: function () {
                            const label = this.name;
                            const process = `{{ $label }}`; // Pass Blade variable (process)

                            const url = `{{ route('api.drillChartDateDistribution.chart', ['process' => ':process', 'label' => ':label']) }}`
                                .replace(':process', process)
                                .replace(':label', label);
                            window.location.href = url;
                        }
                    }
                }
            },
            column: { // Use column for vertical bars
                dataLabels: {
                    enabled: true
                }
            },
            line: {
                dataLabels: {
                    enabled: true
                }
            },
            scatter: {
                marker: {
                    radius: 5
                }
            }
        },
        xAxis: {
            categories: labels,
            title: {
                text: 'Categories'
            }
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        series: [{
            name: 'Share',
            colorByPoint: type === 'pie',
            data: labels.map((label, index) => ({
                name: label,
                y: seriesData[index],
                count: seriesData[index]
            }))
        }]
    });

    $('#loadingSpinner').hide();
    $('#chartContainer').fadeIn();
}

function renderPendingTrainingChart(seriesData, labels) {
    Highcharts.chart('pendingTrainingAnalysisPie', {
        chart: {
            type: 'pie',
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Count: <b>{point.count}</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %<br>Count: {point.count}',
                    connectorColor: 'silver'
                },
                showInLegend: true,
                point: {
                    events: {
                        click: function () {
                            const label = this.name;
                            const process = `{{ $label }}`; // Pass Blade variable (process)

                            const url = `{{ route('api.drillChartDateDistribution.chart', ['process' => ':process', 'label' => ':label']) }}`
                                .replace(':process', process)
                                .replace(':label', label);
                            window.location.href = url;
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Share',
            colorByPoint: true,
            data: labels.map((label, index) => ({
                name: label,
                y: seriesData[index],
                count: seriesData[index] // Add the count of the process
            }))
        }]
    });

    $('#loadingSpinner').hide();
    $('#pendingTrainingAnalysisPie').fadeIn();
}



    // Fetch Data and Prepare Chart
    async function prepareChart(type) {
        $('#loadingSpinner').show(); // Show loader
        $('#chartContainer').hide(); // Hide chart initially

        try {
            let url;
            const process = `{{ $label }}`;

            // Map process to API endpoint
            const endpoints = {
                'Action Item': "{{ route('api.actionItem.stageDistribution') }}",
                'Audit Program': "{{ route('api.AuditProgram.stageDistribution') }}",
                'CAPA': "{{ route('api.CAPA.stageDistribution') }}",
                'Calibration Management': "{{ route('api.CalibrationManagement.stageDistribution') }}",
                'Change Control': "{{ route('api.ChangeControl.stageDistribution') }}",
                'Deviation': "{{ route('api.Deviation.stageDistribution') }}",
                'Effectiveness Check': "{{ route('api.EffectivenessCheck.stageDistribution') }}",
                'Equipment Lifecycle': "{{ route('api.EquipmentLCM.stageDistribution') }}",
                'Global Capa': "{{ route('api.GlobalCAPA.stageDistribution') }}",
                'Global Change Control': "{{ route('api.GlobalChangeControl.stageDistribution') }}",
                'Incident': "{{ route('api.Incident.stageDistribution') }}",
                'Internal Audit': "{{ route('api.InternalAudit.stageDistribution') }}",
                'LabIncident': "{{ route('api.LabIncident.stageDistribution') }}",
                'Preventive Maintenance': "{{ route('api.PreventiveMaintenance.stageDistribution') }}",
                'Risk Assessment': "{{ route('api.RiskAssessment.stageDistribution') }}",
                'Root Cause Analysis': "{{ route('api.RootCauseAnalysis.stageDistribution') }}",
                'Supplier': "{{ route('api.Supplier.stageDistribution') }}",
                'Supplier Audit': "{{ route('api.SupplierAudit.stageDistribution') }}"
            };

            url = endpoints[process] || "";

            if (window.location.href.indexOf('mydemosoftware') !== -1) {
                url = url.replace('http:', 'https:');
            }

            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const { labels, series } = res.data.body;
                renderChart(type, series, labels);
            } else {
                console.error('Error fetching data:', res.data.message);
            }
        } catch (err) {
            console.error('Error in API call:', err.message);
        }
    }

    // Event Listener for Chart Buttons
    document.querySelectorAll('.chart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const chartType = button.getAttribute('data-chart');
            prepareChart(chartType);
        });
    });

    // Default chart type
    prepareChart('pie');
</script>
@endsection
