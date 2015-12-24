<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Data_tanaman_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}	
	/*-------------Post Article------------------*/
	public function GetPost($where = ""){
		$data=$this->db->query("select * from `tanaman`".$where);
		return $data->result_array();
	}

	 public function InsertPost($tableName, $data){
		$res = $this->db->insert($tableName, $data);
		return $res;
	 }

	 public function DeletePost($tableName, $where){
		 $res = $this->db->delete($tableName, $where);
		 return $res;
	 }

	 public function UpdatePost($tableName, $data, $where){
		 $res = $this->db->update($tableName, $data, $where); 	#$where -->  primari key
			return $res;
	 }

	 /*--------Kategori Tanaman----------*/
	 public function GetKategori($where = ""){
		$data=$this->db->query("select * from `kategori`".$where);
		return $data->result_array();
	}


	 public function cek_login_pass($username, $password){
	 	$hasil = $this->db->where('username', $username)
	 				->where('pass',$password)
	 				->limit(1)
	 				->get('admin');
	 	# code...
	 			if($hasil->num_rows() == 1){
	 				return $hasil->row();
	 			}
	 			else{
	 				return false;
	 			}
	 }

	 function cek_id($id){
		$hasil = $this->db->where('username', $id)
	 				->limit(1)
	 				->get('admin');
	 	# code...
	 			if($hasil->num_rows() == 1){
	 				return $hasil->row();
	 			}
	 			else{
	 				return false;
	 			}
	 }
}