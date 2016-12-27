<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super-simple, minimum abstraction MailChimp API v2 wrapper
 * 
 * @author Drew McLellan <drew.mclellan@gmail.com> modified by Ben Bowler <ben.bowler@vice.com>
 * @version 1.0
 */

/**http://apidocs.mailchimp.com/api/2.0/#api-endpoints
 * api_key       
 * api_endpoint            
 */

$config['mailchimp_key'] = '27148816c1b6c779671fb01a6e12b5fa-us3';

$config['mailchimp_list_id']='24ad485048';

$config['api_endpoint'] = 'https://us3.api.mailchimp.com/2.0/';

//$config = array( 'apikey' => '27148816c1b6c779671fb01a6e12b5fa', 
  //              'secure' => FALSE);
                
