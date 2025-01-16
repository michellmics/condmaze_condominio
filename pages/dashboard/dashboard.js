(function($) {
    "use strict";

    function Dashboard() {
        this.$body = $("body");
        this.charts = [];
    }

    // Função para inicializar os gráficos
    Dashboard.prototype.initCharts = function() {
        const defaultColors = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];

        // Cores para o gráfico de Receita
        const revenueChartColors = $("#revenue-chart").data("colors") || defaultColors;

        // Cores para o gráfico de Barras
        const barChartColors = $("#codemaze_bar_chart").data("colors") || defaultColors;

        // Cores para o gráfico de Donut
        const donutChartColors = $("#average-sales").data("colors") || defaultColors;

        // Gráfico de Linha (Revenue Chart)
        const revenueChartOptions = {
            chart: {
                height: 370,
                type: "line",
                dropShadow: {
                    enabled: true,
                    opacity: 0.2,
                    blur: 7,
                    left: -7,
                    top: 7
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: "smooth", width: 4 },
            series: [
                { name: "Current Week", data: [10, 20, 15, 25, 20, 30, 20] },
                { name: "Previous Week", data: [0, 15, 10, 30, 15, 35, 25] }
            ],
            colors: revenueChartColors,
            zoom: { enabled: false },
            legend: { show: false },
            xaxis: {
                type: "string",
                categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                tooltip: { enabled: false },
                axisBorder: { show: false }
            },
            grid: { strokeDashArray: 7 },
            yaxis: {
                stepSize: 9,
                labels: {
                    formatter: (value) => value + "k",
                    offsetX: -15
                }
            }
        };
        new ApexCharts(document.querySelector("#revenue-chart"), revenueChartOptions).render();

        // Gráfico de Barras (Bar Chart)
        const barChartOptions = {
            chart: { height: 256, type: "bar", stacked: true },
            plotOptions: { bar: { horizontal: false, columnWidth: "20%" } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 0, colors: ["transparent"] },
            series: [
                { name: "Actual", data: [65, 59, 80, 81, 56, 89, 40, 32, 65, 59, 80, 81] },
                { name: "Projection", data: [89, 40, 32, 65, 59, 80, 81, 56, 89, 40, 65, 59] }
            ],
            zoom: { enabled: false },
            legend: { show: false },
            colors: barChartColors,
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                axisBorder: { show: false }
            },
            yaxis: {
                stepSize: 40,
                labels: {
                    formatter: (value) => value + "k",
                    offsetX: -15
                }
            },
            fill: { opacity: 1 },
            tooltip: {
                y: { formatter: (value) => "$" + value + "k" }
            }
        };
        new ApexCharts(document.querySelector("#codemaze_bar_chart"), barChartOptions).render();

        // Gráfico de Donut (Average Sales)
        const donutChartOptions = {
            chart: { height: 202, type: "donut" },
            legend: { show: false },
            stroke: { width: 0 },
            series: [44, 55, 41, 17],
            labels: ["Direct", "Affiliate", "Sponsored", "E-mail"],
            colors: donutChartColors,
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: { width: 200 },
                        legend: { position: "bottom" }
                    }
                }
            ]
        };
        new ApexCharts(document.querySelector("#average-sales"), donutChartOptions).render();
    };

    // Função para inicializar o mapa
    Dashboard.prototype.initMaps = function() {
        new jsVectorMap({
            map: "world",
            selector: "#world-map-markers",
            zoomOnScroll: false,
            zoomButtons: true,
            markersSelectable: true,
            hoverOpacity: 0.7,
            hoverColor: false,
            regionStyle: { initial: { fill: "rgba(145, 166, 189, 0.25)" } },
            markerStyle: {
                initial: {
                    r: 9,
                    fill: "#727cf5",
                    "fill-opacity": 0.9,
                    stroke: "#fff",
                    "stroke-width": 7,
                    "stroke-opacity": 0.4
                },
                hover: {
                    stroke: "#fff",
                    "fill-opacity": 1,
                    "stroke-width": 1.5
                }
            },
            backgroundColor: "transparent",
            markers: [
                { coords: [40.71, -74], name: "New York" },
                { coords: [37.77, -122.41], name: "San Francisco" },
                { coords: [-33.86, 151.2], name: "Sydney" },
                { coords: [1.3, 103.8], name: "Singapore" }
            ]
        });
    };

    // Função principal de inicialização
    Dashboard.prototype.init = function() {
        $("#dash-daterange").daterangepicker({ singleDatePicker: true });
        this.initCharts();
        this.initMaps();
    };

    // Inicialização do Dashboard
    const dashboard = new Dashboard();
    dashboard.init();
    window.Dashboard = dashboard;

})(window.jQuery);
