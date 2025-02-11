<?php
$pageTitle = "Pemasukan";
$pageStyle = "pemasukan.css";
$pageScript = "pemasukan.js";
require_once(__DIR__ . '../../includes/header.php');
?>

<div class="c-pemasukan">
    <div class="bx-saldo">
        <h2>SALDO :</h2>
        <h2 id="saldo">$ 200.000</h2>
    </div>
    <div class="c-content-pemasukan">
        <h2>Pemasukan</h2>
        <div class="section-pemasukan">
            <table id="pemasukanTable">
                <thead>
                    <tr id="header-table">
                        <th colspan="5" style="text-align: center;">Table Pemasukan</th>
                    </tr>
                    <tr>
                        <th id="filter-bulanan" colspan="2" style="text-align: center;">Filter Bulanan</th>
                        <th id="filter-tahunan" colspan="3" style="text-align: center;">Filter Tahunan</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Saldo Sebelumnya</th>
                        <th>Perubahan</th>
                        <th>Saldo Akhir</th>
                        <th>Tanggal Perubahan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <form action="#" id="form-pemasukan">
                <label for="jumlah-pemasukan">Pemasukan</label>
                <input type="number" min="0.00" name="jumlah-pemasukan" id="jumlah-pemasukan">
                <label for="descriptions-pemasukan">Deskripsi</label>
                <input type="text" name="descriptions-pemasukan" id="descriptions-pemasukan">
                <button type="submit" id="submit">Submit</button>
            </form>
        </div>
        <div class="amount-of-list-table">
            <div class="button-of-amount">
                <button id="prev-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                    </svg>
                </button>
                <button id="next-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                    </svg>
                </button>

            </div>
            <p>Showing 1 to 10 of 57 entries</p>
        </div>

    </div>
</div>

</main>
</div>

<!-- Memuat JavaScript sesuai halaman -->
<?php if (isset($pageScript)) : ?>
    <script src="./assets/js/<?php echo $pageScript; ?>"></script>
<?php endif; ?>

<?php require_once(__DIR__ . '../../includes/footer.php'); ?>