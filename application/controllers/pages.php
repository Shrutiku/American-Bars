<?php
class Pages extends CI_Controller {

        public function view($page = '')
        {
            $theme = getThemeName();
            
            if (!file_exists(APPPATH . $theme .$page . '.php'))
            {
                $this->redirect('home');
            }

            $this->load->view($theme . "/pages/" . $page);
        }
}