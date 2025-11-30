@extends('layouts.app')

@section('content')
<section class="pt-24 px-4"> <!-- pt-24 to leave space for fixed navbar -->
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold mb-4">Stock Forecast using ARIMA</h2>

        <form id="searchForm" class="mb-6 flex gap-2">
            <input type="text" id="symbol" placeholder="Enter Stock Symbol (e.g. AAPL)"
                class="flex-1 bg-gray-900 text-white rounded-lg px-4 py-2 border border-gray-700" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold">
                Search
            </button>
        </form>

        <p id="status" class="text-gray-400 mb-4"></p>
        <div id="metrics" class="text-gray-400 mb-6"></div>

        <div class="flex gap-2 mb-4">
            <button class="range-btn bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg" data-period="7d">7D</button>
            <button class="range-btn bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg" data-period="1mo">1M</button>
        </div>


        <div class="bg-gray-900 rounded-lg p-6 mb-6 h-96 flex items-center justify-center">
            <canvas id="chart" class="w-full h-full"></canvas>
        </div>


    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentSymbol = "";
    let chart = null;
    let fullHistorical = [];
    let fullLabels = [];
    let forecastData = [];
    let accuracyMetrics = null;

    const statusText = document.getElementById("status");
    const metricsDiv = document.getElementById("metrics");

    const form = document.getElementById("searchForm");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const symbol = document.getElementById("symbol").value.trim().toUpperCase();
        if (!symbol) return;

        statusText.innerText = "Loading...";
        metricsDiv.innerText = "";

        try {
            const response = await fetch(`/forecast/${symbol}`);
            const data = await response.json();

            if (data.error || !data.historical || data.historical.length === 0) {
                statusText.innerText = "No historical data available!";
                metricsDiv.innerText = "";
                if (chart) chart.destroy();
                return;
            }

            statusText.innerText = `Showing results for ${symbol}`;

            // Flatten nested arrays if any
            fullHistorical = data.historical.map(v => Array.isArray(v) ? v[0] : v);
            fullLabels = data.dates;
            forecastData = data.forecast ?? [];
            accuracyMetrics = data.accuracy;

            currentSymbol = symbol;

            // Display metrics
            if (accuracyMetrics) {
                const {
                    MAE,
                    RMSE,
                    MAPE
                } = accuracyMetrics;
                metricsDiv.innerHTML = `<strong>Accuracy:</strong> MAE: ${MAE.toFixed(2)}, RMSE: ${RMSE.toFixed(2)}, MAPE: ${MAPE.toFixed(2)}%`;
            }

            drawChart(fullLabels, fullHistorical, forecastData);

        } catch (error) {
            statusText.innerText = "Error connecting to API";
            metricsDiv.innerText = "";
            console.error(error);
        }
    });

    // Range buttons
    document.querySelectorAll(".range-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const period = btn.dataset.period;
            if (!currentSymbol) return;

            let numPoints;
            switch (period) {
                case "7d":
                    numPoints = 7;
                    break;
                case "1mo":
                    numPoints = 30;
                    break;
                default:
                    numPoints = fullHistorical.length;
            }

            const histSlice = fullHistorical.slice(-numPoints);
            const labelSlice = fullLabels.slice(-numPoints);

            drawChart(labelSlice, histSlice, forecastData);
        });
    });

    function drawChart(labels, histData, forecastData) {
        const totalLabels = [...labels, ...forecastData.map((_, i) => {
            const lastDate = new Date(labels[labels.length - 1]);
            lastDate.setDate(lastDate.getDate() + i + 1);
            return lastDate.toISOString().split("T")[0];
        })];

        const histDataWithNulls = [...histData, ...Array(forecastData.length).fill(null)];
        const forecastDataWithNulls = [...Array(histData.length).fill(null), ...forecastData];

        if (chart) chart.destroy();

        const ctx = document.getElementById("chart").getContext("2d");
        chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: totalLabels,
                datasets: [{
                        label: "Historical",
                        data: histDataWithNulls,
                        borderColor: "blue",
                        pointRadius: 3,
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: "Forecast",
                        data: forecastDataWithNulls,
                        borderColor: "red",
                        pointRadius: 4,
                        borderDash: [5, 5],
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: "index",
                    intersect: false
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ccc'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ccc'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                }
            }
        });
    }
</script>
@endpush