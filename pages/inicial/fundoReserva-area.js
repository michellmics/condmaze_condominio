// Função para buscar os dados do PHP
fetch("fundoReservaAreaGraph.php") // Substitua pelo caminho correto do seu script PHP
    .then(response => response.json())
    .then(data => {
        // Processa os dados do JSON
        let categorias = [];
        let valores = [];

        data.forEach(item => {
            categorias.push(item.FUR_DCMES); // Obtém os meses
            valores.push(parseFloat(item.FUR_DCVALUE)); // Converte os valores para número
        });

        // Configuração do gráfico
        let options = {
            chart: {
                height: 380,
                type: "area"
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 3,
                curve: "smooth"
            },
            colors: ["#727cf5"],
            series: [{
                name: "Fundo Reserva",
                data: valores
            }],
            legend: {
                offsetY: 5
            },
            xaxis: {
                categories: categorias
            },
            tooltip: {
                fixed: {
                    enabled: false,
                    position: "topRight"
                }
            },
            grid: {
                borderColor: "#f1f3fa"
            }
        };

        // Renderiza o gráfico
        let chart = new ApexCharts(document.querySelector("#basic-area"), options);
        chart.render();
    })
    .catch(error => console.error("Erro ao buscar os dados:", error));
