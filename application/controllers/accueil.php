<?php defined("BASEPATH") or exit("No direct script access allowed");

class Accueil extends CI_Controller {

	public function index(){
		echo 'Accueil';

		$this->load->model('adherent_model');
	}
}