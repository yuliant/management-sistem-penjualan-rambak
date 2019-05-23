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

  public function role(){
    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_role = mengambil semua data dari user_role dan mengirimkannya ke variable role
    $data['role'] = $this->db->get('user_role')->result_array();

    $this->form_validation->set_rules('role', 'Role', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role',$data);
      $this->load->view('templates/footer');
    }else {
      $data = [
        'role' => $this->input->post('role')
      ];
      $this->db->insert('user_role', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added</div>');
			redirect('admin/role');
    }
  }

  public function roleAccess($role_id){
    $data['title'] = 'Role Access';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_role = mengambil satu baris data user_role berserta id nya dari user_role dan mengirimkannya ke variable role
    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    //query get table user_menu = mengambil semua data user_menu dan mengirimkannya ke variable menu
    $this->db->where('id !=', 1); // semua data diambil kecuali data dengan id 1
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/role-access',$data);
    $this->load->view('templates/footer');
  }

  public function changeAccess(){
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);
    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    }else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access changed</div>');

  }



  public function deleteRole($id){
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->model('Admin_model', 'admin');
    $this->admin->deleteRole($id);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been delete</div>');
    redirect('admin/role');
  }

}
