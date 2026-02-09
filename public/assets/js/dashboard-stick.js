// deklarasikan global variable untuk chart utama
let mainChart;

$(function () {

  // =====================================
  // Profit (MAIN BAR CHART)
  // =====================================
  var chartOptions = {
    series: [
      {
        name: "Income",
        data: window.chartIncome && window.chartIncome.length ? window.chartIncome : [0]
      },
      {
        name: "Expense",
        data: window.chartExpense && window.chartExpense.length ? window.chartExpense : [0]
      },
    ],

    chart: {
      type: "bar",
      height: 345,
      offsetX: -15,
      toolbar: { show: true },
      foreColor: "#adb0bb",
      fontFamily: 'inherit',
      sparkline: { enabled: false },
    },

    colors: ["#5D87FF", "#49BEFF"],

    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "35%",
        borderRadius: 0
      },
    },

    markers: { size: 0 },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
    },

    grid: {
      borderColor: "rgba(0,0,0,0.1)",
      strokeDashArray: 3,
      xaxis: {
        lines: {
          show: false,
        },
      },
    },

    xaxis: {
      type: "category",
      categories: window.chartDays && window.chartDays.length ? window.chartDays : ['No Data'],
      labels: {
        style: { cssClass: "grey--text lighten-2--text fill-color" },
      },
    },

    yaxis: {
      show: true,
      min: 0,
      labels: {
        formatter: function (value) {
          return "Rp " + value.toLocaleString("id-ID");
        },
        style: {
          cssClass: "grey--text lighten-2--text fill-color",
        },
      },
    },

    stroke: {
      show: true,
      width: 3,
      lineCap: "butt",
      colors: ["transparent"],
    },

    tooltip: {
      theme: "light",
      y: {
        formatter: function (value) {
          return "Rp " + value.toLocaleString("id-ID");
        }
      }
    },

    responsive: [
      {
        breakpoint: 600,
        options: {
          plotOptions: {
            bar: {
              borderRadius: 3,
            }
          },
        }
      }
    ]
  };

  // inisialisasi chart utama
  mainChart = new ApexCharts(document.querySelector("#chart"), chartOptions);
  mainChart.render();


  // =====================================
  // Breakup (DONUT CHART)
  // =====================================
  var breakup = {
    color: "#adb5bd",
    series: [38, 40, 25],
    labels: ["2022", "2021", "2020"],
    chart: {
      width: 180,
      type: "donut",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '75%',
        },
      },
    },
    stroke: {
      show: false,
    },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
    },

    colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],

    responsive: [
      {
        breakpoint: 991,
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],

    tooltip: {
      theme: "dark",
      fillSeriesColor: false,
    },
  };

  var breakupChart = new ApexCharts(document.querySelector("#breakup"), breakup);
  breakupChart.render();


  // =====================================
  // Earning (SPARKLINE)
  // =====================================
  var earning = {
    chart: {
      id: "sparkline3",
      type: "area",
      height: 60,
      sparkline: {
        enabled: true,
      },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [
      {
        name: "Earnings",
        color: "#49BEFF",
        data: [25, 66, 20, 40, 12, 58, 20],
      },
    ],
    stroke: {
      curve: "smooth",
      width: 2,
    },
    fill: {
      colors: ["#f3feff"],
      type: "solid",
      opacity: 0.05,
    },

    markers: {
      size: 0,
    },

    tooltip: {
      theme: "dark",
      fixed: {
        enabled: true,
        position: "right",
      },
      x: {
        show: false,
      },
    },
  };

  new ApexCharts(document.querySelector("#earning"), earning).render();

});


// =====================================
// EVENT FILTER PERIODE
// =====================================
document.getElementById("periodFilter").addEventListener("change", function () {
  let period = this.value;

  fetch(`/chart-data?period=${period}`)
    .then(res => res.json())
    .then(data => {

      if (!mainChart) {
        console.error("Main chart not initialized");
        return;
      }

      mainChart.updateOptions({
        xaxis: {
          categories: data.days
        },
        series: [
          { name: "Income", data: data.income },
          { name: "Expense", data: data.expense }
        ]
      });

    })
    .catch(err => console.error("Error fetching chart data:", err));
});
