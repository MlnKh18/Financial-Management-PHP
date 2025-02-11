const port = "8080";
const baseUrl = `http://localhost:${port}/financial_management/`;

let currentPage = 1;
let totalPages = 1;

$(document).ready(function () {
  // Ambil data pertama kali
  getDataPemasukan(currentPage);

  // Tombol Next & Prev
  $("#next-button").click(function () {
    if (currentPage < totalPages) {
      currentPage++;
      getDataPemasukan(currentPage);
    }
  });

  $("#prev-button").click(function () {
    if (currentPage > 1) {
      currentPage--;
      getDataPemasukan(currentPage);
    }
  });

  // Submit Form Pemasukan
  $("#form-pemasukan").submit(function (e) {
    e.preventDefault();

    const idPegawai = JSON.parse(localStorage.getItem("user")).id;
    const jumlahPemasukan = $("#jumlah-pemasukan").val().trim();
    const deskripsiPemasukan = $("#descriptions-pemasukan").val().trim();

    if (!jumlahPemasukan || !deskripsiPemasukan) {
      alert("Semua field harus diisi!");
      return;
    }

    const data = JSON.stringify({
      id_pegawai: idPegawai,
      total_transaksi: jumlahPemasukan,
      deskripsi: deskripsiPemasukan,
    });

    addDataPemasukan(data);
  });
});

function addDataPemasukan(data) {
  $.ajax({
    url: `${baseUrl}backend/addPemasukan`,
    type: "POST",
    contentType: "application/json",
    data: data,
    beforeSend: function () {
      $("#submit").prop("disabled", true).text("Processing...");
    },
    success: function (response) {
      $("#submit").prop("disabled", false).text("Submit");

      if (response.status === "ok") {
        alert("Pemasukan berhasil ditambahkan!");
        $("#form-pemasukan")[0].reset();
        getDataPemasukan(1);
      } else {
        alert("Pemasukan gagal ditambahkan, coba lagi!");
      }
    },
    error: function (xhr, status, error) {
      alert("Terjadi kesalahan, coba lagi nanti.");
      console.error(error);
      $("#submit").prop("disabled", false).text("Submit");
    },
  });
}

function getDataPemasukan(halaman = 1) {
  $.ajax({
    url: `${baseUrl}backend/pemasukan-GetAllDataLogsSaldo?halaman=${halaman}`,
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $("#pemasukanTable tbody").html(
        '<tr><td colspan="5">Loading data...</td></tr>'
      );
    },
    success: function (response) {
      if (response.status === "ok") {
        const tableBody = $("#pemasukanTable tbody");
        tableBody.empty();

        if (response.data && Array.isArray(response.data)) {
          response.data.forEach((item, index) => {
            const newRow = `
              <tr id="${item.id_log}">
                <td>${index + 1}</td>
                <td>${formatRupiah(item.jumlah_saldo_sebelumnya)}</td>
                <td>${formatRupiah(item.perubahan)}</td>
                <td>${formatRupiah(item.jumlah_saldo_setelah)}</td>
                <td>${formatDate(item.created_at)}</td>
              </tr>
            `;
            tableBody.append(newRow);
          });

          let saldoLocal = localStorage.getItem("saldo");
          if (saldoLocal) {
            $("#saldo").text(formatRupiah(saldoLocal));
          }
          totalPages =
            response.data.length || Math.ceil(response.data.length / 10);

          updatePaginationInfo(response.data.length, halaman);
          togglePaginationButtons();
        } else {
          tableBody.html(
            '<tr><td colspan="5">Tidak ada data pemasukan.</td></tr>'
          );
        }
      } else {
        console.error("Gagal mendapatkan saldo:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error saat mengambil data saldo:", error);
      $("#pemasukanTable tbody").html(
        '<tr><td colspan="5">Gagal mengambil data.</td></tr>'
      );
    },
  });
}

function togglePaginationButtons() {
  $("#prev-button").prop("disabled", currentPage === 1);
  $("#next-button").prop("disabled", currentPage === totalPages);
}

function updatePaginationInfo(totalEntries, halaman) {
  const perPage = 10; // Sesuaikan dengan jumlah data per halaman dari backend
  const start = (halaman - 1) * perPage + 1;
  const end = Math.min(start + perPage - 1, totalEntries);
  $(".amount-of-list-table p").text(
    `Showing ${start} to ${end} of ${totalEntries} entries`
  );
}

function formatRupiah(angka) {
  return parseInt(angka).toLocaleString("id-ID", {
    style: "currency",
    currency: "IDR",
  });
}

function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" };
  const date = new Date(dateString);
  return date.toLocaleDateString("id-ID", options);
}
