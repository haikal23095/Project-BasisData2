<?php
include_once 'database.php';
require_once 'libs/fpdf/fpdf.php';



// Ambil data berdasarkan rentang tanggal tertentu
$start = $_GET['start']; // Anda bisa mengganti nilai defaultnya
$end = $_GET['end'];
$getTransaksiSummaryByDateRange = getTransaksiSummaryByDateRange($start, $end);

$transaksiData = $getTransaksiSummaryByDateRange['transaksiData'];
$totalSemuaHarga = $getTransaksiSummaryByDateRange['totalSemuaHarga'];
$jumlahPelanggan = $getTransaksiSummaryByDateRange['jumlah_pelanggan'];

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Laporan Penjualan', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Rentang Tanggal: ' . $_GET['start'] . ' s/d ' . $_GET['end'], 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Inisiasi PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Tabel Data Penjualan
$pdf->Cell(0, 10, 'Rekap Laporan Penjualan', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(60, 10, 'Total Harga Harian (Rp)', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);

foreach ($transaksiData as $transaksi) {
    $pdf->Cell(40, 10, $transaksi['waktuTransaksi'], 1, 0, 'C');
    $pdf->Cell(60, 10, number_format($transaksi['total_harian']), 1, 1, 'R');
}

// Rekap Total
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 10, 'Jumlah Pelanggan', 1, 0, 'L');
$pdf->Cell(40, 10, $jumlahPelanggan . ' Orang', 1, 1, 'R');
$pdf->Cell(80, 10, 'Jumlah Total Harga', 1, 0, 'L');
$pdf->Cell(40, 10, 'Rp ' . number_format($totalSemuaHarga), 1, 1, 'R');

// Output PDF
$pdf->Output('D', 'laporan_penjualan.pdf');
?>
