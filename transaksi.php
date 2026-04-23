<?php
require_once 'api_config.php';
requireLogin();

// Ambil data transaksi dari API
$result = callAPI('GET', '/transaksi');
$transaksis = $result['response'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Penjualan App</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="kategori.php">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="produk.php">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
                    <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Transaksi</h2>
            <a href="transaksi_create.php" class="btn btn-success">Buat Transaksi Baru</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transaksis)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data transaksi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transaksis as $t): ?>
                            <tr>
                                <td>#<?= $t['id'] ?></td>
                                <td><?= htmlspecialchars($t['pelanggan_nama'] ?? 'Umum') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($t['tanggal'])) ?></td>
                                <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-info text-dark"><?= strtoupper($t['metode_pembayaran']) ?></span></td>
                                <td>
                                    <?php if ($t['status_pembayaran'] === 'lunas'): ?>
                                        <span class="badge bg-success">Lunas</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum Lunas</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="transaksi_detail.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>