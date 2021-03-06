<?php

namespace App\Controllers;

use PHPUnit\Util\Json;
use App\Models\Modeldataproduk;
use Config\Services;


class Penjualan extends BaseController
{
	public function index()
	{
		$data=[
			'nofaktur' => $this->buatFaktur()
		];
		return view('penjualan/index', $data);
	}

	public function buatFaktur()
	{
		$tgl = $this->request->getPost('tanggal');
		$query = $this->db->query("SELECT MAX(jual_faktur) AS nofaktur FROM penjualan WHERE DATE_FORMAT(jual_tgl,'%Y-%m-%d') = '$tgl'");
		$hasil = $query->getRowArray();
		$data = $hasil['nofaktur'];

		$lastNoUrut = substr($data, -4);

		//tambah no urut
		$nextNoUrut = intval($lastNoUrut) + 1;

		//format no transaksi berikutnya
		$fakturPenjualan = 'SK' . date('dmy',strtotime($tgl)).sprintf('%04s', $nextNoUrut);
		
		return $fakturPenjualan;
	}

	public function dataDetail()
	{
		$nofaktur = $this->request->getPost('nofaktur');

		$tempPenjualan = $this->db->table('temp_penjualan');
		$queryTampil = $tempPenjualan->select('detjual_id as id, detjual_kodebarcode as kode, namaproduk,detjual_hargajual as hargajual, detjual_jml as qty,detjual_subtotal as subtotal')->join('produk','detjual_kodebarcode=kode')-> where('detjual_faktur',$nofaktur)->orderBy('detjual_id', 'asc');

		$data = [
			'datadetail' => $queryTampil->get()
		];

		$msg = [
			'data' => view('penjualan/viewdetail', $data)
		];
		echo json_encode($msg);
	}

	public function viewDataProduk()
	{
		if($this->request->isAJAX()){
			$keyword = $this->request->getPost('keyword');
			$data = [
				'keyword' => $keyword
			];
			$msg = [
				'viewmodal' => view('penjualan/viewmodalcariproduk', $data)
			];
			echo json_encode($msg);
		}
	}

	public function listDataProduk()
	{
		$keywordkode = $this->request->getPost('keywordkode');
  		$request = Services::request();
  		$modelProduk = new Modeldataproduk($request);
  		if($request->getMethod(true)=='POST'){
    		$lists = $modelProduk->get_datatables($keywordkode);
        	$data = [];
        	$no = $request->getPost("start");
        	foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->kode;
                $row[] = $list->namaproduk;
				$row[] = $list->katnama;
				$row[] = number_format($list->stok_tersedia,0,",",".");
				$row[] = number_format($list->harga_jual,0,",",".");
                $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"pilihitem('".$list->kode."','".$list->namaproduk."')\">Pilih</button>";
				$data[] = $row;
    		}
    		$output = [
				"draw" => $request->getPost('draw'),
                "recordsTotal" => $modelProduk->count_all($keywordkode),
                "recordsFiltered" => $modelProduk->count_filtered($keywordkode),
                "data" => $data
			];
        echo json_encode($output);
  		}
	}
	
	public function simpanTemp(){
		if ($this->request->isAJAX()){
			$kode = $this->request->getPost('kode');
			$namaproduk = $this->request->getPost('namaproduk'); 
			$jumlah = $this->request->getPost('jumlah');
			$nofaktur =  $this->request->getPost('nofaktur');

			$queryCekProduk = $this->db->table('produk')->like('kode',$kode)->orLike('namaproduk',$kode)->get();
		
			$totalData = $queryCekProduk->getNumRows();

			if($totalData > 1){
				$msg =[
					'totaldata' => 'banyak'
				];
			}else{
				$msg=[
					'totaldata' => 'satu'
				];
			}
			echo json_encode($msg);
		}
	}
}
