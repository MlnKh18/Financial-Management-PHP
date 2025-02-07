<?php
$pageTitle = "Register";
$pageStyle = "auth.css";
$pageScript = "auth.js";
require_once(__DIR__ . '../../includes/header-auth.php');
?>

<div class="c-auth">
    <h2>Register</h2>
    <div class="c-form-auth">
        <form id="registerForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Register</button>
            <a href="./login">
                <p class="link">Login Akun</p>
            </a>

        </form>
    </div>
</div>

</main>
</div>

<!-- Memuat JavaScript sesuai halaman -->
<?php if (isset($pageScript)) : ?>
    <script src="./assets/js/<?php echo $pageScript; ?>"></script>
<?php endif; ?>


<?php require_once(__DIR__ . '../../includes/footer.php'); ?>