<?php
$pageTitle = "Home Dashboard";
$pageStyle = "home.css";
$pageScript = "home.js";
require_once(__DIR__ . '../../includes/header.php');
?>

<div class="c-home-dashboard">
    <div class="bx-saldo">
        <h2>SALDO :</h2>
        <h2 id="saldo">$ 200.000</h2>
    </div>
    <div class="c-content-home-dashboard">
        <h2>Selamat datang</h2>
        <div class="section-container">
            <div class="section">
                <h3>Pemasukan</h3>
            </div>
            <div class="section">
                <h3>Pengeluaran</h3>
            </div>
        </div>

        <label for="filter-select">Filter Data:</label>
        <select id="filter-select">
            <option value="weekly">Per Minggu</option>
            <option value="monthly">Per Bulan</option>
            <option value="yearly">Per Tahun</option>
        </select>
        <div id="section-chart"></div>
    </div>
</div>

</main>
</div>

<!-- Memuat JavaScript sesuai halaman -->
<?php if (isset($pageScript)) : ?>
    <script src="./assets/js/<?php echo $pageScript; ?>"></script>
<?php endif; ?>

<?php require_once(__DIR__ . '../../includes/footer.php'); ?>