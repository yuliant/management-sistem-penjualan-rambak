<?php

function is_logged_in(){
  $ci = get_instance(); // instansiasi CI untuk helper agar this dapat digunakan
  if (!$ci->session->userdata('email')) {
    redirect('auth');
  }else {
    $role_id = $ci->session->userdata('role_id');
    $menu = $ci->uri->segment(1); //untuk menentukan menu yang diakses dari url

    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
    $menu_id = $queryMenu['id']; //mengambil id dari user_menu

    $userAccess = $ci->db->get_where('user_access_menu', [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ]);

    if ($userAccess->num_rows() < 1) {
      redirect('auth/blocked');
    }
  }
}

function check_access($role_id, $menu_id){
  $ci = get_instance(); // instansiasi CI untuk helper agar semua library CI dapat digunakan

  $ci->db->where('role_id', $role_id);
  $ci->db->where('menu_id', $menu_id);
  $result = $ci->db->get('user_access_menu');

  if ($result->num_rows() > 0) {
    return "checked = 'checked' ";
  }
}
