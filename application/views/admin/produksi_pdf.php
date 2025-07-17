<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Produksi</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2, h4 { text-align: center; margin: 0; padding: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background-color: #f2f2f2; }
    ul { padding-left: 15px; margin: 0; }
    .footer { text-align: right; margin-top: 30px; font-size: 11px; }
  </style>
</head>
<body>

  <h2>KENARI BAKERY</h2>
  <h4>Laporan Produksi Pesanan</h4>
  <?php if (!empty($start) && !empty($end)): ?>
    <p style="text-align:center;">Periode: <?= date('d M Y', strtotime($start)) ?> - <?= date('d M Y', strtotime($end)) ?></p>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th style="width:10%;">ID</th>
        <th style="width:25%;">Nama Pemesan</th>
        <th style="width:65%;">Detail Produk</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($pesanan)): ?>
        <?php foreach ($pesanan as $p): ?>
          <tr>
            <td><?= $p->id_pesanan ?></td>
            <td><?= $p->nama_pemesan ?></td>
            <td>
              <?php if (!empty($p->detail_produk)): ?>
                <ul>
                  <?php foreach ($p->detail_produk as $item): ?>
                    <li><?= $item->nama_produk ?> - <?= $item->jumlah ?> pcs</li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <em>Tidak ada produk</em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="3" style="text-align:center;">Tidak ada data</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <p class="footer">Dicetak pada: <?= date('d-m-Y H:i') ?></p>

</body>
</html>
