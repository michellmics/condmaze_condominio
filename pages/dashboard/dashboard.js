// Requisição para o endpoint e preenchimento do gráfico
fetch("barGraph.php")
.then(response => response.json())  // Converte a resposta em JSON
.then(data => {
    // Cria arrays para armazenar os meses e as taxas de inadimplência
    let meses = [];
    let taxasInadimplencia = [];

    // Preenche os arrays com os dados recebidos
    data.forEach(item => { 
        meses.push(traduzirMes(item.Mes));  // Adiciona o mês
        taxasInadimplencia.push(parseFloat(item.TaxaInadimplencia));  // Adiciona a taxa de inadimplência
    });

    // Calcula a média das taxas de inadimplência
    const mediaInadimplencia = taxasInadimplencia.reduce((acc, curr) => acc + curr, 0) / taxasInadimplencia.length;

    // Configuração do gráfico de barras
    var o = {
        chart: {
            height: 256,
            type: "bar",  // Tipo de gráfico: barra
            stacked: true  // Empilha as barras
        },
        plotOptions: {
            bar: {
                horizontal: false,  // Gráfico de barras verticais
                columnWidth: "20%"  // Largura das barras
            }
        },
        dataLabels: {
            enabled: false  // Desativa os rótulos de dados
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"]  // Sem bordas nas barras
        },
        series: [  // Defina os dados das séries aqui
            {
                name: "Taxa Atual de Inadimplência",
                data: taxasInadimplencia  // Usa os dados de taxas de inadimplência
            }
        ],
        zoom: {
            enabled: false  // Desativa o zoom
        },
        legend: {
            show: false  // Desativa a legenda
        },
        colors: e = (t = r("#codemaze_bar_chart").data("colors")) ? t.split(",") : e,  // Usa cores configuradas, se houver
        xaxis: {
            categories: meses,  // Usa os meses extraídos dos dados
            axisBorder: {
                show: false  // Desativa a borda do eixo X
            }
        },
        yaxis: {
            stepSize: 10,  // Define o incremento do eixo Y
            labels: {
                formatter: function(e) {
                    return e + "%";  // Formatação das taxas de inadimplência no eixo Y
                },
                offsetX: -15
            }
        },
        fill: {
            opacity: 1  // Opacidade das barras
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    return e + "%";  // Formatação das tooltips
                }
            }
        },
        annotations: {
            yaxis: [{
                y: mediaInadimplencia,  // Usa a média como limite no gráfico
                borderColor: '#FF0000',  // Cor da linha (vermelho)
                label: {
                    text: `Média da Inadimplência ${mediaInadimplencia.toFixed(2)}%`,  // Texto da anotação com a média
                    style: {
                        color: '#FF0000',  // Cor do texto
                        background: '#FFF',  // Fundo do texto
                    }
                }
            }],
        }
    };

    // Renderiza o gráfico de barras com os dados obtidos
    new ApexCharts(document.querySelector("#codemaze_bar_chart"), o).render();
})
.catch(error => {
    console.error("Erro ao carregar os dados do gráfico:", error);  // Trata qualquer erro na requisição
});
