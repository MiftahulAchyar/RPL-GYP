<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Captcha extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{

		if($this->session->userdata('image_random_value')){
			$this->session->unset_userdata('image_random_value');
		
		}
		srand($this->make_seed());
		$randval = (int)(rand()%2+3);
		$alphaNumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$random = substr(str_shuffle($alphaNumeric), 2, $randval);
		$image = imagecreatefromjpeg(base_url()."/img/backo.jpg");

		$textColor = imagecolorallocate($image, 3, 3, 3);
		imagestring($image, 16, 15, 28, $random, $textColor);

//		$_SESSION['image_random_value'] = md5($random);
	$this->session->set_userdata('image_random_value',md5($random));
		$this->output->set_header("Expires: Mon, 16 Nov 2015 07:00:00 GMT");
		$this->output->set_header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		$this->output->set_header("Chace-Control: no-store, no-chace, must-revalidate");
		$this->output->set_header("Chace-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-chace");
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
		exit();
	}

	function make_seed()
	{
	  list($usec, $sec) = explode(' ', microtime());
	  return (float) $sec + ((float) $usec * 100000);
	}
}