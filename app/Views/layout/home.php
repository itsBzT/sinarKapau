<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3>Selamat Datang di Sistem Informasi Rumah Makan Sinar Kapau</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Selamat Datang !</h5>
    Mohon isi transaksi dengan teliti dan jujur
</div>
<?= $this->endSection() ?>