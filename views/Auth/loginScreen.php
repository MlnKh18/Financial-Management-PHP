<?php
$pageTitle = "Login";
$pageScript = "auth.js";  // Menunjuk ke file JS khusus untuk login
require_once(__DIR__ . '../../includes/header.php');
?>

<h2>Login</h2>

<!-- Form login dengan method POST yang dikelola dengan AJAX -->
<form id="loginForm">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<!-- Memuat JavaScript sesuai halaman -->
<?php if (isset($pageScript)) : ?>
    <script src="./assets/js/<?php echo $pageScript; ?>"></script> <!-- Pastikan path benar -->
<?php endif; ?>

<?php require_once(__DIR__ . '../../includes/footer.php'); ?>
