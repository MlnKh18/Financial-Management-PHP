const port = "8080";
const baseUrl = `http://localhost:${port}/financial_management/`;

$(document).ready(function () {
  let saldoLocal = localStorage.getItem("saldo");
  if (saldoLocal) {
    $("#saldo").text(formatRupiah(saldoLocal));
  }

  fetchSaldo();
  fetchLogsSaldo();

  $("#filter-select").change(function () {
    console.info(this.value);
    fetchLogsSaldo($(this).value);
  });

  document.querySelectorAll(".section").forEach((section) => {
    section.addEventListener("click", function () {
      const sectionName = this.textContent.replace(/\s+/g, "");
      if (sectionName === "Pemasukan") {
        console.log(sectionName);
        window.location.href = `./pemasukan`;
      } else if (sectionName === "Pengeluaran") {
        console.log(sectionName);
        window.location.href = `./pengeluaran`;
      }
    });
  });
});

function fetchSaldo() {
  $.ajax({
    url: `${baseUrl}backend/home-GetSaldo`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.status === "ok" && response.data?.saldo !== undefined) {
        let saldo = response.data.saldo;
        localStorage.setItem("saldo", saldo);
        $("#saldo").text(formatRupiah(saldo));
      } else {
        console.error("Gagal mendapatkan saldo:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error saat mengambil data saldo:", error);
    },
  });
}

function fetchLogsSaldo(filter = "all") {
  $.ajax({
    url: `${baseUrl}backend/home-GetAllLogsSaldo`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.status === "ok" && response.data.length > 0) {
        let logs = filterData(response.data, filter);
        renderChart(logs);
      } else {
        console.error("Gagal mendapatkan log saldo:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error saat mengambil data log saldo:", error);
    },
  });
}

function filterData(data, filter) {
  let now = new Date();
  return data.filter((log) => {
    let logDate = new Date(log.created_at);
    switch (filter) {
      case "week":
        let weekAgo = new Date();
        weekAgo.setDate(now.getDate() - 7);
        return logDate >= weekAgo;
      case "month":
        let monthAgo = new Date();
        monthAgo.setMonth(now.getMonth() - 1);
        return logDate >= monthAgo;
      case "year":
        let yearAgo = new Date();
        yearAgo.setFullYear(now.getFullYear() - 1);
        return logDate >= yearAgo;
      default:
        return true;
    }
  });
}

function renderChart(logs) {
  let categories = logs.map((log) => log.created_at);
  let perubahanSaldo = logs.map((log) => parseFloat(log.perubahan));
  let saldoSetelah = logs.map((log) => parseFloat(log.jumlah_saldo_setelah));

  Highcharts.chart("section-chart", {
    chart: { type: "column" },

    title: { text: "Grafik Perubahan Saldo" },
    xAxis: { categories: categories, title: { text: "Tanggal" } },
    yAxis: {
      min: 0,
      title: { text: "Jumlah Saldo (IDR)" },
      stackLabels: { enabled: true },
      tooltip: { valueSuffix: " IDR" },
    },
    legend: {
      align: "right",
      x: -30,
      verticalAlign: "top",
      y: 25,
      floating: true,
      backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
      borderColor: "#CCC",
      borderWidth: 1,
      shadow: false,
    },
    tooltip: { valueSuffix: " IDR", shared: true },
    series: [
      { name: "Perubahan Saldo", data: perubahanSaldo },
      { name: "Saldo Setelah Perubahan", data: saldoSetelah },
    ],
  });
}

function formatRupiah(angka) {
  return parseInt(angka).toLocaleString("id-ID", {
    style: "currency",
    currency: "IDR",
  });
}
