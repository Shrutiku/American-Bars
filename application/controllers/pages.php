<?php
class Pages extends CI_Controller {

    public function view($page = '')
    {
        $theme = getThemeName();

        if ($page == "metrics")
        {
            $this->load->view($theme . "/pages/" . $page);
        }
        else {
            $data['site_setting'] = site_setting();
            $this->template->set_master_template($theme . '/template.php');
            $this->template->write_view('header', $theme . '/common/header_home', $data, TRUE);
            $this->template->write_view('content_center', $theme . "/pages/" . $page, $data, TRUE);
            $this->template->write_view('footer', $theme . '/common/footer', $data, TRUE);
            $this->template->render();
        }
    }
}