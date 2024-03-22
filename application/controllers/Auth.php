<?php
Class Auth extends CI_Controller{
    
    function index(){
        $this->load->view('auth/login');
    }
    
    function cheklogin(){
        $email      = $this->input->post('email');
        //$password   = $this->input->post('password');
        $password = $this->input->post('password',TRUE);
        $hashPass = password_hash($password,PASSWORD_DEFAULT);
        $test     = password_verify($password, $hashPass);
        // query chek users
        $this->db->where('email',$email);
        //$this->db->where('password',  $test);
        $users       = $this->db->get('tbl_user');
        if($users->num_rows()>0){
            $user = $users->row_array();
            if(password_verify($password,$user['password'])){
                // retrive user data to session
                $this->session->set_userdata($user);
                redirect('welcome');
            }else{
                $this->session->set_flashdata('status_login','Your email or password is incorect !');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('status_login','Your email or password is incorect !');
            redirect('auth');
        }
    }
    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Logout from the application is completed');
        redirect('auth');
    }

    public function savepassword() 
    {
        $this->load->model('User_model');
        $id = $this->input->post('emailsend',TRUE);
        $password       = $this->input->post('new_pass',TRUE);
        $options        = array("cost"=>4);
        $hashPassword   = password_hash($password,PASSWORD_BCRYPT,$options);

        $data = array(
            'password' => $hashPassword,
        );

        $this->User_model->update_reset($id, $data);
        $this->session->set_flashdata('message', 'Create Record Success');    
        redirect(site_url("Auth"));
    }

    function forgetpassword() {
        // $this->load->database();
        $email = $this->input->post('email', TRUE);
    
        // Konfigurasi email
        $config = array(
            // ... (your email configuration)
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'lims.rise@gmail.com',  // Email gmail
            'smtp_pass'   => 'ipeoqfgjxnifbymp',  // Password gmail
            'smtp_crypto' => 'tls',
            'smtp_port'   => 587,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        );
    
        // Load library email dan konfigurasinya
        $this->load->library('email', $config);
    
        $cek = $this->db->from('tbl_user')->where('email', $email)->get();
    
        // Use $cek->result() to get the results
        $result = $cek->result();
        $num = count($result);
    
        if ($num > 0) {
            $this->load->helper('string');
            $data = random_string('numeric', 6);
    
            try {
                $this->email->from($config['smtp_user'], 'RISE PO-MONASH');
                $this->email->to($email);
                $this->email->subject('PO-MONASH Password Reset');
    
                $message = 'Hi There, <br />';
                $message .= 'This is an automatic generated code for LIMS password reset<br />';
                $message .= '<br />';
                $message .= 'Here`s your code : <h1>' . $data . '</h1><br />';
                $message .= '<br />';
                $message .= '<br />';
                $message .= 'Regards, <br />';
                $message .= 'RISE PO-MONASH';
    
                $this->email->message($message);
    
                if ($this->email->send()) {
                    $dataarray = array('emails' => $email, 'resetcode' => $data);
                    // $dataarray = array(['xxxxxx', '12345678'];
                    $this->db->where('emails', $email);
                    $this->db->delete('user_reset');
                    $this->db->insert('user_reset', $dataarray);
                    $response = array('status' => 'success', 'message' => 'Email sent.');
                    echo json_encode($response);
                } else {
                    // Display or log the actual error message
                    $response = array('status' => 'error', 'message' => 'Error! email cannot be sent.' . $this->email->print_debugger());
                    echo json_encode($response);
                }
            } catch (\Throwable $th) {
                // Log or display the actual error message
                $response = array('status' => 'error', 'message' => 'Error! ' . $th->getMessage());
                echo json_encode($response);
            }
        } else {
            $response = array('status' => 'error', 'message' => 'LIMS login email not found !!.');
            echo json_encode($response);
        }
        // redirect(site_url("Auth"));
        // $this->template->load('template', 'auth/login', $data);
    }

    public function valid_code() 
    {
        $this->load->model('User_model');

        $id1 = $this->input->get('id1');
        $id2 = $this->input->get('id2');
        // echo $id;
        $data = $this->User_model->validate_code($id1,$id2);

        header('Content-Type: application/json');
        echo json_encode($data);
        // return $this->response->setJSON($data);
        // $data['location'] = $this->O3_filter_paper_model->find_loc($id);
    }
    

}
?>