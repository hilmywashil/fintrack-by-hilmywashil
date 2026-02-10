// deklarasikan global variable untuk chart utama
let mainChart;

$(function () {

  // =====================================
  // Profit (MAIN AREA CHART / GELombang)
  // =====================================
  var chartOptions = {
    series: [
      {
        name: "Pemasukan",
        data: window.chartIncome && window.chartIncome.length ? window.chartIncome : [0]
      },
      {
        name: "Pengeluaran",
        data: window.chartExpense && window.chartExpense.length ? window.chartExpense : [0]
      },
    ],

    chart: {
      type: "area", // line → area untuk efek gelombang berwarna
      height: 345,
      toolbar: { show: false },
      foreColor: "#adb0bb",
      fontFamily: 'inherit',
      zoom: { enabled: false },
    },

    colors: ["#5D87FF", "#49BEFF"],

    stroke: {
      curve: "smooth",
      width: 3,
    },

    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.3,
        opacityTo: 0.05,
        stops: [0, 90, 100]
      }
    },

    markers: {
      size: 4,
      hover: {
        size: 5
      }
    },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: true,
      position: 'top',
      horizontalAlign: 'center'
    },

    grid: {
      borderColor: "rgba(0,0,0,0.1)",
      strokeDashArray: 3,
    },

    xaxis: {
      type: "category",
      categories: window.chartDays && window.chartDays.length ? window.chartDays : ['No Data'],
      labels: {
        style: { cssClass: "grey--text lighten-2--text fill-color" },
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },

    yaxis: {
      min: 0,
      tickAmount: 4,
      labels: {
        formatter: function (value) {
          if (value >= 1000000) return (value / 1000000).toFixed(1) + " jt";
          if (value >= 1000) return (value / 1000).toFixed(0) + " rb";
          return value;
        },
        style: { cssClass: "grey--text lighten-2--text fill-color" },
      },
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
          stroke: { width: 2 },
          markers: { size: 3 },
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
        donut: { size: '75%' },
      },
    },
    stroke: { show: false },
    dataLabels: { enabled: false },
    legend: { show: false },
    colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],
    responsive: [
      { breakpoint: 991, options: { chart: { width: 150 } } },
    ],
    tooltip: { theme: "dark", fillSeriesColor: false },
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
      sparkline: { enabled: true },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [{ name: "Earnings", color: "#49BEFF", data: [25, 66, 20, 40, 12, 58, 20] }],
    stroke: { curve: "smooth", width: 2 },
    fill: { colors: ["#f3feff"], type: "solid", opacity: 0.05 },
    markers: { size: 0 },
    tooltip: { theme: "dark", fixed: { enabled: true, position: "right" }, x: { show: false } },
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
        xaxis: { categories: data.days },
        series: [
          { name: "Pemasukan", data: data.income },
          { name: "Pengeluaran", data: data.expense }
        ]
      });

    })
    .catch(err => console.error("Error fetching chart data:", err));
});
