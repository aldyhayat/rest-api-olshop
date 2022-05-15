<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;


class Elektronik extends RestController{
    function __construct()
    {
        parent::__construct();
    }

    public function index_get($id = '0'){

        $check_data = $this->db->get_where('elektronik',['id'=> $id])->row_array();

        if($id){
            if($check_data){
                $this->response($check_data, RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ],404);
            }
        }else{
            $data = $this->db->get('elektronik')->result();
            $this->response($data,RestController::HTTP_OK);
        }

        
    }

    public function index_post(){
        $data = array(
            'merk_elektronik' => $this->post('merk_elektronik'),
            'harga' => $this->post('harga'),
            'detail' => $this->post('detail'),
        );

        $insert = $this->db->insert('elektronik', $data);

        if($insert){
            $this->response($data, RestController::HTTP_OK);
        }else{
            $this->response(array('status' => 'failed', 502));
        }
    }

    public function index_put(){
        $id = $this->put('id');
        $data = array(
            'merk_elektronik' => $this->put('merk_elektronik'),
            'harga' => $this->put('harga'),
            'detail' => $this->put('detail'),
        );

        $this->db->where('id',$id);
        $update = $this->db->update('elektronik', $data);

        if($update){
            $this->response($data, RestController::HTTP_OK);
        }else{
            $this->response(array('status' => 'failed', 502));
        }
    }

    public function index_delete(){
        $id = $this->delete('id');
        $check_data = $this->db->get_where('elektronik',['id'=> $id])->row_array();

        if($check_data){
            $this->db->where('id', $id);
            $this->db->delete('elektronik');

            $this->response(array('status'=>'success'),200);
        }else{
            $this->response(array('status'=>'data not found'),404);

        }
    }
}







?>