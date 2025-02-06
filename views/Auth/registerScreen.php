<?php
$pageTitle = "Register";
$pageScript = "auth.js";  // Menunjuk ke file JS khusus untuk register
require_once(__DIR__ . '../../includes/header.php');
?>

<h2>Register</h2>
<form id="registerForm">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

<?php if (isset($pageScript)) : ?>
    <script src="./assets/js/<?php echo $pageScript; ?>"></script> <!-- Pastikan path benar -->
<?php endif; ?>

<?php require_once(__DIR__ . '../../includes/footer.php'); ?>