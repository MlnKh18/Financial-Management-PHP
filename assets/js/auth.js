const port = "8080";
const baseUrl = `http://localhost:${port}/financial_management/`;

$(document).ready(function () {
  // Login Form Handler
  $("#loginForm").submit(function (e) {
    e.preventDefault(); // Mencegah reload halaman
    let email = $("#email").val().trim();
    let password = $("#password").val().trim();

    if (!email || !password) {
      alert("Email dan password harus diisi!");
      return;
    }
    console.info(email, password);

    // Menyusun data dalam format JSON
    let data = JSON.stringify({ email: email, password: password });

    $.ajax({
      url: `${baseUrl}backend/login`,
      type: "POST",
      contentType: "application/json", // Menetapkan content type sebagai JSON
      data: data, // Mengirimkan data dalam format JSON
      success: function (response) {
        console.log(response);
        if (response.status === "ok") {
          alert("Login berhasil!");
          localStorage.setItem("user", JSON.stringify(response.user));
          window.location.href = "./home"
        } else {
          alert("Login gagal, email atau password salah!");
        }
      },
      error: function (xhr, status, error) {
        alert("Login gagal, coba lagi!");
        console.error(error);
      },
    });
  });

  // Register Form Handler
  $("#registerForm").submit(function (e) {
    e.preventDefault(); // Mencegah reload halaman

    let username = $("#username").val().trim();
    let email = $("#email").val().trim();
    let password = $("#password").val().trim();

    if (!username || !email || !password) {
      alert("Semua field harus diisi!");
      return;
    }

    // Menyusun data untuk registrasi dalam format JSON
    let data = JSON.stringify({
      username: username,
      email: email,
      password: password,
    });

    $.ajax({
      url: `${baseUrl}backend/register`, // Sesuaikan dengan URL backend yang benar
      type: "POST",
      contentType: "application/json", // Menetapkan content type sebagai JSON
      data: data, // Mengirim data dalam format JSON
      success: function (response) {
        console.log(response);
        if (response.status === "ok") {
          alert("Registrasi berhasil!");
          window.location.href = "./login"; // Pindahkan ke halaman login setelah berhasil registrasi
        } else {
          alert("Registrasi gagal, coba lagi!");
        }
      },
      error: function () {
        alert("Registrasi gagal, coba lagi!");
      },
    });
  });
});
