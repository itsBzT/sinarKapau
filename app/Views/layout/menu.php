<?= $this->extend('layout/main') ?>

<?= $this->section('menu') ?>
<li class="nav-header">Tambah Data</li>
<li class="nav-item">
    <a href="<?= site_url('kategori/index') ?>" class="nav-link">
        <i class="nav-icon fa fa-tasks"></i>
        <p>
            Kategori
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('satuan/index') ?>" class="nav-link">
        <i class="nav-icon fa fa-tasks"></i>
        <p>
            Satuan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('produk/index') ?>" class="nav-link">
        <i class="nav-icon fa fa-table"></i>
        <p>
            Produk
        </p>
    </a>
</li>
<li class="nav-header">Transaksi</li>
<li class="nav-item">
    <a href="<?= site_url('penjualan/index') ?>" class="nav-link">
        <i class="nav-icon fa fa-tasks"></i>
        <p>
            Penjualan
        </p>
    </a>
</li>
<?= $this->endSection(); ?>