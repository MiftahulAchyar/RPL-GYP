<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admin extends Login {
	public function clear_cache(){$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");$this->output->set_header("Pragma: no-cache");}
	function _remap($method,$args){$this->index($method,$args);}
	function Admin(){
		parent::__construct();			
		$this->clear_cache();
		define('editor', '');		
	}
	public function index($pages='', $args=array()){
	 if($this->session->userdata('user')){
		if(!$pages){
			$this->Defaulted();
		}
		else{
			
			switch ($pages) {
				case 'data_tanaman':
						if($args)
							$cek = $this->$pages($args[0]);
						else
							$cek = $this->$pages();
					
					if ($cek) {
						// print_r($cek);
						extract($cek);
						if ($header=='write') {
							$this->load->view('admin/data_tanaman/content/write', array('data'=>$data));
						}
						else{
							if(isset($pesan))
								$this->load->view('admin/home.php', array('header' => $header, 'content'=>$content, 'data'=>$data, 'pesan'=>$pesan));
							else
								$this->load->view('admin/home.php', array('header' => $header, 'content'=>$content, 'data'=>$data));
						}
					}
					// else echo "<br>No no no";
					break;
				
				default:
					if (!method_exists($this, $pages))
						// $this->Defaulted();
						show_404();
					else
						$this->$pages();
					break;
			}
		}
	 }
	 else{
	 	$this->login();
	 }
	}

/*--------------------------------
|			URL Method  		|
---------------------------------*/
	public function Defaulted(){
		$this->load->view('admin/home.php');
	}


public function data_tanaman($value=''){
	$this->load->model('data_tanaman_model');
	switch ($value) {
		case 'data': case 'kategori':
			$data['data'] = '';
			$data['header'] = "data_tanaman/header/".$value.".php";
			$data['content'] = "data_tanaman/content/".$value.".php";		
			if($value=='data'){
				$data['data'] = $this->data_tanaman_model->GetPost();
				$this->session->set_flashdata('token', 'add');
			}
			elseif($value=='kategori'){
				$data['data'] = $this->data_tanaman_model->GetKategori();
			}
			return $data;
			break;

		case 'write': 
			$data['data'] = $this->data_tanaman_model->GetKategori();
			$data['header'] = "write";
			return $data;
			break;
		
		default:
			show_404();
			return false;
			
	}
}

/*----------------------------------
|			Processing Method  		
---------------------------------*/
	public function Kategori_write($ed=''){
		if (isset($_POST['add_kategori'])) {
				extract($_POST);
				$this->load->model('data_tanaman_model');
				$cek = $this->data_tanaman_model->InsertPost('kategori', 
													array(
														'id' => strtolower($kategori),
														'nama'=>$kategori
														)
												);
				if ($cek) {
					$this->session->set_flashdata('pesan', 'Sukses menambahkan\n'.$kategori);
					redirect('admin/data_tanaman/kategori');
				}
		}

		elseif(isset($_POST['delete'])){
			extract($_POST);
			$this->load->model('data_tanaman_model');
			$data = $this->data_tanaman_model->DeletePost('kategori', array('id' =>  $id));
			if ($data) {
				$this->session->set_flashdata('pesan', 'Sukses Terhapus\n'.$id);
				redirect('admin/data_tanaman/kategori');
			}
		}
	}
	public function Tanaman_write($ed=''){
	/*------------Menulis Artikel-----------*/
		if(isset($_POST['editor1'])){
				date_default_timezone_set('Asia/Jakarta');
				$data['deskripsi'] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $_POST['editor1']);
				$data['nama'] = strip_tags($_POST['nama']);
				$data['id'] = str_replace(" ", "_", strtolower($data['nama']));
				if ($_POST['status']=='edit') {
					$data['id'] = $_POST['id'];
				}
				$data['kategori'] = strip_tags($_POST['kategori']);


				$config['file_name'] = strip_tags($data['id']).'.jpg';
				$path = './tanaman/'.strip_tags($_POST['kategori']);
				$config['upload_path'] = $path.'/';
				if (!file_exists($path)) {
				    mkdir($path, 0777, true);
				}
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']	= '1500';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$this->load->library('upload', $config);
				$data['pic1'] =$data['pic2'] ="";
					
				if ($this->upload->do_upload()){
					$trip = $this->upload->data();
					$data['pic1'] = $trip['file_name'];
					
				}
				else{
					$this->session->set_flashdata('upload', $this->upload->display_errors());
				}

				extract($data);
				if($nama==''){
					$this->session->set_flashdata('pesan', 'Nama tanaman harus diisi');
					$this->session->set_flashdata('article', $content);
					$this->session->set_flashdata('subjudul', $subtitle);
					redirect('admin/data_tanaman/write');
				}
				elseif($deskripsi==''){
					$this->session->set_flashdata('pesan', 'The content is none');
					$this->session->set_flashdata('judul', $title);
					$this->session->set_flashdata('subjudul', $subtitle);
					redirect('admin/data_tanaman/write');
				}
				$this->load->model('data_tanaman_model');

				// Menambah Data Tanaman
				if ($_POST['status']!='edit') {
					$cek = $this->data_tanaman_model->InsertPost('tanaman', 
														array(
															'id' => $id,
															'nama'=>$nama, 
															'kategori' => $kategori,
															'deskripsi' => $deskripsi, 
															'pic1' => $pic1,
															'pic2' => $pic2
															)
													);
					if($cek==true and $ed==''){
						$this->session->set_flashdata('pesan', 'Sukses menambahkan\n'.$nama);
						redirect('admin/data_tanaman/data');
					}
					else{
						$this->session->set_flashdata('pesan', mysql_error());
						redirect('admin/data_tanaman/data');	
					}
				}

				// Mengedit tanaman
				elseif ($_POST['status']=='edit') {
					if ($pic1 !='') {
						# code...
					}
					$cek = $this->data_tanaman_model->UpdatePost(
						'tanaman', 
						 array(
						 		'nama'=>$nama, 
								'kategori' => $kategori,
								'deskripsi' => $deskripsi, 
								'pic1' => $pic1,
								'pic2' => $pic2
								),
							 array('id' => $id));
					if($cek==true and $ed==''){
						$this->session->set_flashdata('pesan', 'Sukses menambahkan\n'.$nama);
						redirect('admin/data_tanaman/data');
					}
					else{
						$this->session->set_flashdata('pesan', mysql_error());
						redirect('admin/data_tanaman/data');	
					}
				}
			
			}
		

	/*------------Edit Artikel-----------*/
		elseif(isset($_POST['edit']) ){
			extract($_POST);
			$this->load->model('data_tanaman_model');
			$data = $this->data_tanaman_model->GetPost("where id like'".$id."'");
			foreach ($data as  $data) {
				extract($data);
				$this->session->set_flashdata('pesan', 'Mari kita edit');
				$this->session->set_flashdata('id', $id);
				$this->session->set_flashdata('article', $deskripsi);
				$this->session->set_flashdata('kategori', $kategori);
				$this->session->set_flashdata('nama', $nama);
				$this->session->set_flashdata('token', 'edit');
			}
		}
		elseif(isset($_POST['delete'])){
			extract($_POST);
			$this->load->model('data_tanaman_model');
			$del = $this->data_tanaman_model->GetPost("where id like'".$id."'");
			$data = $this->data_tanaman_model->DeletePost('tanaman', array('id' =>  $id));
			if ($data) {
				$this->load->helper("url");
				foreach ($del as  $del) {
					$path = base_url("tanaman/". $del['kategori'] .'/'. $del['pic1'] .'.jpg');
					unlink($path);
				}
				$this->session->set_flashdata('pesan', 'Sukses Terhapus\n'.$id);
				redirect('admin/data_tanaman/data');
			}
			else{
				$this->session->set_flashdata('pesan', mysql_error());
				redirect('admin/data_tanaman/data');
			}
		}

	}


	public function crypto($stat='', $input=''){
		try {
			if ($stat == 'encrypt') {
					$key = "USxKSJ()sd{+=|Ascmdee/|\SLsxdvf35^45522p";
					$td = mcrypt_module_open('blowfish', '', 'ecb', '');
					$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
					mcrypt_generic_init($td, $key, $iv);
					$encrypted_data = mcrypt_generic($td, $input);
					mcrypt_generic_deinit($td);
					mcrypt_module_close($td);
					return md5($encrypted_data);
				}
			elseif($stat=='decrypt'){
				$td = mcrypt_module_open('blowfish', '', 'ecb', '');
				$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
				$key = substr($key, 0, mcrypt_enc_get_key_size($td));
				mcrypt_generic_init($td, $key, $iv);
				$decrypted_data = mdecrypt_generic($td, $input);
				return $decrypted_data;
			}
		} catch (Exception $e) {
			echo "Undefined";
		}

	}


	public function logout(){
		$this->session->sess_destroy();
		redirect('admin');
	}

}

/*------------------------------------
		Login
------------------------------------*/
class  Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('data_tanaman_model');
		// $this->log();
	}
	protected function login(){
		if(!$this->session->userdata('user')){		
			//$data['users'] = $this->model_admin->get_all_userss();
			//$this->load->view('admin/login.php');
			
				$this->form_validation->set_rules('username', 'Username','required|alpha_numeric|xss_clean');
				$this->form_validation->set_rules('password', 'Password','required|alpha_numeric');
				$this->form_validation->set_rules('captcha', 'Captcha', 'trim|callback_check_captcha|required');
			if($this->form_validation->run() == false){
				$this->load->view('admin/login.php');
			}
			else{
				//cek--> apakah ada kombinasi username && password
				$username = set_value('username');
				$password = $this->crypto('encrypt',set_value('password'));
				$captcha = set_value('captcha');
				$validasi = $this->data_tanaman_model->cek_login_pass($username, $password);
				if($validasi!=false){
					//login sukses
					if(md5($captcha) == $this->session->userdata('image_random_value')){
						$this->session->set_userdata('user',$username);
						$password = '';
						
					}
					else{
						$this->session->set_flashdata('error','Wrong Captcha !');
					}
					
				}
				else{
					//salah
					$this->session->set_flashdata('error','Wrong username or password !');
					
				}
				redirect('admin');
					
			}

		}
	}

}