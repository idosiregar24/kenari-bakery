<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h3 { text-align: center; margin-bottom: 5px; }
    .periode { text-align: center; margin-bottom: 20px; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; }
    tfoot td { font-weight: bold; background-color: #f2f2f2; }
  </style>
</head>
<body>

  <h3>Laporan Penjualan - Kenari Bakery</h3>
  <div class="periode">
    Periode: <?= htmlspecialchars($this->input->get('start')) ?> s/d <?= htmlspecialchars($this->input->get('end')) ?>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>ID Pesanan</th>
        <th>Nama Pemesan</th>
        <th>Tanggal Pesanan</th>
        <th>Total Pembayaran</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $no = 1;
        $grand_total = 0;

        if (!empty($pesanan)) :
          foreach ($pesanan as $inv) :
            $total = 0;
            foreach ($inv->detail_produk as $d) {
              $total += $d->subtotal;
            }
            $grand_total += $total;
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($inv->id_pesanan) ?></td>
        <td><?= htmlspecialchars($inv->nama_pemesan) ?></td>
        <td><?= htmlspecialchars($inv->tanggal_pesanan) ?></td>
        <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
      </tr>
      <?php 
          endforeach;
        else: 
      ?>
      <tr>
        <td colspan="5">Tidak ada data pesanan pada periode ini.</td>
      </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4">Total Keseluruhan</td>
        <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
      </tr>
    </tfoot>
  </table>

</body>
</html>
