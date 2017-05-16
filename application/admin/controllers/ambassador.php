<?php
class Suggest_bar extends  CI_Controller 
{
    function Suggest_bar()
    {
             parent::__construct();	
            $this->load->model('bar_model');

    }

    function index()
    {
            if(!check_admin_authentication())
            {
                    redirect('home');
            }
            redirect('ambassador/list_ambassador');


    }


    function list_ambassador($limit='10',$offset=0,$msg='')
    {
            if(!check_admin_authentication())
            {
                    redirect('home');
            }
            $check_rights=get_rights('ambassador');

            if(	$check_rights==0) {			
                    redirect('home/dashboard/no_rights');	
            }

            $theme = getThemeName();
            $this->template->set_master_template($theme .'/template.php');

            $this->load->library('pagination');

            $config['uri_segment']='4';
            $config['base_url'] = base_url().'ambassador'.$limit.'/';
            $config['total_rows'] = $this->bar_model->get_total_suggest_bar();

            $config['per_page'] = $limit;		
            $this->pagination->initialize($config);		
            $data['page_link'] = $this->pagination->create_links();

            $data['result'] = $this->bar_model->get_suggest_bar_result($offset,$limit);
            $data['msg'] = $msg;

            $data['offset'] = $offset;
            $data['error']='';
            if($this->input->post('limit') != '')
            {
                    $data['limit']=$this->input->post('limit');
            }
            else
            {
                    $data['limit']=$limit;
            }
            $data['option']='1V1';
            $data['keyword']='1V1';
            $data['serach_option']='1V1';
            $data['serach_keyword']='1V1';
            $data['search_type']='normal';
//            $data['redirect_page']='list_suggest_bar';

            $data['site_setting'] = site_setting();
            $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
            $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
            $this->template->write_view('center',$theme .'/layout/ambassador/list_ambassador',$data,TRUE);
            $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
            $this->template->render();
    }
}
?>