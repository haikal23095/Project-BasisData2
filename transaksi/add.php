<?php
$title = "Tambah Detail Transaksi";
$page = "transaksi";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");
if ($level=='owner'&& $title==='Tambah Detail Transaksi'){
    header("location: index.php");
}

// ketika pertama kali masuk tambah detail transaksi
if (isset($_GET["pelanggan"])) {
    $arrPelanggan = explode('#', $_GET["pelanggan"]);
    $IDPelanggan = $arrPelanggan[0]; 
    $namaPelanggan = $arrPelanggan[1];
    $transaksiID = insertTransaksi1_getLastID($IDPelanggan);
    header("location: add.php?IDPelanggan=$IDPelanggan&namaPelanggan=$namaPelanggan&transaksiID=$transaksiID");
}

// setelah transaksi ditambahkan, dan untuk memulai tambah detail transaksi
if (isset($_GET['IDPelanggan'])){
    $IDPelanggan = ($_GET['IDPelanggan']);
    $transaksiID = ($_GET['transaksiID']);
    $namaPelanggan = ($_GET['namaPelanggan']);
}

if (isset($_GET['transaksiID'])){
    $listBarangYgBoleh = getBarangNotYetByTransaksiID($_GET['transaksiID']);
}
if (isset($_POST['submitTransaksi'])){
    $errors = [
        'waktuTransaksi'=>'',
        'keterangan'=>''
    ];
    $waktuTransaksi = $_POST['waktuTransaksi'];
    $keterangan = $_POST['keterangan'];
    $transaksiID = $_POST['transaksiID']; 
    

    validateWaktuTransaksi($waktuTransaksi, $errors['waktuTransaksi']);
    validateKeteranganTransaksi($keterangan, $errors['keterangan']);

    if(empty($errors['keterangan']) && empty($errors['waktuTransaksi'])){
        $data=[
            'waktuTransaksi'=>$waktuTransaksi,
            'keterangan'=>$keterangan,
            'id'=>$transaksiID
        ];
        if(insertTransaksi2($data)){
            echo "<script>
            window.location.href='add.php?IDPelanggan=$IDPelanggan&namaPelanggan=$namaPelanggan&transaksiID=$transaksiID&doneInsert2=true'
            </script>";
        }
    }
}

?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3>ID Transaksi : <?php echo (isset($_GET['IDPelanggan'])) ? $transaksiID : ''; ?> </h3>
        <h3>Pelanggan atas nama: <?php echo (isset($_GET['IDPelanggan'])) ? $namaPelanggan : ''; ?></h3>
    </div>
    
    <!-- Tombol untuk menambah barang dan menyimpan detailTransaksi -->
    <a href="index.php"><button type="button" class="btn btn-primary mb-3">Selesai dan kembali</button></a>
    
    <form action="" method="POST" id="formDetailTransaksi">
        <?php if (isset($_GET['doneInsert2'])):
            $dataTransaksiByID = getDataTransaksiByID($transaksiID);
            ?>
            <div class='p-3 mb-2 bg-success-subtle text-success-emphasis'>
                --- Data Transaksi berikut Berhasil disimpan --- <br>
                <b>Waktu Transaksi: </b><?= $dataTransaksiByID['waktuTransaksi'] ?><br>
                <b>Keterangan: </b><?= $dataTransaksiByID['keterangan'] ?>
            </div>
        <?php else:?>
            <div class="mb-3">
                <label for="waktuTransaksi" class="form-label fw-bold">Waktu Transaksi</label>
                <input type="date" class="form-control" id="waktuTransaksi" name="waktuTransaksi" value="<?php if(isset($_POST['submitTransaksi']) && isset($_POST['waktuTransaksi']) ){echo $_POST['waktuTransaksi'];}elseif(!isset($_POST['waktuTransaksi'])){echo date('Y-m-d');} ?>">
            </div>
            <?php if (isset($_POST['submitTransaksi'])) {echo (!empty($errors['waktuTransaksi'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['waktuTransaksi'].'</div><br>' : ''; } ?>

            <div class="mb-3">
                <label for="keterangan" class="form-label fw-bold">keterangan</label>
                <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" rows="3"><?php if(isset($_POST['submitTransaksi']) && isset($_POST['keterangan']) ){echo $_POST['keterangan'];} ?></textarea>
            </div>
            <?php if (isset($_POST['submitTransaksi'])) {echo (!empty($errors['keterangan'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['keterangan'].'</div><br>' : ''; } ?>

            <button type="submit" name="submitTransaksi" class="btn btn-success">Simpan</button><br><br>
        <?php endif?>
        

        <input type="hidden" name="transaksiID" value="<?php echo (isset($_GET['transaksiID'])) ? $_GET['transaksiID'] : ''; ?>">
        <input type="hidden" name="namaPelanggan" value="<?php echo (isset($_GET['namaPelanggan'])) ? $_GET['namaPelanggan'] : ''; ?>">
        <input type="hidden" name="IDPelanggan" value="<?php echo (isset($_GET['IDPelanggan'])) ? $_GET['IDPelanggan'] : ''; ?>">

        <!-- <div class="mb-3">
            <label for="semester" class="form-label fw-bold">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div> -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tabelDetailTransaksi">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang | Harga</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody id="detailTransaksiBody">
                    <tr class="detailTransaksi-row">
                        <td>
                            <select class="form-select" name="id_harga_barang" aria-label="Pilih Barang" onchange="updateTotalHarga()">
                                <option value="" disabled selected>Pilih Barang</option>
                                <?php foreach ($listBarangYgBoleh as $barang) :?>
                                    <option value="<?=$barang["id"]?>#<?=$barang['harga']?>" data-harga="<?=$barang['harga']?>" > <?= $barang["nama"] ?> | Rp. <?= $barang['harga'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="1" class="form-control" name="qty" onkeyup="updateTotalHarga()">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <strong>Total Harga:</strong> <span id="totalHarga">0</span>
                <input type="hidden" value="" id="totalHargaPost" name="totalHarga">
            </div>
            <div>
                <button type="submit" class="btn btn-success mb-3" name="newBrg">Tambahkan</button>
            </div>
        </div>
    </form>

    <?php 
    if (isset($_POST["newBrg"]) && isset($_POST['transaksiID'])) {
        $data = [
            "id_harga_barang" => $_POST["id_harga_barang"],
            "qty" => $_POST["qty"],
            // "keterangan" => $_POST["keterangan"],
            "transaksiID"=>$_POST['transaksiID']
        ];

        $transaksiID = $_GET['transaksiID'];
        $namaPelanggan = $_GET['namaPelanggan'];
        $IDPelanggan = $_GET['IDPelanggan'];

        if (!insertDetailTransaksi($data)){
            echo "<script>
                alert('Transaksi detail gagal disimpan');
                window.location.href = 'add.php';
            </script>";
        }else {
            
            // Menghapus data post. jadi di lempar lagi ke link seperti berikut ini (link waktu new brg (form yg atas) belum disubmit)
            if (isset($_GET['doneInsert2'])){
                echo "<script>
                    window.location.href='add.php?IDPelanggan=$IDPelanggan&namaPelanggan=$namaPelanggan&transaksiID=$transaksiID&doneInsert2=true'
                    </script>";
            }else{
                echo "<script>
                    window.location.href = 'add.php?IDPelanggan=$IDPelanggan&namaPelanggan=$namaPelanggan&transaksiID=$transaksiID&total=';
                    </script>";
            }
        }
    }
    ?>
    <!-- MENAMPILKAN DETAIL TRANSAKSI SESUAI TRANSAKSI INI -->
    <?php if (isset($_GET['transaksiID'])): ?>
        <?php
        $transaksiID = $_GET['transaksiID'];
        $detailTransaksiByIDTransaksi = getDataDetailTransaksiByIDTransaksi($transaksiID);
        // JIKA ADA BARISNYA(!empty), ARTINYA TRANSAKSI INI SUDAH PERNAH DITAMBAHKAN maka dari itu fungsi di database.php mengembalikan minimal 1 baris jika ada
        if (!empty($detailTransaksiByIDTransaksi)):
        ?>
            <div class='p-3 mb-2 bg-success-subtle text-success-emphasis'> --- Berhasil Ditambahkan --- </div>
            <table class="table table-hover table-bordered">
                <tr><thead><th>Nama Barang</th><th>Harga Satuan</th><th>Qty</th><th>Harga Total</th></thead></tr>
            <?php $total_semua = 0;foreach ($detailTransaksiByIDTransaksi as $row): 
                $harga_satuan = $row['harga'];
                $harga_total = $row['harga_total'];
                $qty = $row['qty'];
                $nama_barang = $row['nama'];
                ?>
                <tr>
                    <td><?=$nama_barang?></td>
                    <td><?=$harga_satuan?></td>
                    <td><?=$qty?></td>
                    <td><?=$harga_total?></td>
                </tr>
            <?php endforeach?>
            </table>
        <?php endif?>
    <?php endif?>
</div>

<script>
    function updateTotalHarga() {
        let totalHarga = 0;
        $('')
        $('select[name="id_harga_barang"]').each(function() {
            let selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                let qtyInput = $(this).closest('.detailTransaksi-row').find('input[name="qty"]');
                if (qtyInput.val()){
                totalHarga += (parseInt(selectedOption.data('harga')))*(parseFloat(qtyInput.val()));
                }
            }
        });
        $('#totalHarga').text(totalHarga);
        $('#totalHargaPost').val(totalHarga);
    }
</script>

<?php
include_once("../layout/footer.php");
