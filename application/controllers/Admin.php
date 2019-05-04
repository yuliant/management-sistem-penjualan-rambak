<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
    is_logged_in();
	}

  public function index(){
    $data['title'] = 'Dashboard';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index',$data);
    $this->load->view('templates/footer');
  }
}
