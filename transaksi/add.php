<?php
$jenis = $_GET['jenis'] ?? 'keluar'; // default keluar
$isMasuk = $jenis === 'masuk';
$title = $isMasuk ? 'Tambah Transaksi Masuk' : 'Tambah Transaksi Keluar';
$page = "transaksi";
include_once "../layout/header.php";

// Ambil data relasi sesuai jenis
$relasiList = $isMasuk ? getAllSuppliers() : getAllCustomers();
$x = $isMasuk ? "supplier":"customer";
$barangs = getAllBarang();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tanggal            = trim($_POST['tanggal'] ?? '');
    $idX        = $_POST['idX'] ?? '';
    $metode_pembayaran  = $_POST['metode_pembayaran'] ?? '';
    $id_user            = $_SESSION['user']['id'] ?? null;
    $items              = $_POST['items'] ?? [];

    $errors = [];

    // Validasi dasar
    if (!$tanggal) $errors[] = "Tanggal wajib diisi";
    if (!$idX) $errors[] = "Customer wajib dipilih";
    if (empty($items)) $errors[] = "Minimal satu barang harus ditambahkan";

    foreach ($items as $index => $item) {
        if (empty($item['id_barang']) || empty($item['jumlah']) || empty($item['harga'])) {
            $errors[] = "Item ke-".($index+1)." tidak lengkap";
        }
    }
    // Jika tidak ada error, lakukan insert
    if (empty($errors)) {
        $data = [
            'tanggal' => $tanggal,
            'idX' => $idX,
            'metode_pembayaran' => $metode_pembayaran,
            'id_user' => $id_user,
            'items' => $items
        ];

        $id_transaksi = insertTransaksi($data, $jenis);
        if ($id_transaksi) {
            header("Location: " . BASEURL . "/transaksi/read_$jenis.php?id=$id_transaksi");
            exit;
        } else {
            $errors[] = "Gagal menyimpan transaksi ke database.";
        }
    }
}

?>

<div class="container my-4">
    <h3><?= $title ?></h3>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?= implode("<br>", $errors) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?= $x ?></label>
            <select name="idX" class="form-select">
                <option value="">-- Pilih --</option>
                <?php foreach ($relasiList as $row): ?>
                    <option value="<?= $row["id_$x"] ?>"> <?= $row["nama_$x"] ?> </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select">
                <option value="Cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        <h5>Detail Barang</h5>
        <table class="table table-bordered" id="itemTable">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th><button type="button" class="btn btn-sm btn-primary" onclick="addRow()">+</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][id_barang]" class="form-select" onchange="loadHarga(this)">
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($barangs as $barang): ?>
                                <option value="<?= $barang['id_barang'] ?>"><?= $barang['nama_barang'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][jumlah]" class="form-control" value="1">
                    </td>
                    <td>
                        <input type="number" name="items[0][harga]" class="form-control" step="100">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">-</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    </form>
</div>

<script>
    let rowIndex = 1;
    function addRow() {
        const table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        Array.from(newRow.querySelectorAll('input, select')).forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\d+/, rowIndex);
                input.setAttribute('name', newName);
                input.value = (input.tagName === 'INPUT') ? '' : input.value;
            }
        });
        table.appendChild(newRow);
        rowIndex++;
    }

    function removeRow(button) {
        const row = button.closest('tr');
        const table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
        if (table.rows.length > 1) row.remove();
    }

    function isDuplicateBarang(selectedValue, currentSelect) {
        const allSelects = document.querySelectorAll('select[name$="[id_barang]"]');
        let count = 0;
        allSelects.forEach(select => {
            if (select.value === selectedValue) {
                if (select !== currentSelect) count++;
            }
        });
        return count > 0;
    }

    function loadHarga(selectElement) {
        const idBarang = selectElement.value;
        if (!idBarang) return;

        if (isDuplicateBarang(idBarang, selectElement)) {
            alert("Barang ini sudah ditambahkan sebelumnya!");
            selectElement.value = ''; // Reset selection
            return;
        }

        const row = selectElement.closest('tr');
        const hargaInput = row.querySelector('input[name$="[harga]"]');

        fetch('get_harga.php?id_barang=' + idBarang)
            .then(response => response.json())
            .then(data => {
                if (data && data.harga_jual) {
                    hargaInput.value = data.harga_jual;
                }
            })
            .catch(error => {
                console.error('Gagal ambil harga:', error);
            });
    }

</script>

<?php include_once("../layout/footer.php"); ?>
