<?php
$pageTitle = "Login";
$pageStyle = "auth.css";
$pageScript = "auth.js";
require_once(__DIR__ . '../../includes/header-auth.php');
?>

<div class="c-auth">
    <h2>Login</h2>
    <div class="c-form-auth">
        <form id="loginForm">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
            <a href="./register">
                <p class="link">Register Akun</p>
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