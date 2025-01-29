(function(r) {
    "use strict";

    // Função construtora do Dashboard
    function e() {
        this.$body = r("body");  // Corpo da página
        this.charts = [];  // Array para armazenar os gráficos
    }

    // Função para inicializar os gráficos
    e.prototype.initCharts = function() {
        // Configuração global do ApexCharts
        window.Apex = {
            chart: {
                parentHeightOffset: 0,
                toolbar: {
                    show: false  // Defina como 'true' para exibir a barra de ferramentas
                }
            },
            grid: {
                padding: {
                    left: 0,
                    right: 0
                }
            },
            colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"]  // Defina as cores padrão dos gráficos
        };

        // Definindo a variável `e` com as cores padrão
        var e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];

        // Obtendo as cores configuradas para o gráfico de receita
        var t = r("#revenue-chart").data("colors");

        // Gráfico de linha de Receita (Revenue Chart)
        var o = {
            chart: {
                height: 370,
                type: "line",  // Tipo de gráfico: linha
                dropShadow: {
                    enabled: true,
                    opacity: 0.2,
                    blur: 7,
                    left: -7,
                    top: 7
                }
            },
            dataLabels: {
                enabled: false  // Define se os rótulos de dados são exibidos
            },
            stroke: {
                curve: "smooth",  // Tipo de curva da linha: suave
                width: 4  // Largura da linha
            },
            series: [  // Defina os dados das séries aqui
                {
                    name: "Current Week",
                    data: [10, 20, 15, 25, 20, 30, 20]
                },
                {
                    name: "Previous Week",
                    data: [0, 15, 10, 30, 15, 35, 25]
                }
            ],
            colors: e = t ? t.split(",") : e,  // Se houver cores configuradas no HTML, usa as delas, senão usa as padrões
            zoom: {
                enabled: false  // Desativa o zoom no gráfico
            },
            legend: {
                show: false  // Desativa a legenda do gráfico
            },
            xaxis: {
                type: "string",
                categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],  // Defina os dias da semana
                tooltip: {
                    enabled: false  // Desativa as tooltips ao passar o mouse
                },
                axisBorder: {
                    show: false  // Desativa a borda do eixo X
                }
            },
            grid: {
                strokeDashArray: 7  // Estilo da linha da grade
            },
            yaxis: {
                stepSize: 9,
                labels: {
                    formatter: function(e) {
                        return e + "k";  // Formatação dos rótulos do eixo Y (ex: "10k")
                    },
                    offsetX: -15
                }
            }
        };
        new ApexCharts(document.querySelector("#revenue-chart"), o).render();  // Renderiza o gráfico de receita

        function traduzirMes(mes) {
            const mesesEmPortugues = {
                "Jan": "Jan",   // Janeiro
                "Feb": "Fev",   // Fevereiro
                "Mar": "Mar",   // Março
                "Apr": "Abr",   // Abril
                "May": "Mai",   // Maio
                "Jun": "Jun",   // Junho
                "Jul": "Jul",   // Julho
                "Aug": "Ago",   // Agosto
                "Sep": "Set",   // Setembro
                "Oct": "Out",   // Outubro
                "Nov": "Nov",   // Novembro
                "Dec": "Dez"    // Dezembro
            };
            return mesesEmPortugues[mes] || mes;  // Retorna o mês traduzido ou o valor original caso não haja correspondência
        }

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
                y: 15,  // Limiar no valor Y (ajuste conforme necessário)
                borderColor: '#FF0000',  // Cor da linha (vermelho)
                label: {
                    text: 'Meta Inadimplência 15%',  // Texto da anotação
                    style: {
                        color: '#FF0000',  // Cor do texto
                        background: '#FFF',  // Fundo do texto
                    }
                }
            }],
            xaxis: [{
                x: 1,  // Posição no eixo X, ajustado para a posição do mês
                y: 20,  // Posição no eixo Y para o texto
                text: 'Texto explicativo',  // Texto que você deseja exibir
                borderColor: '#000',  // Cor da borda do texto
                backgroundColor: '#FFF',  // Cor de fundo do texto
                style: {
                    fontSize: '14px',  // Tamanho da fonte
                    color: '#000'  // Cor da fonte
                }
            }]
        }
    };
    
    // Renderiza o gráfico de barras com os dados obtidos
    new ApexCharts(document.querySelector("#codemaze_bar_chart"), o).render();
})
.catch(error => {
    console.error("Erro ao carregar os dados do gráfico:", error);  // Trata qualquer erro na requisição
});


        // Gráfico de Donut
        var o = {
            chart: {
                height: 202,
                type: "donut"  // Tipo de gráfico: Donut
            },
            legend: {
                show: false  // Desativa a legenda
            },
            stroke: {
                width: 0  // Remove a borda do gráfico
            },
            series: [44, 55, 41, 17],  // Defina os valores das fatias do gráfico
            labels: ["Direct", "Affiliate", "Sponsored", "E-mail"],  // Defina os rótulos das fatias
            colors: e = (t = r("#average-sales").data("colors")) ? t.split(",") : e,  // Usa cores configuradas, se houver
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200  // Largura do gráfico em telas pequenas
                    },
                    legend: {
                        position: "bottom"  // Posição da legenda em telas pequenas
                    }
                }
            }]
        };
        new ApexCharts(document.querySelector("#average-sales"), o).render();  // Renderiza o gráfico de donut
    };

    // Função para inicializar o mapa com marcadores
    e.prototype.initMaps = function() {
        new jsVectorMap({
            map: "world",  // Mapa do mundo
            selector: "#world-map-markers",  // Seleciona o elemento para o mapa
            zoomOnScroll: false,  // Desativa o zoom com scroll
            zoomButtons: true,  // Habilita botões de zoom
            markersSelectable: true,  // Permite seleção de marcadores
            hoverOpacity: 0.7,  // Opacidade ao passar o mouse
            hoverColor: false,  // Desativa mudança de cor ao passar o mouse
            regionStyle: {
                initial: {
                    fill: "rgba(145, 166, 189, 0.25)"  // Cor inicial das regiões
                }
            },
            markerStyle: {
                initial: {
                    r: 9,
                    fill: "#727cf5",  // Cor inicial dos marcadores
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
            backgroundColor: "transparent",  // Cor de fundo do mapa
            markers: [{ coords: [40.71, -74], name: "New York" },
                      { coords: [37.77, -122.41], name: "San Francisco" },
                      { coords: [-33.86, 151.2], name: "Sydney" },
                      { coords: [1.3, 103.8], name: "Singapore" }]  // Marcadores de localização
        });
    };

    // Função principal de inicialização
    e.prototype.init = function() {
        r("#dash-daterange").daterangepicker({ singleDatePicker: true });  // Configura o range de datas
        this.initCharts();  // Inicializa os gráficos
        this.initMaps();  // Inicializa o mapa
    };

    // Instância do Dashboard
    r.Dashboard = new e;
    r.Dashboard.Constructor = e;

})(window.jQuery);

// Quando o documento estiver pronto, inicializa o Dashboard
(function(t) {
    "use strict";
    t(document).ready(function(e) {
        t.Dashboard.init();  // Chama a função de inicialização
    });
})(window.jQuery);
