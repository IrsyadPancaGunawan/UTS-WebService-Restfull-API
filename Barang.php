<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Barang extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);        
    }

    //Menampilkan data 
    public function index_get() {		
			
        $id = $this->get('id');
        if ($id == '') {
            $data = $this->db->get('barang')->result();
        } else {
            $this->db->where('BarangID', $id);
            $data = $this->db->get('barang')->result();
        }	
		$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>200,
                  "message"=>"Response successfully",
                  "data"=>$data];	
        $this->response($result, 200);
    }


	//Menambah data 
	public function index_post() {
        $data = array(
                    'BarangID'    => $this->post('BarangID'),
                    'NamaBarang'          => $this->post('NamaBarang'),
                    'Merek'    => $this->post('Merek'),
					'Model'    => $this->post('Model'),
					'Harga'    => $this->post('Harga'),
					'Stok'    => $this->post('Stok'),
					'SupplierID'    => $this->post('SupplierID'));
        $insert = $this->db->insert('barang', $data);
        if ($insert) {
            //$this->response($data, 200);
			$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>201,
                  "message"=>"Data has successfully added",
                  "data"=>$data];	
			$this->response($result, 201);
        } else {
			$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                  "code"=>502,
                  "message"=>"Failed adding data",
                  "data"=>null];	
			$this->response($result, 502);            
        }
    }
	
	//Memperbarui data yang telah ada
    public function index_put() {
        $id = $this->get('id');
        $data = array(
                    'BarangID'    => $this->put('BarangID'),
                    'NamaBarang'          => $this->put('NamaBarang'),
                    'Merek'    => $this->put('Merek'),
					'Model' => $this->put('Model'),
					'Harga'    => $this->put('Harga'),
					'Stok'    => $this->put('Stok'),
					'SupplierID'    => $this->put('SupplierID'));
        $this->db->where('BarangID', $id);
        $update = $this->db->update('barang', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
	
	// Menghapus data penjualan
	public function index_delete() {
        $id = $this->get('id');
        $this->db->where('BarangID', $id);
        $delete = $this->db->delete('barang');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
}
?>