<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_user_profile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_user_profile_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {

            $data = array(
                'action'        => site_url('tbl_user_profile/update_action'),
		'id_users'      => set_value('id_users', $this->session->userdata('id_users')),
		'full_name'     => set_value('full_name', $this->session->userdata('full_name')),
		'email'         => set_value('email', $this->session->userdata('email')),
		'password'      => set_value('password', ''),
		'images'        => set_value('images', $this->session->userdata('images'))

	    );
            $this->template->load('template','tbl_user_profile/tbl_user_profile_form', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_user_profile_model->json();
    }

    
    // public function update($id) 
    // {
    //     $row = $this->Tbl_user_profile_model->get_by_id($id);

    //     if ($row) {
    //         $data = array(
    //             'button' => 'Update',
    //             'action' => site_url('tbl_user_profile/update_action'),
	// 	'id_users' => set_value('id_users', $row->id_users),
	// 	'full_name' => set_value('full_name', $row->full_name),
	// 	'email' => set_value('email', $row->email),
	// 	'password' => set_value('password', $row->password),
	// 	'images' => set_value('images', $row->images),
	// 	'id_user_level' => set_value('id_user_level', $row->id_user_level),
	// 	'is_aktif' => set_value('is_aktif', $row->is_aktif),
	//     );
    //         $this->template->load('template','tbl_user_profile/tbl_user_profile', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Record Not Found');
    //         redirect(site_url('tbl_user_profile'));
    //     }
    // }
    
    public function update_action() 
    {
        $this->_rules();
        $foto = $this->upload_foto();

        $password       = $this->input->post('password2',TRUE);
        $options        = array("cost"=>4);
        $hashPassword   = password_hash($password,PASSWORD_BCRYPT,$options);

        if($password!='') {
            if($foto['file_name']==''){
                $data = array(
                'full_name'     => $this->input->post('full_name',TRUE),
                'email'         => $this->input->post('email',TRUE),
                'password'      => $hashPassword);
            }else{
                $data = array(
                'full_name'     => $this->input->post('full_name',TRUE),
                'email'         => $this->input->post('email',TRUE),
                'password'      => $hashPassword,
                'images'        =>$foto['file_name']);
                
                // ubah foto profil yang aktif
                $this->session->set_userdata('images',$foto['file_name']);
            }    
        }
        else {
            if($foto['file_name']==''){
                $data = array(
                'full_name'     => $this->input->post('full_name',TRUE),
                'email'         => $this->input->post('email',TRUE));
            }else{
                $data = array(
                'full_name'     => $this->input->post('full_name',TRUE),
                'email'         => $this->input->post('email',TRUE),
                'images'        =>$foto['file_name']);
                
                // ubah foto profil yang aktif
                $this->session->set_userdata('images',$foto['file_name']);
            }    
        }

        $this->Tbl_user_profile_model->update($this->input->post('id_users', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('tbl_user_profile'));
    }

    function upload_foto(){
        $config['upload_path']          = './assets/foto_profil';
        $config['allowed_types']        = 'gif|jpg|png';
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('images');
        return $this->upload->data();
    }
    
    
    public function delete($id) 
    {
        $row = $this->Tbl_user_profile_model->get_by_id($id);

        if ($row) {
            $this->Tbl_user_profile_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tbl_user_profile'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_user_profile'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('full_name', 'full name', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	// $this->form_validation->set_rules('password', 'password', 'trim|required');
	// $this->form_validation->set_rules('images', 'images', 'trim|required');
	$this->form_validation->set_rules('id_user_level', 'id user level', 'trim|required');
	$this->form_validation->set_rules('is_aktif', 'is aktif', 'trim|required');

	$this->form_validation->set_rules('id_users', 'id_users', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}

/* End of file Tbl_user_profile.php */
/* Location: ./application/controllers/Tbl_user_profile.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-27 12:33:39 */
/* http://harviacode.com */