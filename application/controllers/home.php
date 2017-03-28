<?php

require(APPPATH . 'PayPal-PHP-SDK/paypal/rest-api-sdk-php/sample/bootstrap.php');
require_once(APPPATH . 'libraries/Twilio/autoload.php');
require_once(APPPATH . 'libraries/Twilio/Rest/Client.php');
require_once(APPPATH . 'libraries/facebook-sdk-v5/autoload.php');

// require(APPPATH.'Paypal/bootstrap.php');
// //require(APPPATH.'PayPal/vendor/autoload.php');
// //require ('Paypal/common.php');
//require(APPPATH.'Paypal/bootstrap.php');
use PayPal\Api\CreditCard;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
use Twilio\Rest\Client as TwilioClient;

require(APPPATH . 'Paypal-PayFlow-API-Wrapper-Class-master/Class.PayFlow.php');

class Home extends SPACULLUS_Controller {
    /*
      Function name :Home()
      Description :Its Default Constuctor which called when home object initialzie.its load necesary models
     */

    function Home() {



        parent :: __construct();
        $this->load->library("PasswordHash");
        $this->load->library("encrypt");
        $this->load->model('home_model');
        $this->load->model('bar_model');
        $this->load->model('user_model');
        $this->load->helper("cookie");
        $this->load->library('fb_connect');
        $this->config->load('facebook');
//
//
        $getpaypalsetting = paypalsetting();

        $this->apiContext = new ApiContext(
                new OAuthTokenCredential(
                $getpaypalsetting->client_id, $getpaypalsetting->secret_key
                )
        );


        $this->apiContext->setConfig(
                array(
                    'mode' => $getpaypalsetting->site_status,
                    'http.ConnectionTimeOut' => 30,
                    'log.LogEnabled' => true,
                    'log.FileName' => FCPATH . 'application/logs/PayPal.log',
                    'log.LogLevel' => 'FINE'
                )
        );
    }

    public function index($msg = '') {

        //echo "<script l$this->fb_connectanguage=\"javascript\">alert('test');</script>";
        //$this->cart->destroy();
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $data['ms'] = base64_decode($msg);



        // echo md5($data['site_setting']->site_name.time());
        // die; 
        $data['active_menu'] = 'home';
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->load->helper('recaptchalib');
        $publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
        $privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
        $resp = null;
        $error = null;
        $captcha_error = '';

        $data['captcha_img'] = recaptcha_get_html($publickey, $error);
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['email'] = $this->input->post('email');
        $data['user_name'] = $this->input->post('user_name');
        $data['gallery'] = $this->home_model->getBannerGallery();
        $data['latest_news'] = $this->home_model->latestmews(10, '');

        $data['latest_event'] = $this->home_model->latestevent(10);
        $data["recent_blog"] = $this->home_model->getrecentblog();
        //$data['latest_forum']  = $this->home_model->latestforum();
        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/home/index', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function signup($msg = '') {
        if (check_user_authentication() != '') {
            redirect('home');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data['msg'] = '';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check_enthuser');
        $this->form_validation->set_rules('user_name', 'User Name', 'required|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_password_check');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            $data['first_name'] = $this->input->post('first_name');
            $data['last_name'] = $this->input->post('last_name');
            $data['email'] = $this->input->post('email');
            $data['user_name'] = $this->input->post('user_name');
        } else {
            $password = md5($this->input->post("password"));
            $data_insert = array();
            $data_insert['first_name'] = $this->input->post('first_name');
            $data_insert['last_name'] = $this->input->post('last_name');
            $data_insert['email'] = $this->input->post('email');
            $data_insert['password'] = $password;
            $data_insert["status"] = "inactive";
            $data_insert['user_name'] = $this->input->post('user_name');
            $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
            $data_insert['sign_up_date'] = date('Y-m-d H:i:s');

            $login = $this->home_model->insert_user($data_insert, $this->input->post("password"));
            $msg = 'insert';
            $msg = base64_encode("signup_sucess");
            redirect('home/login/' . $msg);
        }
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/signup', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    /** password check function
     * 
     * author : Thais
     */
    public function password_check($str) {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {

            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', 'The password can only contain alphanumeric characters');
            return FALSE;
        }
    }

    /** login function
     * 
     * author : Thais
     */
    function login($msg = '', $email = '') {

        redirect('home');

        $data["email"] = get_cookie('email');
        $data["password"] = $this->encrypt->decode(get_cookie('password'));
        $data["remember_me"] = get_cookie('remember_me');
        $theme = getThemeName();

        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);

        $data["reset_email"] = base64_decode($email);

        $data["maximum_attemp_cond"] = '';

        $this->template->set_master_template($theme . '/template.php');


        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }


                $data["email"] = $this->input->post('email');
                $data["password"] = $this->input->post('password');
                $data["remember_me"] = $this->input->post('remember_me');
            } else {


                $login = $this->home_model->check_login($this->input->post('email'), $this->input->post('password'), $this->input->post('remember_me'));

                if ($login == '1') {

                    $REDIRECT_URL = $this->session->userdata("REDIRECT_PAGE");
                    $this->session->unset_userdata("REDIRECT_PAGE");

                    if ($REDIRECT_URL != "") {
                        redirect($REDIRECT_URL);
                    }
                    redirect('home/dashboard');
                } elseif ($login == 0) {
                    $data['error'] = INACTIVE_ACCOUNT;
                } else {
                    $data["msg"] = "invalid";
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/login', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function dashboard($msg = '') {

        if (get_authenticateUserID() == '') {
            redirect('home');
        }

        if ($this->session->userdata('user_type') != 'bar_owner' && $this->session->userdata('user_type') != 'taxi_owner' && get_authenticateUserID()) {
            redirect('home/user_dashboard');
        }

        if ($this->session->userdata('user_type') != 'bar_owner' && $this->session->userdata('user_type') != 'user' && get_authenticateUserID()) {
            redirect('home/taxi_owner_dashboard');
        }
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $data['theme'] = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $data['active_menu'] = 'home';

        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
        //echo get_authenticateUserID();
        //print_r($data['getbar']);
        //die;
        $data['getpostcard'] = $this->home_model->get_bar_postcard($data['getbar']['bar_id'], '4');
        $data['getorder'] = $this->home_model->get_bar_order($data['getbar']['bar_id'], '4');
        $data['get_cat'] = $this->home_model->barCategory();
        $data['one_user'] = $this->home_model->get_availability_time($data['getbar']['bar_id']);
        $data['albumgallery'] = $this->bar_model->getAllBarGal($data['getbar']['bar_id']);
        $data['result'] = $this->bar_model->getAllComments($data['getbar']['bar_id'], $offset = 0, $limit = 4);
        $data['resultmessage'] = $this->bar_model->getUnreadMessage($offset = 0, $limit = 4);
        $data['getalldata'] = $this->home_model->getOneUser();
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/dashboard', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function taxi_owner_dashboard($msg = '') {
        if ($this->session->userdata('user_type') == 'bar_owner') {
            redirect('home/dashboard');
        }
        if ($this->session->userdata('user_type') == 'user') {
            redirect('home/user_dashboard');
        }
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $data['theme'] = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $data['active_menu'] = 'home';

        $data['getalldata'] = get_user_info_taxi(get_authenticateUserID());
        $data['albumgallery'] = $this->user_model->getalbumgallery(get_authenticateUserID());
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/dashboard_taxi_owner', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function user_dashboard($msg = '') {

        if ($this->session->userdata('user_type') == 'bar_owner') {
            redirect('home/dashboard');
        }
        if ($this->session->userdata('user_type') == 'taxi_owner') {
            redirect('home/taxi_owner_dashboard');
        }
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $data['theme'] = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $data['active_menu'] = 'home';

        $data['getalldata'] = get_user_info(get_authenticateUserID());
        $data['albumgallery'] = $this->user_model->getalbumgallery(get_authenticateUserID());
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/dashboard_user', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function bar_owner_register($type = '') {

        if (check_user_authentication() != '') {
            redirect('home');
        }


        $theme = getThemeName();
        $data['error'] = '';
        //$data['bar_id'] = $bar_id;
        $data["active_menu"] = '';
        $data["type"] = $type;
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        //$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
        //$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
        //$data['one_user'] = $this->home_model->get_availability($bar_id);
        // if($data['getbardatafeature']){
        // $data['getbardatafeature_new'] = $data['getbardatafeature']['feature_id'];
        // }

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('btype', 'Free Listing Or Paid Listing', 'required');


        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                redirect('home/registration_step2/' . base64_encode($this->input->post('btype')));
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step2', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step2($type = '', $bar_id = '', $email = '', $msg = '', $bar_id_orig = '') {


        if (check_user_authentication() != '' || $type == '') {
            redirect('home');
        }

        $theme = getThemeName();

        $data['error'] = '';
        $data["active_menu"] = '';
        $data["type"] = $type;
        $data['site_setting'] = site_setting();
        $data["msg"] = base64_decode($msg);

        $data["reset_email"] = base64_decode($email);


        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        //$bar_id ='';
        $data['get_cat'] = $this->home_model->barCategory();
        if ($bar_id_orig != '') {
            $bar_id_orig = base64_decode($bar_id_orig);
            $this->session->set_userdata(array('viewid_orig' => $bar_id_orig));
            $data['getbardata'] = $this->home_model->getBarData($bar_id_orig);

            //print_r($data['getbardata']);

            $data["email"] = $data['getbardata']['email'];
            $data["bar_title"] = $data['getbardata']['bar_title'];
            //$data["first_name"] = $data['getbardata']['first_name'];
            //$data["last_name"] = $data['getbardata']['last_name'];
            $data["address"] = $data['getbardata']['address'];
            $data["city"] = $data['getbardata']['city'];
            $data["zip"] = $data['getbardata']['zipcode'];
            $data["state"] = $data['getbardata']['state'];
            $data["bar_category"] = explode(',', $data['getbardata']['bar_category']);
            $data["bar_meta_title"] = $data['getbardata']['bar_meta_title'];
            $data["bar_meta_keyword"] = $data['getbardata']['bar_meta_keyword'];
            $data["bar_meta_description"] = $data['getbardata']['bar_meta_description'];
            //$data["zip"] = $data['getbardata']['zip'];
            //$data["desc"] = $data['getbardata']['desc'];
            //$bar_id = $this->session->userdata('viewid_orig');
            //$barid= $this->home_model->register_bar_owner($bar_id);
        } else {
            $bar_id = $this->session->userdata('viewid');
        }

        if ($bar_id != '') {

            $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);


            $data["email"] = $data['getbardata']['email'];
            $data["bar_title"] = $data['getbardata']['bar_title'];
            $data["first_name"] = $data['getbardata']['first_name'];
            $data["last_name"] = $data['getbardata']['last_name'];
            $data["address"] = $data['getbardata']['address'];
            $data["city"] = $data['getbardata']['city'];
            $data["state"] = $data['getbardata']['state'];
            $data["bar_category"] = explode(',', $data['getbardata']['bar_category']);
            //print_r($data["bar_category"]);
            $data["zip"] = $data['getbardata']['zip'];
            $data["desc"] = $data['getbardata']['desc'];
            $data["bar_meta_title"] = $data['getbardata']['bar_meta_title'];
            $data["bar_meta_keyword"] = $data['getbardata']['bar_meta_keyword'];
            $data["bar_meta_description"] = $data['getbardata']['bar_meta_description'];
        }

        //print_r($data["bar_category"]);
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check_baruser');
        //$this->form_validation->set_rules('bar_title', 'Bar Title', 'required|callback_bartitle_check');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|numeric');
        //$this->form_validation->set_rules('desc', 'Description', 'required');
        //$this->form_validation->set_rules('bar_meta_title', 'Meta Title', 'required');
        //$this->form_validation->set_rules('bar_meta_keyword', 'Meta Keyword', 'required');
        //$this->form_validation->set_rules('bar_meta_description', 'Meta Description', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }


                $data["email"] = $this->input->post('email');
                $data["bar_title"] = $this->input->post('bar_title');
                $data["first_name"] = $this->input->post('first_name');
                $data["last_name"] = $this->input->post('last_name');
                $data["address"] = $this->input->post('address');
                $data["bar_category"] = $this->input->post('bar_category');
                $data["city"] = $this->input->post('city');
                $data["state"] = $this->input->post('state');
                $data["zip"] = $this->input->post('zip');
                $data["desc"] = $this->input->post('desc');
                $data["bar_meta_title"] = $this->input->post('bar_meta_title');
                $data["bar_meta_keyword"] = $this->input->post('bar_meta_keyword');
                $data["bar_meta_description"] = $this->input->post('bar_meta_description');
            } else {
                if ($this->input->post('claim_bar_id') != "" && $this->input->post('claim_bar_id') != 0) {
                    //$this->session->set_userdata(array('claim_bar_id' => $claim_bar_id));
                    $this->session->set_userdata('claim_bar_id', $this->input->post('claim_bar_id'));
                } elseif ($this->session->userdata('viewid') != "") {
                    $bar_id = $this->session->userdata('viewid');
                } else {
                    $this->session->unset_userdata('claim_bar_id');
                }

                if ($this->input->post('temp_id') == "") {
                    $barid = $this->home_model->register_bar_owner($type);
                    redirect('home/registration_step3/' . base64_encode($barid) . '/' . $type);
                } else {
                    $barid = $this->home_model->register_bar_owner_update($type);
                    redirect('home/registration_step3/' . base64_encode($barid) . '/' . $type);
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/bar_owner_register', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step3($bar_id = '', $type = '') {

        //print_r($this->session->all_userdata());
        //echo $this->session->userdata('claim_bar_id')."das";
        if ($bar_id != "") {
            $bar_id = base64_decode($bar_id);
            $this->session->set_userdata(array('viewid' => $bar_id));
            $bar_id = $this->session->userdata('viewid');
        } elseif ($this->session->userdata('viewid') != "") {
            $bar_id = $this->session->userdata('viewid');
        }



        if ($bar_id == '' && $type == '') {
            redirect('home/bar_owner_register');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data['type'] = $type;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);


        $data['count'] = 0;
        if (base64_decode($type) == 1) {
            $data['count'] = 6;
            //$count = count(explode(',',$count));
        }
        $data['type'] = $type;
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('choise_bar', 'Choise Bar', 'required');

        if ($_POST) {

            //$barid_new = $this->home_model->register_bar_owner_features();
            if (base64_decode($type) != 0) {
                redirect('home/registration_step4/' . base64_encode($bar_id) . '/' . $type);
            } else {

                $slug = getBarSlug($data['getbardata']['bar_title']);
                $bar_id = $this->session->userdata('viewid');
                $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
                $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
                $pass = randomCode();
                $conf = rand('11111111', '99999999');
                $data_insert['first_name'] = $data['getbardata']['first_name'];
                $data_insert['last_name'] = $data['getbardata']['last_name'];
                $data_insert['email'] = $data['getbardata']['email'];

                $data_insert['gender'] = $data['getbardata']['gender'];
                $data_insert['address'] = $data['getbardata']['address'];


                $data_insert['status'] = 'inactive';
                $data_insert['is_deleted'] = 'no';
                $data_insert['user_type'] = 'bar_owner';

                $data_insert['password'] = md5($pass);
                $data_insert['confirm_code'] = $conf;
                $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
                $data_insert['sign_up_date'] = date('Y-m-d H:i:s');
                $this->db->insert('user_master', $data_insert);
                $uid = mysql_insert_id();
                $data['user_id'] = $uid;
                //

                if (($this->session->userdata('viewid_orig') != '' && $this->session->userdata('viewid_orig') != 0 ) || ( $this->session->userdata('claim_bar_id') != '' && $this->session->userdata('claim_bar_id') != '0')) {
                    $getlat = getCoordinatesFromAddress($data['getbardata']['address'], $data['getbardata']['city'], $data['getbardata']['state']);
                    $data_insert_new['bar_title'] = $data['getbardata']['bar_title'];
                    $data_insert_new['owner_name'] = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                    $data_insert_new['email'] = $data['getbardata']['email'];
                    $data_insert_new['owner_id'] = $uid;
                    $data_insert_new['address'] = $data['getbardata']['address'];
                    $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
                    $data_insert_new['city'] = $data['getbardata']['city'];
                    $data_insert_new['bar_category'] = $data['getbardata']['bar_category'];
                    $data_insert_new['bar_type'] = 'half_mug';
                    $data_insert_new['owner_type'] = 'bar_owner';
                    $data_insert_new['bar_slug'] = $slug;
                    $data_insert_new['state'] = $data['getbardata']['state'];
                    $data_insert_new['zipcode'] = $data['getbardata']['zip'];
                    //$data_insert_new['status'] = 'inactive';
                    $data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
                    $data_insert_new['bar_meta_keyword'] = $data['getbardata']['bar_meta_keyword'];
                    $data_insert_new['date_added'] = date('Y-m-d H:i:s');
                    $data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
                    $data_insert_new["lat"] = $getlat['lat'];
                    $data_insert_new["lang"] = $getlat['lng'];
                    $this->db->where('bar_id', $this->session->userdata('claim_bar_id'));

                    $this->db->update('bars', $data_insert_new);
                    $bar_id = $this->session->userdata('claim_bar_id');

                    $data['one_user'] = $this->home_model->get_availability($bar_id);



                    /* --------- E-mail To Super Admin ---- */

                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Claim Bar'");
                    $email_temp = $email_template->row();

                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;

                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;

                    $email = getsuperadminemail();

                    $barname = ucwords($data['getbardata']['bar_title']);
                    $type = 'Half Mug';
                    $username = ucwords($data['getbardata']['first_name']) . " " . ucwords($data['getbardata']['last_name']);
                    $email_to = $email;

                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{barname}', $barname, $email_message);
                    $email_message = str_replace('{type}', $type, $email_message);
                    $email_message = str_replace('{username}', $username, $email_message);
                    $str = $email_message;
                    $getemail = explode(',', $email);
                    if ($email_temp->status == 'active') {
                        foreach ($getemail as $r) {
                            email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                        }
                    }
                    //email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);


                    /* --------- E-mail To Super Admin ---- */

                    if ($data['one_user']) {
                        foreach ($data['one_user'] as $os) {

                            if ($os->start_from != '') {
                                $f = $os->start_from;
                            } else {
                                $f = '';
                            }
                            if ($os->start_to != '') {
                                $t = $os->start_to;
                            } else {
                                $t = '';
                            }
                            if ($os->is_closed != '') {
                                $c = $os->is_closed;
                            } else {
                                $c = '';
                            }
                            $ava_arr = array("bar_id" => $bar_id1,
                                "days_id" => $os->days_id,
                                "start_from" => $f,
                                "start_to" => $t,
                                "is_closed" => $c,
                                "date_added" => date("Y-m-d H:i:s")
                            );
                            $this->db->insert("bar_hours", $ava_arr);
                        }
                    }
                } else {
                    $getlat = getCoordinatesFromAddress($data['getbardata']['address'], $data['getbardata']['city'], $data['getbardata']['state']);
                    $data_insert_new["lat"] = $getlat['lat'];
                    $data_insert_new["lang"] = $getlat['lng'];
                    $data_insert_new['bar_title'] = $data['getbardata']['bar_title'];
                    $data_insert_new['owner_name'] = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                    $data_insert_new['email'] = $data['getbardata']['email'];
                    $data_insert_new['owner_id'] = $uid;
                    $data_insert_new['address'] = $data['getbardata']['address'];
                    $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
                    $data_insert_new['city'] = $data['getbardata']['city'];
                    $data_insert_new['bar_type'] = 'half_mug';
                    $data_insert_new['owner_type'] = 'bar_owner';
                    $data_insert_new['bar_slug'] = $slug;
                    $data_insert_new['bar_category'] = $data['getbardata']['bar_category'];
                    $data_insert_new['state'] = $data['getbardata']['state'];
                    $data_insert_new['zipcode'] = $data['getbardata']['zip'];
                    $data_insert_new['date_added'] = date('Y-m-d H:i:s');

                    //$data_insert_new['status'] = 'inactive';
                    $data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
                    $data_insert_new['bar_meta_keyword'] = $data['getbardata']['bar_meta_keyword'];
                    $data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
                    $this->db->insert('bars', $data_insert_new);
                    $bar_id1 = mysql_insert_id();

                    $data['one_user'] = $this->home_model->get_availability($bar_id);


                    if ($data['one_user']) {
                        foreach ($data['one_user'] as $os) {

                            if ($os->start_from != '') {
                                $f = $os->start_from;
                            } else {
                                $f = '';
                            }
                            if ($os->start_to != '') {
                                $t = $os->start_to;
                            } else {
                                $t = '';
                            }
                            if ($os->is_closed != '') {
                                $c = $os->is_closed;
                            } else {
                                $c = '';
                            }
                            $ava_arr = array("bar_id" => $bar_id1,
                                "days_id" => $os->days_id,
                                "start_from" => $f,
                                "start_to" => $t,
                                "is_closed" => $c,
                                "date_added" => date("Y-m-d H:i:s")
                            );
                            $this->db->insert("bar_hours", $ava_arr);
                        }
                    }
                }
                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
                $email_temp = $email_template->row();

                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;
                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;
                $email = $data['getbardata']['email'];
                $user_name = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                //$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
                $email_to = $email;
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{user_name}', $user_name, $email_message);
                //$email_message = str_replace('{email}', $email, $email_message);
                //$email_message = str_replace('{password}', $pass, $email_message);
                $email_message = str_replace('{activation_link}', $conf, $email_message);
                $str = $email_message;
                if ($email_temp->status == 'active') {
                    email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                }
                $getfull = gethalmugfeature('fullmug');


                $getrecord = '';
                $i = 1;
                foreach ($getfull as $sct) {

                    $getrecord .= $i . ") " . ucwords($sct->fullmug) . "<br>";
                    $i++;
                }



                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminding Of Full Mug Features'");
                $email_temp = $email_template->row();

                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;
                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;
                $email = $data['getbardata']['email'];
                $user_name = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                //$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
                $email_to = $email;
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{username}', $user_name, $email_message);
                $email_message = str_replace('{featurelist}', $getrecord, $email_message);
                //$email_message = str_replace('{email}', $email, $email_message);
                //$email_message = str_replace('{password}', $pass, $email_message);
                //$email_message = str_replace('{activation_link}', $conf, $email_message);
                $str = $email_message;

                if ($email_temp->status == 'active') {
                    email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                }

                $uid = base64_encode($uid);
                $this->session->set_userdata(array('userid_sess' => $uid));
                $this->session->unset_userdata('viewid_orig');
                $this->session->unset_userdata('claim_bar_id');
                $this->session->unset_userdata('viewid');
                //	$bar_id = $this->session->userdata('viewid');

                redirect('home/registration_step5');
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step3', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function object_to_array($obj) {
        if (is_object($obj))
            $obj = (array) $obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = $this->object_to_array($val);
            }
        } else
            $new = $obj;
        return $new;
    }

    function registration_step4($bar_id = '', $type = '') {
        if (check_user_authentication() != '') {
            redirect('home');
        }

        $bar_id = $this->session->userdata('viewid');

        if ($bar_id == '') {
            redirect('home/bar_owner_register');
        }

        $res = '';
        $getpaypalsetting = paypalsetting();
        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data['type'] = $type;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $site_setting = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
        $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
        $count = 0;
        if ($data['getbardatafeature']) {
            $count = $data['getbardatafeature']['feature_id'];
            //$count = count(explode(',',$count));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cc_type', 'Credit Card Type', 'required');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required');
        $this->form_validation->set_rules('ex_month', 'Month', 'required');
        $this->form_validation->set_rules('ex_year', 'Year', 'required');
        $this->form_validation->set_rules('cvv', 'Cvv', 'required');
        $this->form_validation->set_rules('billing_address1', 'Address1', 'required');
        //$this->form_validation->set_rules('billing_address2', 'Address2', 'required');
        $this->form_validation->set_rules('billing_city', 'City', 'required');
        $this->form_validation->set_rules('billing_state', 'State', 'required');
        $this->form_validation->set_rules('billing_country', 'Country', 'required');
        $this->form_validation->set_rules('billing_zipcode', 'Zipcode', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                //	print_r($getpaypalsetting);
                //$PayFlow = new PayFlow('aDbaDmin', 'PayPal', 'aDbaDmin', 'AmericanBars2016', 'test');
                $PayFlow = new PayFlow($getpaypalsetting->vendor, $getpaypalsetting->partner_name, $getpaypalsetting->paypal_username, $getpaypalsetting->paypal_password, 'recurring');

                $PayFlow->setEnvironment($getpaypalsetting->site_status);                           // test or live
                $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
                $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
                $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
                // Only used for recurring transactions
                $PayFlow->setProfileAction('A');
                $PayFlow->setProfileName('RegularSubscription');
                $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
                //$PayFlow->setProfileStartDate(date('mdY'));
                $PayFlow->setProfilePayPeriod('MONT');
                $PayFlow->setProfileTerm(0);
                $amount = $site_setting->amount;
                if ($this->input->post('type_bar') == 2) {
                    $amount = $site_setting->managed_account_amount;
                }

                $PayFlow->setAmount($amount, FALSE);
                $PayFlow->setCCNumber($this->input->post('card_number'));
                $PayFlow->setCVV($this->input->post('cvv'));
                $PayFlow->setExpiration($this->input->post('ex_month') . substr($this->input->post('ex_year'), 2, 4));


                if ($PayFlow->processTransaction()) {
                    //print_r($PayFlow->getResponse());
                    //	print_r($PayFlow->getResponse())."SD";
                    //die;
                    $res = $PayFlow->getResponse();


                    $slug = getBarSlug($data['getbardata']['bar_title']);
                    $bar_id = $this->session->userdata('viewid');
                    $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
                    $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
                    $pass = randomCode();
                    $conf = rand('11111111', '99999999');
                    $data_insert['first_name'] = $data['getbardata']['first_name'];
                    $data_insert['last_name'] = $data['getbardata']['last_name'];
                    $data_insert['email'] = $data['getbardata']['email'];
                    $data_insert['gender'] = $data['getbardata']['gender'];
                    $data_insert['address'] = $data['getbardata']['address'];
                    $data_insert['billing_address1'] = $this->input->post('billing_address1');
                    $data_insert['billing_address2'] = $this->input->post('billing_address2');
                    $data_insert['billing_city'] = $this->input->post('billing_city');

                    $data_insert['billing_state'] = $this->input->post('billing_state');
                    $data_insert['billing_zipcode'] = $this->input->post('billing_zipcode');
                    $data_insert['billing_country'] = $this->input->post('billing_country');
                    $data_insert['status'] = 'inactive';
                    $data_insert['is_deleted'] = 'no';
                    $data_insert['user_type'] = 'bar_owner';
                    $data_insert['password'] = md5($pass);
                    $data_insert['confirm_code'] = $conf;
                    $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
                    $data_insert['sign_up_date'] = date('Y-m-d H:i:s');
                    $data_insert['expire_date'] = date('Y-m-d', strtotime("+30 days"));
                    $data_insert['credit_card_id'] = $res['PROFILEID'];
                    $data_insert['PNREF'] = $res['RPREF'];
                    $this->db->insert('user_master', $data_insert);
                    $uid = mysql_insert_id();
                    $data['user_id'] = $uid;


                    if (($this->session->userdata('viewid_orig') != '' && $this->session->userdata('viewid_orig') != 0 ) || ( $this->session->userdata('claim_bar_id') != '' && $this->session->userdata('claim_bar_id') != '0')) {
                        $getlat = getCoordinatesFromAddress($data['getbardata']['address'], $data['getbardata']['city'], $data['getbardata']['state']);
                        $data_insert_new["lat"] = $getlat['lat'];
                        $data_insert_new["lang"] = $getlat['lng'];
                        $data_insert_new['bar_title'] = $data['getbardata']['bar_title'];
                        $data_insert_new['owner_name'] = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                        $data_insert_new['email'] = $data['getbardata']['email'];
                        $data_insert_new['owner_id'] = $uid;
                        $data_insert_new['address'] = $data['getbardata']['address'];
                        $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
                        $data_insert_new['city'] = $data['getbardata']['city'];
                        $data_insert_new['bar_category'] = $data['getbardata']['bar_category'];
                        $data_insert_new['bar_type'] = 'full_mug';
                        if ($this->input->post('type_bar') == 2) {
                            $data_insert_new['is_managed'] = 'yes';
                        }
                        $data_insert_new['bar_slug'] = $slug;
                        $data_insert_new['owner_type'] = 'bar_owner';
                        //	$data_insert_new['status'] = 'inactive';
                        $data_insert_new['state'] = $data['getbardata']['state'];
                        $data_insert_new['zipcode'] = $data['getbardata']['zip'];
                        $data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
                        $data_insert_new['bar_meta_keyword'] = $data['getbardata']['bar_meta_keyword'];
                        $data_insert_new['date_added'] = date('Y-m-d h:i:s');
                        $data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
                        $this->db->where('bar_id', $this->session->userdata('claim_bar_id'));
                        $this->db->update('bars', $data_insert_new);
                        $bar_id = $this->session->userdata('claim_bar_id');

                        $data['one_user'] = $this->home_model->get_availability($bar_id);
                        /* --------- E-mail To Super Admin ---- */

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Claim Bar'");
                        $email_temp = $email_template->row();

                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;

                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;

                        $email = getsuperadminemail();

                        $barname = ucwords($data['getbardata']['bar_title']);
                        $type = 'Full Mug';
                        $username = ucwords($data['getbardata']['first_name']) . " " . ucwords($data['getbardata']['last_name']);
                        $email_to = $email;

                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{barname}', $barname, $email_message);
                        $email_message = str_replace('{type}', $type, $email_message);
                        $email_message = str_replace('{username}', $username, $email_message);
                        $str = $email_message;
                        $getemail = explode(',', $email);
                        if ($email_temp->status == 'active') {
                            foreach ($getemail as $r) {
                                email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                            }
                        }
                        //email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);


                        /* --------- E-mail To Super Admin ---- */

                        if ($data['one_user']) {
                            foreach ($data['one_user'] as $os) {

                                if ($os->start_from != '') {
                                    $f = $os->start_from;
                                } else {
                                    $f = '';
                                }
                                if ($os->start_to != '') {
                                    $t = $os->start_to;
                                } else {
                                    $t = '';
                                }
                                if ($os->is_closed != '') {
                                    $c = $os->is_closed;
                                } else {
                                    $c = '';
                                }
                                $ava_arr = array("bar_id" => $bar_id1,
                                    "days_id" => $os->days_id,
                                    "start_from" => $f,
                                    "start_to" => $t,
                                    "is_closed" => $c,
                                    "date_added" => date("Y-m-d H:i:s")
                                );
                                $this->db->insert("bar_hours", $ava_arr);
                            }
                        }
                    } else {

                        $getlat = getCoordinatesFromAddress($data['getbardata']['address'], $data['getbardata']['city'], $data['getbardata']['state']);
                        $data_insert_new["lat"] = $getlat['lat'];
                        $data_insert_new["lang"] = $getlat['lng'];
                        $data_insert_new['bar_title'] = $data['getbardata']['bar_title'];
                        $data_insert_new['owner_name'] = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                        $data_insert_new['email'] = $data['getbardata']['email'];
                        $data_insert_new['owner_id'] = $uid;
                        $data_insert_new['address'] = $data['getbardata']['address'];
                        $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
                        $data_insert_new['city'] = $data['getbardata']['city'];
                        $data_insert_new['bar_type'] = 'full_mug';
                        if ($this->input->post('type_bar') == 2) {
                            $data_insert_new['is_managed'] = 'yes';
                        }
                        $data_insert_new['bar_slug'] = $slug;
                        $data_insert_new['owner_type'] = 'bar_owner';
                        //$data_insert_new['status'] = 'inactive';
                        $data_insert_new['state'] = $data['getbardata']['state'];
                        $data_insert_new['bar_category'] = $data['getbardata']['bar_category'];
                        $data_insert_new['zipcode'] = $data['getbardata']['zip'];
                        $data_insert_new['date_added'] = date('Y-m-d h:i:s');
                        $data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
                        $data_insert_new['bar_meta_keyword'] = $data['getbardata']['bar_meta_keyword'];
                        $data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];


                        $this->db->insert('bars', $data_insert_new);
                        $bar_id1 = mysql_insert_id();
                        $data['one_user'] = $this->home_model->get_availability($bar_id);

                        if ($data['one_user']) {
                            foreach ($data['one_user'] as $os) {

                                if ($os->start_from != '') {
                                    $f = $os->start_from;
                                } else {
                                    $f = '';
                                }
                                if ($os->start_to != '') {
                                    $t = $os->start_to;
                                } else {
                                    $t = '';
                                }
                                if ($os->is_closed != '') {
                                    $c = $os->is_closed;
                                } else {
                                    $c = '';
                                }
                                $ava_arr = array("bar_id" => $bar_id1,
                                    "days_id" => $os->days_id,
                                    "start_from" => $f,
                                    "start_to" => $t,
                                    "is_closed" => $c,
                                    "date_added" => date("Y-m-d H:i:s")
                                );
                                $this->db->insert("bar_hours", $ava_arr);
                            }
                        }
                    }
                    $transar = array('txn_id' => $res['PROFILEID'], 'user_id' => $uid, 'price' => $amount, 'transaction_date' => date('Y-m-d H:i:s'), 'is_deleted' => 'no');
                    $this->db->insert('transaction', $transar);


                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
                    $email_temp = $email_template->row();
                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;
                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;
                    $email = $data['getbardata']['email'];
                    $user_name = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                    $email_to = $email;
                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{user_name}', $user_name, $email_message);
                    //$email_message = str_replace('{email}', $email, $email_message);
                    //$email_message = str_replace('{password}', $pass, $email_message);
                    $email_message = str_replace('{activation_link}', $conf, $email_message);
                    $str = $email_message;

                    if ($email_temp->status == 'active') {

                        email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                    }
                    $uid = base64_encode($uid);



                    $this->session->set_userdata(array('userid_sess' => $uid));
                    $this->session->unset_userdata('viewid_orig');
                    $this->session->unset_userdata('viewid');
                    redirect('home/registration_step5');


                    //die;
                } else {




                    // echo('Transaction could not be processed at this time.');

                    $data["error"] = 'Transaction could not be processed at this time. Please enter proper card details';

                    $data['cc_type'] = $this->input->post('cc_type');
                    $data['card_number'] = $this->input->post('card_number');
                    $data['ex_month'] = $this->input->post('ex_month');
                    $data['ex_year'] = $this->input->post('ex_year');
                    $data['cvv'] = $this->input->post('cvv');
                    $data['type_bar'] = $this->input->post('type_bar');
                    $data['billing_address1'] = $this->input->post('billing_address1');
                    $data['billing_address2'] = $this->input->post('billing_address2');
                    $data['billing_city'] = $this->input->post('billing_city');
                    $data['billing_state'] = $this->input->post('billing_state');
                    $data['billing_country'] = $this->input->post('billing_country');
                    $data['billing_zipcode'] = $this->input->post('billing_zipcode');
                }
            }

            unset($PayFlow);
        }
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step4', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step4_upgrade($bar_id = '', $type = '', $coupon = '') {
        if (check_user_authentication() == '') {
            redirect('home');
        }

        $getpaypalsetting = paypalsetting();
        if ($bar_id == '') {
            redirect('home/claim_bar_owner_register');
        }

        if ($type != 'managed' && $type != 'fullmug') {
            redirect('home/dashboard');
        }

        $res = '';


        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data['type'] = $type;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $site_setting = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['getbardata'] = $this->home_model->getBardata(base64_decode($bar_id));
        if (empty($data['getbardata'])) {
            redirect('home');
        }
        $getuserinfo = get_user_info(get_authenticateUserID());

        if ($coupon == "Cheers25") {
            if ($type == 'fullmug') {
                $site_setting->amount = (string) ((int) $site_setting->amount * 0.5);
            } else if ($type == 'managed') {
                $site_setting->managed_account_amount = (string) ((int) $site_setting->managed_account_amount * 0.5);
            }
        }

        $data['coupon'] = $coupon;
        $data['amount'] = $site_setting->amount;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cc_type', 'Credit Card Type', 'required');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required');
        $this->form_validation->set_rules('ex_month', 'Month', 'required');
        $this->form_validation->set_rules('ex_year', 'Year', 'required');
        $this->form_validation->set_rules('cvv', 'Cvv', 'required');
        $this->form_validation->set_rules('billing_address1', 'Address1', 'required');
        //$this->form_validation->set_rules('billing_address2', 'Address1', 'required');
        $this->form_validation->set_rules('billing_city', 'City', 'required');
        $this->form_validation->set_rules('billing_state', 'State', 'required');
        $this->form_validation->set_rules('billing_country', 'Country', 'required');
        $this->form_validation->set_rules('billing_zipcode', 'Zipcode', 'required');

        if ($_POST) {

            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $PayFlow = new PayFlow($getpaypalsetting->vendor, $getpaypalsetting->partner_name, $getpaypalsetting->paypal_username, $getpaypalsetting->paypal_password, 'recurring');

                $PayFlow->setEnvironment($getpaypalsetting->site_status);                           // test or live
                $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
                $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
                $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
                // Only used for recurring transactions
                $PayFlow->setProfileAction('A');
                $PayFlow->setProfileName('RegularSubscription');
                $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
                //$PayFlow->setProfileStartDate(date('mdY'));
                $PayFlow->setProfilePayPeriod('MONT');
                $PayFlow->setProfileTerm(0);
                $amount = $site_setting->amount;
                if ($type == 'managed') {
                    $amount = $site_setting->managed_account_amount;
                }
                $PayFlow->setAmount($amount, FALSE);
                $PayFlow->setCCNumber($this->input->post('card_number'));
                $PayFlow->setCVV($this->input->post('cvv'));
                $PayFlow->setExpiration($this->input->post('ex_month') . substr($this->input->post('ex_year'), 2, 4));

                if ($PayFlow->processTransaction()) {
                    //print_r($PayFlow->getResponse());
                    //	print_r($PayFlow->getResponse())."SD";
                    //die;
                    $res = $PayFlow->getResponse();
                    show_error(json_encode($res), 200);
                    $is_managed = 'no';
                    if ($type == 'managed') {
                        $is_managed = 'yes';
                    }

                    $data_insert_new = array('bar_type' => 'full_mug', 'is_managed' => $is_managed);
                    $this->db->where('owner_id', get_authenticateUserID());
                    $this->db->update('bars', $data_insert_new);

                    $data_insert['flag'] = 0;
                    $data_insert['expire_date'] = date('Y-m-d', strtotime("+30 days"));
                    $data_insert['credit_card_id'] = $res['PROFILEID'];
                    $data_insert['PNREF'] = $res['RPREF'];
                    $data_insert['billing_address1'] = $this->input->post('billing_address1');
                    $data_insert['billing_address2'] = $this->input->post('billing_address2');
                    $data_insert['billing_city'] = $this->input->post('billing_city');
                    $data_insert['billing_state'] = $this->input->post('billing_state');
                    $data_insert['billing_zipcode'] = $this->input->post('billing_zipcode');
                    $data_insert['billing_country'] = $this->input->post('billing_country');
                    $this->db->where('user_id', get_authenticateUserID());
                    $this->db->update('user_master', $data_insert);


                    $transar = array('txn_id' => $res['PROFILEID'], 'user_id' => get_authenticateUserID(), 'price' => $amount, 'transaction_date' => date('Y-m-d H:i:s'), 'is_deleted' => 'no');
                    $this->db->insert('transaction', $transar);



                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Notification Email Profile Upgrade From Half Mug To Full Mug'");
                    $email_temp = $email_template->row();
                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;
                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;
                    $email = getsuperadminemail();
                    $email_to = $email;
                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{username}', ucwords($getuserinfo->first_name . " " . $getuserinfo->last_name), $email_message);
                    $email_message = str_replace('{barname}', $data['getbardata']['bar_title'], $email_message);
                    $email_subject = str_replace('{barname}', $data['getbardata']['bar_title'], $email_subject);
                    $str = $email_message;
                    //email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                    $getemail = explode(',', $email);
                    if ($email_temp->status == 'active') {
                        foreach ($getemail as $r) {
                            email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                        }
                    }
                    //$this->session->set_userdata(array('userid_sess' => $uid));


                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Profile Upgrade Successfully'");
                    $email_temp = $email_template->row();
                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;
                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;
                    $email = $getuserinfo->email;
                    $email_to = $email;
                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{username}', ucwords($getuserinfo->first_name . " " . $getuserinfo->last_name), $email_message);
                    $email_message = str_replace('{barname}', $data['getbardata']['bar_title'], $email_message);
                    $email_subject = str_replace('{barname}', $data['getbardata']['bar_title'], $email_subject);
                    $str = $email_message;
                    if ($email_temp->status == 'active') {
                        email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                    }
                    $this->session->unset_userdata('viewid_orig');
                    $this->session->unset_userdata('viewid');
                    redirect('home/success_page/' . base64_encode(get_authenticateUserID()));
                } else {
                    $data["error"] = "Please Enter proper credit card details.";
                    $data['cc_type'] = $this->input->post('cc_type');
                    $data['card_number'] = $this->input->post('card_number');
                    $data['ex_month'] = $this->input->post('ex_month');
                    $data['ex_year'] = $this->input->post('ex_year');
                    $data['cvv'] = $this->input->post('cvv');
                    $data['billing_address1'] = $this->input->post('billing_address1');
                    $data['billing_address2'] = $this->input->post('billing_address2');
                    $data['billing_city'] = $this->input->post('billing_city');
                    $data['billing_state'] = $this->input->post('billing_state');
                    $data['billing_country'] = $this->input->post('billing_country');
                    $data['billing_zipcode'] = $this->input->post('billing_zipcode');
                }
            }
        }
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step4_upgrade', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step5() {

        $this->session->unset_userdata('viewid');
        $uid = $this->session->userdata('userid_sess');
        if ($uid == '') {
            redirect('home/bar_owner_register');
        }


        $theme = getThemeName();
        $data['error'] = '';
        //$data['bar_id'] = $bar_id;
        $data['user_id'] = base64_decode($uid);
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');
        $data['get_user_info'] = get_user_info($data['user_id']);

        $this->form_validation->set_rules('code', 'Code', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $user_id = $this->home_model->checkcode();

                if ($user_id != "" && $user_id['confirm_code'] != '') {
                    $pass = randomCode();
                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Successfully Registration'");
                    $email_temp = $email_template->row();
                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;
                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;
                    $email = $data['get_user_info']->email;
                    $user_name = $data['get_user_info']->first_name . " " . $data['get_user_info']->last_name;
                    $email_to = $email;
                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{user_name}', $user_name, $email_message);
                    $email_message = str_replace('{email}', $email, $email_message);
                    $email_message = str_replace('{password}', $pass, $email_message);
                    $str = $email_message;
                    if ($email_temp->status == 'active') {
                        email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                    }
                    $data_up = array('status' => "active", 'confirm_code' => '', 'password' => md5($pass));
                    $this->db->where('user_id', $this->input->post('user_id'));
                    $this->db->update('user_master', $data_up);

                    $data_up12 = array('status' => "active");
                    $this->db->where('taxi_owner_id', $this->input->post('user_id'));
                    $this->db->update('taxi_directory', $data_up12);

                    $data_up1 = array('status' => "active", 'claim' => 'claimed');
                    $this->db->where('owner_id', $this->input->post('user_id'));
                    $this->db->update('bars', $data_up1);
                    $this->session->unset_userdata('userid_sess');


                    redirect('home/success_page/' . base64_encode($this->input->post('user_id')));
                }
                // elseif($user_id['confirm_code']=='') {
                // $this->session->unset_userdata('userid_sess');
                // redirect('home/index/reg_link_expire');
//
                // }
                else {
                    $data["error"] = "<p>Please Enter Correct Confirmation Code .</p>";
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/confirm', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();


        //return $uid;
    }

    function success_page($uid = '') {

        if ($uid == '') {
            redirect('home');
        }
        $theme = getThemeName();
        $data['error'] = '';
        //$data['msg'] = $msg;

        $data['user_info'] = get_user_info(base64_decode($uid));
        if ($data['user_info'] == '') {
            redirect('home');
        }
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        //$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/confirmpage', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function bartitle_check($title) {
        $username = $this->home_model->bar_title_unique($title);
        if ($username == FALSE) {
            $this->form_validation->set_message('bartitle_check', 'There is an existing Bar associated with this Title');
            return FALSE;
        }
        return TRUE;
    }

    function forgetpassword_ajax() {
        $theme = getThemeName();
        $data['error'] = '';
        $data["msg"] = '';
        $data['active_menu'] = '';
        $this->template->set_master_template($theme . '/template.php');

        $meta_setting = meta_setting();
        $pageTitle = $meta_setting->title;
        $metaDescription = $meta_setting->meta_description;

        $metaKeyword = $meta_setting->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            $data["email"] = $this->input->post('email');
        } else {
            $message = $this->home_model->user_forgot_password($this->input->post('email'), $this->input->post('type'));

            if ($message == "success") {
                $data['msg'] = "success";
            } else if ($message == "inactive") {
                $data['error'] = "<p>Your account is Inactive. Please, Contact to your Administrator.</p>";
            } else if ($message == "suspend") {
                $data['error'] = "<p>Your account is Suspended. Please, Contact to your Administrator.</p>";
            } else {
                $data['error'] = "<p>Email Address Not Found.</p>";
            }
        }

        echo json_encode($data);
        exit;
        // $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
        // $this->template->write_view('content_center',$theme .'/layout/common/forget_password',$data,TRUE);
        // $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
        // $this->template->render();
    }

    function login_ajax($msg = "") {
        $this->load->helper('cookie');
        $data["email"] = get_cookie('email');
        $data["password"] = get_cookie('password');
        $data["remember_me"] = get_cookie('remember_me');
        $data['active_menu'] = '';
        $theme = getThemeName();

        $data['error'] = '';
        $data["msg"] = $msg;

        $this->template->set_master_template($theme . '/template.php');

        $meta_setting = meta_setting();

        $pageTitle = 'Login - ' . $meta_setting->title;
        $metaDescription = $meta_setting->meta_description;
        $metaKeyword = $meta_setting->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        //$data["account_type"]='';

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            //echo $data["password"];die;
            if ($_POST) {
                $data["email"] = $this->input->post('email');
                $data["password"] = $this->input->post('password');
                $data["remember_me"] = $this->input->post('remember_me');
            }
        } else {


            $this->load->helper('cookie');
            $login = $this->home_model->check_login(trim($this->input->post('email')), trim($this->input->post('password')), $this->input->post('remember_me'), $this->input->post('type'));


            //$getuserinfo = get_user_info(get);
            if ($login == '1') {


                $REDIRECT_URL = $this->session->userdata("REDIRECT_PAGE");
                $this->session->unset_userdata("REDIRECT_PAGE");


                if ($REDIRECT_URL != "") {
                    $data['redirectpage'] = $this->session->unset_userdata("REDIRECT_PAGE");
                }
                $data['msg'] = "success";
                $data['user_type'] = $this->session->userdata("user_type");
                $data['user_id'] = get_authenticateUserID();

                if ($this->session->userdata("user_type") == 'bar_owner') {
                    $data['redirectpage'] = 'home/dashboard';
                } else {
                    $data['redirectpage'] = 'user/profile/' . base64_encode($data['user_id']);
                }
            } else if ($login == '0') {

                $data['error'] = INACTIVE_ACCOUNT;
            } else if ($login == '2') {

                $data['error'] = 'Invalid User Type';
            } else {
                $data["error"] = "Invalid Username Or Password.";
            }

            //echo json_encode($data);
            //exit;
        }
        echo json_encode($data);
        exit;
    }

    /** user activation function
     * @return null
     * author: sanjay Amin
     */
    function activation($code) {

        $user_type = '';
        $org_code = base64_decode($code);
        $org_code_arr = explode("1@1", $org_code);
        $uid = $org_code_arr[0];
        $code_org = $org_code_arr[1];

        if (isset($org_code_arr[2])) {
            $user_type = $org_code_arr[2];
        }

        $check = $this->home_model->check_user_activation($uid, $code_org);

        if ($check == 1) {
            $msg = base64_encode("activate");
        } else {

            $msg = base64_encode("expired");
        }

        redirect("home/index/" . $msg);
    }

    /** logout function
     * @return null
     * author: Thais
     */
    function logout() {

        if (get_authenticateUserID() != '' && $this->session->userdata('login_history_id') != "") {

            $usl = array(
                'logout_date_time' => date('Y-m-d H:i:s'),
                'login_status' => 'offline'
            );
            $this->db->where('login_id', $this->session->userdata('login_history_id'));
            $this->db->update('user_login', $usl);
        }

        $this->session->sess_destroy();
        redirect("home");
    }

    /** email_check function
     * check unique email
     * @return booloean
     * author: Thais
     */
    function email_check($email) {

        $email = $this->home_model->email_unique($email);
        if ($email == FALSE) {
            $this->form_validation->set_message('email_check', 'There is an existing record with this Email Address');
            return FALSE;
        }
        return TRUE;
    }

    function email_check_taxiuser($email) {

        $email = $this->home_model->email_unique($email, 'taxi_owner');
        if ($email == FALSE) {
            $this->form_validation->set_message('email_check_taxiuser', 'There is an existing record with this Email Address');
            return FALSE;
        }
        return TRUE;
    }

    function email_check_baruser($email) {

        $email = $this->home_model->email_unique($email, 'bar_owner');

        if ($email == FALSE) {
            $this->form_validation->set_message('email_check_baruser', 'There is an existing record with this Email Address');
            return FALSE;
        }
        return TRUE;
    }

    function email_check_enthuser($email) {

        $email = $this->home_model->email_unique($email, 'user');
        if ($email == FALSE) {
            $this->form_validation->set_message('email_check_enthuser', 'There is an existing record with this Email Address');
            return FALSE;
        }
        return TRUE;
    }

    function username_check($name) {
        $username = $this->home_model->register_unique($name);
        if ($username == FALSE) {
            $this->form_validation->set_message('username_check', 'There is an existing record with this User Name');
            return FALSE;
        }
        return TRUE;
    }

    /** function : forget paassword
     *  author : Pokatalk
     */
    function forget_password($type = '') {
        $type = base64_decode($type);
        if (check_user_authentication() != '') {
            redirect('home');
        }

        $theme = getThemeName();

        $data['error'] = '';
        $data["msg"] = '';
        $data["active_menu"] = '';
        $this->template->set_master_template($theme . '/template.php');

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $pageTitle = 'forget_password';
        $metaDescription = '';
        $metaKeyword = '';
        $data['site_setting'] = site_setting();

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);


        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
                $data["email"] = $this->input->post('email');
            } else {



                $message = $this->home_model->user_forgot_password($this->input->post('email'));

                if ($message == "success") {
                    $msg = base64_encode("forget");
                    $email_encode = base64_encode($this->input->post('email'));
                    if ($type != "doctor") {
                        redirect('home/login/' . $msg . '/' . $email_encode);
                    } else {
                        redirect('home/professional_login/' . $msg . '/' . $email_encode);
                    }
                } else
                if ($message == "inactive") {
                    $data['error'] = INACTIVE_ACCOUNT;
                } else
                if ($message == "suspend") {
                    $data['error'] = ACCOUNT_SUSPEND;
                } else {
                    $data['error'] = EMAIL_NOT_FOUND;
                }
            }
        }
        $data["type"] = $type;
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/common/forget_password', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    /** function : reset_password
     * author : Pokatalk
     * 
     */
    function reset_password($id = 0, $msg = '') {
        $uid = base64_decode($id);
        $type = '';

        $check_forgot_password = $this->home_model->check_forgot_passwordflag($uid, $type);

        if ($check_forgot_password == 0) {
            redirect("home/login/" . base64_encode('set'));
        }
        $theme = getThemeName();

        $data['error'] = '';
        $data["msg"] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;


        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->load->library('form_validation');
        //	$this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('rpassword', 'New Password', 'required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('confirm_password', 'confirm New Password', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                $data["error"] = '';

                if (validation_errors()) {
                    $data["error"] .= validation_errors();
                } else {

                    $data["error"] .= "";
                }

                $data["rpassword"] = $this->input->post('rpassword');
                $data["confirm_pssword"] = $this->input->post('confirm_pssword');
            } else {
                $message = $this->home_model->reset_password($this->input->post("rpassword"), $uid, $type);
                if ($message == "1") {
                    $msg = base64_encode("reset");
                    redirect('home/index/' . $msg);
                    /*
                      if($type=='doctor')
                      {
                      redirect('home/login/' . $msg);
                      }
                      else {
                      redirect('home/login/' . $msg);
                      } */
                }
            }
        }
        $data["msg"] = $msg;
        $data["user_id"] = $uid;
        $data["type"] = $type;

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/common/reset_password', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function page($slug = '') {

        if ($slug == '') {
            redirect('home');
        }

        $data = array();
        $site_setting = site_setting();
        $data['site_setting'] = $site_setting;
        $data['active_menu'] = $slug;

        $result = get_page_info($slug);
        if (!$result) {
            redirect('home');
        }

        $data['result'] = $result;

        $theme = getThemeName();
        $page_detail = meta_setting();
        $pageTitle = $result->pages_title;
        $metaDescription = $result->meta_description;
        $metaKeyword = $result->meta_keyword;
        $this->template->set_master_template($theme . '/template.php');
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/common/page', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    /* Function : FAQ
     * Display all faq from admin side */

    function faq($keyword = "1v1") {


        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'faq';

        if ($_POST) {
            $keyword = $this->input->post("keyword");
        }

        $data["all_faq"] = $this->home_model->get_all_faq($keyword);
        $data["keyword"] = $keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/home/faq', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    /* Function : FAQ
     * Display all faq from admin side */

    function contactus($msg = '') {


        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'contactus';
        $data["error"] = "";
        $data["msg"] = $msg;
        $data["site_setting"] = site_setting();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'nom', 'required');
        $this->form_validation->set_rules('last_name', 'Prenom', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Sujet', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');




        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                    $data['name'] = $this->input->post('name');
                    $data['last_name'] = $this->input->post('last_name');
                    $data['email'] = $this->input->post('email');
                    $data['subject'] = $this->input->post('subject');
                    $data['message'] = $this->input->post('message');
                } else {
                    $data["error"] = "";
                    $data['name'] = '';
                    $data['last_name'] = "";
                    $data['email'] = '';
                    $data['subject'] = '';
                    $data['message'] = '';
                }
            } else {

                $name = $this->input->post('name');
                $last_name = $this->input->post('last_name');
                $email = $this->input->post('email');
                $subject = $this->input->post('subject');
                $message = $this->input->post('message');
                $result = $this->home_model->insert_inquiry($name, $last_name, $email, $subject, $message);
                $msg = "success";
                redirect('contact-us/' . $msg);
            }
        } else {
            $data['name'] = '';
            $data['last_name'] = "";
            $data['email'] = '';
            $data['subject'] = '';
            $data['message'] = 'Votre message';
        }


        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/common/contactus', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function add_contact() {
        $name = $_REQUEST["name"];
        $last_name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $subject = $_REQUEST["subject"];
        $message = $_REQUEST["message"];

        $this->home_model->insert_inquiry($name, $last_name, $email, $subject, $message);

        echo "Contact us inquiry send successfully.";
    }

    /*
     * function : newsletter();
     * inseret news letter data 
     * author: Thais
     */

    function newsletter() {
        $result = $this->home_model->insert_newsletter($_POST);
        $set = site_setting();
        $apikey = $set->mailchimp_apikey;
        $my_email = $this->input->post('email');
        // A List Id to run examples against. use lists() to view all
        // Also, login to MC account, go to List, then List Tools, and look for the List ID entry
        $listId = $set->newsletter_mailchimp_listid;

        $api = new MCAPI($apikey);
        $merge_vars = array('FNAME' => $this->input->post('first_name'),
            'LNAME' => $this->input->post('last_name'),
            'INTERESTS' => '');
        $retval = $api->listSubscribe($listId, $my_email, $merge_vars);

        if ($api->errorCode) {
            //$data['error'] ="Unable to load listSubscribe()!\n";
            //  echo "\tCode=".$api->errorCode."\n";
            // echo "\tMsg=".$api->errorMessage."\n";
        } else {
            //echo "Returned: ".$retval."\n";
        }
        echo $result;

        die;
    }

    ////////////////////facebook///////////////////////////////////////


    function social_signup($social_data = array()) {

        $data = array();
        $data['fb_img'] = '';
        ini_set('memory_limit', -1);
        ini_set('memory_size', -1);
        ini_set('max_execution_time', 0);

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $site_setting = site_setting();
        $meta_setting = meta_setting();

        $pageTitle = 'Facebook Register for - ' . $meta_setting->title;
        $metaDescription = 'Facebook Register for - ' . $meta_setting->meta_description;
        $metaKeyword = 'Facebook Register for - ' . $meta_setting->meta_keyword;




        if ($social_data) {

            $data['first_name'] = $social_data['first_name'];
            $data['last_name'] = $social_data['last_name'];
            $data['email'] = $social_data['email'];
            $data['password'] = '';
            $data['fb_id'] = $social_data['fb_id'];
            if (isset($social_data['fb_img']))
                $data['image'] = $social_data['fb_img'];
            $data['gender'] = $social_data['gender'];
            $data['birthday'] = $social_data['birthday'];
            $data['verified'] = $social_data['verified'];
            $data["user_type"] = "user";
            $data["verify_email"] = "1";


            //	$password=randomCode();
            $pass = randomCode();
            //$password = $this->passwordhash->hash ($pass);
            $password = md5($pass);
            $data_user['first_name'] = $social_data['first_name'];
            $data_user['last_name'] = $social_data['last_name'];
            $data_user['email'] = $social_data['email'];
            $data_user['fb_id'] = $social_data['fb_id'];
            $data_user['status'] = "active";
            $data_user['gender'] = $social_data['gender'];
            $data_user['password'] = $password;
            $data_user["profile_image"] = $social_data['fb_img'];
            $data_user["user_type"] = "user";
            $data_user["verify_email"] = "1";
            //$data_user["right_upload"] = "no";

            if ($social_data['birthday'] != '') {
                if (explode('/', $social_data['birthday'])) {
                    $bdd = explode('/', $social_data['birthday']);
                    $dob = $bdd[2] . '-' . $bdd[0] . '-' . $bdd[1];
                }
            }


            $data_user["birthdate"] = date("Y-m-d", strtotime($dob));

            $this->db->insert('user_master', $data_user);
            $uid = mysql_insert_id();
            $data["user_id"] = $uid;

            $data = array(
                'user_id' => $uid,
                'fb_id' => $social_data['fb_id'],
                'email' => $social_data['email'],
                'username' => $social_data['first_name'],
                "user_type" => "user",
                    // "right_upload" => "no",
            );
            $this->session->set_userdata($data);

            //04/18/1990
            //$data["countrylist"]=get_all_country();
            /* Mail Send */
            $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Sign up with Facebook'");
            $email_temp = $email_template->row();


            $email_address_from = $email_temp->from_address;
            $email_address_reply = $email_temp->reply_address;

            $email_subject = $email_temp->subject;
            $email_message = $email_temp->message;

            $email = $social_data['email'];

            //$password = $this->input->post('password');
            $user_name = $social_data['first_name'] . " " . $social_data['last_name'];

            $email_to = $email;
            //$login_link= base_url().'home/activate/'.$uid."/".$confirm_code;
            $login_link = '<a href=' . base_url() . 'home>Here</a>';

            $email_message = str_replace('{break}', '<br/>', $email_message);
            $email_message = str_replace('{user_name}', $user_name, $email_message);
            $email_message = str_replace('{email}', $email, $email_message);
            $email_message = str_replace('{password}', $pass, $email_message);
            $email_message = str_replace('{login_link}', $login_link, $email_message);

            $str = $email_message;


            /** custom_helper email function * */
            //echo $str; die; 
            if ($email_temp->status == 'active') {
                email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
            }
            redirect("user/myprofile");
            /* End mail send */
        } else {
            redirect('home/socialfail');
        }
    }

    function customersignup($msg = '') {

        $site_setting = site_setting();
        $theme = getThemeName();

        $data['error'] = '';
        $data["msg"] = $msg;
        $data['active_menu'] = '';

        $this->template->set_master_template($theme . '/template.php');


        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('nick_name', 'Bar Fly Nickname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check_enthuser');
        $this->form_validation->set_rules('custpassword', 'Password', 'required|min_length[8]|callback_password_check');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
        //$this->form_validation->set_rules('gender','Gender','required');
        //$this->form_validation->set_rules('mobile_no', 'Mobile No', 'required|numeric|min_length[9]|max_length[11]');
        // $this->form_validation->set_rules('question', 'Question', 'required|');
        // if($this->input->post('question')!="")
        // {
        // $this->form_validation->set_rules('answer', 'Answer', 'required|');
        // }
        //$this->form_validation->set_rules('month', 'Month','required|trim|callback_compareDates');

        $imagarr = '';
        if ($_POST) {
            //echo '<pre>';
            //print_r($_FILES);die;

            $start = strtotime($this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('day'));
            //$date = strtotime('2010-01-01 -21 year');
            //$end = strtotime(date('Y-m-d', $date));

            $dt = date('Y-m-d');
            $end = strtotime($dt . '-21 year');
            // echo $start.'<br>';
            // echo $end.'<br>';

            if ($start >= $end) {
                $imagarr = 'Your age must be 21 years or above plese enter proper birth date.';
            }
        }
        if ($this->form_validation->run() == FALSE || $imagarr != '') {

            if (validation_errors() || $imagarr != '') {
                $data["error"] = validation_errors() . $imagarr;
            } else {
                $data["error"] = "";
            }
            if ($_POST) {
                $data["first_name"] = $this->input->post('first_name');
                $data["last_name"] = $this->input->post('last_name');
                $data["email"] = $this->input->post('email');
                $data["nick_name"] = $this->input->post('nick_name');
                $data["custpassword"] = $this->input->post('custpassword');
                $data["confirm_password"] = $this->input->post('confirm_password');
                //$data["phone_no"] = $this->input->post('phone_no');
                //$data["mobile_no"] = $this->input->post('mobile_no');
                $data["number"] = $this->input->post('number');
                $data['msg'] = 'notsuccess';
                // $data["question"] = $this->input->post('question');
                // $data["answer"] =$this->input->post('answer');
            }
        } else {

            $login = $this->home_model->insert_customer();
            $uid = mysql_insert_id();

            if ($uid != "") {
                $data['msg'] = 'success';
            } else {
                $data['msg'] = 'notsuccess';
            }
        }

        echo json_encode($data);
        exit;
    }

    /////////////// end of facebook//////////////////////////////////

    function compareDates() {
        $start = strtotime($this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('day'));
        $end = strtotime(date('Y-m-d'));


        if ($start < $end) {
            $this->form_validation->set_message('compareDates', 'Your age must be 21 years or above plese enter proper birth date.');
            return false;
        }
    }

    function test() {


        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'contactus';
        $data["error"] = "";
        $data["site_setting"] = site_setting();


        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        //   $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/common/test', $data, TRUE);
        //$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render();
    }

    function test_ajax() {
        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'contactus';
        $data["error"] = "";
        $data["site_setting"] = site_setting();


        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        //   $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/common/test123', $data, TRUE);
        //$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render();
    }

    function test_ajax123() {

        // $obj->name = "sadadad";
        //$obj->message = "Hello " . $obj->name;

        echo $_GET['callback'] . '(' . json_encode("dsadsa") . ');';
    }

    function changepassword($msg = '') {
        if (get_authenticateUserID() == '') {
            redirect('home');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('oldpassword', 'Old Password', 'required|');
        $this->form_validation->set_rules('upassword', 'Password', 'required|');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[upassword]');
        $data["msg"] = '';
        $data["error"] = '';
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
        } else {

            $res = $this->home_model->updateUserPassword();
            if ($res) {
                //$data["msg"] = '';
                $data["msg"] = "success";
                //redirect('home/dashboard/passwordUpdateSuccess');
            } else {
                $data["error"] = "<p>Please enter valid old password.</p>";
            }
        }

        if ($data["error"] != "") {
            $response = array("comment_error" => $data["error"], "status" => "fail");
            echo json_encode($response);
            die;
        }

        if ($data["msg"] == "success") {
            $response = array("status" => "success");
            echo json_encode($response);
            die;
        }

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/changepassword', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function upgrade($bar_id = '') {
        if (get_authenticateUserID() == '') {
            redirect('home');
        }

        if ($bar_id != "") {
            $bar_id = base64_decode($bar_id);
            $this->session->set_userdata(array('viewid' => $bar_id));
            $bar_id = $this->session->userdata('viewid');
        } elseif ($this->session->userdata('viewid') != "") {
            $bar_id = $this->session->userdata('viewid');
        }


        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
        $data['getbardata'] = $this->home_model->getBardata($bar_id);
        $data['one_user'] = $this->home_model->get_availability($bar_id);
        if ($data['getbardatafeature']) {
            $data['getbardatafeature_new'] = $data['getbardatafeature']['feature_id'];
        }
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('btype', 'Bar Type', 'required');

        if ($_POST) {

            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                if ($this->input->post('bar_feature_id') == "") {
                    $barid_new = $this->home_model->register_bar_owner_features();
                    redirect('home/registration_step3_upgrade');
                } else {
                    $barid_new = $this->home_model->register_bar_owner_features_update();
                    redirect('home/registration_step3_upgrade');
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step2_upgrade', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step3_upgrade($bar_id = '', $type = '', $coupon = '') {

        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');


        if ($bar_id != "") {

            $bar_id = base64_decode($bar_id);
        } else {
            redirect('home');
        }


        $data['type'] = $type;
        if ($type != 'managed' & $type != 'fullmug') {
            redirect('home/dashboard');
        }

        $data['getbardata'] = $this->home_model->getBardata($bar_id);
        $data['coupon'] = $coupon;


        $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
        $count = 1;
        if ($data['getbardatafeature']) {
            $count = $data['getbardatafeature']['feature_id'];
        }
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        if ($coupon == "Cheers25") {
            if ($type == 'fullmug') {
                $data['site_setting']->amount = (string) ((int) $data['site_setting']->amount * 0.5);
            } else if ($type == 'managed') {
                $data['site_setting']->managed_account_amount = (string) ((int) $data['site_setting']->managed_account_amount * 0.5);
            }
        }

        //$this->form_validation->set_rules('btype','Free Listing Or Paid Listing','required');

        if ($_POST) {
            redirect('home/registration_step4_upgrade/' . $this->input->post('bar_id') . "/$type" . "/$coupon");
        }


        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step3_upgrade', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function registration_step5_upgrade() {

        $this->session->unset_userdata('viewid');
        $uid = $this->session->userdata('userid_sess');
        if ($uid == '') {
            redirect('home/bar_owner_register');
        }


        $theme = getThemeName();
        $data['error'] = '';
        //$data['bar_id'] = $bar_id;
        $data['user_id'] = base64_decode($uid);
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');
        $data['get_user_info'] = get_user_info($data['user_id']);
        $this->form_validation->set_rules('code', 'Code', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $user_id = $this->home_model->checkcode();

                if ($user_id != "" && $user_id['confirm_code'] != '') {
                    $data_up = array('status' => "active", 'confirm_code' => '', 'flag' => '0');
                    $this->db->where('user_id', $this->input->post('user_id'));
                    $this->db->update('user_master', $data_up);

                    // $data_up_owner = array('bar_type'=>"full_mug");
                    // $this->db->where('owner_id',$this->input->post('user_id'));
                    // $this->db->update('bars',$data_up_owner); 
                    $this->session->unset_userdata('userid_sess');

                    redirect('home/success_page/' . base64_encode($this->input->post('user_id')));
                } elseif ($user_id['confirm_code'] == '') {
                    $this->session->unset_userdata('userid_sess');
                    redirect('home/index/reg_link_expire');
                } else {
                    $data["error"] = "<p>Please Enter Correct Confirmation Code .</p>";
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/confirm', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();


        //return $uid;
    }

    function statistics() {
        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'contactus';
        $data["error"] = "";
        $data["site_setting"] = site_setting();
        $this->load->helper('recaptchalib');
        $publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
        $privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
        # the response from reCAPTCHA
        $resp = null;
        # the error code from reCAPTCHA, if any
        $error = null;
        $captcha_error = '';

        $data['captcha_img'] = recaptcha_get_html($publickey, $error);
        $data['statistics'] = $this->home_model->getStatisticsData();
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/statistics', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function news($limit = 5, $offset = 0, $msg = '') {
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $this->load->library('pagination');
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $data['active_menu'] = 'home';
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->getnewslettercount();
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'home/news/' . $limit;
        $config["total_rows"] = $this->home_model->getnewslettercount();

        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $data['page_link'] = $this->pagination->create_links();
        $data['result'] = $this->home_model->getnewsletterresult($offset, $limit);
        $data['latest_mews'] = $this->home_model->latestmews($limit = 2, '');

        //	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        $data['redirect_page'] = 'newsletterevent';

        if ($this->input->is_ajax_request()) {
            echo $this->load->view($theme . '/home/newsletterajax', $data, TRUE);
            die;
        } else {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
            $this->template->write_view('content_center', $theme . '/home/newsletter', $data, TRUE);
            $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
            $this->template->render();
        }
    }

    function news_details($slug = '') {

        if ($slug == '') {
            redirect('home');
        }

        $data = array();
        $site_setting = site_setting();
        $data['site_setting'] = $site_setting;
        $data['active_menu'] = $slug;

        $result = get_news_info($slug);
        if (!$result) {
            redirect('home');
        }

        $data['result'] = $result;
        $data['latest_mews'] = $this->home_model->latestmews($limit = 3, $result->news_id);
        $theme = getThemeName();
        $page_detail = meta_setting();
        //  $pageTitle=$result->pages_title;
        // $metaDescription=$result->meta_description;
        //  $metaKeyword=$result->meta_keyword;
        $this->template->set_master_template($theme . '/template.php');
        // $this->template->write ('pageTitle', $pageTitle, TRUE);
        //  $this->template->write ('metaDescription', $metaDescription, TRUE);
        //  $this->template->write ('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/home/news_detail', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function getmorecomment() {
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data["bar_comment"] = $this->bar_model->getAllComments($_GET['bar_id'], $_GET['offset'], $_GET['limit']);
        echo $this->load->view($theme . '/bar/barcommentajaxscroll', $data, TRUE);
        die;
    }

    function update_user_old() {
        $getUsers = $this->home_model->getAllUser();
        $site_setting = site_setting();
        if ($getUsers) {
            foreach ($getUsers as $row) {

                if ($row->credit_card_id != "" && $row->expire_date < date('Y-m-d')) {

                    $usr_status = array('staus' => 'inactive');
                    $this->db->where('user_id', $row->user_id);
                    $this->db->update('user_master', $usr_status);

                    $ccToken = new CreditCardToken();
                    $ccToken->setCreditCardId($row->credit_card_id);

                    $fi = new FundingInstrument();
                    $fi->setCreditCardToken($ccToken);

                    $payer = new Payer();
                    $payer->setPaymentMethod("credit_card");
                    $payer->setFundingInstruments(array($fi));

                    // Specify the payment amount.
                    $amount = new Amount();
                    $amount->setCurrency("USD");
                    $amount->setTotal($site_setting->amount);
                    // ###Transaction
                    // A transaction defines the contract of a
                    // payment - what is the payment for and who
                    // is fulfilling it. Transaction is created with
                    // a `Payee` and `Amount` types
                    $transaction = new Transaction();
                    $transaction->setAmount($amount);
                    //$transaction->setDescription($paymentDesc);

                    $payment = new Payment();
                    $payment->setIntent("sale");
                    $payment->setPayer($payer);
                    $payment->setTransactions(array($transaction));

                    //$payment->create(getApiContext());
                    try {
                        //$res = $payment->create($this->apiContext);
                        $payment->create(getApiContext());

                        /*
                         * transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
                         */
                    } catch (Exception $ex) {

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $row->email;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $link = anchor('home/update_creditcard_detail/' . $row->user_id, 'home/update_creditcard_detail/' . $row->user_id, 'target="_blank"');
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{link}', $link, $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email To Admin'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $email_temp->from_address;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }
                        //var_dump($ex->getData());
                        exit(1);
                    }

                    if ($payment->state != "approved") {
                        //$data["error"]='<p>Payment Fail</p>';

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $row->email;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $link = anchor('home/update_creditcard_detail/' . $row->user_id, 'home/update_creditcard_detail/' . $row->user_id, 'target="_blank"');
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{link}', $link, $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }
                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email To Admin'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $email_temp->from_address;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }
                        //echo 'in';die;
                    } else {


                        $expDate = date('Y-m-d', strtotime("+30 days"));

                        $usr = array('expire_date' => date('Y-m-d', strtotime($expDate)), 'credit_card_id' => $row->credit_card_id, 'staus' => 'active');

                        $this->db->where('user_id', $row->user_id);
                        $this->db->update('user_master', $usr);
                        /*  User Update  */
                        /*  Insert Transaction  */
                        $transar = array('txn_id' => $payment->id, 'user_id' => $row->user_id, 'price' => $site_setting->amount, 'transaction_date' => date('Y-m-d'));
                        $this->db->insert('transaction', $transar);

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='User Account Update'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $row->email;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }



                        //die;
                    }
                }

                // else if($row->credit_card_id =="" && $row->expire_date<date('Y-m-d'))
                // {
//
//
                // $chargeAmount = "0";
                // $userplan = $row->user_plan;
                // $countAccounts = getTotalAccountsByuserID($row->user_id);
                // $data['reachMaxLimit']  = 0;
                // $total_account = "0";
                // if($countAccounts>=10 && $userplan==1 || $countAccounts>=20 && $userplan==2 || $countAccounts>=50 && $userplan==3 || $countAccounts>=100 && $userplan==4 || $countAccounts>=500 && $userplan==5)
                // {
                // $data['reachMaxLimit'] = 1;
                // if($userplan==1)
                // {
                // $chargeAmount = $row->plan_amt/10;
                // $total_account = $countAccounts-10;
                // }
                // elseif($userplan==2)
                // {
                // $chargeAmount = $row->plan_amt/20;
                // $total_account = $countAccounts-20;
                // }
                // elseif($userplan==3)
                // {
                // $chargeAmount = $row->plan_amt/50;
                // $total_account = $countAccounts-50;
                // }
                // elseif($userplan==4)
                // {
                // $chargeAmount = $row->plan_amt/100;
                // $total_account = $countAccounts-100;
                // }
                // elseif($userplan==5)
                // {
                // $chargeAmount = $row->plan_amt/500;
                // $total_account = $countAccounts-500;
                // }
//
                // }
                // if($total_account>0)
                // {
                // $total_amount = $row->plan_amt + $chargeAmount*$total_account;
                // }
                // else {
                // $total_amount = $row->plan_amt + $chargeAmount;
                // }
                // $usr_status=array('staus'=>4);
                // $this->db->where('user_id',$row->user_id);
                // $this->db->update('user_master',$usr_status);
//                
//
                // $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
                // $email_temp=$email_template->row();
                // $email_address_from=$email_temp->from_address;
                // $email_address_reply=$email_temp->reply_address;
                // $email_subject=$email_temp->subject;
                // $email_message=$email_temp->message;
                // $email = $row->email;
                // $user_name = ucwords($row->first_name." ".$row->last_name);
                // $email_to =$email;
                // $link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
                // $email_message=str_replace('{break}','<br/>',$email_message);
                // $email_message=str_replace('{user_name}',$user_name,$email_message);
                // $email_message=str_replace('{break}','<br/>',$email_message);
                // $email_message=str_replace('{link}',$link,$email_message);
                // $str=$email_message;
                // email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
//
//
                // $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
                // $email_temp=$email_template->row();
                // $email_address_from=$email_temp->from_address;
                // $email_address_reply=$email_temp->reply_address;
                // $email_subject=$email_temp->subject;
                // $email_message=$email_temp->message;
                // $email = $email_temp->from_address;
                // $user_name = ucwords($row->first_name." ".$row->last_name);
                // $email_to =$email;
                // $email_message=str_replace('{break}','<br/>',$email_message);
                // $email_message=str_replace('{user_name}',$user_name,$email_message);
                // $str=$email_message;
                // email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
                // }
            }
        }
    }

    function update_user() {
        $getUsers = $this->home_model->getAllUser();



        // $email_address_from = "php.viral@spaculus.info";
        // $email_address_reply = "php.viral@spaculus.info";
        // $email_to = "qa@spaculus.com,php.viral@spaculus.info";
        // $email_subject = "cronjob";
        // $str = "cronjob";
        // email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);

        $site_setting = site_setting();
        if ($getUsers) {
            foreach ($getUsers as $row) {


                $date = date('Y-m-d', strtotime('+31 day', strtotime($row->expire_date)));

                if ($row->PNREF != "" && $date < date('Y-m-d') && $row->flag == 1) {
                    // echo $date;
                    // die;
                    $usr_status = array('bar_type' => 'half_mug');
                    $this->db->where('owner_id', $row->user_id);
                    $this->db->update('bars', $usr_status);
                }

                if ($row->PNREF != "" && $row->expire_date < date('Y-m-d') && $row->flag != 1) {

                    //	echo "Dsa";
                    $usr_status = array('flag' => '1');
                    $this->db->where('user_id', $row->user_id);
                    $this->db->update('user_master', $usr_status);


                    $getpaypalsetting = paypalsetting();
                    $PayFlow = new PayFlow($getpaypalsetting->vendor, $getpaypalsetting->partner_name, $getpaypalsetting->paypal_username, $getpaypalsetting->paypal_password, 'recurring');
                    $user = $getpaypalsetting->paypal_username; // API User Username
                    $password = $getpaypalsetting->paypal_password; // API User Password
                    $vendor = $getpaypalsetting->vendor; // Merchant Login ID
                    // Reseller who registered you for Payflow or 'PayPal' if you registered
                    // directly with PayPal
                    $partner = 'PayPal';

                    if ($getpaypalsetting->site_status == 'sandbox') {
                        $sandbox = true;
                    } else {
                        $sandbox = false;
                    }

                    $transactionId = $row->PNREF; // The PNREF # returned when the card was charged
                    //$transactionId = 'R7359CA03249'; // The PNREF # returned when the card was charged

                    $amount = '1';
                    $currency = 'USD';

                    $url = $sandbox ? 'https://pilot-payflowpro.paypal.com' : 'https://payflowpro.paypal.com';

                    $params = array(
                        'USER' => $user,
                        'VENDOR' => $vendor,
                        'PARTNER' => $partner,
                        'PWD' => $password,
                        'TENDER' => 'C', // C = credit card, P = PayPal
                        'TRXTYPE' => 'I', //  S=Sale, A= Auth, C=Credit, D=Delayed Capture, V=Void                        
                        'ORIGID' => $transactionId,
                        'AMT' => $amount,
                        'CURRENCY' => $currency
                    );

                    $data = '';
                    $i = 0;
                    foreach ($params as $n => $v) {
                        $data .= ($i++ > 0 ? '&' : '') . "$n=" . urlencode($v);
                    }

                    $headers = array();
                    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                    $headers[] = 'Content-Length: ' . strlen($data);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    // Parse results
                    $response = array();
                    $result = strstr($result, 'RESULT');
                    $valArray = explode('&', $result);
                    foreach ($valArray as $val) {
                        $valArray2 = explode('=', $val);
                        $response[$valArray2[0]] = $valArray2[1];
                    }


                    if (isset($response['RESULT']) && $response['RESULT'] == 0) {

                        $expDate = date('Y-m-d', strtotime("+30 days"));
                        $usr = array('expire_date' => date('Y-m-d', strtotime($expDate)), 'flag' => '0');
                        $this->db->where('user_id', $row->user_id);
                        $this->db->update('user_master', $usr);

                        $transar = array('txn_id' => $transactionId, 'user_id' => $row->user_id, 'price' => $site_setting->amount);
                        $this->db->insert('transaction', $transar);

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='User Account Upgrade Notification To User'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $row->email;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }
                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='User Account Upgrade Notification To Admin'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = getsuperadminemail();
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $str = $email_message;
                        //email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
                        $getemail = explode(',', $email);
                        if ($email_temp->status == 'active') {
                            foreach ($getemail as $r) {
                                email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                            }
                        }
                    } else {
                        //echo 'FAILURE: ' . $response['RESPMSG'] . ' ['. $response['RESULT'] . ']';
                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $row->email;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = $email;
                        $link = anchor('home/update_creditcard_detail/' . $row->user_id, 'home/update_creditcard_detail/' . $row->user_id, 'target="_blank"');
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        //$email_message=str_replace('{break}','<br/>',$email_message);
                        $email_message = str_replace('{link}', $link, $email_message);
                        $str = $email_message;
                        if ($email_temp->status == 'active') {
                            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                        }

                        $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Payment Failure Email To Admin'");
                        $email_temp = $email_template->row();
                        $email_address_from = $email_temp->from_address;
                        $email_address_reply = $email_temp->reply_address;
                        $email_subject = $email_temp->subject;
                        $email_message = $email_temp->message;
                        $email = $email_temp->from_address;
                        $user_name = ucwords($row->first_name . " " . $row->last_name);
                        $email_to = getsuperadminemail();
                        $email_message = str_replace('{break}', '<br/>', $email_message);
                        $email_message = str_replace('{user_name}', $user_name, $email_message);
                        $str = $email_message;
                        $getemail = explode(',', $email);
                        if ($email_temp->status == 'active') {
                            foreach ($getemail as $r) {
                                email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                            }
                        }
                    }
                }
            }
        }
    }

    function update_creditcard_detail($id = "", $msg = "") {


        $site_setting = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data = array();
        $data['error'] = '';
        $data['id'] = $id;
        $res = "";
        $user_info = get_user_info($id);

        if (!$user_info) {
            redirect('home');
        }
        $data['email'] = $user_info->email;
        $data['msg'] = $msg; //login fail message

        $this->form_validation->set_rules('cc_type', 'Credit Card Type', 'required');
        $this->form_validation->set_rules('card_number', 'Credit Card Number', 'required');
        $this->form_validation->set_rules('ex_month', 'Expire Month', 'required');
        $this->form_validation->set_rules('ex_year', 'Expire Year', 'required');
        $this->form_validation->set_rules('cvv', 'Cvv Number', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            if ($_POST) {

                $data['cc_type'] = $this->input->post('cc_type');
                $data['card_number'] = $this->input->post('card_number');
                $data['ex_month'] = $this->input->post('ex_month');
                $data['ex_year'] = $this->input->post('ex_year');
                $data['cvv'] = $this->input->post('cvv');
                $data['email'] = $this->input->post('email');
            } else {
                $data['email'] = $user_info->email;
            }
        } else {
            $PayFlow = new PayFlow($getpaypalsetting->vendor, $getpaypalsetting->partner_name, $getpaypalsetting->paypal_username, $getpaypalsetting->paypal_password, 'recurring');

            $PayFlow->setEnvironment($getpaypalsetting->site_status);                           // test or live
            $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
            $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
            $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
            // Only used for recurring transactions
            $PayFlow->setProfileAction('A');
            $PayFlow->setProfileName('RegularSubscription');
            $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
            //$PayFlow->setProfileStartDate(date('mdY'));
            $PayFlow->setProfilePayPeriod('MONT');
            $PayFlow->setProfileTerm(0);
            $amount = $site_setting->amount;
            if ($this->input->post('type_bar') == 2) {
                $amount = $site_setting->managed_account_amount;
            }

            $PayFlow->setAmount($amount, FALSE);
            $PayFlow->setCCNumber($this->input->post('card_number'));
            $PayFlow->setCVV($this->input->post('cvv'));
            $PayFlow->setExpiration($this->input->post('ex_month') . substr($this->input->post('ex_year'), 2, 4));

            if ($PayFlow->processTransaction()) {
                $res = $PayFlow->getResponse();
                $expDate = date('Y-m-d', strtotime("+30 days"));
                $usr = array('PNREF' => $res['RPREF'], 'expire_date' => date('Y-m-d', strtotime($expDate)), 'credit_card_id' => $res['PROFILEID'], 'staus' => 'active');

                $this->db->where('user_id', $user_info->user_id);
                $this->db->update('user_master', $usr);
                /*  User Update  */
                /*  Insert Transaction  */
                $transar = array('txn_id' => $res['PROFILEID'], 'user_id' => $user_info->user_id, 'amount' => $amount, 'transaction_date' => date('Y-m-d'));
                $this->db->insert('transaction', $transar);
                //  $msg = "insert";
                //  redirect('home/index/successfully_registration');


                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='User Account Update'");
                $email_temp = $email_template->row();
                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;
                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;
                $email = $user_info->email;
                $user_name = ucwords($user_info->first_name . " " . $user_info->last_name);
                $email_to = $email;
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{user_name}', $user_name, $email_message);
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $str = $email_message;
                if ($email_temp->status == 'active') {
                    email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                }
                redirect('home/index/successfully_update_credit_card');
            } else {
                $data["error"] = 'Transaction could not be processed at this time. Please enter proper card details';
            }
        }

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/update_payment_account', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function updatecard($msg = "") {
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        if ($this->session->userdata('user_type') != 'bar_owner') {
            redirect('home');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('cc_type', 'Credit Card Type', 'required');
        $this->form_validation->set_rules('card_number', 'Credit Card Number', 'required');
        $this->form_validation->set_rules('ex_month', 'Expire Month', 'required');
        $this->form_validation->set_rules('ex_year', 'Expire Year', 'required');
        $this->form_validation->set_rules('cvv', 'Cvv Number', 'required');
        $data['error'] = '';
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            $data['cc_type'] = $this->input->post('cc_type');
            $data['card_number'] = $this->input->post('card_number');
            $data['ex_month'] = $this->input->post('ex_month');
            $data['ex_year'] = $this->input->post('ex_year');
            $data['cvv'] = $this->input->post('cvv');
            $data['email'] = $this->input->post('email');
        } else {
            $card = new CreditCard();


            $type = strtolower($this->input->post('cc_type'));
            $number = strtolower($this->input->post('card_number'));
            $month = strtolower($this->input->post('ex_month'));
            $year = strtolower($this->input->post('ex_year'));
            $cvv_number = strtolower($this->input->post('cvv'));


            $card->setType($type)
                    ->setNumber($number)
                    ->setExpireMonth($month)
                    ->setExpireYear($year)
                    ->setCvv2($cvv_number);
            try {
                //$card->create($apiContext); 

                $card->create($this->apiContext);
                $usr = array('credit_card_id' => $card->getId());

                $this->db->where('user_id', get_authenticateUserID());
                $this->db->update('user_master', $usr);
                $data["msg"] = "success";
                //redirect('home/updatecard/update_credit_card_successfully');
            } catch (Exception $ex) {
                $data["error"] = "Please enter proper credit card information.";
            }
        }

        if ($data["error"] != "") {
            $response = array("comment_error" => $data["error"], "status" => "fail");
            echo json_encode($response);
            die;
        }

        if ($data["msg"] == "success") {
            $response = array("status" => "success");
            echo json_encode($response);
            die;
        }

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/updatecardinfo', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function contact_us($msg = '') {

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $data['site_setting'] = site_setting();
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $data['error'] = '';
        $this->load->helper('recaptchalib');
        $publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
        $privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
        $resp = null;
        # the error code from reCAPTCHA, if any
        $error = null;
        $captcha_error = '';

        if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {
                // echo "You got it!";
            } else {
                # set the error code so that we can display it
                $cerror = $resp->error;
                $captcha_error = '<span> Please enter valid captcha code. </span>';
            }

            //echo $cerror;die;
        }
        $data['captcha_img'] = recaptcha_get_html($publickey, $error);
        if ($this->form_validation->run() == FALSE || $captcha_error != '') {
            if (validation_errors() || $captcha_error != '') {
                $data["error"] = validation_errors() . $captcha_error;
            } else {
                $data["error"] = "";
            }
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['subject'] = $this->input->post('subject');
            $data['message'] = $this->input->post('message');
        } else {
            $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Contact Us'");
            $email_temp = $email_template->row();
            $email_address_from = $email_temp->from_address;
            $email_address_reply = $email_temp->reply_address;
            $email_subject = $email_temp->subject;
            $email_message = $email_temp->message;
            $email = $data['site_setting']->site_email;
            $email_to = $email;
            $email_message = str_replace('{break}', '<br/>', $email_message);
            $email_message = str_replace('{name}', $this->input->post('name'), $email_message);
            $email_message = str_replace('{email}', $this->input->post('email'), $email_message);
            $email_message = str_replace('{subject}', $this->input->post('subject'), $email_message);
            $email_message = str_replace('{message}', $this->input->post('message'), $email_message);
            $str = $email_message;
            if ($email_temp->status == 'active') {
                email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
            }
            $this->session->set_flashdata('msg', 'success');
            $msg = 'success';
            redirect('home/contact_us/' . $msg);
        }


        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/contactus', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function add_clcik() {
        // $getad = getadvertisementByIDSec($this->input->post('id'),'click');
//
        // if($getad==0)
        // {
        $getad = $this->geta($this->input->post('id'));

        //echo $getad['number_click'];
        $getad_newsec = getadvertisementByID_new(@$getad['advertisement_id'], 'click');

        if (($getad_newsec < 5 || $getad_newsec == 0) && $getad['total_click'] < $getad['number_click']) {

            $array = array('ip' => $_SERVER['REMOTE_ADDR'], 'datetime' => date('Y-m-d H:i:s'), 'advertisement_id' => $this->input->post('id'), 'click_type' => 'click');
            $this->db->insert('count_clcik_advertisement', $array);

            $array1 = array('total_click' => $getad['total_click'] + 1);
            $this->db->where('advertisement_id', $getad['advertisement_id']);
            $this->db->update('advertisement_master', $array1);
        }
        //}
    }

    function add_clcik_banner() {
        // $getad = getadvertisementByIDSec($this->input->post('id'),'click');
//
        // if($getad==0)
        // {
        $getad = $this->geta_banner($this->input->post('id'));

        //echo $getad['number_click'];
        $getad_newsec = getadvertisementBannerByID_new(@$getad['banner_pages_id'], 'click');


        if (($getad_newsec < 5 || $getad_newsec == 0) && $getad['total_click'] < $getad['number_click']) {

            $array = array('ip' => $_SERVER['REMOTE_ADDR'], 'datetime' => date('Y-m-d H:i:s'), 'banner_pages_id' => $this->input->post('id'), 'click_type' => 'click');
            $this->db->insert('count_clcik_advertisement_banner', $array);

            $array1 = array('total_click' => $getad['total_click'] + 1);
            $this->db->where('banner_pages_id', $getad['banner_pages_id']);
            $this->db->update('banner_pages_master', $array1);
        }
        //}
    }

    function geta($id) {

        $this->db->select('*');
        $this->db->where('advertisement_id', $id);
        $query = $this->db->get('advertisement_master');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return '';
        }
    }

    function geta_banner($id) {

        $this->db->select('*');
        $this->db->where('banner_pages_id', $id);
        $query = $this->db->get('banner_pages_master');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return '';
        }
    }

    function taxi_owner_register($msg = '') {

        if (check_user_authentication() != '') {
            redirect('home');
        }

        $theme = getThemeName();

        $data['error'] = '';
        $data['msg'] = $msg;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check_taxiuser');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        //	$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
        //$this->form_validation->set_rules ('pass', 'Password', 'required|min_length[8]|max_length[12]|callback_password_check');
        //	$this->form_validation->set_rules('confpass', 'confirm Password', 'required');

        $bar_id = $this->session->userdata('viewid');

        if ($bar_id != '') {
            $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
            $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
            $data["email"] = $data['getbardata']['email'];
            $data["bar_title"] = $data['getbardata']['bar_title'];
            $data["first_name"] = $data['getbardata']['first_name'];
            $data["last_name"] = $data['getbardata']['last_name'];
            $data["address"] = $data['getbardata']['address'];
            $data["city"] = $data['getbardata']['city'];
            $data["state"] = $data['getbardata']['state'];
            $data["mobile_no"] = $data['getbardata']['mobile_no'];

            $data["zip"] = $data['getbardata']['zip'];
            $data["desc"] = $data['getbardata']['desc'];
        }
        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }


                $data["email"] = $this->input->post('email');
                $data["first_name"] = $this->input->post('first_name');
                $data["last_name"] = $this->input->post('last_name');
                $data["mobile_no"] = $this->input->post('mobile_no');
                //	$data["pass"] = $this->input->post ('pass');
                $data["temp_id"] = $this->input->post('temp_id');
                //	$data["confpass"] = $this->input->post ('confpass');
            } else {
                if ($this->input->post('temp_id') == "") {
                    $barid = $this->home_model->register_taxi_owner();
                    redirect('home/taxi_owner_registration_step2/' . base64_encode($barid));
                } else {
                    $barid = $this->home_model->register_bar_owner_update();
                    redirect('home/taxi_owner_registration_step2/' . base64_encode($this->input->post('temp_id')));
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/taxi_owner_register', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function taxi_owner_registration_step2($bar_id = '') {


        if ($bar_id != "") {
            $bar_id = base64_decode($bar_id);
            $this->session->set_userdata(array('viewid' => $bar_id));
            $bar_id = $this->session->userdata('viewid');
        } elseif ($this->session->userdata('viewid') != "") {
            $bar_id = $this->session->userdata('viewid');
        }
        if ($bar_id == '') {
            redirect('home/taxi_owner_register');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $site_setting = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $conf = rand('11111111', '99999999');
        $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);



        $this->load->library('form_validation');
        $this->form_validation->set_rules('tax_company_name', 'Taxi Company Name', 'required');
        $this->form_validation->set_rules('tax_cmpn_address', 'Address', 'required');
        //$this->form_validation->set_rules('texi_company_phone_number','Phone Number','required');
        //$this->form_validation->set_rules('taxi_company_website','Taxi Company Website','required');
        //	$this->form_validation->set_rules('reciew','Review','required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('cmpn_zipcode', 'Zipcode', 'required|numeric');
        //$this->form_validation->set_rules('profile_image','Profile Image','required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {

                $data_insert['first_name'] = $data['getbardata']['first_name'];
                $data_insert['last_name'] = $data['getbardata']['last_name'];
                $data_insert['mobile_no'] = $data['getbardata']['mobile_no'];
                $data_insert['email'] = $data['getbardata']['email'];
                $data_insert['password'] = md5($data['getbardata']['pass']);
                $data_insert1['taxi_company'] = $this->input->post('tax_company_name');
                $data_insert1['address'] = $this->input->post('tax_cmpn_address');
                $data_insert1['phone_number'] = $this->input->post('texi_company_phone_number');
                $data_insert1['cmpn_website'] = $this->input->post('taxi_company_website');
                $data_insert1['taxi_desc'] = $this->input->post('reciew');
                $data_insert1['city'] = $this->input->post('city');
                $data_insert1['state'] = $this->input->post('state');
                $data_insert1['cmpn_zipcode'] = $this->input->post('cmpn_zipcode');

                $data_insert['status'] = 'inactive';
                $data_insert1['status'] = 'inactive';
                $data_insert['is_deleted'] = 'no';
                $data_insert['user_type'] = 'taxi_owner';
                $data_insert['confirm_code'] = $conf;
                $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
                $data_insert['sign_up_date'] = date('Y-m-d H:i:s');
                $data_insert1['date_added'] = date('Y-m-d H:i:s');


                $bar_logo_img = '';
                if ($_FILES['profile_image']['name'] != '') {
                    $this->load->library('upload');
                    $rand = rand(0, 100000);

                    $_FILES['userfile']['name'] = $_FILES['profile_image']['name'];
                    $_FILES['userfile']['type'] = $_FILES['profile_image']['type'];
                    $_FILES['userfile']['tmp_name'] = $_FILES['profile_image']['tmp_name'];
                    $_FILES['userfile']['error'] = $_FILES['profile_image']['error'];
                    $_FILES['userfile']['size'] = $_FILES['profile_image']['size'];

                    $config['file_name'] = 'user_logo' . $rand;

                    $config['upload_path'] = base_path() . 'upload/user_orig/';

                    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()) {
                        $error = $this->upload->display_errors();
                    }


                    $picture = $this->upload->data();

                    $this->load->library('image_lib');

                    $this->image_lib->clear();


                    $gd_var = 'gd2';


                    if ($_FILES["profile_image"]["type"] != "image/png" and $_FILES["profile_image"]["type"] != "image/x-png") {
                        $gd_var = 'gd2';
                    }


                    if ($_FILES["profile_image"]["type"] != "image/gif") {
                        $gd_var = 'gd2';
                    }

                    if ($_FILES["profile_image"]["type"] != "image/jpeg" and $_FILES["profile_image"]["type"] != "image/pjpeg") {
                        $gd_var = 'gd2';
                    }

                    resize(base_path() . 'upload/user_orig/' . $picture['file_name'], base_path() . 'upload/user_thumb/' . $picture['file_name'], 120, 120);

                    $bar_logo_img = $picture['file_name'];
                }

                $data_insert1['taxi_image'] = $bar_logo_img;
                $this->db->insert('user_master', $data_insert);
                $uid = mysql_insert_id();
                $data_insert1['taxi_owner_id'] = $uid;
                $data['user_id'] = $uid;
                $this->db->insert('taxi_directory', $data_insert1);


                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
                $email_temp = $email_template->row();
                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;
                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;
                $email = $data['getbardata']['email'];
                $user_name = $data['getbardata']['first_name'] . " " . $data['getbardata']['last_name'];
                $email_to = $email;
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{user_name}', $user_name, $email_message);
                //$email_message = str_replace('{email}', $email, $email_message);
                //$email_message = str_replace('{password}', $pass, $email_message);
                $email_message = str_replace('{activation_link}', $conf, $email_message);
                $str = $email_message;
                if ($email_temp->status == 'active') {
                    email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                }
                $uid = base64_encode($uid);

                $this->session->set_userdata(array('userid_sess' => $uid));

                redirect('home/claimbar_registration_step5/' . $uid);
            }
        }
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/taxi_registration_step2', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function suggest_advertise($msg = '') {
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $data["bar_event"] = $this->bar_model->getBarEventGallery();
        $data["barpostcard"] = $this->bar_model->getBarPostcards();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('name', 'Contact Person name', 'required');
        $this->form_validation->set_rules('number', 'Number', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }

            $data["type"] = $this->input->post('type');
            $data["text"] = $this->input->post('text');
            $data["remarks"] = $this->input->post('remarks');
            $data["description"] = $this->input->post('description');
            $data["name"] = $this->input->post('name');
            $data["number"] = $this->input->post('number');
            $data["email"] = $this->input->post('email');
        } else {
            $this->home_model->insert_advertise();
            $this->session->set_flashdata('msg', 'success');
            $msg = 'success';

            $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Suggest Advertise'");
            $email_temp = $email_template->row();
            $email_address_from = $email_temp->from_address;
            $email_address_reply = $email_temp->reply_address;
            $email_subject = $email_temp->subject;
            $email_message = $email_temp->message;
            $email = $data['site_setting']->site_email;
            $email_to = $email;
            $email_message = str_replace('{break}', '<br/>', $email_message);
            $email_message = str_replace('{type}', $this->input->post('type'), $email_message);
            $email_message = str_replace('{text}', $this->input->post('text'), $email_message);
            $email_message = str_replace('{remarks}', $this->input->post('remarks'), $email_message);
            $email_message = str_replace('{description}', $this->input->post('description'), $email_message);
            $email_message = str_replace('{name}', $this->input->post('name'), $email_message);
            $email_message = str_replace('{number}', $this->input->post('number'), $email_message);
            $email_message = str_replace('{email}', $this->input->post('email'), $email_message);
            $str = $email_message;
            if ($email_temp->status == 'active') {
                email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
            }

            redirect('home/suggest_advertise/' . $msg);
        }
        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/home/suggestadvertise', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function updatebanner($msg = '') {
        if (get_authenticateUserID() == '') {
            redirect('home');
        }

        if ($this->session->userdata('user_type') == 'bar_owner') {
            $data['bar_detail'] = $this->home_model->get_bar_info(get_authenticateUserID());
        } else {
            $data['bar_detail'] = get_user_info(get_authenticateUserID());
        }
        $data['msg'] = $msg;
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        if ($this->session->userdata('user_type') == 'bar_owner') {
            $this->template->write_view('content_center', $theme . '/home/updatebanner', $data, TRUE);
        } else {
            $this->template->write_view('content_center', $theme . '/home/updatebanneruser', $data, TRUE);
        }
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function updatebannernew() {

        $bar_banner_img = '';
        if ($_FILES['file']['name'] != '') {
            $this->load->library('upload');
            $rand = rand(0, 100000);

            $_FILES['userfile']['name'] = $_FILES['file']['name'];
            $_FILES['userfile']['type'] = $_FILES['file']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['file']['error'];
            $_FILES['userfile']['size'] = $_FILES['file']['size'];

            $config['file_name'] = 'bar_logo' . $rand;

            $config['upload_path'] = base_path() . 'upload/barlogo_orig/';

            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->upload->initialize($config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
            }


            $picture = $this->upload->data();

            $this->load->library('image_lib');

            $this->image_lib->clear();


            $gd_var = 'gd2';


            if ($_FILES["file"]["type"] != "image/png" and $_FILES["file"]["type"] != "image/x-png") {

                $gd_var = 'gd2';
            }


            if ($_FILES["file"]["type"] != "image/gif") {

                $gd_var = 'gd2';
            }


            if ($_FILES["file"]["type"] != "image/jpeg" and $_FILES["file"]["type"] != "image/pjpeg") {

                $gd_var = 'gd2';
            }


            $this->image_lib->clear();

            $this->image_lib->initialize(array(
                'image_library' => $gd_var,
                'source_image' => base_path() . 'upload/barlogo_orig/' . $picture['file_name'],
                'new_image' => base_path() . 'upload/barlogo/' . $picture['file_name'],
                'maintain_ratio' => FALSE,
                'quality' => '100%',
                'width' => '685',
                'height' => '320',
            ));


            if (!$this->image_lib->resize()) {
                $error = $this->image_lib->display_errors();
            }

            $this->image_lib->clear();

            $this->image_lib->initialize(array(
                'image_library' => $gd_var,
                'source_image' => base_path() . 'upload/barlogo_orig/' . $picture['file_name'],
                'new_image' => base_path() . 'upload/banner_without_drag/' . $picture['file_name'],
                'maintain_ratio' => FALSE,
                'quality' => '100%',
                'width' => '1140',
                'height' => '244',
            ));


            if (!$this->image_lib->resize()) {
                $error = $this->image_lib->display_errors();
            }

            $this->image_lib->clear();

            $crop_from_top = abs($this->input->post('pos'));


            $default_cover_width = 1140;
            $default_cover_height = 244;
            $a = base_path() . "cover-reposition/thumbncrop.inc.php";
            require_once ($a);
            //php class for image resizing & cropping

            $tb = new ThumbAndCrop ();

            $p = base_path() . 'upload/barlogo_orig/' . $picture['file_name'];

            $tb->openImg($p);
            //original cover image

            $newHeight = $tb->getRightHeight($default_cover_width);

            $tb->creaThumb($default_cover_width, $newHeight);

            $tb->setThumbAsOriginal();

            $tb->cropThumb($default_cover_width, $default_cover_height, 0, $crop_from_top);

            $q = base_path() . 'upload/banner_drag/' . $picture['file_name'];
            $tb->saveThumb($q);
            //save cropped cover image

            $tb->resetOriginal();

            $tb->closeImg();

            resize(base_path() . 'upload/banner_drag/' . $picture['file_name'], base_path() . 'upload/banner_drag_thumb/' . $picture['file_name'], 150, 150);
            // $this->image_lib->initialize(array(
            // 'image_library' => $gd_var,
            // 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
            // 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
            // 'maintain_ratio' => FALSE,
            // 'quality' => '100%',
            // 'width' => '685',
            // 'height' => '320',
            // 'x_axis' => $this->input->post('pos'),
            // ));
//
//
            // if(!$this->image_lib->crop())
            // {
            // $error = $this->image_lib->display_errors();
            // }
//
            $bar_banner_img = $picture['file_name'];


            if ($this->input->post('prev_bar_banner') != '') {
                if (file_exists(base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner'))) {
                    $link = base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner');
                    unlink($link);
                }

                if (file_exists(base_path() . 'upload/barlogo/' . $this->input->post('prev_bar_banner'))) {
                    $link2 = base_path() . 'upload/barlogo/' . $this->input->post('prev_bar_banner');
                    unlink($link2);
                }

                if (file_exists(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'))) {
                    $link2 = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');
                    unlink($link2);
                }
            }
        } else {

            if ($this->input->post('prev_bar_banner') != '') {

                if ($this->input->post('pos') != 0) {

                    if (file_exists(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'))) {
                        $link = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');
                        unlink($link);
                    }

                    if (file_exists(base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner'))) {
                        $link = base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner');
                        unlink($link);
                    }

                    $this->load->library('upload');
                    $crop_from_top = abs($this->input->post('pos'));


                    $default_cover_width = 1140;
                    $default_cover_height = 244;
                    $a = base_path() . "cover-reposition/thumbncrop.inc.php";
                    require_once ($a);
                    //php class for image resizing & cropping

                    $tb = new ThumbAndCrop ();

                    $p = base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner');

                    $tb->openImg($p);
                    //original cover image

                    $newHeight = $tb->getRightHeight($default_cover_width);

                    $tb->creaThumb($default_cover_width, $newHeight);

                    $tb->setThumbAsOriginal();

                    $tb->cropThumb($default_cover_width, $default_cover_height, 0, $crop_from_top);

                    $q = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');


                    $tb->saveThumb($q);
                    //save cropped cover image

                    $tb->resetOriginal();

                    $tb->closeImg();

                    resize(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'), base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner'), 150, 150);
                }
                $bar_banner_img = $this->input->post('prev_bar_banner');
            }
        }
        //$bar_detail = $this->bar_model->get_one_bar($this->input->post('bar_id'));

        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
        $data1 = array('bar_banner' => $bar_banner_img);
        $this->db->where("bar_id", @$data['getbar']['bar_id']);
        $this->db->update('bars', $data1);
        //redirect('bar/details/'.$data['getbar']['bar_slug']);

        redirect('home/updatebanner/success');
    }

    function updatebannernew_user() {


        $bar_banner_img = '';
        if ($_FILES['file']['name'] != '') {
            $this->load->library('upload');
            $rand = rand(0, 100000);

            $_FILES['userfile']['name'] = $_FILES['file']['name'];
            $_FILES['userfile']['type'] = $_FILES['file']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['file']['error'];
            $_FILES['userfile']['size'] = $_FILES['file']['size'];

            $config['file_name'] = 'bar_logo' . $rand;

            $config['upload_path'] = base_path() . 'upload/barlogo_orig/';

            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->upload->initialize($config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
            }


            $picture = $this->upload->data();

            $this->load->library('image_lib');

            $this->image_lib->clear();


            $gd_var = 'gd2';


            if ($_FILES["file"]["type"] != "image/png" and $_FILES["file"]["type"] != "image/x-png") {

                $gd_var = 'gd2';
            }


            if ($_FILES["file"]["type"] != "image/gif") {

                $gd_var = 'gd2';
            }


            if ($_FILES["file"]["type"] != "image/jpeg" and $_FILES["file"]["type"] != "image/pjpeg") {

                $gd_var = 'gd2';
            }


            $this->image_lib->clear();

            $this->image_lib->initialize(array(
                'image_library' => $gd_var,
                'source_image' => base_path() . 'upload/barlogo_orig/' . $picture['file_name'],
                'new_image' => base_path() . 'upload/barlogo/' . $picture['file_name'],
                'maintain_ratio' => FALSE,
                'quality' => '100%',
                'width' => '685',
                'height' => '320',
            ));


            if (!$this->image_lib->resize()) {
                $error = $this->image_lib->display_errors();
            }

            $this->image_lib->clear();

            $this->image_lib->initialize(array(
                'image_library' => $gd_var,
                'source_image' => base_path() . 'upload/barlogo_orig/' . $picture['file_name'],
                'new_image' => base_path() . 'upload/banner_without_drag/' . $picture['file_name'],
                'maintain_ratio' => FALSE,
                'quality' => '100%',
                'width' => '1140',
                'height' => '244',
            ));


            if (!$this->image_lib->resize()) {
                $error = $this->image_lib->display_errors();
            }

            $this->image_lib->clear();

            $crop_from_top = abs($this->input->post('pos'));


            $default_cover_width = 1140;
            $default_cover_height = 244;
            $a = base_path() . "cover-reposition/thumbncrop.inc.php";
            require_once ($a);
            //php class for image resizing & cropping

            $tb = new ThumbAndCrop ();

            $p = base_path() . 'upload/barlogo_orig/' . $picture['file_name'];

            $tb->openImg($p);
            //original cover image

            $newHeight = $tb->getRightHeight($default_cover_width);

            $tb->creaThumb($default_cover_width, $newHeight);

            $tb->setThumbAsOriginal();

            $tb->cropThumb($default_cover_width, $default_cover_height, 0, $crop_from_top);

            $q = base_path() . 'upload/banner_drag/' . $picture['file_name'];
            $tb->saveThumb($q);
            //save cropped cover image

            $tb->resetOriginal();

            $tb->closeImg();

            resize(base_path() . 'upload/banner_drag/' . $picture['file_name'], base_path() . 'upload/banner_drag_thumb/' . $picture['file_name'], 150, 150);
            // $this->image_lib->initialize(array(
            // 'image_library' => $gd_var,
            // 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
            // 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
            // 'maintain_ratio' => FALSE,
            // 'quality' => '100%',
            // 'width' => '685',
            // 'height' => '320',
            // 'x_axis' => $this->input->post('pos'),
            // ));
//
//
            // if(!$this->image_lib->crop())
            // {
            // $error = $this->image_lib->display_errors();
            // }
//
            $bar_banner_img = $picture['file_name'];


            if ($this->input->post('prev_bar_banner') != '') {
                if (file_exists(base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner'))) {
                    $link = base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner');
                    unlink($link);
                }

                if (file_exists(base_path() . 'upload/barlogo/' . $this->input->post('prev_bar_banner'))) {
                    $link2 = base_path() . 'upload/barlogo/' . $this->input->post('prev_bar_banner');
                    unlink($link2);
                }

                if (file_exists(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'))) {
                    $link2 = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');
                    unlink($link2);
                }
            }
        } else {



            if ($this->input->post('prev_bar_banner') != '') {

                if ($this->input->post('pos') != 0) {
                    if (file_exists(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'))) {
                        $link = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');
                        unlink($link);
                    }

                    if (file_exists(base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner'))) {
                        $link = base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner');
                        unlink($link);
                    }

                    $this->load->library('upload');
                    $crop_from_top = abs($this->input->post('pos'));


                    $default_cover_width = 1140;
                    $default_cover_height = 244;
                    $a = base_path() . "cover-reposition/thumbncrop.inc.php";
                    require_once ($a);
                    //php class for image resizing & cropping

                    $tb = new ThumbAndCrop ();

                    $p = base_path() . 'upload/barlogo_orig/' . $this->input->post('prev_bar_banner');

                    $tb->openImg($p);
                    //original cover image

                    $newHeight = $tb->getRightHeight($default_cover_width);

                    $tb->creaThumb($default_cover_width, $newHeight);

                    $tb->setThumbAsOriginal();

                    $tb->cropThumb($default_cover_width, $default_cover_height, 0, $crop_from_top);

                    $q = base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner');


                    $tb->saveThumb($q);
                    //save cropped cover image

                    $tb->resetOriginal();

                    $tb->closeImg();

                    resize(base_path() . 'upload/banner_drag/' . $this->input->post('prev_bar_banner'), base_path() . 'upload/banner_drag_thumb/' . $this->input->post('prev_bar_banner'), 150, 150);
                }
                $bar_banner_img = $this->input->post('prev_bar_banner');
            }
        }
        //$bar_detail = $this->bar_model->get_one_bar($this->input->post('bar_id'));
        //$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
        $data1 = array('user_banner' => $bar_banner_img);
        $this->db->where("user_id", get_authenticateUserID());
        $this->db->update('user_master', $data1);
        redirect('home/updatebanner');
    }

    function socialmedialink($msg = "") {
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        if ($this->session->userdata('user_type') != 'bar_owner') {
            redirect('home');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        //$this->form_validation->set_rules('facebook_link', 'Facebook Link', 'valid_url');
        //$this->form_validation->set_rules('twitter_link', 'Twitter Tink', 'valid_url');
        $this->form_validation->set_rules('linkedin_link', 'Linkedin Link', 'valid_url');
        //$this->form_validation->set_rules('instagram_link', 'Instagram Link', 'valid_url');
        $this->form_validation->set_rules('google_plus_link', 'Google Plus Link', 'valid_url');
        $this->form_validation->set_rules('dribble_link', 'Dribble Link', 'valid_url');
        $this->form_validation->set_rules('pinterest_link', 'Pinterest Link', 'valid_url');
        $data['error'] = '';

        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());

        // print_r($data['getbar']); 
        $data['facebook_link'] = $data['getbar']['facebook_link'];
        $data['twitter_link'] = $data['getbar']['twitter_link'];
        $data['instagram_link'] = $data['getbar']['instagram_link'];
        $data['linkedin_link'] = $data['getbar']['linkedin_link'];
        $data['google_plus_link'] = $data['getbar']['google_plus_link'];
        $data['dribble_link'] = $data['getbar']['dribble_link'];
        $data['pinterest_link'] = $data['getbar']['pinterest_link'];


        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
                $data['facebook_link'] = $this->input->post('facebook_link');
                $data['twitter_link'] = $this->input->post('twitter_link');
                $data['linkedin_link'] = $this->input->post('linkedin_link');
                $data['instagram_link'] = $this->input->post('instagram_link');
                $data['google_plus_link'] = $this->input->post('google_plus_link');
                $data['dribble_link'] = $this->input->post('dribble_link');
                $data['pinterest_link'] = $this->input->post('pinterest_link');
            } else {

                $usr = array('facebook_link' => $this->input->post('facebook_link'),
                    'twitter_link' => $this->input->post('twitter_link'),
                    'instagram_link' => $this->input->post('instagram_link'),
                    'linkedin_link' => $this->input->post('linkedin_link'),
                    'google_plus_link' => $this->input->post('google_plus_link'),
                    'dribble_link' => $this->input->post('dribble_link'),
                    'pinterest_link' => $this->input->post('pinterest_link'),);

                $this->db->where('owner_id', get_authenticateUserID());
                $this->db->update('bars', $usr);


                $data["msg"] = "success";
            }
        }


        if ($data["error"] != "") {
            $response = array("comment_error" => $data["error"], "status" => "fail");
            echo json_encode($response);
            die;
        }

        if ($data["msg"] == "success") {
            $response = array("status" => "success");
            echo json_encode($response);
            die;
        }

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/updatesocialurl', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function barcriteria() {
        $this->session->set_userdata(array('count' => 0));
        $data = array();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $data["site_setting"] = site_setting();
        $data["active_menu"] = 'barcriteria';
        $data["error"] = "";
        $data["site_setting"] = site_setting();

        $data['get_dive_bar'] = $this->home_model->getdivebar();
        if ($_POST) {
            $this->session->set_userdata(array('count' => count($this->input->post('sample')), 'fchk' => $this->input->post('fchk')));
            redirect('bar/suggest_bar');
        }
        $data['statistics'] = $this->home_model->getStatisticsData();
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/criteria', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function adminLogin($user_id) {
        // echo get_cookie('login_for');
        // die;
        //$this->load->helper('cookie');
        //$login_for = get_cookie('login_for');
        //$user_id = get_cookie('user_id');



        $OneUsr = get_user_info($user_id);

        if ($OneUsr != '') {
            $data = array(
                'user_id' => $OneUsr->user_id,
                'email' => $OneUsr->email,
                'user_type' => $OneUsr->user_type,
                'username' => $OneUsr->first_name,
            );
            $this->session->set_userdata($data);
        }


        //delete_cookie('login_for');
        //delete_cookie('user_id');
        redirect('home/dashboard');
    }

    function test123() {
        $login_for = get_cookie('login_for');
        $user_id = get_cookie('user_id');

        $OneUsr = get_user_info($user_id);

        if ($OneUsr != '') {
            $data = array(
                'user_id' => $OneUsr->user_id,
                'email' => $OneUsr->email,
                'user_type' => $OneUsr->user_type,
                'username' => $OneUsr->first_name,
            );
            $this->session->set_userdata($data);
        }


        redirect('home/dashboard');
    }

    function events() {
        echo "sda";
        die;
    }

    function sitemap($msg = '') {
        $data = array();
        $data['msg'] = $msg;
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $data['error'] = '';
        $data['site_setting'] = site_setting();
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        if (get_authenticateUserID() > 0) {
            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        } else {
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        }
        $this->template->write_view('content_center', $theme . '/home/sitemap', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);

        $this->template->render();
    }

    function emaisend() {
        $str = "Your Account Created Successfully";
        email_send('qa@spaculus.com', 'qa@spaculus.com', 'qa@spaculus.com', 'Regitration Syccess', $str);
    }

    function success_user() {
        if (get_authenticateUserID() != '') {
            redirect('home');
        }
        $theme = getThemeName();
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/confirmpage_user', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function sendemail() {
        $message = $this->home_model->user_forgot_password($this->input->post('email'), $this->input->post('type'));
    }

    function getsugbar() {
        $theme = getThemeName();
        $data = array();
        //$bar_detail = $this->bar_model->get_one_bar($this->input->post('id'));
        //$data['bar_detail'] = $bar_detail;
        //$data['result'] = $this->taxiowner_model->gettaxibysearch($bar_detail['city'],$bar_detail['zipcode']);
        echo $this->load->view($theme . '/bar/bar_suggest', $data, TRUE);
        die;
    }

    function redirect_home() {
        redirect(base_url());
    }

    function _facebook_validate($fb_uid = 0, $email = '', $accessToken = '') {
        //this query basically sees if the users facebook user id is associated with a user.
        $bQry = $this->home_model->validate_user_facebook($fb_uid, $email, $accessToken);

        //echo $bQry;
        if ($bQry == '2') {
            //$this->session->set_flashdata('msg', 'login');
            $this->session->set_flashdata('successmsg', "loginSuccess");
            redirect('user/profile/' . base64_encode(get_authenticateUserID()));
            //redirect('home/dashboard');
            //redirect('home/facebook_login');
        } elseif ($bQry) { // if the user's credentials validated...
            //$this->session->set_flashdata('msg', 'login');
            $this->session->set_flashdata('successmsg', "loginSuccess");
            redirect('user/profile/' . base64_encode(get_authenticateUserID()));
            //redirect('home/facebook_login');
        } else {
            // incorrect username or password
            $data = array();
            $data["login_failed"] = TRUE;
            $this->index($data);
        }
    }

    function facebook() {
        //  $this->load->library('upload');
        if (!$this->fb_connect->fbSession) {
            redirect('home');
        } else {
            $fb_uid = $this->fb_connect->user_id;
            $fb_usr = $this->fb_connect->user;

            $accessToken = '';

            if ($fb_uid != '') {
                $this->session->set_userdata(array("facebook_id" => $fb_uid));
            }

            if ($fb_uid != false) {
                if (isset($fb_usr["email"])) {
                    $email = $fb_usr["email"];
                } else {
                    $email = '';
                }

                $usr = $this->home_model->get_user_by_fb_uid($fb_uid, $email);

                if ($usr) {
                    $this->_facebook_validate($fb_uid, $email, $accessToken);
                } else {
                    $fname = $fb_usr["first_name"];
                    $lname = $fb_usr["last_name"];
                    $fullname = $fb_usr["name"];
                    $pwd = '';
                    $fb_img = '';

                    $base_path = base_path();
                    $image_settings = image_setting();
                    $img = file_get_contents('https://graph.facebook.com/' . $fb_uid . '/picture?type=large');
                    $file = base_path() . "upload/user_orig/" . $fb_uid . ".jpg";

                    file_put_contents($file, $img);
                    $fb_img = $fb_uid . '.jpg';
                    $config['upload_path'] = $base_path . 'upload/user_orig/';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
                    //$config['max_size']	= '100';// in KB
                    $this->load->library('upload', $config);
                    $config['source_image'] = $this->upload->upload_path . $fb_img;
                    $config['new_image'] = base_path() . "upload/user_thumb/";
                    $config['thumb_marker'] = "";
                    //$config['maintain_ratio'] = $image_settings['u_ratio'];
                    $config['create_thumb'] = TRUE;
                    $config['width'] = 120;
                    $config['height'] = 120;
                    $this->load->library('image_lib', $config);
                    $gd_var = 'gd2';
                    if (!$this->image_lib->resize()) {
                        echo $error = $this->image_lib->display_errors();
                        die;
                    }

                    $fb_values = array(
                        'fb_id' => $fb_uid,
                        'first_name' => strtolower(str_replace(" ", "", $fname)),
                        'last_name' => strtolower(str_replace(" ", "", $lname)),
                        'email' => $email,
                        'fb_img' => $fb_img,
                        'type' => 'facebook'
                    );

                    //print_r($fb_values)
                    //if(GetDomainId() > 0){
                    $this->home_model->save_social_data($fb_values);
                    //$this->session->set_flashdata('msg', 'login');
                    $this->session->set_flashdata('successmsg', "loginSuccess");
                    redirect('home/dashboard');
                }
            }
        }
    }

    function test_paypal() {
        $card = new CreditCard();
        $card->setType("visa")
                ->setNumber("4148529247832259")
                ->setExpireMonth("11")
                ->setExpireYear("2019")
                ->setCvv2("012")
                ->setFirstName("Joe")
                ->setLastName("Shopper");

// ### FundingInstrument
// A resource representing a Payer's funding instrument.
// For direct credit card payments, set the CreditCard
// field on this object.
        $fi = new FundingInstrument();
        $fi->setCreditCard($card);

// ### Payer
// A resource representing a Payer that funds a payment
// For direct credit card payments, set payment method
// to 'credit_card' and add an array of funding instruments.
        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
                ->setFundingInstruments(array($fi));

// ### Itemized information
// (Optional) Lets you specify item wise
// information
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);
        $item2 = new Item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
        $details = new Details();
        $details->setShipping(1.2)
                ->setTax(1.3)
                ->setSubtotal(17.5);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency("USD")
                ->setTotal(20)
                ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description")
                ->setInvoiceNumber(uniqid());

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to sale 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction));

// For Sample Purposes Only.
        $request = clone $payment;

// ### Create Payment
// Create a payment by calling the payment->create() method
// with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
// The return object contains the state.
        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
            exit(1);
        }

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);
        echo "<pre>";
        print_r($payment);
    }

    function contentView($pages_slug = '') {

        $is_valid_page = $this->home_model->is_valid_page_by_slug($pages_slug);
        $data = array();
        $data['page_name'] = $pages_slug;
        $data['result'] = $is_valid_page;
        $data['m_css'] = 'mview';
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $this->template->write_view('content_center', $theme . '/common/content', $data, TRUE);
        $this->template->render();
    }

    function contentViewarticle($id = '') {

        $is_valid_page = $this->home_model->is_valid_page_by_slug_id($id);
        $data = array();
        $data['site_setting'] = site_setting();
        $data['blog_detail'] = $is_valid_page;
        $data['m_css'] = 'mview';
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $this->template->write_view('content_center', $theme . '/common/articlecontent', $data, TRUE);
        $this->template->render();
    }

    function changestate() {
        $data = array('is_read' => 1);
        $this->db->where('message_id', $this->input->post('id'));
        $this->db->update('broadcast_message', $data);
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
                        redirect('home/claim_bar_owner_verify_code/' . "/" . base64_encode($bar_id));
                    } else {
                        $barid = $this->input->post('temp_id');
                        redirect('home/claim_bar_owner_verify_code/' . "/" . base64_encode($bar_id));
                    }
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/claim_bar_owner_register', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function claim_bar_owner_verify_code($bar_id = '') {
        if (check_user_authentication() != '') {
            redirect('home');
        }

        if ($bar_id == "") {
            redirect('home');
        }

        $bar_id = base64_decode($bar_id);

        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = $bar_id;
        $data['type'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
        $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
        $data['one_user'] = $this->home_model->get_availability($bar_id);

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('code', 'Verification Code is missing', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $this->db->where('bar_id', $bar_id);
                $bar_info = $this->db->get('bars')->row();
                if ($bar_info != NULL) {
                    $code = $bar_info->claim_code;

                    if ($code == $this->input->post('code')) {
                        redirect('home/claimbar_owner_info/' . base64_encode($bar_id));
                    } else {
                        $data["error"] = "Invalid verification code.";
                    }
                } else {
                    $data["error"] = "Internal Error";
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/claim_bar_owner_verify_code', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function claimbar_owner_info($bar_id = '') {
        if ($bar_id == '') {
            redirect('home');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data['bar_id'] = base64_decode($bar_id);
        $bar_id = base64_decode($bar_id);
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
        $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $email = $this->input->post('email');
                $pass = randomCode();
                $data_insert['mobile_no'] = $data['getbardata']['claim_phone'];
                $data_insert['first_name'] = $firstname;
                $data_insert['last_name'] = $lastname;
                $data_insert['email'] = $email;
                $data_insert['status'] = 'active';
                $data_insert['is_deleted'] = 'no';
                $data_insert['user_type'] = 'bar_owner';
                $data_insert['password'] = md5($pass);
                $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
                $data_insert['sign_up_date'] = date('Y-m-d H:i:s');
                $this->db->insert('user_master', $data_insert);
                $uid = mysql_insert_id();
                $data['user_id'] = $uid;

                $getlat = getCoordinatesFromAddress($data['getbardata']['address'], $data['getbardata']['city'], $data['getbardata']['state']);
                $data_insert_new["lat"] = $getlat['lat'];
                $data_insert_new["lang"] = $getlat['lng'];
                $data_insert_new['owner_name'] = $firstname . " " . $lastname;
                $data_insert_new['email'] = $email;
                $data_insert_new['claim'] = 'claimed';
                $data_insert_new['owner_id'] = $uid;
                $data_insert_new['owner_type'] = 'bar_owner';
                $data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
                $data_insert_new['bar_meta_keyword'] = $data['getbardata']['bar_meta_keyword'];
                $data_insert_new['date_added'] = date('Y-m-d H:i:s');
                $data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
                $this->db->where('bar_id', $bar_id);
                $this->db->update('bars', $data_insert_new);
                $data['one_user'] = $this->home_model->get_availability($bar_id);

                $this->session->set_userdata(array('user_id' => $uid));
                $uid = base64_encode($uid);
                $this->session->set_userdata(array('userid_sess' => $uid, 'user_type' => 'bar_owner'));

                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Successfully Registration'");
                $email_temp = $email_template->row();
                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;
                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;
                $user_name = $firstname . " " . $lastname;
                $email_to = $email;
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{user_name}', $user_name, $email_message);
                $email_message = str_replace('{email}', $email, $email_message);
                $email_message = str_replace('{password}', $pass, $email_message);
                $str = $email_message;
                if ($email_temp->status == 'active') {
                    email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                }

                $account_sid = 'AC5d7f1511f026bd36a6d3eac9cb2a2d82';
                $auth_token = 'd79f765dae55cbf3755b261e6d47e222';
                $client = new TwilioClient($account_sid, $auth_token);
                $phone_number = $data['getbardata']['claim_phone'];
                $body = "Your American Bars profile login is\nUsername: " . $email . "\nPassword: " . $pass . "\nWelcome to American Bars, the largest bar customer network in the US.";

                try {
                    $client->account->messages->create($phone_number, array(
                        'from' => '+13102725642',
                        'body' => $body,
                            )
                    );
                } catch (Exception $e) {
                    
                }

                /* --------- E-mail To Super Admin ---- */

                $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Claim Bar'");
                $email_temp = $email_template->row();
                $barname = ucwords($data['getbardata']['bar_title']);

                $email_address_from = $email_temp->from_address;
                $email_address_reply = $email_temp->reply_address;

                $email_subject = $email_temp->subject;
                $email_message = $email_temp->message;

                $email = getsuperadminemail();

                $type = 'Half Mug';
                $username = ucwords($firstname) . " " . ucwords($lastname);
                $email_to = $email;

                $email_subject = str_replace('{barname}', $barname, $email_subject);
                $email_message = str_replace('{break}', '<br/>', $email_message);
                $email_message = str_replace('{barname}', $barname, $email_message);
                $email_message = str_replace('{type}', $type, $email_message);
                $email_message = str_replace('{username}', $username, $email_message);
                $str = $email_message;
                $getemail = explode(',', $email);
                if ($email_temp->status == 'active') {
                    foreach ($getemail as $r) {
                        email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
                    }
                }

                redirect('home/claimbar_type/' . base64_encode($bar_id));
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/claim_bar_owner_info', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function claimbar_type($bar_id = '') {
        $uid = $this->session->userdata("userid_sess");

        if ($bar_id == '' || $uid == '') {
            redirect('home/');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data["uid"] = $uid;
        $data["bar_id"] = $bar_id;
        $data["type"] = 1;
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;

        $bar_id = base64_decode($bar_id);

        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('btype', 'Free Listing Or Paid Listing', 'required');


        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $btype = $this->input->post('btype');
                $btypestr = 'halfmug';
                if ($btype == 0) {
                    $btypestr = "halfmug";
                } else if ($btype == 1) {
                    $btypestr = "fullmug";
                } else if ($btype == 2) {
                    $btypestr = "managed";
                }
                $uid = $this->session->userdata('userid_sess');
                $this->session->unset_userdata('viewid');
                $this->session->unset_userdata('userid_sess');

                if ($btypestr == "halfmug") {
                    redirect('/home/success_page/' . $uid);
                }


                redirect('home/registration_step3_upgrade/' . base64_encode($bar_id) . "/" . $btypestr);
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/registration_step2', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function claimbar_registration_step5($uid) {

        if ($uid == '') {
            redirect('home/bar_owner_register');
        }


        $theme = getThemeName();
        $data['error'] = '';
        //$data['bar_id'] = $bar_id;
        $data['user_id'] = base64_decode($uid);
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $page_detail = meta_setting();
        $pageTitle = $page_detail->title;
        $metaDescription = $page_detail->meta_description;
        $metaKeyword = $page_detail->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);
        $this->load->library('form_validation');
        $data['get_user_info'] = get_user_info($data['user_id']);
        $this->form_validation->set_rules('code', 'Code', 'required');

        if ($_POST) {
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $data["error"] = validation_errors();
                } else {
                    $data["error"] = "";
                }
            } else {
                $user_id = $this->home_model->checkcode();

                if ($user_id != "" && $user_id['confirm_code'] != '') {
                    $pass = randomCode();
                    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Successfully Registration'");
                    $email_temp = $email_template->row();
                    $email_address_from = $email_temp->from_address;
                    $email_address_reply = $email_temp->reply_address;
                    $email_subject = $email_temp->subject;
                    $email_message = $email_temp->message;
                    $email = $data['get_user_info']->email;
                    $user_name = $data['get_user_info']->first_name . " " . $data['get_user_info']->last_name;
                    $email_to = $email;
                    $email_message = str_replace('{break}', '<br/>', $email_message);
                    $email_message = str_replace('{user_name}', $user_name, $email_message);
                    $email_message = str_replace('{email}', $email, $email_message);
                    $email_message = str_replace('{password}', $pass, $email_message);
                    $str = $email_message;
                    if ($email_temp->status == 'active') {
                        email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
                    }
                    $data_up = array('status' => "active", 'confirm_code' => '', 'password' => md5($pass));
                    $this->db->where('user_id', $this->input->post('user_id'));
                    $this->db->update('user_master', $data_up);

                    $data_up12 = array('status' => "active");
                    $this->db->where('taxi_owner_id', $this->input->post('user_id'));
                    $this->db->update('taxi_directory', $data_up12);

                    $data_up1 = array('status' => "active");
                    $this->db->where('owner_id', $this->input->post('user_id'));
                    $this->db->update('bars', $data_up1);
                    $this->session->unset_userdata('userid_sess');


                    redirect('home/success_page/' . base64_encode($this->input->post('user_id')));
                }
                // elseif($user_id['confirm_code']=='') {
                // $this->session->unset_userdata('userid_sess');
                // redirect('home/index/reg_link_expire');
//
                // }
                else {
                    $data["error"] = "<p>Please Enter Correct Confirmation Code .</p>";
                }
            }
        }

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/confirm', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();


        //return $uid;
    }

    function testnew() {
        $theme = getThemeName();
        echo $theme . '/home/confirm';
        $amount = 5500;
        $tot = 0;
        $rupees = array(1000, 500, 100, 50, 20, 10);
        $count = array(0, 0, 0, 0, 0);

        for ($i = 0; $i <= count($rupees); $i++) {
            if ($rupees[$i] == $amount) {


                echo $amount;
            }
        }
    }

    function socialshare($msg = '', $scrname = '') {

        if (!check_user_authentication()) {
            redirect('home');
        }

        if ($this->session->userdata('user_type') != 'bar_owner') {
            redirect('home');
        }

        $bar_info = $this->home_model->get_bar_info(get_authenticateUserID());
        if ($bar_info['bar_type'] == 'half_mug') {
            redirect('home/dashboard');
        }

        // cho "Fdsa";
        $this->load->library('fb_connect');
        $this->load->library('facebook');

        $config = array(
            'appId' => '322878041237170',
            'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
            'fileUpload' => true,
            'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
        );

        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();
        $data['fb_usr'] = $this->fb_connect->user;
        $data['user_id'] = $user_id;

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('comment', 'Comment');

        $data['screener_name'] = $scrname;

        $this->load->library('HybridAuthLib');
        $data['providers'] = $this->hybridauthlib->getProviders();

        foreach ($data['providers'] as $provider => $d) {
            if ($d['connected'] == 1) {
                try {
                    $service = $this->hybridauthlib->authenticate($provider);
                    if ($service->isUserConnected()) {
                        if (!Hybrid_Auth::storage()->get("hauth_session.$provider.account")) {
                            $profile = $service->getUserProfile();
                            if ($profile != null) {
                                $account_name = end(explode('/', $profile->identifier));
                                $data['providers'][$provider]['user_profile'] = $profile;
                                Hybrid_Auth::storage()->set("hauth_session.$provider.account", $account_name);
                            }
                        }
                    }
                    $data['providers'][$provider]['account'] = Hybrid_Auth::storage()->get("hauth_session.$provider.account");
                } catch (Exception $e) {
                    $data["error"] = "Couldn't authenticate with " . $provider . $e->getMessage();
                    $data['providers'][$provider] = false;
                }
            } else {
                
            }
        }

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/socialshare1', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function twitter() {
        $this->load->library('twconnect');
        /* twredirect() parameter - callback point in your application */
        /* by default the path from config file will be used */
        $this->session->set_userdata('tw_access_token', '');
        $this->session->set_userdata('tw_status', '');

        $ok = $this->twconnect->twredirect('home/twitter_callback');
        // //print_r($ok); die;
        // if (!$ok) {
        // //echo 'Could not connect to Twitter. Refresh the page or try again later.';
        // $this->session->set_flashdata('errormsg', 'nottoken');
        // //redirect('home/index/'. base64_encode('login'));
        // redirect('home/login/');
        // }
    }

    function twitter_callback() {

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');
        $data = array();
        $this->load->library('twconnect');
        $ok = $this->twconnect->twprocess_callback();


        //echo $ok;
        if ($ok) {
            $this->twconnect->twaccount_verify_credentials();
            $success_respose = $this->twconnect->tw_user_info;

            $this->session->set_userdata('screen_name', $success_respose->screen_name);

            $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
            $this->template->write_view('content_center', $theme . '/home/socialshare123', $data, TRUE);
            $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
            $this->template->render();
            //echo('JavaScript:eval(window.close(););');
            //echo "success"; die;
            //echo 'test <pre>';  print_r($ok); die;
            // saves Twitter user information to $this->twconnect->tw_user_info
            // twaccount_verify_credentials returns the same information
            //$this->twconnect->twaccount_verify_credentials();
            //$content = $this->twconnect->tw_post('statuses/update', array('status' => 'Test Tweet'));
            //print_r($conte); die;
            //$success_respose=$this->twconnect->tw_user_info;
            //	//redirect('http://google.com');
            //	$this->session->set_userdata('screen_name', $success_respose->screen_name);
            //	redirect('home/socialshare/tweeter/'.$this->session->userdata('screen_name'));
            //redirect('home/socialshare/tweeter/'.$this->session->userdata('screen_name')); 
        } else {
            redirect('home/socialshare/tw_wrong');
        }
    }

    function shareontwitter() {
        $image = 'http://sandbox.americanbars.com/default/images/americanbars.png';
        //print_r(file_get_contents($image));
        //die;
        $this->load->library('twconnect');
        define("CONSUMER_KEY", "I8FPWn9NgmM1i5we1FIByLuon");
        define("CONSUMER_SECRET", "zsHqDh6U7a4ROLcH7WWC8BQmV8le2G6LMwsfSCRtVopRWvFrq7");
        define("OAUTH_TOKEN", "3590956093-YOxMk8OgfcSsmLB11meR2VHJVky2mmqcrTb3a3n");
        define("OAUTH_SECRET", "JM17psGjJxOk6vmcu45OglkD3X7oXeIGnuivPp0uLDQTD");
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
        $content = $connection->get('account/verify_credentials');

        $status_message = 'Attaching an image to a tweet';
        //$status = $connection->request('statuses/update_with_media', array('status' => $status_message, 'media' =>  "{$image}"));
        $content1 = $this->twconnect->tw_post('statuses/update', array('status' => $this->input->post('comment') . " -Posted through http://sandbox.americanbars.com"));


        if ($content1 && !isset($content1->errors)) {
            $dataarr = array('user_id' => get_authenticateUserID(),
                'post_to' => 'twitter',
                'date' => date('Y-m-d h:i:s'),
                'comment' => $this->input->post('comment')
            );
            $this->db->insert('social_post', $dataarr);
            redirect('home/twitterpost/success');
        } else {
            redirect('home/socialshare/twerror');
        }

        //echo json_encode($status);
    }

    function shareoninstagram() {
        require(APPPATH . 'instagram/src/Instagram.php');



        $username = $this->session->userdata("insta_username");
        $password = $this->session->userdata("insta_password");
        //echo $username;
        //$username = "php.viral";
        //$password = "viral@123";
        $debug = false;

//$photo = 'http://www.themobileindian.com/images/nnews/2015/10/16989/reglobe.jpg';     // path to the photo
//$caption = null;   // caption


        $photo = '';
        if (isset($_FILES['image_insta']) && $_FILES['image_insta']["name"] != '') {
            $this->load->library('upload');
            $rand = rand(0, 100000);

            $_FILES['userfile']['name'] = $_FILES['image_insta']['name'];
            $_FILES['userfile']['type'] = $_FILES['image_insta']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['image_insta']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['image_insta']['error'];
            $_FILES['userfile']['size'] = $_FILES['image_insta']['size'];

            $config['file_name'] = 'comment' . $rand;

            $config['upload_path'] = base_path() . 'upload/temp/';

            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->upload->initialize($config);

            if (!$this->upload->do_upload()) {
                echo $error = $this->upload->display_errors();
                die;
            }


            $picture = $this->upload->data();

            $photo = $picture['file_name'];
        }
        $caption = $this->input->post('comment_insta') . " -Posted through http://sandbox.americanbars.com";   // caption
        //////////////////////

        $i = new Instagram($username, $password, $debug);

        try {
            $i->login();
        } catch (InstagramException $e) {
            $e->getMessage();
            exit();
        }

        try {
            if ($photo) {
                $photo = 'http://sandbox.americanbars.com/upload/temp/' . $photo;
            }



            $i->uploadPhoto($photo, $caption);
            $dataarr = array('user_id' => get_authenticateUserID(),
                'post_to' => 'instagram',
                'image' => $photo,
                'date' => date('Y-m-d h:i:s'),
                'comment' => $this->input->post('comment_insta'),
            );
            $this->db->insert('social_post', $dataarr);
            redirect('home/instagrampost/success');
        } catch (Exception $e) {
            redirect('home/instagrampost/success');
            //echo $e->getMessage();
        }
    }

    function instagramlogin_ajax() {

        require(APPPATH . 'instagram/src/Instagram.php');
        $theme = getThemeName();
        $data['error'] = '';
        $data["msg"] = '';
        $data['active_menu'] = '';
        $this->template->set_master_template($theme . '/template.php');

        $meta_setting = meta_setting();
        $pageTitle = $meta_setting->title;
        $metaDescription = $meta_setting->meta_description;

        $metaKeyword = $meta_setting->meta_keyword;
        $this->template->write('pageTitle', $pageTitle, TRUE);
        $this->template->write('metaDescription', $metaDescription, TRUE);
        $this->template->write('metaKeyword', $metaKeyword, TRUE);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('insta_username', 'Username', 'required');
        $this->form_validation->set_rules('insta_password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }
            $data["email"] = $this->input->post('email');
        } else {
            $instauser = $this->input->post('insta_username');
            $instapassword = $this->input->post('insta_password');
            $i = new Instagram($instauser, $instapassword, false);

            try {
                $i->login();

                $data_insta = array('insta_username' => $instauser,
                    'insta_password' => $instapassword,
                );

                $this->session->set_userdata($data_insta);
                $data['msg'] = "success";
            } catch (InstagramException $e) {
                $e->getMessage();
                $data['error'] = "<p>" . $e->getMessage() . "</p>";
                //exit();
            }

            // if($message=="success")
            // {
            // $data['msg'] = "success";
            // }
            // else if($message=="inactive")
            // {
            // $data['error']="<p>Your account is Inactive. Please, Contact to your Administrator.</p>";
            // }
            // else if($message=="suspend")
            // {
            // $data['error']="<p>Your account is Suspended. Please, Contact to your Administrator.</p>";
            // }
            // else
            // {
            // $data['error']="<p>Email Address Not Found.</p>";
            // }
        }

        echo json_encode($data);
        exit;
        // $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
        // $this->template->write_view('content_center',$theme .'/layout/common/forget_password',$data,TRUE);
        // $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
        // $this->template->render();
    }

    function insta_logout() {
        $this->session->unset_userdata("insta_username");
        $this->session->unset_userdata("insta_password");

        redirect('home/socialshare/logout');
    }

    function twitterlogout() {
        $this->session->unset_userdata("screen_name");
        redirect('home/socialshare/logout');
    }

    function postfb() {
        //require_once(APPPATH.'Facebook-master/facebook.php');
        // $config = array(
        // 'appId' => '322878041237170',
        // 'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
        // 'fileUpload' => true,
        // 'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
        // );
//
        // $facebook = new Facebook($config);
        // $user_id = $facebook->getUser();
//  
        // $loginUrl = $facebook->getLoginUrl();
        // header('Location:' . $loginUrl . '&scope=user_photos,publish_actions');
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data = array();
        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/socialsharefb', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function shareonfacebook() {
        $config = array(
            'appId' => '322878041237170',
            'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
            'fileUpload' => true,
            'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
        );

        $facebook = new Facebook($config);

        $user_id = $facebook->getUser();

        //echo $user_id;
        if ($user_id == '' || $user_id == 0) {
            redirect('home/socialshare');
        }
        $photo = '';

        if (isset($_FILES['image_facebook']) && $_FILES['image_facebook']["name"] != '') {
            $this->load->library('upload');
            $rand = rand(0, 100000);

            $_FILES['userfile']['name'] = $_FILES['image_facebook']['name'];
            $_FILES['userfile']['type'] = $_FILES['image_facebook']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['image_facebook']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['image_facebook']['error'];
            $_FILES['userfile']['size'] = $_FILES['image_facebook']['size'];

            $config['file_name'] = 'comment' . $rand;

            $config['upload_path'] = base_path() . 'upload/temp/';

            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->upload->initialize($config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
            }


            $picture = $this->upload->data();

            $this->load->library('image_lib');

            $this->image_lib->clear();


            $gd_var = 'gd2';


            if ($_FILES["image_facebook"]["type"] != "image/png" and $_FILES["image_facebook"]["type"] != "image/x-png") {

                $gd_var = 'gd2';
            }


            if ($_FILES["image_facebook"]["type"] != "image/gif") {

                $gd_var = 'gd2';
            }


            if ($_FILES["image_facebook"]["type"] != "image/jpeg" and $_FILES["image_facebook"]["type"] != "image/pjpeg") {

                $gd_var = 'gd2';
            }


            $photo = $picture['file_name'];
        }
        $caption = $this->input->post('comment_facebook');



        if ($this->input->post('page_id') == '') {
            if ($photo) {
                $photo = "http://sandbox.americanbars.com/upload/temp/" . $photo;
            }
            if ($photo) {

                $param = array(
                    'message' => $caption . " - Posted through http://sandbox.americanbars.com",
                    'description' => ' ',
                    'caption' => ' ',
                    'name' => '  ',
                    'title' => ' ',
                    'picture' => $photo,
                    'link' => "http://sandbox.americanbars.com",
                );
            } else {
                $param = array(
                    'message' => $caption . " - Posted through http://sandbox.americanbars.com",
                    'description' => ' ',
                    'caption' => ' ',
                    'name' => '  ',
                    'title' => ' ',
                    'picture' => $photo,
                    'link' => '');
            }




            $posted = $facebook->api('/me/feed/', 'post', $param);
//
// $facebook->setFileUploadSupport(true); 
// $args = array('message' => 'My Friend\'s'); $args['image'] = '@' . $photo;
            // $data = $facebook->api('/me/photos', 'post', $args);
            // print_r($data);
//  
// die;
        } else {
            $datatick['page_id'] = $this->input->post('page_id');
            if ($photo) {
                $photo = "http://sandbox.americanbars.com/upload/temp/" . $photo;
            }
            if (isset($datatick['page_id']) && is_array($datatick['page_id'])) {
                foreach ($datatick['page_id'] as $key => $each) {

                    $page = split("-", $datatick['page_id'][$key]);
                    $page_token = $page[0];
                    $page_id = $page[1];
                    if ($photo) {

                        $publish = $facebook->api('/' . $page_id . '/feed', 'post', array('access_token' => $page_token,
                            'message' => $caption . " - Posted through http://sandbox.americanbars.com",
                            'from' => '322878041237170',
                            'to' => $page_id,
                            'description' => ' ',
                            'caption' => ' ',
                            'name' => '  ',
                            'title' => ' ',
                            'link' => "http://sandbox.americanbars.com",
                            'picture' => $photo,
                        ));
                    } else {
                        $publish = $facebook->api('/' . $page_id . '/feed', 'post', array('access_token' => $page_token,
                            'message' => $caption . " - Posted through http://sandbox.americanbars.com",
                            'from' => '322878041237170',
                            'description' => ' ',
                            'caption' => ' ',
                            'name' => '  ',
                            'title' => ' ',
                            'picture' => $photo,
                        ));
                    }
                }
            }
        }
        // $facebook->setFileUploadSupport(true);
//
//
        // $post_url = '/'.$user_id.'/photos';
        // //posts message on page statues
        // $msg_body = array(
        // 'source'=>'@'.$photo,
        // 'message' => "Fdsa"
        // );
        // $postResult = $facebook->api($post_url, 'post', $msg_body );
//
        // die;




        $dataarr = array('user_id' => get_authenticateUserID(),
            'post_to' => 'facebook',
            'date' => date('Y-m-d h:i:s'),
            'image' => $photo,
            'comment' => $caption
        );
        $this->db->insert('social_post', $dataarr);
        redirect('home/facebookpost/success');
    }

    function twitterpost($msg = '') {
        // if($this->session->userdata('screen_name')=='')
        // {
        // redirect('home/socialshare');
        // }
        // if(!check_user_authentication())
        // { redirect('home'); }	 
        // cho "Fdsa";
        //}
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('comment', 'Comment');
        $data['screener_name'] = $this->session->userdata('screen_name');
        $data['getpostfb'] = $this->home_model->getAllPost('facebook');
        $data['getposttw'] = $this->home_model->getAllPost('twitter');
        $data['getpostin'] = $this->home_model->getAllPost('instagram');



        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/socialshare_twitter', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function facebookpost($msg = '') {

        if (!check_user_authentication()) {
            redirect('home');
        }
        // cho "Fdsa";
        //}

        $this->load->library('fb_connect');
        $this->load->library('facebook');

        $config = array(
            'appId' => '322878041237170',
            'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
            'fileUpload' => true,
            'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
        );

        $facebook = new Facebook($config);

        $data['token'] = $facebook->getAccessToken();
        $graph_url_pages = "https://graph.facebook.com/me/accounts?access_token=" . $data['token'];
        $pages = json_decode(file_get_contents($graph_url_pages)); // get all pages information from above url.


        $data['pages'] = $pages;
        if ($msg == 'logout') {
            $facebook->destroySession();
            redirect('home/socialshare/logout');
        }
        $user_id = $facebook->getUser();
        $data['fb_usr'] = $this->fb_connect->user;
        $data['user_id'] = $user_id;

        // echo $user_id;
        if ($user_id == '' || $user_id == 0) {
            //echo "Fdsa";
            redirect('home/socialshare');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('comment', 'Comment');
        $data['screener_name'] = '';
        $data['getpostfb'] = $this->home_model->getAllPost('facebook');
        $data['getposttw'] = $this->home_model->getAllPost('twitter');
        $data['getpostin'] = $this->home_model->getAllPost('instagram');



        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/socialshare_facebook', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function instagrampost($msg = '') {
        $username = $this->session->userdata("insta_username");
        $password = $this->session->userdata("insta_password");

        if (!check_user_authentication()) {
            redirect('home');
        }
        // cho "Fdsa";
        //}

        if ($username == '') {
            redirect('home/socialshare');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "credit_card_update";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('comment', 'Comment');
        $data['screener_name'] = '';
        $data['getpostfb'] = $this->home_model->getAllPost('facebook');
        $data['getposttw'] = $this->home_model->getAllPost('twitter');
        $data['getpostin'] = $this->home_model->getAllPost('instagram');



        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/socialshare_instagram', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function fbreturn() {
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data = array();

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/fbclose', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function jay() {
        echo "Posted through American Bars";
    }

    function getevent() {
        include(APPPATH . "eventbrite/Eventbrite.php");
        //session_start();
// 2. Create a login widget OR redirect:
        $authentication_tokens = array('app_key' => '7HRYQFSYT6D2TXYMIJ',
            'user_key' => '1468299181180406035308');
        $eb_client = new Eventbrite($authentication_tokens);

        //echo "<pre>";
        $event = json_decode(file_get_contents('https://www.eventbriteapi.com/v3/events/search/?venue.country=US&categories=103%2C110&token=RWHPUCAOVGFCX6V5Z37G'));


        // echo "<pre>";
        // print_r($event);
        // die;
        //$pagestart = $event->pagination->page_number;
        $pagestart = 301;
        $pageend = 328;
        //$pageend = $event->pagination->page_count;
        for ($i = $pagestart; $i <= $pageend; $i++) {
            //echo $i."<br>";
            $event1 = json_decode(file_get_contents('https://www.eventbriteapi.com/v3/events/search/?venue.country=US&expand=venue,category,organizer&token=RWHPUCAOVGFCX6V5Z37G&page=' . $i . '&categories=103%2C110'));
            //  print_r($event1);
            //  die;
            if ($event1->events) {
                foreach ($event1->events as $row) {

                    if (isset($row->category) && $row->category->name != '') {
                        $cat = $row->category_id;
                        if ($cat == '103') {
                            $cat = 42;
                        }
                        if ($cat == '110') {
                            $cat = 38;
                        }
                    } else {
                        $cat = '';
                    }
                    $array = array('event_title' => $row->name->text != '' ? $row->name->text : '',
                        'event_desc' => $row->description->text != '' ? $row->description->text : '',
                        'address' => $row->venue->address->address_1 != '' ? $row->venue->address->address_1 : '',
                        'city' => $row->venue->address->city != '' ? $row->venue->address->city : '',
                        'state' => $row->venue->address->region != '' ? $row->venue->address->region : '',
                        'zipcode' => $row->venue->address->postal_code != '' ? $row->venue->address->postal_code : '',
                        'event_lat' => $row->venue->address->latitude != '' ? $row->venue->address->latitude : '',
                        'event_lng' => $row->venue->address->longitude != '' ? $row->venue->address->longitude : '',
                        'date_added' => date('Y-m-d H:i:s', strtotime($row->created)),
                        'organizer' => $row->organizer->name != '' ? $row->organizer->name : '',
                        'eid' => $row->id,
                        'event_upload_type' => 'image',
                        'event_category' => $cat,
                    );

                    $this->db->insert('events', $array);
                    $id = mysql_insert_id();

                    $startdate = date('Y-m-d', strtotime(@$row->start->local));
                    $enddate = date('Y-m-d', strtotime(@$row->end->local));
                    $datetime1 = date_create($startdate);
                    $datetime2 = date_create($enddate);
                    $interval = date_diff($datetime1, $datetime2);
                    $day = $interval->format('%a');

                    for ($j = 0; $j <= $day; $j++) {
                        $date = array('eventdate' => date('Y-m-d', strtotime($startdate . ' + ' . $j . ' days')),
                            'eventstarttime' => date('H:i A', strtotime($row->start->local)),
                            'eventendtime' => date('H:i A', strtotime($row->end->local)),
                            'event_id' => $id);
                        $this->db->insert('event_time', $date);
                    }


                    $rand = rand(0, 100000);
                    if (isset($row->logo->url) && $row->logo->url != '') {
                        $fb_img = '';
                        $base_path = base_path();
                        $image_settings = image_setting();

                        $img = @file_get_contents($row->logo->url);

                        //echo  $img;
                        if ($img) {
                            $file = base_path() . "upload/bar_eventgallery_orig/" . $rand . "eventgallery.jpg";

                            file_put_contents($file, $img);
                            $fb_img = $rand . 'eventgallery.jpg';
                            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
                            //$config['max_size']	= '100';// in KB
                            $this->load->library('upload', $config);
                            $config['source_image'] = $this->upload->upload_path . $fb_img;
                            //$config['new_image'] = base_path()."upload/user_thumb/";
                            //$config['thumb_marker'] = "";
                            //$config['maintain_ratio'] = $image_settings['u_ratio'];
                            //$config['create_thumb'] = TRUE;
                            //$config['width'] = 120;
                            //$config['height'] = 120;

                            $picture = $this->upload->data();

                            $this->load->library('image_lib');
                            $gd_var = 'gd2';
                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_big/' . $fb_img, 394, 290);


                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb/' . $fb_img, 70, 70);

                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_250by150/' . $fb_img, 240, 150);

                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_304by201/' . $fb_img, 304, 201);

                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_225/' . $fb_img, 225, 225);
                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_840by720/' . $fb_img, 840, 720);

                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_261/' . $fb_img, 261, 261);


                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_140/' . $fb_img, 140, 140);
                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_200/' . $fb_img, 200, 200);

                            $this->image_lib->clear();

                            resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_600/' . $fb_img, 600, 600);


                            $company_image = $fb_img;
                            $pg = array('bar_eventgallery_id' => $id, 'event_image_name' => $company_image);
                            $this->db->insert('event_images', $pg);
                        }
                    }
                }
            }
        }
    }

    function update_event_cron() {
        $event = json_decode(file_get_contents('https://www.eventbriteapi.com/v3/events/search/?venue.country=US&date_created.keyword=yesterday&token=RWHPUCAOVGFCX6V5Z37G&categories=103%2C110'));
        $pagestart = $event->pagination->page_number;
        $pageend = $event->pagination->page_count;
        if (!empty($event->events)) {

            for ($i = $pagestart; $i <= $pageend; $i++) {
                $event1 = json_decode(file_get_contents('https://www.eventbriteapi.com/v3/events/search/?venue.country=US&date_created.keyword=yesterday&expand=venue,category,organizer&token=RWHPUCAOVGFCX6V5Z37G&page=' . $i . 'categories=103%2C110'));
                if ($event1->events) {
                    foreach ($event1->events as $row) {
                        if (isset($row->category) && $row->category->name != '') {
                            $cat = $row->category_id;
                            if ($cat == '103') {
                                $cat = 42;
                            }
                            if ($cat == '110') {
                                $cat = 38;
                            }
                        } else {
                            $cat = '';
                        }
                        $array = array('event_title' => $row->name->text != '' ? $row->name->text : '',
                            'event_desc' => $row->description->text != '' ? $row->description->text : '',
                            'address' => $row->venue->address->address_1 != '' ? $row->venue->address->address_1 : '',
                            'city' => $row->venue->address->city != '' ? $row->venue->address->city : '',
                            'state' => $row->venue->address->region != '' ? $row->venue->address->region : '',
                            'zipcode' => $row->venue->address->postal_code != '' ? $row->venue->address->postal_code : '',
                            'event_lat' => $row->venue->address->latitude != '' ? $row->venue->address->latitude : '',
                            'event_lng' => $row->venue->address->longitude != '' ? $row->venue->address->longitude : '',
                            'date_added' => date('Y-m-d H:i:s', strtotime($row->created)),
                            'organizer' => $row->organizer->name != '' ? $row->organizer->name : '',
                            'eid' => $row->id,
                            'event_category' => $cat,
                            'event_upload_type' => 'image',
                        );

                        $this->db->insert('events', $array);
                        $id = mysql_insert_id();

                        $startdate = date('Y-m-d', strtotime(@$row->start->local));
                        $enddate = date('Y-m-d', strtotime(@$row->end->local));
                        $datetime1 = date_create($startdate);
                        $datetime2 = date_create($enddate);
                        $interval = date_diff($datetime1, $datetime2);
                        $day = $interval->format('%a');

                        for ($j = 0; $j <= $day; $j++) {
                            $date = array('eventdate' => date('Y-m-d', strtotime($startdate . ' + ' . $j . ' days')),
                                'eventstarttime' => date('H:i A', strtotime($row->start->local)),
                                'eventendtime' => date('H:i A', strtotime($row->end->local)),
                                'event_id' => $id);
                            $this->db->insert('event_time', $date);
                        }


                        $rand = rand(0, 100000);
                        if (isset($row->logo->url) && $row->logo->url != '') {
                            $fb_img = '';
                            $base_path = base_path();
                            $image_settings = image_setting();

                            $img = @file_get_contents($row->logo->url);

                            //echo  $img;
                            if ($img) {
                                $file = base_path() . "upload/bar_eventgallery_orig/" . $rand . "eventgallery.jpg";

                                file_put_contents($file, $img);
                                $fb_img = $rand . 'eventgallery.jpg';
                                $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
                                //$config['max_size']	= '100';// in KB
                                $this->load->library('upload', $config);
                                $config['source_image'] = $this->upload->upload_path . $fb_img;
                                //$config['new_image'] = base_path()."upload/user_thumb/";
                                //$config['thumb_marker'] = "";
                                //$config['maintain_ratio'] = $image_settings['u_ratio'];
                                //$config['create_thumb'] = TRUE;
                                //$config['width'] = 120;
                                //$config['height'] = 120;

                                $picture = $this->upload->data();

                                $this->load->library('image_lib');
                                $gd_var = 'gd2';
                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_big/' . $fb_img, 394, 290);


                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb/' . $fb_img, 70, 70);

                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_250by150/' . $fb_img, 240, 150);

                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/bar_eventgallery_thumb_304by201/' . $fb_img, 304, 201);

                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_225/' . $fb_img, 225, 225);
                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_840by720/' . $fb_img, 840, 720);

                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_261/' . $fb_img, 261, 261);


                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_140/' . $fb_img, 140, 140);
                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_200/' . $fb_img, 200, 200);

                                $this->image_lib->clear();

                                resize(base_path() . 'upload/bar_eventgallery_orig/' . $fb_img, base_path() . 'upload/event_600/' . $fb_img, 600, 600);


                                $company_image = $fb_img;
                                $pg = array('bar_eventgallery_id' => $id, 'event_image_name' => $company_image);
                                $this->db->insert('event_images', $pg);
                            }
                        }
                    }
                }
            }
        }
    }

    function emailcheck1() {
        $email_address_from = "php.viral@spaculus.info";
        $email_address_reply = "php.viral@spaculus.info";
        $email_to = "php.viral@spaculus.info";
        $email_subject = "Nfl_player_game_stats_by_week";
        $str = "Nfl_player_game_stats_by_week" . date('Y-m-d h:i:s');

        email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
    }

    function payment_inquiry() {
        $getpaypalsetting = paypalsetting();
        // $PayFlow = new PayFlow($getpaypalsetting->vendor,'PayPal', $getpaypalsetting->paypal_username,$getpaypalsetting->paypal_password, 'recurring');
        $PayFlow = new PayFlow($getpaypalsetting->vendor, $getpaypalsetting->partner_name, $getpaypalsetting->paypal_username, $getpaypalsetting->paypal_password, 'recurring');
// $PayFlow->setEnvironment('test');                           // test or live
// $PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
// $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
// $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
// 
// $PayFlow->setAmount('50.00', FALSE);
// $PayFlow->setCCNumber('378282246310005');
// $PayFlow->setCVV('4685');
// $PayFlow->setExpiration('1118');
// $PayFlow->setCreditCardName('Richard Castera');
// 
// $PayFlow->setCustomerFirstName('Richard');
// $PayFlow->setCustomerLastName('Castera');
// $PayFlow->setCustomerAddress('589 8th Ave Suite 10');
// $PayFlow->setCustomerCity('New York');
// $PayFlow->setCustomerState('NY');
// $PayFlow->setCustomerZip('10018');
// $PayFlow->setCustomerCountry('US');
// $PayFlow->setCustomerPhone('212-123-1234');
// $PayFlow->setCustomerEmail('richard.castera@gmail.com');
// $PayFlow->setPaymentComment('New Regular Transaction');
// $PayFlow->setPaymentComment2('Product 233');
// 
// if($PayFlow->processTransaction()):
        // echo('Transaction Processed Successfully!');
// else:
        // echo('Transaction could not be processed at this time.');
// endif;
//  
// echo('<h2>Name Value Pair String:</h2>');
// echo('<pre>');
// print_r($PayFlow->debugNVP('array'));
// echo('</pre>');
//  
// echo('<h2>Response From Paypal:</h2>');
// echo('<pre>');
// print_r($PayFlow->getResponse());
// echo('</pre>');
//  
// unset($PayFlow);
// die;

        $PayFlow->setEnvironment('test');                           // test or live
        $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
        $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
        $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
// Only used for recurring transactions
        $PayFlow->setProfileAction('A');
        $PayFlow->setProfileName('Richard_Castera');
        $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
        $PayFlow->setProfilePayPeriod('MONT');
        $PayFlow->setProfileTerm(0);

        $PayFlow->setAmount('11.00', FALSE);
        $PayFlow->setCCNumber('378282246310005');
        $PayFlow->setCVV('4685');
        $PayFlow->setExpiration('1118');
        $PayFlow->setCreditCardName('Richard Castera');

        $PayFlow->setCustomerFirstName('Richard');
        $PayFlow->setCustomerLastName('Castera');
        $PayFlow->setCustomerAddress('589 8th Ave Suite 10');
        $PayFlow->setCustomerCity('New York');
        $PayFlow->setCustomerState('NY');
        $PayFlow->setCustomerZip('10018');
        $PayFlow->setCustomerCountry('US');
        $PayFlow->setCustomerPhone('212-123-1234');
        $PayFlow->setCustomerEmail('richard.castera@gmail.com');
        $PayFlow->setPaymentComment('New Monthly Transaction');

        if ($PayFlow->processTransaction()):
            echo('Transaction Processed Successfully!');
        else:
            echo('Transaction could not be processed at this time.');
        endif;

        echo('<h2>Name Value Pair String:</h2>');
        echo('<pre>');
        print_r($PayFlow->debugNVP('array'));
        echo('</pre>');

        echo('<h2>Response From Paypal:</h2>');
        echo('<pre>');
        print_r($PayFlow->getResponse());
        echo('</pre>');

        unset($PayFlow);
        die;
        $user = $getpaypalsetting->paypal_username; // API User Username
        $password = $getpaypalsetting->paypal_password; // API User Password
        $vendor = $getpaypalsetting->vendor; // Merchant Login ID
// Reseller who registered you for Payflow or 'PayPal' if you registered
// directly with PayPal
        $partner = 'PayPal';

        $sandbox = true;

        $transactionId = 'B13P9E3CB4B8'; // The PNREF # returned when the card was charged
//$transactionId = 'R7359CA03249'; // The PNREF # returned when the card was charged

        $amount = '3';
        $currency = 'USD';

        $url = $sandbox ? 'https://pilot-payflowpro.paypal.com' : 'https://payflowpro.paypal.com';

        $params = array(
            'USER' => $user,
            'VENDOR' => $vendor,
            'PARTNER' => $partner,
            'PWD' => $password,
            'TENDER' => 'C', // C = credit card, P = PayPal
            'TRXTYPE' => 'I', //  S=Sale, A= Auth, C=Credit, D=Delayed Capture, V=Void                        
            'ORIGID' => $transactionId,
            'AMT' => $amount,
            'CURRENCY' => $currency
        );

        $data = '';
        $i = 0;
        foreach ($params as $n => $v) {
            $data .= ($i++ > 0 ? '&' : '') . "$n=" . urlencode($v);
        }

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Content-Length: ' . strlen($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

// Parse results
        $response = array();
        $result = strstr($result, 'RESULT');
        $valArray = explode('&', $result);
        foreach ($valArray as $val) {
            $valArray2 = explode('=', $val);
            $response[$valArray2[0]] = $valArray2[1];
        }
        echo "<pre>";
        print_r($response);

        if (isset($response['RESULT']) && $response['RESULT'] == 0) {
            echo 'SUCCESS!';
        } else {
            echo 'FAILURE: ' . $response['RESPMSG'] . ' [' . $response['RESULT'] . ']';
        }
    }

    function domainmanagement($msg = "") {
        $data = array();
        $user_info = get_user_info(get_authenticateUserID());
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        if ($this->session->userdata('user_type') != 'bar_owner') {
            redirect('home');
        }
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "domainmanagement";
        $data['msg'] = $msg; //login fail message
        $this->form_validation->set_rules('domain_registrar', 'Domain Registrar', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('un', 'UN', 'required');
        $this->form_validation->set_rules('pw', 'PW', 'required');
        $this->form_validation->set_rules('agree', "agree", 'required');

        $data['companies'] = array("1&1 Internet SE", "101domain Discovery Limited", "101domain GRS Limited", "10dencehispahard, S.L.", "123-Reg Limited", "123domainrenewals, LLC", "1800-website, LLC", "1API GmbH", "1st-for-domain-names, LLC", "2030138 Ontario Inc. dba NamesBeyond.com and dba GoodLuckDomain.com", "22net, Inc.", "24x7domains, LLC", "35 Technology Co., Ltd.", "4X", "995discountdomains, LLC", "Aahwed, Inc.", "AB Name ISP", "AB RIKTAD", "Abansys & Hostytec, S.L.", "Aboss Technology Limited", "Above.com Pty Ltd.", "Abraham Lincoln, LLC", "Abu-Ghazaleh Intellectual Property dba TAGIdomains.com", "AccentDomains LLC", "Acens Technologies, S.L.U.", "Achilles 888, LLC", "AcquiredNames LLC", "Active Registrar, Inc.", "Ad Valorem Domains, LLC", "Address Creation, LLC", "Addressontheweb, LLC", "Adomainofyourown.com LLC", "Advanced Internet Technologies, Inc. (AIT)", "Aerotek Bilisim Sanayi ve Ticaret AS", "Aetrion LLC dba DNSimple", "AFRIREGISTER S.A.", "Afterdark Domains, Incorporated", "Agrinoon Inc", "Aim High!, Inc.", "Akamai Technologies, Inc.", "Alantron Bilisim Ltd Sti.", "Alethia Domains, LLC", "Alexander the Great, LLC", "Alfena, LLC", "Alibaba Cloud Computing Ltd. d/b/a HiChina (www.net.cn)", "Alibrother Technology Limited", "Alice's Registry, Inc.", "All Domains LLC", "Allaccessdomains, LLC", "Alldomains, LLC", "Allearthdomains.com LLC", "AllGlobalNames, S.A. dba Cyberegistro.com", "Allworldnames.com LLC", "Alpine Domains Inc.", "Alpnames Limited", "Amazon Registrar, Inc.", "Anessia Inc.", "Annam, LLC", "Annulet LLC", "Anytime Sites, Inc.", "Apollo 888, LLC", "April Sea Information Technology Company Limited", "Aquarius Domains, LLC", "Arab Internet Names, Incorporated", "Arcanes Technologies", "Arctic Names, Inc.", "Ares 888, LLC", "Aristotle 888, LLC", "Arsys Internet, S.L. dba NICLINE.COM", "Arthur Pendragon, LLC", "Aruba SpA", "Ascio Technologies, Inc. Danmark – Filial af Ascio technologies, Inc. USA", "AsiaDomains, Incorporated", "AsiaRegister, Inc.", "Astutium Limited", "Atak Domain Hosting Internet ve Bilgi Teknolojileri Limited Sirketi d/b/a Atak Teknoloji", "ATI", "AtlanticDomains, LLC", "AtlanticFriendNames.com LLC", "Atomicdomainnames.com LLC", "Attila the Hun, LLC", "Austriadomains, LLC", "Austriandomains, LLC", "Authentic Web Inc.", "Automattic Inc.", "AvidDomain LLC", "AXC BV", "Azdomainz, LLC", "Azprivatez, LLC", "Backslap Domains, Inc.", "Backstop Names LLC", "Baracuda Domains, LLC", "Baronofdomains.com LLC", "BatDomains.com Ltd.", "BB-Online UK Limited ", "BDL Systemes SAS dba ProDomaines", "Beartrapdomains.com LLC", "Beijing Brandma International Networking Technology Ltd.", "Beijing Guoxu Network Technology Co., Ltd.", "Beijing HuaRui Wireless Technology Co., Ltd", "Beijing Innovative Linkage Technology Ltd. dba dns.com.cn", "Beijing Lanhai Jiye Technology Co.,Ltd", "Beijing Midwest Taian Technology Services Ltd.", "Beijing RITT - Net Technology Development Co., Ltd", "Beijing Sanfront Information Technology Co., Ltd", "Beijing Tong Guan Xin Tian Technology Ltd (Novaltel)", "Beijing Wangzun Technology Co., Ltd.", "Beijing ZhongWan Network Technology Co Ltd", "Beijing Zhuoyue Shengming Technologies Company Ltd.", "Beijing Zihai Technology Co., Ltd", "Belmontdomains.com LLC", "Benjamin Franklin 888, LLC", "Best Drop Names LLC", "Betterthanaveragedomains.com LLC", "Bidfordomainnames, LLC", "Big Dipper Domains, LLC", "Big Domain Shop, Inc.", "Big House Services, Inc.", "Biglizarddomains.com LLC", "BigRock Solutions Ltd.", "Billy the Kid, LLC", "Binero AB", "Bizcn.com, Inc.", "Blacknight Internet Solutions Ltd.", "BlastDomains LLC", "Blisternet, Incorporated", "BlockHost LLC", "Blue Angel Domains LLC", "Blue Fractal, Inc.", "Blue Hi Interconnect (Beijing) Technology Limited Company", "Blue Razor Domains, LLC", "Bombora Technologies Pty Ltd.", "Bonam Fortunam Domains, LLC", "Bonzai Domains, LLC", "BoteroSolutions.com S.A.", "Bottle Domains, Inc.", "Bounce Pass Domains LLC", "BR domain Inc. dba namegear.co", "Brandma.co Limited", "BrandNames.com SARL", "BRANDON GRAY INTERNET SERVICES INC. (dba \"NameJuice.com\")", "BraveNames Inc.", "Brennercom Limited", "BRS, LLC", "Buddha, LLC", "BullRunDomains.com LLC", "Burnsidedomains.com LLC", "camPoint AG", "Capitaldomains, LLC", "Catalog.com", "Catch Deleting Names LLC", "Catch Domains LLC", "CCI REG S.A.", "Center of Ukrainian Internet Names (UKRNAMES)", "Century Oriental International Co., Ltd.", "Charlemagne 888, LLC", "Charles Darwin, LLC", "Chengdu Fly-Digital Technology Co., Ltd.", "Chengdu West Dimension Digital Technology Co., Ltd.", "China Springboard, Inc.", "ChinaNet Technology (SuZhou) CO., LTD", "Chinesedomains, LLC", "Chipshot Domains LLC", "ChocolateChipDomains, LLC", "Chocolatecovereddomains,LLC", "Circle of Domains LLC", "Claimeddomains, LLC", "Click Registrar, Inc. d/b/a publicdomainregistry.com", "Cloud Bamboo, LLC", "Cloud Beauty, LLC", "Cloud Boom, LLC", "Cloud City, LLC", "Cloud Diamond, LLC", "Cloud Orchid, LLC", "Cloud Plum, LLC", "Cloud Seed, LLC", "Cloud Shark, LLC", "Cloud Sun, LLC", "Cloud Super, LLC", "Cloud System, LLC", "CloudBreakDomains, LLC", "CloudFlare, Inc.", "CloudNineDomain, LLC", "Cocosislandsdomains, LLC", "Columbiadomains, LLC", "Columbianames.com LLC", "ComfyDomains LLC", "Commerce Island, Inc.", "CommuniGal Communication Ltd.", "Compuglobalhypermega.com LLC", "Confucius, LLC", "Constantine the Great, LLC", "Cool Breeze Domains, LLC", "Cool Ocean, Inc.", "Cool River Names, LLC", "Copper Domain Names LLC", "Coral Reef Domains LLC", "COREhub, S.R.L.", "Corporation Service Company (DBS) INC.", "CORPORATION SERVICE COMPANY (UK) LIMITED", "Cosmotown, Inc.", "CPS-Datensysteme GmbH", "Crazy Domains FZ-LLC", "Crisp Names, Inc.", "Cronon AG", "Crystal Coal, Inc.", "CSC Corporate Domains, Inc.", "CSL Computer Service Langenbach GmbH d/b/a joker.com", "CT CORPORATION SYSTEM", "Curious Net, Inc.", "Curveball Domains LLC", "CV. Jogjacamp", "CV. Rumahweb Indonesia", "CyanDomains, Inc.", "Cyrus the Great, LLC", "Dagnabit, Incorporated", "Dainam, LLC", "Dalai Lama, LLC", "DanCue Inc.", "DanDomain A/S", "Danesco Trading Ltd.", "Dattatec.com SRL", "Decentdomains, LLC", "Deep Dive Domains, LLC", "Deep Sea Domains LLC", "Deep Water Domains LLC", "Deleting Name Zone LLC", "Deluxe Small Business Sales, Inc. d/b/a Aplus.net", "Demys Limited", "Department-of-domains, LLC", "Deschutesdomains.com LLC", "Desert Devil, Inc.", "Desert Sand Domains, LLC", "Deutchdomains, LLC", "Deutsche Telekom AG", "DevilDogDomains.com, LLC", "Diamatrix C.C.", "Diggitydot, LLC", "Dinahosting s.l.", "Discount Domains Ltd.", "Discountdomainservices, LLC", "DNC Holdings, Inc.", "DNS:NET Internet Service GmbH", "DNSPod, Inc.", "Domain Ala Carte, LLC", "Domain Band, Inc.", "Domain Bazaar LLC", "Domain Central Australia Pty Ltd.", "Domain Collage, LLC", "Domain Esta Aqui, LLC", "Domain Gold Zone LLC", "Domain Grabber LLC", "Domain Guardians, Inc.", "Domain Jamboree, LLC", "Domain Landing Zone LLC", "Domain Lifestyle, LLC", "Domain Locale, LLC", "Domain Mantra, Inc.", "Domain Monkeys, LLC", "DOMAIN NAME NETWORK PTY LTD", "Domain Name Origin, LLC", "Domain Name Root, LLC", "Domain Name Services (Pty) Ltd", "Domain Original, LLC", "Domain Pickup LLC", "Domain Pro, LLC", "Domain Registration Services, Inc. dba dotEarth.com", "Domain Research, LLC", "Domain Rouge, Inc.", "Domain Secure LLC", "Domain Source LLC", "Domain Stopover LLC", "Domain Success LLC", "Domain The Net Technologies Ltd.", "DOMAIN TRAIN, INC.", "Domain Vault Limited", "Domain-A-Go-Go, LLC", "Domain-It!, Inc.", "Domain.com, LLC", "DomainAdministration.com, LLC", "DomainAhead LLC", "DomainAllies.com, Inc.", "Domainamania.com LLC", "Domainarmada.com LLC", "Domainbox Limited", "Domainbulkregistration, LLC", "Domainbusinessnames, LLC", "Domaincamping, LLC", "Domaincapitan.com LLC", "Domaincatcher LLC", "Domaincircle LLC", "Domainclip Domains, Inc.", "Domainclub.com, LLC", "Domaincomesaround.com LLC", "DomainContext, Inc.", "DomainCraze LLC", "DomainCreek LLC", "DomainCritics LLC", "DomainDelights LLC", "Domaindrop LLC", "Domainducks, LLC", "Domainer Names LLC", "DomainExtreme LLC", "domainfactory GmbH", "DomainFalcon LLC", "Domaingazelle.com LLC", "DomainGetter LLC", "Domainhawks.net LLC", "DomainHood LLC", "Domainhostingweb, LLC", "Domainhysteria.com LLC", "Domainia Inc.", "Domaining Oro, LLC", "Domaininternetname, LLC", "Domaininthebasket.com LLC", "Domaininthehole.com LLC", "Domainjungle.net LLC", "DomainLadder LLC", "DomainLocal LLC", "Domainmonster Limited", "Domainmonster.com, Inc.", "DOMAINNAME BLVD, INC.", "DomainName Bridge, Inc.", "DomainName Driveway, Inc.", "DOMAINNAME FWY, INC.", "DomainName Highway LLC", "DomainName Parkway, Inc.", "DomainName Path, Inc.", "DomainName, Inc.", "Domainnamebidder, LLC", "Domainnamelookup, LLC", "Domainnovations, Incorporated", "DOMAINOO SAS", "DomainParkBlock.com LLC", "DomainPeople, Inc.", "DomainPicking LLC", "Domainplace LLC", "DomainPrime.com LLC", "Domainraker.net LLC", "DomainRegistry.com Inc.", "Domainroyale.com LLC", "Domains Etc LLC", "Domains Express LLC", "Domains of Origin, LLC", "Domains.coop Limited", "DomainSails.net LLC", "Domainsalsa.com LLC", "Domainsareforever.net LLC", "Domainshop LLC", "Domainshype.com, Inc.", "Domainsinthebag.com LLC", "DomainSite, Inc.", "DomainSnap, LLC", "Domainsnapper LLC", "Domainsofcourse.com LLC", "Domainsoftheday.net LLC", "Domainsoftheworld.net LLC", "Domainsofvalue.com LLC", "Domainsouffle.com LLC", "Domainsoverboard.com LLC", "Domainsovereigns.com LLC", "DomainSprouts.com LLC", "Domainstreetdirect.com LLC", "Domainsurgeon.com LLC", "DomainTact LLC", "Domaintimemachine.com LLC", "DomaintoOrder, LLC", "Domainwards.com LLC", "Domainyeti.com LLC", "Domainz Limited", "Domdrill.com, Inc.", "Domeneshop AS dba domainnameshop.com", "Domerati, Inc.", "Dominion Domains, LLC", "DomReg Ltd. d/b/a LIBRIS.COM", "Domus Enterprises LLC dba DOMUS", "Dot Holding Inc.", "DotAlliance Inc.", "DotArai Co., Ltd.", "DotMedia Limited", "Dotname Korea Corp.", "DotNamed LLC", "DotRoll Kft.", "DOTSERVE INC.", "Douglas MacArthur, LLC", "Draftpick Domains LLC", "DreamHost, LLC", "DreamScape Networks FZ-LLC", "Drop Catch Mining LLC", "Dropcatch Auction LLC", "Dropcatch Landing Spot LLC", "Dropcatch Marketplace LLC", "DropCatch.com 1000 LLC", "Dropcatching Names LLC", "DropExtra.com, Inc.", "DropFall.com Inc.", "DropHub.com, Inc.", "DropJump.com Inc.", "Dropoutlet, Incorporated", "DropSave.com, Inc.", "DropWalk.com, Inc.", "DropWeek.com, Inc.", "DuckBilledDomains.com LLC", "Dwight D. Eisenhower, LLC", "Dynadot, LLC", "Dynamic Network Services, Inc.", "DynaNames.com Inc.", "Eagle Eye Domains, LLC", "EastEndDomains, LLC", "EastNames Inc.", "Easy Street Domains, LLC", "easyDNS Technologies Inc.", "Easyspace Limited", "eBrand Services S.A.", "eBrandSecure, LLC", "EchoDomain LLC", "Ednit Software Private Limited", "EIMS (Shenzhen) Culture & Technology Co., Ltd", "Ejee Group Beijing Limited", "EJEE Group Holdings Limited", "Ekados, Inc., d/b/a groundregistry.com", "ELB Group Inc", "Emerald Registrar Limited", "Emirates Telecommunications Corporation - Etisalat", "EmpireStateDomains Inc.", "eName Technology Co., Ltd.", "Enameco, LLC", "EnCirca, Inc.", "EndeavourDomains, LLC", "Enetica Pty Ltd", "Enom Corporate, Inc.", "EnomAU, Inc.", "eNombre Corporation", "EnomEU, Inc.", "Enomfor, Inc.", "EnomMX, Inc.", "Enomnz, Inc.", "eNomsky, Inc.", "EnomTen, Inc.", "EnomToo, Inc.", "EnomV, Inc.", "EnomX, Inc.", "Enset", "Entertainment Names, Incorporated", "Entorno Digital, S.A.", "Entrust Domains, LLC", "EPAG Domainservices GmbH", "Epik, Inc.", "Eranet International Limited", "Eric the Red, LLC", "Erwin Rommel, LLC", "Ethos Domains, LLC", "EU Technology (HK) Limited", "EUNameFlood.com LLC", "EunamesOregon.com LLC", "EuroDNS S.A.", "EuropeanConnectiononline.com LLC", "EurotrashNames.com LLC", "EUTurbo.com LLC", "Ever Ready Names, Inc.", "Everyones Internet, Ltd. dba SoftLayer", "Excalibur, LLC", "Exclusive Domain Find LLC", "Experinom Inc.", "Extend Names, Inc.", "Extra Threads Corporation", "Extremely Wild", "EZ Times Domains, LLC", "Fabulous.com Pty Ltd", "Fair Trade Domains, LLC", "Fan Domains Ltd", "Fastball Domains LLC", "FastDomain Inc.", "FBS Inc.", "Fenominal, Inc.", "Fetch Registrar, LLC", "Fiducia LLC, Latvijas Parstavnieciba", "Find Good Domains, Inc.", "FindUAName.com LLC", "FindYouADomain.com LLC", "FindYouAName.com LLC", "Fine Grain Domains, LLC", "Firstround Names LLC", "Firstserver, Inc.", "Flancrestdomains.com LLC", "FLAPPY DOMAIN, INC.", "Focus IP, Inc. dba AppDetex", "Foshan YiDong Network Co., LTD", "Free Dive Domains, LLC", "Free Drop Zone LLC", "Free Spirit Domains, LLC", "Freefall Domains LLC", "Freeparking Domain Registrars, Inc.", "French Connexion SARL dba Domaine.fr", "Freshbreweddomains.com LLC", "FrontStreetDomains.com LLC", "Fujian Domains, Inc.", "Fujian Litian Network Technology Co.,Ltd", "Funpeas Media Ventures, LLC dba DomainProcessor.com", "Fushi Tarazu, Incorporated", "Gabia C&S", "Gabia, Inc.", "Galileo Galilei, LLC", "Game For Names, Inc.", "Gandi SAS", "GateKeeperDomains.net LLC", "Genghis Khan, LLC", "Genious Communications SARL/AU", "George S. Patton, LLC", "George Washington 888, LLC", "Gesloten Domain N.V.", "Ghana Dot Com Ltd.", "GKG.NET, INC.", "GlamDomains LLC", "Glide Slope Domains, LLC", "Global Domains International, Inc. DBA DomainCostClub.com", "Global Village GmbH", "GMO Brights Consulting Inc.", "GMO Internet, Inc. d/b/a Onamae.com", "GMO-Z.com Pte. Ltd.", "Go Australia Domains, LLC", "Go Canada Domains, LLC", "Go China Domains, LLC", "Go France Domains, LLC", "Go Full House, Inc.", "Go Montenegro Domains, LLC", "GoDaddy.com, LLC", "Godomaingo.com LLC", "Gold Domain Names LLC", "Goldenfind Domains LLC", "Goldmine Domains LLC", "GoName-FL.com, Inc.", "GoName-HI.com, Inc.", "GoName-TN.com, Inc.", "GoName-TX.com, Inc.", "GoName-WA.com, Inc.", "GoName.com, Inc", "Good Domain Registry Pvt Ltd.", "Good Luck Internet Services PVT, LTD.", "Google Inc.", "GoServeYourDomain.com LLC", "Goto Domains LLC", "Gozerdomains.com LLC", "Gradeadomainnames.com LLC", "Gransy, s.r.o. d/b/a subreg.cz", "Green Destiny, LLC", "GreenZoneDomains Inc.", "Ground Internet, Inc.", "Guangdong HUYI Internet & IP Services Co., Ltd", "Guangdong JinWanBang Technology Investment Co., Ltd.", "GuangDong NaiSiNiKe Information Technology Co Ltd.", "Guangzhou Domains, Inc.", "Guangzhou Ehost Tech. Co. Ltd.", "Guangzhou Ming Yang Information Technology Co., Ltd", "Gunga Galunga Corporation", "Hang Ten Domains, LLC", "HANGANG Systems, Inc. dba Doregi.com", "Hanging Curve Domains LLC", "Hangzhou AiMing Network Co., Ltd.", "Hangzhou Dianshang Internet Technology Co., LTD.", "Hangzhou Duomai E-Commerce Co., Ltd", "Hangzhou Midaizi Network Co., Ltd.", "Hannibal Barca, LLC", "Haveaname, LLC", "Hawthornedomains.com LLC", "HazelDomains, Inc.", "Heavens Will, LLC", "Heavydomains.net LLC", "Hebei Guoji Maoyi (Shanghai) LTD dba HebeiDomains.com", "Hello Internet Corp.", "Henan Weichuang Network Technology Co. Ltd.", "Hercules 888, LLC", "Hetzner Online GmbH", "Hezhong Liancheng Beijing Technology Co., Ltd", "HiChina Zhicheng Technology Limited", "HLJ E-Link Network Co., Ltd", "HOAPDI INC.", "Hogan Lovells International LLP", "HongKong Di En Si International Co., Limited", "Hongkong Domain Name Information Management Co., Ltd.", "Honjo Masamune, LLC", "HooYoo Information Technology Co. Ltd.", "Hosteur SARL", "Hosting Concepts B.V. d/b/a Openprovider", "Hosting Ukraine LLC", "Hostinger, UAB", "Hostlane, LLC", "Hostnet bv", "Hostpoint AG", "Hostserver GmbH", "Hotdomaintrade.com, Inc.", "House of Domains, LLC", "Hrunting, LLC", "http.net Internet GmbH", "Hu Yi Global Information Hong Kong Limited", "Humeia Corporation", "Iconicnames LLC", "Ignitela, LLC", "IHS Telekom, Inc.", "Ilait AB", "Imminentdomains.net LLC", "Imperial Registrations, Inc.", "In2net Network Inc.", "Inames Co., Ltd.", "Indirection Identity Corporation", "iNET CORPORATION", "Infocom Network Ltd.", "Infomaniak Network SA", "Ingenit GmbH & Co. KG", "Inic GmbH", "InlandDomains, LLC", "InsaneNames LLC", "INSTANTNAMES LLC", "Instinct Solutions, Inc.", "Instra Corporation Pty Ltd.", "Interdominios, Inc.", "Interlakenames.com LLC", "Interlink Co., Ltd.", "Internet Domain Name System Beijing Engineering Research Center LLC (ZDNS)", "Internet Domain Service BS Corp", "Internet Internal Affairs Corporation", "Internet Invest, Ltd. dba Imena.ua", "Internet NAYANA Inc.", "Internetters Limited", "Intersolved-FL.com, Inc.", "Intersolved-HI.com, Inc.", "Intersolved-TN.com, Inc.", "Intersolved-TX.com, Inc.", "Intersolved-WA.com Inc.", "Interweb Advertising D.B.A. Profile Builder", "Intracom Middle East FZE", "INWX GmbH & Co. KG", "IP Mirror Pte Ltd dba IP MIRROR", "IP Twins SAS", "Isaac Newton, LLC", "IServeYourDomain.com LLC", "Isoroku Yamamoto, LLC", "James Madison, LLC", "Japan Registry Services Co., Ltd.", "JARHEADDOMAINS.COM, LLC", "Jiangsu Bangning Science & technology Co. Ltd.", "Joan of Arc, LLC", "Joyeuse, LLC", "JPRS Registrar Co., Ltd.", "JSC Registrar R01", "Julius Caesar, LLC", "Jumbo Name, Inc.", "Jumpshot Domains LLC", "Kagoya Japan Inc.", "Karl Von Clausewitz, LLC", "Kaunas University of Technology, Department of Information Technologies dba Domreg.lt", "Key Registrar, Inc.", "Key-Systems GmbH", "Key-Systems, LLC", "Kheweul.com SA", "Kingdomains, Incorporated", "KINX Co., Ltd.", "Klaatudomains.com LLC", "Knet Registrar Co., Ltd.", "Kontent GmbH", "Korea Server Hosting Inc.", "Koreacenter.com co., Ltd.", "KQW, Inc.", "KuwaitNET General Trading Co.", "La Tizone, LLC", "Ladas Domains LLC", "Lakeodomains.com LLC", "Larsen Data ApS", "Launchpad.com Inc.", "Layup Domains LLC", "LCN.COM Ltd.", "Leatherneckdomains.com, LLC", "Ledl.net GmbH", "Leif Ericson, LLC", "LEMARIT GmbH", "Lemon Shark Domains, LLC", "Leonardo da Vinci, LLC", "Leonidas, LLC", "Lexsynergy Limited", "Ligne Web Services SARL dba LWS", "Line Drive Domains, LLC", "Lionshare Domains, LLC", "LiquidNet Ltd.", "LiteDomains LLC", "LogicBoxes Naming Services Ltd", "Long Drive Domains LLC", "Lucky Elephant Domains, LLC", "MAFF AVENUE, INC.", "MAFF Inc.", "Magic Friday, Inc.", "Magnate Domains, LLC", "Magnolia Domains, LLC", "Mahatma Gandhi, LLC", "Mailinh, LLC", "MainReg Inc.", "Major League Domains, LLC", "Maoming QunYing Network Co., Ltd.", "Marcaria.com International, Inc.", "Mark Barker, Incorporated", "MarkMonitor Inc.", "Masterofmydomains.net LLC", "Mat Bao Trading & Services Joint Stock Company d/b/a Mat Bao", "Maximus, LLC", "Mayi Information Co., Limited", "Media Elite Holdings Limited", "Meganames LLC", "Megazone Corp., dba HOSTING.KR", "Melbourne IT Ltd", "Mesh Digital Limited", "Metaregistrar BV", "Microbreweddomains.com LLC", "Microsoft Corporation", "MidWestDomains, LLC", "Mighty Bay, Inc.", "Mijn InternetOplossing B.V.", "Mijndomein.nl BV", "Millennial Names LLC", "Minds and Machines LLC", "Minds and Machines Registrar UK Limited", "Misk.com, Inc.", "MISTERNIC LLC", "Mobile Name Services, Inc.", "Moniker Online Services LLC", "Moon Shot Domains, LLC", "Mps Infotecnics Limited", "Mvpdomainnames.com LLC", "MyManager, Inc.", "Mypreciousdomain.com LLC", "Nakazawa Trading Co.,Ltd.", "Name Connection Area LLC", "Name Connection Spot LLC", "Name Find Source LLC", "Name Icon LLC", "Name Nelly Corporation", "Name Perfections, Inc.", "Name Share, Inc.", "Name Thread Corporation", "Name To Fame, Inc.", "Name Trance LLC", "Name.cc Inc", "Namearsenal.com LLC", "NameBake LLC", "Namebay SAM", "NameBrew LLC", "NameCamp Limited", "Namecatch LLC", "Namecatch Zone LLC", "NameCentral, Inc.", "NameCheap, Inc.", "NameChild LLC", "Namecroc.com LLC", "Nameemperor.com LLC", "Namefinger.com LLC", "NameForward LLC", "Namegrab LLC", "NameJolt.com LLC", "NameKing.com Inc.", "Nameling.com LLC", "Namemaster RC GmbH", "Namepanther.com LLC", "Names Express LLC", "Names In Motion, Inc.", "Names On The Drop LLC", "Names Stop Here LLC", "Namesalacarte.com LLC", "Namesaplenty LLC", "NameSay LLC", "NameScout Corp.", "NameSector LLC", "NameSecure L.L.C.", "Nameselite, LLC", "NamesHere LLC", "Nameshield SAS", "NameSilo, LLC", "Namesnap LLC", "NameSnapper LLC", "Namesource LLC", "Namesourcedomains, LLC", "Namespro Solutions Inc.", "Namestop LLC", "NameStrategies LLC", "NameStream.com, Inc.", "NameTell.com LLC", "NameTurn LLC", "Namevolcano.com LLC", "NameWeb BVBA", "Namewinner LLC", "Namezero, LLC", "Namware.com, Inc.", "Nanjing Imperiosus Technology Co. Ltd.", "Napoleon Bonaparte, LLC", "Naugus Limited LLC", "NCC Group Secure Registrar, Inc.", "Need Servers, Inc.", "Neen Srl", "NeoNIC OY", "Nerd Names Corporation", "Net 4 India Limited", "Net Juggler, Inc.", "Net Logistics Pty Ltd.", "Net-Chinese Co., Ltd.", "NetArt Sp z o.o", "Netdorm, Inc. dba DnsExit.com", "NetEarth One Inc. d/b/a NetEarth", "Netestate, LLC", "NETIM SARL", "Netistrar Limited", "Netnames Pty Ltd.", "Netowl, Inc.", "Netpia.com, Inc.", "NetraCorp LLC dba Global Internet", "NetRegistry Pty Ltd.", "NetTuner Corp. dba Webmasters.com", "Network Information Center Mexico, S.C.", "Network Savior, Inc.", "Network Solutions, LLC", "Networking4all B.V.", "Netzadresse.at Domain Service GmbH", "NetZone AG", "Neubox Internet S.A. de C.V.", "NEUDOMAIN LLC", "New Great Domains, Inc.", "New Order Domains, LLC", "Nhan Hoa Software Company Ltd.", "NHN Techorus Corp.", "Nicco Ltd.", "NICREG LLC", "Nics Telekomünikasyon Tic Ltd. Şti.", "Nictrade Internet Identity Provider AB", "Niuedomains, LLC", "Nom Infinitum, Incorporated", "Nom-iq Ltd. dba COM LAUDE", "Nominalia Internet S.L.", "Nominet Registrar Services Limited", "NordNet SA", "Nordreg AB", "NorthNames Inc.", "Noteworthydomains, LLC", "NoticedDomains LLC", "NotSoFamousNames.com LLC", "Number One Web Hosting Limited", "NUXIT", "Octopusdomains.net LLC", "Odysseus 888, LLC", "Oi Internet S/A", "Old Tyme Domains, LLC", "OldTownDomains.com LLC", "OldWorldAliases.com LLC", "Omni 888, LLC", "Omnis Network, LLC", "One Putt, Inc.", "One.com A/S", "Onlide Inc", "Online Data Services Joint Stock Company", "Online SAS", "OnlineNIC, Inc.", "Only Domains Limited", "Open System Ltda - Me", "OPENNAME LLC", "OpenTLD B.V.", "ORANGE SA", "OregonEU.com LLC", "OregonURLs.com LLC", "Ourdomains Limited", "OVH sas", "Own Identity, Inc.", "P.A. Viet Nam Company Limited", "PacificDomains, LLC", "Paimi Inc", "Painted Pony Names, LLC", "pair Networks, Inc.d/b/a pairNIC", "Paknic (Private) Limited", "Papaki Ltd", "Paragon Internet Group Ltd t/a Paragon Names", "Pararescuedomains.com, LLC", "PDR Ltd. d/b/a PublicDomainRegistry.com", "PDXPrivateNames.com LLC", "PE Overseas Limited", "PearlNamingService.com LLC", "Perseus 888, LLC", "Peter the Great, LLC", "Pheenix, Inc.", "PierX, Inc", "Pink Elephant Domains, LLC", "Pipeline Domains, LLC", "PlanetDomain Pty Ltd", "PlanetHoster Inc.", "Platinum Registrar, Inc.", "Plato 888, LLC", "PocketDomain.com Inc.", "Porkbun LLC", "Porting Access B.V.", "PortlandNames.com LLC", "Ports Group AB", "Poseidon 888, LLC", "PostalDomains, Incorporated", "Power Carrier, Inc.", "Power Namers, Inc.", "Powered by Domain.com LLC", "Premierename.ca Inc.", "PresidentialDomains LLC", "PrivacyPost, LLC", "Private Domains, Incorporated", "Promo People, Inc.", "ProNamed LLC", "Protocol Internet Technology Limited T/A Hosting Ireland", "Protondomains.com LLC", "PSI-Japan, Inc.", "PSI-USA, Inc. dba Domain Robot", "PT Ardh Global Indonesia", "Purenic Japan Inc.", "Purity Names Incorporated", "Rabbitsfoot.com LLC d/b/a Oxygen.nyc", "Radu Damian, LLC", "Rainydaydomains.com LLC", "Rally Cry Domains, LLC", "Ramses II, LLC", "Rank USA, Inc.", "Rare Gem Domains LLC", "Realtime Register B.V.", "Rebel Ltd", "Rebel.ca Corp.", "ReclaimDomains LLC", "REG.BG OOD", "Reg2C.com Inc.", "Regional Network Information Center, JSC dba RU-CENTER", "Register Names, LLC", "Register NV dba Register.eu", "Register.ca Inc.", "Register.com, Inc.", "REGISTER.IT SPA", "Register4Less, Inc.", "Registrar Manager Inc.", "Registrar of Domain Names REG.RU LLC", "Registrar Services LLC", "RegistrarDirect LLC`", "RegistrarSafe, LLC", "RegistrarSEC LLC", "RegistrarTrust, LLC", "Registration Technologies, Inc.", "Registrator Domenov LLC", "RegistryGate GmbH", "Regtime Ltd.", "Reliable Software", "Reseller Services, Inc. dba ResellServ.com", "Retail Domains, Inc.", "Rethem Hosting LLC", "Richard the Lionheart 888, LLC", "Ripcord Domains, LLC", "Ripcurl Domains, LLC", "Riptide Domains, LLC", "Robert E. Lee 888, LLC", "rockenstein AG", "SafeBrands SAS", "SafeNames Ltd.", "SALENAMES LTD", "Samjung Data Service Co., Ltd", "Sammamishdomains.com LLC", "Samoandomains, LLC", "Santiamdomains.com LLC", "SaveMoreNames.com Inc.", "Savethename.com LLC", "SBSNames, Incorporated", "Scipio Africanus, LLC", "Searchnresq, Inc.", "Secondround Names LLC", "Secura GmbH", "Sedo.com LLC", "Server Plan Srl", "Service Development Center of the State Commission Office for Public Sector Reform", "Seymour Domains, LLC", "Shanghai Best Oray Information S&T Co., Ltd.", "Shanghai Meicheng Technology Information Development Co., Ltd.", "Shanghai Oweb Network Co., Ltd", "Shanghai Yovole Networks, Inc.", "Sharkweek Domains LLC", "Shenzhen Esin Technology Co., Ltd", "Shenzhen HuLianXianFeng Technology Co.,LTD", "Shenzhen Internet Works Online Technology Co., Ltd. (62.com)", "Shining Star Domains, LLC", "Shinjiru MSC Sdn Bhd", "Sibername Internet and Software Technologies Inc.", "SicherRegister, Incorporated", "SiliconHouse.Net Pvt Ltd.", "Silver Domain Names LLC", "Silverbackdomains.com LLC", "Sipence, Inc.", "Sir Lancelot du Lac, LLC", "Sitefrenzy.com LLC", "SiteName Ltd.", "Sksa Technology Co., Limited", "Skykomishdomains.com LLC", "Slamdunk Domains LLC", "Sliceofheaven Domains, LLC", "Slow Motion Domains LLC", "Slow Putt Domains LLC", "Small Business Names and Certs, Incorporated", "Small World Communications, Inc.", "Snag Your Name LLC", "Snappyregistrar.com LLC", "Snapsource LLC", "Snoqulamiedomains.com LLC", "Soaring Eagle Domains, LLC", "Socrates 888, LLC", "SoftLayer Technologies, Inc.", "Soldierofonedomains.com, LLC", "Soluciones Corporativas IP, SL", "Sourced Domains, LLC", "SouthNames Inc.", "Soyouwantadomain.com LLC", "Spartacus, LLC", "SQUIDSAILERDOMAINS.COM, LLC", "Sssasss, Incorporated", "Sterling Domains LLC", "Stichting Registrar of Last Resort Foundation", "Stork Registry Inc.", "Stormbringer, LLC", "Straight 8 Domains, LLC", "Streamline Domains, LLC", "Sugar Cube Domains, LLC", "Sun Tzu 888, LLC", "Super Name World, Inc.", "Super Registry Ltd", "SW Hosting & Communications Technologies SL dba Serveisweb", "Swedish Domains AB", "Switchplus Ltd", "Swordfish Domains LLC", "Synergy Wholesale Pty Ltd", "Taiwan Network Information Center", "Taka Enterprise Ltd", "Tan Tran, LLC", "Targeted Drop Catch LLC", "Tech Tyrants, Inc.", "Tecnocrática Centro de Datos, S.L.", "Tecnologia, Desarrollo Y Mercado S. de R.L. de C.V.", "The Domains LLC", "The Registrar Company B.V.", "The Registrar Service, Inc.", "The Registry at Info Avenue, LLC d/b/a Spirit Communications", "TheNameCo LLC", "Theseus 888, LLC", "ThirdFloorDNS.com LLC", "Thirdroundnames LLC", "Thomas Edison, LLC", "Thomas Jefferson, LLC", "Threadagent.com, Inc.", "Threadwalker.com, Inc.", "Threadwatch.com, Inc.", "Threadwise.com, Inc.", "Threepoint Domains LLC", "Tianjin Zhuiri Science and Technology Development Co Ltd.", "TierraNet Inc. d/b/a DomainDiscover", "Tiger Shark Domains, LLC", "Tiger Technologies LLC", "Tirupati Domains and Hosting Pvt Ltd.", "Titanic Hosting, Inc.", "Titus 888, LLC", "TLD Registrar Pty Ltd", "TLD Registrar Solutions Ltd.", "TLDS L.L.C. d/b/a SRSPlus", "Tname Group Inc.", "Todaynic.com, Inc.", "TOGLODO S.A.", "Tong Ji Ming Lian (Beijing) Technology Corporation Ltd. (Trename)", "Top Level Domains LLC", "Top Pick Names LLC", "Top Shelf Domains LLC", "Top Tier Domains LLC", "Topsystem, LLC", "Total Web Solutions Limited trading as TotalRegistrations", "TotallyDomain LLC", "Touchdown Domains LLC", "TPP Domains Pty Ltd. dba TPP Internet", "TPP Wholesale Pty Ltd", "Trade Starter, Inc.", "TradeNamed LLC", "Tradewinds Names, LLC", "Traffic Names, Incorporated", "TransIP B.V.", "TravelDomains, Incorporated", "Treasure Trove Domains LLC", "Tropic Management Systems, Inc.", "Trunkoz Technologies Pvt Ltd. d/b/a OwnRegistrar.com", "Tucows Domains Inc.", "Tuonome.it Srl d/b/a APIsrs.com", "Turbonames LLC", "TurnCommerce, Inc. DBA NameBright.com", "Tuvaludomains, LLC", "TWT S.p.A.", "Udamain.com LLC", "UdomainName.com LLC", "UK-2 Limited", "Ulfberht, LLC", "Ultra Registrar, Inc.", "Ulysses S. Grant, LLC", "Unified Servers, Inc.", "Uniregistrar Corp", "united-domains AG", "Unitedkingdomdomains, LLC", "Universal Registration Services, Inc. dba NewDentity.com", "Universo Online S/A (UOL)", "Unpower, Inc.", "Upperlink Limited", "URL Solutions, Inc.", "V12 Domains, LLC", "Variomedia AG dba puredomain.com", "Vautron Rechenzentrum AG", "Vedacore.com, Inc.", "VentraIP Australia Pty Ltd", "Verelink, Inc.", "Veritas Domains, LLC", "Vertex names.com, Inc.", "Victorynames LLC", "Vigson, Inc.", "Virtual Registrar, Inc.", "Virtucom Networks S.A.", "Visual Monster, Inc.", "VisualNames LLC", "Vitalwerks Internet Solutions, LLC DBA No-IP", "Vivid Domains, Inc.", "Vlad the Impaler, LLC", "Vo Nguyen Giap, LLC", "Vodien Internet Solutions Pte Ltd", "Web Business, LLC", "Web Commerce Communications Limited dba WebNic.cc", "Web Drive Ltd.", "Web Site Source, Inc.", "Web Werks India Pvt. Ltd d/b/a ZenRegistry.com", "Web4Africa Inc.", "Webagentur.at Internet Services GmbH d/b/a domainname.at", "Webair Internet Development, Inc.", "Webnames Limited", "Webnames.ca Inc.", "West263 International Limited", "WhatIsYourDomain LLC", "White Alligator Domains, LLC", "White Rhino Domains, LLC", "Whiteglove Domains, Incorporated", "Whois Networks Co., Ltd.", "WHT Co., Ltd", "Wide Left Domains LLC", "Wide Right Domains LLC", "Wild Bill Hickok, LLC", "Wild Bunch Domains, LLC", "Wild West Domains, LLC", "Wildzebradomains, LLC", "WillametteNames.com LLC", "William the Conqueror, LLC", "William Wallace, LLC", "Win Names LLC", "Wingu Networks, S.A. de C.V.", "Winston Churchill, LLC", "WIXI Incorporated", "World Biz Domains, LLC", "World4You Internet Services GmbH", "WorthyDomains LLC", "Xiamen ChinaSource Internet Service Co., Ltd", "Xiamen Dianmei Network Technology Co., Ltd.", "Xiamen Domains, Inc.", "Xiamen Nawang Technology Co., Ltd", "Xiamen Niucha Technology Co., Ltd.", "Xiamen Xin click Network Polytron Technologies Inc", "Xiamen Yuwang Technology Co., LTD", "Xin Net Technology Corporation", "Yellow Start, Inc.", "yenkos, LLC", "YouDamain.com LLC", "Your Domain Casa, LLC", "Your Domain King, Inc.", "Your Domain LLC", "Zeus 888, LLC", "Zhengzhou Business Technology Co., Ltd.", "Zhengzhou Century Connect Electronic Technology Development Co., Ltd", "Zhengzhou Zitian Network Technology Co., Ltd.", "Zhenjiang Aimingwang Information and Technology Co., Ltd", "Zhong Yu Network Technology Company Limited", "Zhuimi Inc", "ZigZagNames.com LLC", "Zinc Domain Names LLC", "ZNet Technologies Pvt Ltd.", "Zone Casting, Inc.", "Zone of Domains LLC", "ZoomRegistrar LLC", "Zulfigar, LLC");
        $data['error'] = '';
        $user_info = get_user_info(get_authenticateUserID());
        $data['domain_registrar'] = $user_info->domain_registrar;
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                $data["error"] = validation_errors();
            } else {
                $data["error"] = "";
            }

            $data['domain_registrar'] = $user_info->domain_registrar;
            $data['url'] = $user_info->url;
            $data['un'] = $user_info->un;
            $data['pw'] = $user_info->pw;
            $data['agree'] = $user_info->agree;
        } else {
            $this->load->library('email');
            $this->email->from('info@americanbars.com', 'American Bars');
            $this->email->to($user_info->email);
            $this->email->subject('Domain Management Submited');
            $this->email->message('You have submitted Domain Management');
            $this->email->send();

            $dr = $this->input->post('domain_registrar');
            $url = $this->input->post('url');
            $un = $this->input->post('un');
            $pw = $this->input->post('pw');
            $agree = $this->input->post('agree');

            try {
                $usr = array('domain_registrar' => $dr, 'url' => $url, 'un' => $un, 'pw' => $pw, 'agree' => $agree);
                $this->db->where('user_id', get_authenticateUserID());
                $this->db->update('user_master', $usr);
                $data["msg"] = "success";
            } catch (Exception $ex) {
                $data["error"] = "Please enter proper domain  information.";
            }
        }

        if ($data["error"] != "") {
            $response = array("comment_error" => $data["error"], "status" => "fail");
            echo json_encode($response);
            die;
        }

        if ($data["msg"] == "success") {
            $response = array("status" => "success");
            echo json_encode($response);
            die;
        }

        $this->template->write_view('header', $theme . '/common/header', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/domainmanagement', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

    function barlistings($msg = "") {
        $data = array();
        $user_info = get_user_info(get_authenticateUserID());
        if (get_authenticateUserID() == '') {
            redirect('home');
        }
        if ($this->session->userdata('user_type') != 'bar_owner') {
            redirect('home');
        }

        $theme = getThemeName();
        $data['error'] = '';
        $data["active_menu"] = '';
        $data['site_setting'] = site_setting();
        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['getbardata'] = $this->home_model->get_bar_info(get_authenticateUserID());

        $theme = getThemeName();
        $this->template->set_master_template($theme . '/template.php');

        $data['page_name'] = "barlistings";

        $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
        $this->template->write_view('content_center', $theme . '/home/bar_listings', $data, TRUE);
        $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
        $this->template->render();
    }

}

?>
