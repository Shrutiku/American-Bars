<?php

/* !
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Hybrid_Providers_Facebook provider adapter based on OAuth2 protocol
 * Hybrid_Providers_Facebook use the Facebook PHP SDK created by Facebook
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_Facebook.html
 */
class Hybrid_Providers_PushNotifications extends Hybrid_Provider_Model {

    /**
     * Provider API client
     *
     * @var \Facebook\Facebook
     */
    public $api;

    public $useSafeUrls = true;

    /**
     * {@inheritdoc}
     */
    function initialize() {
    }

    /**
     * {@inheritdoc}
     */
    function loginBegin() {
    }

    /**
     * {@inheritdoc}
     */
    function loginFinish() {    
    }

    /**
     * {@inheritdoc}
     */
    function logout() {
    }

    /**
     * {@inheritdoc}
     */
    function getUserProfile() {
        return null;
    }
    
    function getAllUser_Device()
    {
        $CI =& get_instance();
        $qry = $CI->db->query("select * from sss_registered_iphone");		
        if ($qry->num_rows() > 0) {
                return $qry->result();
        }
        return '';
    }

    function getAllUser_Device_android()
    {
        $CI =& get_instance();
        
        $qry = $CI->db->query("select * from sss_registered_android");		
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return '';
    }
    
    function sendPushNotificationAndroid($patient_id,$data)
    {
        $CI =& get_instance();
        $registatoin_ids_count	= $CI->db->select('COUNT(registered_android_id) as TOTAL')->where("gcm_regid",$patient_id)->get("registered_android")->row()->TOTAL;

        if($registatoin_ids_count)
        {
            $site_setting = site_setting();
            $registatoin_ids = $CI->db->select('gcm_regid')->where(array("gcm_regid"=>$patient_id,"android_session"=>'1'))->get("registered_android");

            if($registatoin_ids->num_rows())
            {
                foreach($registatoin_ids->result() as $r)
                {
                        $__registatoin_ids[] = $r->gcm_regid;
                }
                $registatoin_ids = $__registatoin_ids;
                $url = 'https://android.googleapis.com/gcm/send';

                $fields = array(
                    'registration_ids' => $registatoin_ids,
                    'data' => $data,
                );

                        $temp ="AIzaSyD_ZMHoIPB5--2926J94uI0J8Tj-fZiPm4";

                $headers = array(
                    "Authorization: key=$temp",
                    'Content-Type: application/json'
                );

                // Open connection
                $ch = curl_init();

                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                // Execute post
                $result = curl_exec($ch);

                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }

                // Close connection
                curl_close($ch);

                $res = json_decode($result);
                $res->results;
                if(isset($res->results) && $res->results)
                {
                    for($i=0;$i<count($res->results);$i++)
                    {
                    }
                }
                
                return $result;
            }
        }
		
    }                           
    
    function sendPushNotificationiPhone($patient_id,$data)
    {
        $CI =& get_instance();
        $registatoin_ids_count = $CI->db->select('COUNT(registered_iphone_id) as TOTAL')->where("device_id",$patient_id)->get("registered_iphone")->row()->TOTAL;

        if($registatoin_ids_count)
        {
            $registatoin_ids = $CI->db->select('token_id,sound_name')->where(array("device_id"=>$patient_id,"iphone_session"=>'1'))->get("registered_iphone");

            if($registatoin_ids->num_rows())
            {
                foreach($registatoin_ids->result() as $r)
                {

                    $r->token_id;
                    // Put your device token here (without spaces):
                    $deviceToken = str_replace(array("<",">"," "),'',$r->token_id);

                    // Put your private key's passphrase here:
                    $passphrase = '123456';
                    ////////////////////////////////////////////////////////////////////////////////
                    $ctx = stream_context_create();


                    if($_SERVER['HTTP_HOST']=='sandbox.americanbars.com')
                    {
                            //ab_ck.pem	
                            // adb_dist_ck.pem
                            $pem_file = 'ab_ck.pem';
                            $stream = 'ssl://gateway.push.apple.com:2195';
                    }
                    else
                    {
                            $pem_file = 'adb-adhoc-ck.pem';
                            $stream = 'ssl://gateway.sandbox.push.apple.com:2195';
                    }
                    stream_context_set_option($ctx, 'ssl', 'local_cert', base_path()."iphone/$pem_file");


                    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                    // Open a connection to the APNS server
                    $fp = stream_socket_client(
                            $stream, $err,
                            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                    if (!$fp)
                            exit("Failed to connect: $err $errstr" . PHP_EOL);

                    if($data['type'] == 'Recursive Reminder'){
                            if($r->sound_name !=''){
                                    $sound =  $r->sound_name;	
                            }
                            else{
                                    $sound = 'Argonium-30s.mp3';
                            }

                    }else {
                            $sound =  'default'; //'push_sound.wav';
                    }

                    // Create the payload body
                    $body['aps'] = array(
                            'alert' => $data['message'],
                            'sound' => $sound,
                            );

                    $body['type'] = $data['type'];
                    $body['subject'] = $data['subject'];

                    // Encode the payload as JSON
                    $payload = json_encode($body);
                    // Build the binary notification
                    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                    // Send it to the server
                    $result = fwrite($fp, $msg, strlen($msg));                           
                    // Close the connection to the server
                    fclose($fp);
                }

                return (bool)$result;
            }
        }
    }

    /**
     * {@inheritdoc}
     */  
    function setUserStatus($message) { 
	$to_id_arr 	 = $this->getAllUser_Device('user');
        $to_id_android =  $this->getAllUser_Device_android('user');
		
        if($to_id_android){
        foreach($to_id_android as $row){
                sendPushNotificationAndroid($row->gcm_regid,array("type"=>"American Bars","subject"=>"American Bars","message"=>$message));
        }	
        }
        if($to_id_arr){
            foreach($to_id_arr as $row){
                sendPushNotificationiPhone($row->device_id,array("type"=>"American Bars","subject"=>"American Bars","message"=>$message));
            }	
	}  
    }
}