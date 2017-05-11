<?php

    require_once(APPPATH . 'libraries/Twilio/autoload.php');
    require_once(APPPATH . 'libraries/Twilio/Rest/Client.php');
    use Twilio\Rest\Client as TwilioClient;

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
                        
        echo '<script>console.log("TEST")</script>';


    }
    
        function verification_form($msg = '', $phone_number = '') {

        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);
    //        $data["reset_email"] = base64_decode($email);
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

//        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        echo '<script>console.log("TEST")</script>';
        if ($_POST) {
            echo '<script>console.log("HERE")</script>';
//            if ($this->form_validation->run() == FALSE) {
//            
//                echo '<script>console.log("BAD FORM")</script>';
//
//                if (validation_errors()) {
//                    $data["error"] = validation_errors();
//                } else {
//                    $data["error"] = "";
//                }

//                $data["bar_id"] = $this->input->post('bar_id');
//                $data["phone_number"] = $this->input->post('phone_number');
//            } else {
                echo '<script>console.log("GOOD")</script>';
                $account_sid = 'AC5d7f1511f026bd36a6d3eac9cb2a2d82';
                $auth_token = 'd79f765dae55cbf3755b261e6d47e222';
                $client = new TwilioClient($account_sid, $auth_token);
                echo '<script>console.log("GOOD")</script>';
                $phone_number = $this->input->post('phone_number');
                echo '<script>console.log("#: " + <?php echo $phone_number; ?>)</script>';
                if ($phone_number == '') {
                    redirect('home');
                }
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
                        redirect('ambassador/verify_code/');
                    } else {
                        $barid = $this->input->post('temp_id');
                        redirect('ambassador/verify_code/');
                    }
                }
//            }
        }
//        $this->template->write ('pageTitle', $pageTitle, TRUE);
//        $this->template->write ('metaDescription', $metaDescription, TRUE);
//        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
//        $this->load->library ('form_validation');
//
//        $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
//        $this->template->write_view ('content_center', $theme.'/ambassador/verification_form/', $data, TRUE);
//        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
//        $this->template->render();
    }
    function verify_code($msg = "") {
        
        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);
    //        $data["reset_email"] = base64_decode($email);
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
//        $data['error'] = '';
//        $data["active_menu"]='';
//        $data['site_setting'] = site_setting ();
//
//        $theme = getThemeName ();
//        $this->template->set_master_template ($theme.'/template.php');
//
//        $page_detail=meta_setting();
//        $pageTitle=$page_detail->title;
//        $metaDescription=$page_detail->meta_description;
//        $metaKeyword=$page_detail->meta_keyword;
//
//        $this->template->write ('pageTitle', $pageTitle, TRUE);
//        $this->template->write ('metaDescription', $metaDescription, TRUE);
//        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
//        $this->load->library ('form_validation');
//
//        $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
//        $this->template->write_view ('content_center', $theme.'/ambassador/verify_code', $data, TRUE);
//        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
//        $this->template->render();
    }
}
