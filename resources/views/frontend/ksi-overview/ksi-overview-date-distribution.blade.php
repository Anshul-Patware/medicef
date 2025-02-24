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

    .tab-content {
        margin-top: 20px;
    }

    .chart-container {
        margin: 20px auto;
        max-width: 1200px;
        height: 400px;
    }

    .refresh-button-container {
        text-align: right;
        margin-bottom: 10px;
    }

    .refresh-button {
        background-color: #eca035;
        color: rgb(19, 16, 16);
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .refresh-button:hover {
        background-color: #d28f30;
    }

    #loadingSpinner {
        display: none; 
    }
</style>

<div class="container" style="max-width: 1769px;">
    <h3 class="record-analytics-heading">
        <i class="fas fa-chart-bar"></i> KPI Analytics
    </h3>
    <br>

    <!-- Refresh Button -->
    <div class="refresh-button-container">
        <button id="refreshButton" class="refresh-button" onclick="location.reload()" title="Refresh Page"><i class="bi bi-arrow-clockwise"></i> Refresh Chart</button>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        <div id="loadingSpinner" class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Tabs for Chart Types -->
    <ul class="nav nav-tabs" id="chartTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="bar-tab" data-bs-toggle="tab" data-bs-target="#bar-chart" type="button" role="tab" aria-controls="bar-chart" aria-selected="true">
                <i class="fas fa-chart-bar"style="color: #d28f30;"></i>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="pie-tab" data-bs-toggle="tab" data-bs-target="#pie-chart" type="button" role="tab" aria-controls="pie-chart" aria-selected="false">
                <i class="fas fa-chart-pie" style="color: #d28f30;"></i>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="line-tab" data-bs-toggle="tab" data-bs-target="#line-chart" type="button" role="tab" aria-controls="line-chart" aria-selected="false">
                <i class="fas fa-chart-line" style="color: #d28f30;"></i>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="scatter-tab" data-bs-toggle="tab" data-bs-target="#scatter-chart" type="button" role="tab" aria-controls="scatter-chart" aria-selected="false">
                <i class="bi bi-cloud"style="color: #d28f30;"></i>
            </button>
        </li>
    </ul>

    <!-- Tab Content for Charts -->
    <div class="tab-content" id="chartTabContent">
        <div class="tab-pane fade show active chart-container" id="bar-chart" role="tabpanel" aria-labelledby="bar-tab">
            <div id="barChartContainer"></div>
        </div>
        <div class="tab-pane fade chart-container" id="pie-chart" role="tabpanel" aria-labelledby="pie-tab">
            <div id="pieChartContainer"></div>
        </div>
        <div class="tab-pane fade chart-container" id="line-chart" role="tabpanel" aria-labelledby="line-tab">
            <div id="lineChartContainer"></div>
        </div>
        <div class="tab-pane fade chart-container" id="scatter-chart" role="tabpanel" aria-labelledby="scatter-tab">
            <div id="scatterChartContainer"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const process = `{{ $process }}`;
    const prevLabel = `{{ $label }}`;
    let currentChartType = 'bar'; // Track the current chart type

    // Function to fetch data and render charts
    async function fetchAndRenderChart(chartType, containerId) {
        $('#loadingSpinner').show(); // Show loader
        $(`#${containerId}`).empty(); // Clear the chart container

        let url = `{{ route('api.MonthlyDistribution', ['process' => ':process', 'label' => ':label']) }}`.replace(':process', process).replace(':label', prevLabel);

        if (window.location.href.indexOf('mydemosoftware') !== -1) {
            url = url.replace('http:', 'https:');
        }

        try {
            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const { labels, series } = res.data.body;

                // Render the chart with the fetched data
                renderChart(labels, series, chartType, containerId);
            } else {
                console.error("Error fetching data:", res.data.message);
            }
        } catch (err) {
            console.error("Error in API call:", err.message);
        } finally {
            $('#loadingSpinner').hide(); // Hide loader
        }
    }

    // Function to render the chart
    function renderChart(labels, series, chartType, containerId) {
        let options;

        // Handle Pie Chart differently
        if (chartType === 'pie') {
            options = {
                chart: {
                    type: chartType,
                    height: 350,
                    events: {
                        dataPointSelection: function (event, chartContext, config) {
                            if (config.dataPointIndex !== undefined) {
                                const index = config.dataPointIndex;
                                const label = chartContext.opts.xaxis.categories[index];
                                const url = `{{ route('api.drillChartLogs.chart', ['process' => ':process', 'label' => ':label']) }}`
                                    .replace(':process', process)
                                    .replace(':label', prevLabel);
                                window.location.href = url; // Redirect to new URL
                            }
                        }
                    }
                },
                labels: labels,
                series: series,
                title: {
                    text: 'Pie Chart',
                    align: 'center',
                },
            };
        } else {
            options = {
                chart: {
                    type: chartType,
                    height: 350,
                    events: {
                        dataPointSelection: function (event, chartContext, config) {
                            if (config.dataPointIndex !== undefined) {
                                const index = config.dataPointIndex;
                                const label = chartContext.opts.xaxis.categories[index];
                                const url = `{{ route('api.drillChartLogs.chart', ['process' => ':process', 'label' => ':label']) }}`
                                    .replace(':process', process)
                                    .replace(':label', prevLabel);
                                window.location.href = url; // Redirect to new URL
                            }
                        }
                    }
                },
                series: [{
                    name: 'Flow Count',
                    data: series,
                }],
                xaxis: {
                    categories: labels,
                },
                title: {
                    text: `${chartType.charAt(0).toUpperCase() + chartType.slice(1)} Chart`,
                    align: 'center',
                },
            };
        }

        const chart = new ApexCharts(document.querySelector(`#${containerId}`), options);
        chart.render();
    }

    // Event Listeners for Tab Buttons
    document.addEventListener('DOMContentLoaded', () => {
        // Default: Load Bar Chart
        fetchAndRenderChart('bar', 'barChartContainer');

        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', (event) => {
                currentChartType = event.target.id.replace('-tab', ''); // Update the chart type
                const containerId = `${currentChartType}ChartContainer`;
                fetchAndRenderChart(currentChartType, containerId);
            });
        });

        // Refresh Button Click Event
        document.getElementById('refreshButton').addEventListener('click', () => {
            const containerId = `${currentChartType}ChartContainer`;
            fetchAndRenderChart(currentChartType, containerId);
        });
    });
</script>

@endsection
