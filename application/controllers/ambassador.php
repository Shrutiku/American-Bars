<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ambassador
 *
 * @author esco
 */
class Ambassador extends SPACULLUS_Controller {
    //put your code here
    
    function Abassador () {

        
        parent :: __construct ();
        $this->load->library ("PasswordHash");
        $this->load->library ("encrypt");
        $this->load->model ('home_model');

    }

    public function index () {
        $data['error'] = '';
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();

        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');

        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $this->load->library ('form_validation');

        $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/ambassador/verification_form', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render();

    }
    
        function ambassador_register($msg = '', $email = '', $bar_id_orig = '') {
        if (check_user_authentication() != '') {
            redirect('home');
        }
        
        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);
//        $data["reset_email"] = base64_decode($email);
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        
//        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');

        if ($_POST) {
//            if ($this->form_validation->run() == FALSE) {
//                if (validation_errors()) {
//                    $data["error"] = validation_errors();
//                } else {
//                    $data["error"] = "";
//                }
//
////                $data["bar_id"] = $this->input->post('bar_id');
//                $data["phone_number"] = $this->input->post('phone_number');
//            } else {
                $account_sid = 'AC5d7f1511f026bd36a6d3eac9cb2a2d82';
                $auth_token = 'd79f765dae55cbf3755b261e6d47e222';
                $client = new TwilioClient($account_sid, $auth_token);
                $phone_number = $this->input->post('phone_number');
                $claim_code = rand(100000, 999999);
//                $bar_update = array('claim_code' => $claim_code, 'claim_phone' => $phone_number);
                $body = 'Here is your ambassador verification code for American Bars: ' . $claim_code;

                try {
                    $client->account->messages->create($phone_number, array(
                        'from' => '+13102725642',
                        'body' => $body,
                            )
                    );
                } catch (Exception $e) {
                    $data["error"] = "Connectivity Error";
                }
                
                if ($data["error"] == null) {
                    if ($this->input->post('temp_id') == "") {
                        redirect('home/claim_bar_owner_verify_code/' . "/" . base64_encode($bar_id));
                    } else {
                        $barid = $this->input->post('temp_id');
                        redirect('home/claim_bar_owner_verify_code/' . "/" . base64_encode($bar_id));
                    }
                }
//            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/ambassador/verification_form', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function claim_bar_owner_register($msg = '', $email = '', $bar_id_orig = '') {
        if (check_user_authentication() != '') {
            redirect('home');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);
        $data["reset_email"] = base64_decode($email);
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $bar_id = '';
        $data['new_bar_id'] = $bar_id_orig;
        $data['get_cat'] = $this->home_model->barCategory();

        if ($bar_id_orig != '') {
            $bar_id = base64_decode($bar_id_orig);
            $this->session->set_userdata(array('viewid' => $bar_id));
            $data['getbardata'] = $this->home_model->getBarData($bar_id);

            $data["bar_id"] = $data['getbardata']['bar_id'];
            $data["bar_title"] = $data['getbardata']['bar_title'];
            $data["address"] = $data['getbardata']['address'];
            $data["city"] = $data['getbardata']['city'];
            $data["zip"] = $data['getbardata']['zipcode'];
            $data["state"] = $data['getbardata']['state'];
            $data["bar_meta_title"] = $data['getbardata']['bar_meta_title'];
            $data["bar_meta_keyword"] = $data['getbardata']['bar_meta_keyword'];
            $data["bar_meta_description"] = $data['getbardata']['bar_meta_description'];
        } else {
            $bar_id = $this->session->userdata('viewid');

            if ($bar_id == '') {
                redirect('home');
            }
        }

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }

                $data["bar_id"] = $this->input->post('bar_id');
                $data["phone_number"] = $this->input->post('phone_number');
            } else {

                $bar_id = $this->input->post('bar_id');
                $account_sid = 'AC5d7f1511f026bd36a6d3eac9cb2a2d82';
                $auth_token = 'd79f765dae55cbf3755b261e6d47e222';
                $client = new TwilioClient($account_sid, $auth_token);
                $phone_number = $this->input->post('phone_number');
                $claim_code = rand(100000, 999999);
                $bar_update = array('claim_code' => $claim_code, 'claim_phone' => $phone_number);
                $body = 'Here is your verification code for American Bars: ' . $claim_code;

                try {
                    $client->account->messages->create($phone_number, array(
                        'from' => '+13102725642',
                        'body' => $body,
                            )
                    );

                    $this->db->where('bar_id', $bar_id);
                    $this->db->update('bars', $bar_update);
                } catch (Exception $e) {
                    $data["error"] = "Connectivity Error";
                }

                if ($data["error"] == null) {
                    if ($this->input->post('temp_id') == "") {
                        redirect('ambassador/verify_code/'));
                    } else {
                        $barid = $this->input->post('temp_id');
                        redirect('ambassador/verify_code/');
                    }
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/claim_bar_owner_register', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }
}
