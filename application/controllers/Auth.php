<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
		$this->load->library('form_validation'); // untuk memvalidasi inputan
	}

	public function index()
	{
		if ($this->session->userdata('email')) { //penge checkan apabila sdh login tidak bisa ke halaman login kecuali logout dahulu
			redirect('user');
		}

		$this->form_validation->set_rules("email","Email","required|valid_email|trim");
		$this->form_validation->set_rules("password","Password","required|trim");
		if ($this->form_validation->run() == false) {
			$data['title']='Login Page';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		}else {
			//validation success menggunakan method private
			$this->_login();
		}
	}
	private function _login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email'=>$email])->row_array();
		if ($user) { // jika usernya ada
			// jika usernya aktif
			if ($user['is_active'] == 1) {
				// cek password
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];
					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						redirect('admin');
					}else {
						redirect('user');
					}
				}else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password</div>');
					redirect('auth');
				}
			}else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated</div>');
				redirect('auth');
			}
		}else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		if ($this->session->userdata('email')) { //penge checkan apabila sdh login tidak bisa ke halaman login kecuali logout dahulu
			redirect('user');
		}

		$this->form_validation->set_rules("name","Name","required|trim");
		$this->form_validation->set_rules("email","Email","required|valid_email|trim|is_unique[user.email]",[
			'is_unique' => 'This email has already registered'
		]);
		$this->form_validation->set_rules("password1","Password","required|trim|min_length[3]|matches[password2]",[
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
			]);
		$this->form_validation->set_rules("password2","Password","required|trim|min_length[3]|matches[password1]");

		if ($this->form_validation->run() == false) {
			$data['title']='WPU User Registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		}else {
			$email = $this->input->post('email', true);
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($email),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
				'date_created' => time()
			];

			//siapkan token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);

			$this->_sendEmail($token, 'verify'); //mengirim email untuk verifikasi

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please activated your account</div>');
			redirect('auth');
		}
	}
	private function _sendEmail($token, $type){
		$config = [
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'youremail@email.com',
			'smtp_pass' => 'yourpassword',
			'smtp_port' => 465,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => "\r\n"
 		];

		$this->load->library('email' , $config);
		$this->email->initialize($config); // jika terjadi error di verifikasi smtp, tambahkan baris ini

		$this->email->from('masrizalsn@gmail.com', 'yuliant');
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="'. base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activite</a>');
		}elseif ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password : <a href="'. base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset password</a>');
		}

		if ($this->email->send()) {
			return true;
		}else {
			echo $this->email->print_debugger();
			die;
		}

	}

	public function verify(){
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) { //emailnya ada
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) { //tokennya ada
				if (time() - $user_token['date_created'] < (60*60*24)) { //masa expired token hanya 1 hari
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user');

					$this->db->delete('user_token', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'. $email .' has been activated. Please login</div>');
					redirect('auth');

				}else { //token tidak bisa digunakan jika lebih dari 1 hari
					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! token expired</div>');
					redirect('auth');
				}
			}else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! wrong token</div>');
				redirect('auth');
			}
		}else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! wrong email</div>');
			redirect('auth');
		}
	}

	public function logout(){
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out</div>');
		redirect('auth');
	}

	public function blocked(){
		$this->load->view('auth/blocked');
	}

	public function forgotPassword(){
		$data['title']='Forgot Password';

		$this->form_validation->set_rules("email","Email","required|valid_email|trim");
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		}else {
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array(); //untuk mengecek apakah email yang dipost ada dan sudah diaktivasi di table user
			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot'); //mengirim email untuk forgot password

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password</div>');
				redirect('auth/forgotPassword');
			}else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated</div>');
				redirect('auth/forgotPassword');
			}
		}
	}

	public function resetpassword(){
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();// mengecek email dengan email yang diget 1 baris
		if ($user) { //emailnya ada
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array(); // mengecek token dengan token yang diget 1 baris
			if ($user_token) { //tokennya ada
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();

			}else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! wrong token</div>');
				redirect('auth');
			}
		}else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! wrong email</div>');
			redirect('auth');
		}
	}

	public function changePassword(){
		$data['title']='Change Password';

		if ( !$this->session->userdata('reset_email')) {
			redirect('auth');
		}

		$this->form_validation->set_rules("password1","Password","required|trim|min_length[3]|matches[password2]");
		$this->form_validation->set_rules("password2","Repeat Password","required|trim|min_length[3]|matches[password1]");
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		}else {
			$password = password_hash($this->input->post('password1'),PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]); // menghapus token bila sdh mereset password

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been change! please login</div>');
			redirect('auth');
		}
	}

}
