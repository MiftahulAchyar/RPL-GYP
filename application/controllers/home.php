<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->clear_cache();
	}
	private function clear_cache(){	$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");$this->output->set_header("Pragma: no-cache");}
	function _remap($method,$args){$this->index($method,$args);}

	public function index($pages='', $args=array())
	{
		if ($pages!='' && $args!=null) {
		
			$this->load->model('data_tanaman_model');
			$cek = $this->data_tanaman_model->GetPost("where id like '".$args[0]."'");
			if ($cek) {
				
				foreach ($cek as $d) {
					$data['content'] = $d['deskripsi'];
					if ($d['pic1']!='') {
						$data['img'] = base_url()."tanaman/".$pages."/".$d['pic1']."";
					}
					
				}
				$this->load->view("view",$data);
			}
			else{
				return "None";
			}
		}
			else{
				echo "None";
			}

	}
		
	public function get_ip() {
		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}
		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		echo  $the_ip;


		$details = json_decode(file_get_contents("http://freegeoip.net/json/".$ip));
		echo $details->country_name;
	}
}