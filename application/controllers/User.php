<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
    is_logged_in();
	}

  public function index(){
    $data['title'] = 'My Profile';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/index',$data);
    $this->load->view('templates/footer');
  }

  public function edit(){
    $data['title'] = 'Edit Profile';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //validation
    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/edit',$data);
      $this->load->view('templates/footer');
    }else {
      $name = $this->input->post('name');
      $email = $this->input->post('email');

      // cek jika ada gambar
      $upload_image = $_FILES['image']['name'];
      if ($upload_image) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '2048';
        $config['upload_path'] = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ( $this->upload->do_upload('image')) {
          $old_image = $data['user']['image'];
          if ($old_image != 'default.jpg') {
            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }

          $new_image = $this->upload->data('file_name');
          $this->db->set('image', $new_image);
        }else{
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
          redirect('user');
        }
      }

      $this->db->set('name', $name);
      $this->db->where('email', $email);
      $this->db->update('user');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated</div>');
			redirect('user');
    }
  }

  public function changePassword(){
    $data['title'] = 'Change Password';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //validation
    $this->form_validation->set_rules('current_pasword', 'Current Password', 'required|trim'); //untuk inputan dengan name="current_pasword"
    $this->form_validation->set_rules('new_pasword1', 'New Password', 'required|trim|min_length[3]|matches[new_pasword2]'); //untuk inputan dengan name="new_pasword1"
    $this->form_validation->set_rules('new_pasword2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_pasword1]'); //untuk inputan dengan name="new_pasword2"

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/changepassword',$data);
      $this->load->view('templates/footer');
    }else {
      $current_password = $this->input->post('current_pasword');
      $new_password = $this->input->post('new_pasword1');
      if ( !password_verify($current_password, $data['user']['password'])) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password</div>');
  			redirect('user/changepassword');
      }else {
        if ($current_password == $new_password) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password</div>');
    			redirect('user/changepassword');
        }else {
          //password yang benar
          $password_hash = password_hash($new_password,PASSWORD_DEFAULT);

          //update password
          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed</div>');
    			redirect('user/changepassword');
        }
      }
    }

  }
// ===================================================Jual Rambak=======================================================
  public function jualrambak(){
    $data['title'] = 'Jual Rambak';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_role = mengambil semua data dari user_role dan mengirimkannya ke variable role
    $data['rambak'] = $this->db->order_by("nama", "ASC")->get('user_jual_rambak')->result_array();

    //validation
    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('rambak', 'Rambak', 'trim|numeric|max_length[3]');
    $this->form_validation->set_rules('gadung', 'Gadung', 'trim|numeric|max_length[3]');
    $this->form_validation->set_rules('tenggiri', 'Tenggiri', 'trim|numeric|max_length[3]');
    $this->form_validation->set_rules('rengginang', 'Rengginang', 'trim|numeric|max_length[3]');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/jualrambak',$data);
      $this->load->view('templates/footer');
    }else {

      $nama = $this->input->post('nama');
      $isi_rambak = $this->input->post('rambak');
      if (! $isi_rambak) {
        $rambak = 0;
      }else {
        $rambak = $this->input->post('rambak');
      }

      $isi_gadung = $this->input->post('gadung');
      if (! $isi_gadung) {
        $gadung = 0;
      }else {
        $gadung = $this->input->post('gadung');
      }

      $isi_tenggiri = $this->input->post('tenggiri');
      if (! $isi_tenggiri) {
        $tenggiri = 0;
      }else {
        $tenggiri = $this->input->post('tenggiri');
      }

      $isi_rengginang = $this->input->post('rengginang');
      if (! $isi_rengginang) {
        $rengginang = 0;
      }else {
        $rengginang = $this->input->post('rengginang');
      }

      // $data['harga_rambak'] = 70000;
      // $data['harga_gadung'] = 25000;
      // $data['harga_tenggiri'] = 30000;
      // $data['harga_rengginang'] = 25000;

      $total = ($rambak * 70000)+($gadung * 25000)+($tenggiri * 30000)+($rengginang * 25000);
      $status = $this->input->post('status');
      $keterangan = $this->input->post('keterangan');

      //$this->db->insert('user_jual_rambak', $data);
      $this->db->insert('user_jual_rambak', [
        'nama'=>$nama,
        'rambak'=>$rambak,
        'gadung'=>$gadung,
        'tenggiri'=>$tenggiri,
        'rengginang'=>$rengginang,
        'total' => $total,
        'status' => $status,
        'keterangan' => $keterangan
      ]);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pembeli Baru telah ditambahkan</div>');
			redirect('user/jualrambak');
    }
  }

  public function cetak_pdf(){

    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_role = mengambil semua data dari user_role dan mengirimkannya ke variable role
    $data['rambak'] = $this->db->get('user_jual_rambak')->result_array();

    $this->load->library('pdf');

    $this->pdf->setPaper('A4', 'landscape');
    $this->pdf->filename = "laporan-pembelirambak.pdf";
    $this->pdf->load_view('user/laporan_pembelirambak_pdf', $data);
  }

  public function cetak_label(){

    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    //query get table user_role = mengambil semua data dari user_role dan mengirimkannya ke variable role
    $data['rambak'] = $this->db->get('user_jual_rambak')->result_array();

    $this->load->library('pdf');

    $this->pdf->setPaper('A4', 'portrait');
    $this->pdf->filename = "label-pembeli.pdf";
    $this->pdf->load_view('user/label_pdf', $data);
  }

  public function deleteJualrambak($id){
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->model('User_model', 'user');
    $this->user->deleteJualrambak($id);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pembeli sudah dihapus</div>');
    redirect('user/jualrambak');
  }


  public function editJualrambak($id){
    $data['title'] = 'Edit Data Pembeli';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $data['rambak'] = $this->db->get_where('user_jual_rambak', ['id'=>$id])->row_array();

    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('rambak', 'Rambak', 'required|trim|numeric|max_length[3]');
    $this->form_validation->set_rules('gadung', 'Gadung', 'required|trim|numeric|max_length[3]');
    $this->form_validation->set_rules('tenggiri', 'Tenggiri', 'required|trim|numeric|max_length[3]');
    $this->form_validation->set_rules('rengginang', 'Rengginang', 'required|trim|numeric|max_length[3]');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/edit_datapembeli',$data);
      $this->load->view('templates/footer');
    }else {

      $nama = $this->input->post('nama');
      $rambak = $this->input->post('rambak');
      $gadung = $this->input->post('gadung');
      $tenggiri = $this->input->post('tenggiri');
      $rengginang = $this->input->post('rengginang');
      $total = ($rambak * 70000)+($gadung * 25000)+($tenggiri * 30000)+($rengginang * 25000);
      $keterangan = $this->input->post('keterangan');

      //$this->db->insert('user_jual_rambak', $data);
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_jual_rambak', [
        'nama'=>$nama,
        'rambak'=>$rambak,
        'gadung'=>$gadung,
        'tenggiri'=>$tenggiri,
        'rengginang'=>$rengginang,
        'total' => $total,
        'keterangan' => $keterangan
      ]);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pembeli berhasil diubah</div>');
			redirect('user/jualrambak');
    }
  }




  public function changestatus($id, $status){
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    if ($this->db->get_where('user_jual_rambak',['id'=> $id, 'status' => $status =1])->row_array() ) {
      $this->db->where('id', $id);
      $this->db->update('user_jual_rambak', ['status'=>0]);
    }else if ($this->db->get_where('user_jual_rambak',['id'=> $id,'status' => $status =0])->row_array() ) {
      $this->db->where('id', $id);
      $this->db->update('user_jual_rambak', ['status'=>1]);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status pembeli berhasil diubah</div>');
    redirect('user/jualrambak');

  }





  public function cari_pembeli(){
    $data['title'] = 'Jual Rambak';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->model('User_model');

    $data['rambak'] = $this->User_model->getAllPembeli();
    if ($this->input->post('keyword')) {
      $data['rambak'] = $this->User_model->cariDataPembeli();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/jualrambak',$data);
    $this->load->view('templates/footer');

  }

//=============================================Hasil jual rambak ==============================================
  public function hasilrambak(){
    $data['harga_rambak'] = 70000;
    $data['harga_gadung'] = 25000;
    $data['harga_tenggiri'] = 30000;
    $data['harga_rengginang'] = 25000;

    $data['title'] = 'Hasil Jual Rambak';
    $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();

    $this->load->model('User_model');
    $data['rambak'] = $this->User_model->getAllPembeli();

    $data['total_rambak'] = $this->User_model->hitungJumlahRambak();
    $data['total_gadung'] = $this->User_model->hitungJumlahGadung();
    $data['total_tenggiri'] = $this->User_model->hitungJumlahTenggiri();
    $data['total_rengginang'] = $this->User_model->hitungJumlahRengginang();
    $data['total_pendapatan'] = $this->User_model->hitungPendapatan();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/hasil_jualrambak',$data);
    $this->load->view('templates/footer');

  }
}
