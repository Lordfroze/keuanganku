// Cegah error kalau chart atau data gak ada
if (
    typeof window.monthlyIncome !== "undefined" &&
    document.querySelector("#chart-income")
) {
    var optionsProfileVisit = {
        chart: {
            type: "bar",
            height: 300,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false,
        },
        series: [
            {
                name: "Pendapatan",
                data: window.monthlyIncome,
            },
        ],
        colors: ["#435ebe"],
        xaxis: {
            categories: [
                "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
            ],
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return "Rp " + val.toLocaleString("id-ID");
                }
            }
        }
    };

    var chart = new ApexCharts(
        document.querySelector("#chart-income"),
        optionsProfileVisit
    );

    chart.render();
}
