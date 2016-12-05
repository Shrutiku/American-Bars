<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	
class  SPACULLUS_Controller  extends  CI_Controller  {


	
    public function __construct()
	{
	
		// get the CI superobject
		$CI =& get_instance();
		parent::__construct();
		
		 
		    
	    date_default_timezone_set("Europe/London");
      }
		
	
} 

// END MY_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */