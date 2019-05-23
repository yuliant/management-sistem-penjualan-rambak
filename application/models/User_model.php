<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  public function deleteJualrambak($id){
    $this->db->where('id', $id);
    $this->db->delete('user_jual_rambak');
  }

  public function getAllPembeli()
  {
    return $this->db->order_by("nama", "ASC")->get('user_jual_rambak')->result_array(); // seperti select * from mahasiswa
  }

  public function cariDataPembeli()
  {
      $keyword = $this->input->post('keyword', true);
      $this->db->like('nama', $keyword);
      $this->db->or_like('total', $keyword);
      if ($keyword == "belum lunas") {
        $this->db->or_like('status', 1);
      }elseif ($keyword == "lunas") {
        $this->db->or_like('status', 0);
      }

      $this->db->or_like('keterangan', $keyword);
      return $this->db->get('user_jual_rambak')->result_array();
  }

  public function hitungJumlahRambak(){
     $this->db->select_sum('rambak');
     $query = $this->db->get('user_jual_rambak');
     if($query->num_rows()>0){
       return $query->row()->rambak;
     }
     else{
       return 0;
     }
  }

  public function hitungJumlahGadung(){
     $this->db->select_sum('gadung');
     $query = $this->db->get('user_jual_rambak');
     if($query->num_rows()>0){
       return $query->row()->gadung;
     }
     else{
       return 0;
     }
  }

  public function hitungJumlahTenggiri(){
     $this->db->select_sum('tenggiri');
     $query = $this->db->get('user_jual_rambak');
     if($query->num_rows()>0){
       return $query->row()->tenggiri;
     }
     else{
       return 0;
     }
  }

  public function hitungJumlahRengginang(){
     $this->db->select_sum('rengginang');
     $query = $this->db->get('user_jual_rambak');
     if($query->num_rows()>0){
       return $query->row()->rengginang;
     }
     else{
       return 0;
     }
  }

  public function hitungPendapatan(){
     $this->db->select_sum('total');
     $query = $this->db->get('user_jual_rambak');
     if($query->num_rows()>0){
       return $query->row()->total;
     }
     else{
       return 0;
     }
  }

}
