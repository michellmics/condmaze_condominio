// Função para buscar os dados do PHP
fetch("fundoReservaAreaGraph.php") // Substitua pelo caminho correto do seu script PHP
    .then(response => response.json())
    .then(data => {
        // Mapeia os meses para um formato numérico para garantir a ordenação correta
        const mesesOrdem = {
            "janeiro": 1, "fevereiro": 2, "março": 3, "abril": 4, "maio": 5, "junho": 6,
            "julho": 7, "agosto": 8, "setembro": 9, "outubro": 10, "novembro": 11, "dezembro": 12
        };

        // Ordena os dados corretamente por ano e mês
        data.sort((a, b) => {
            if (b.FUR_DCANO !== a.FUR_DCANO) {
                return b.FUR_DCANO - a.FUR_DCANO; // Ano mais recente primeiro
            }
            return mesesOrdem[b.FUR_DCMES] - mesesOrdem[a.FUR_DCMES]; // Mês mais recente primeiro
        });

        // Processa os dados ordenados
        let categorias = data.map(item => `${item.FUR_DCMES}/${item.FUR_DCANO}`); // Mes/Ano
        let valores = data.map(item => parseFloat(item.FUR_DCVALUE)); // Converte os valores para número

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
