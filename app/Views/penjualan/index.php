<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i> Menu Penjualan</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>

<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-warning btn-sm"
                onclick="window.location='<?= site_url('penjualan/index') ?>'">&laquo; Kembali</button>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nofaktur">Faktur</label>
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;"
                     name="nofaktur" id="nofaktur" readonly value="<?= $nofaktur; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly
                        value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal">Aksi</label>
                    <div class="input-group">
                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                            <i class="fa fa-trash-alt"></i>
                        </button>&nbsp;
                        <button class="btn btn-success" type="button" id="btnSimpanTransaksi">
                            <i class="fa fa-save"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control form-control-sm" name="kode" id="kode" autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="namaproduk">Nama Produk</label>
                    <input type="text" style="font-weight: bold; font-size:16pt;" class="form-control form-control-sm" name="namaproduk" id="namaproduk" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Total Bayar</label>
                    <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar"
                        style="text-align: right; color:blue; font-weight : bold; font-size:40pt;" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dataDetailPenjualan">
 
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>
<script>
$(document).ready(function() {
    $('body').addClass('sidebar-collapse');

    dataDetailPenjualan();

    $('#kode').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });
});


function dataDetailPenjualan(){
    $.ajax({
        type: "post",
        url: "<?= site_url('penjualan/dataDetail') ?>",
        data: {
            nofaktur: $('#nofaktur').val()
        },
        dataType: "json",
        beforeSend:function(){
            $('.dataDetailPenjualan').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        success: function (response) {
            if(response.data){
                $('.dataDetailPenjualan').html(response.data);
            }
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function cekKode(){
    let kode = $('#kode').val();

    if(kode.length==0){
        $.ajax({
            url: "<?= site_url('penjualan/viewDataProduk') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();

                $('#modalproduk').modal('show');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }else{
        $.ajax({
            type: "post",
            url: "<?= site_url('penjualan/simpanTemp')?>",
            data: {
                kode: kode,
                namaproduk: $('#namaproduk').val(),
                jumlah: $('#jumlah').val(),
                nofaktur: $('#nofaktur').val(),
            },
            dataType: "json",
            success: function(response){
                if(response.totaldata == 'banyak'){
                    $.ajax({
                        url: "<?= site_url('penjualan/viewDataProduk') ?>",
                        dataType: "json",
                        data: {
                            keyword : kode
                        },
                        type: "post",
                        success: function(response) {
                            $('.viewmodal').html(response.viewmodal).show();

                            $('#modalproduk').modal('show');
                        },
                        error: function(xhr, thrownError){
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}
       

</script>
<?= $this->endSection() ?>