<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

  public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
		is_logged_in();
	}

  public function index(){
    $data['title'] = 'Menu Management';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_menu
    $data['menu'] = $this->db->get('user_menu')->result_array();

    //validation menu
    $this->form_validation->set_rules('menu', 'Menu', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index',$data);
      $this->load->view('templates/footer');
    }else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added</div>');
			redirect('menu');
    }
  }

  public function submenu(){
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //menggunkan model untuk melakukan join 2 tabel
    $this->load->model('Menu_model', 'menu');
    $data['subMenu'] = $this->menu->getSubMenu();

    //mengirim tabel menu untuk combo box di modal
    $data['menu'] = $this->db->get('user_menu')->result_array();

    //validation menu
    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
    $this->form_validation->set_rules('url', 'URL', 'required|trim');
    $this->form_validation->set_rules('icon', 'icon', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu',$data);
      $this->load->view('templates/footer');
    }else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->insert('user_sub_menu', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New submenu added</div>');
			redirect('menu/submenu');
    }
  }

  public function deleteSubmenu($id){
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->model('Menu_model', 'menu');
    $this->menu->deleteSubmenu($id);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been delete</div>');
    redirect('menu/submenu');
  }

  // public function editSubmenu($id){
  //
  // }

}
