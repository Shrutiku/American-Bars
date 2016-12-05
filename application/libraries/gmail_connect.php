<?php
  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    class GmailContacts_lib {

        var $FEED_URL = "http://www.google.com/m8/feeds/contacts/default/full";
        var $LOGIN_URL = "https://www.google.com/accounts/ClientLogin";
        var $username;
        var $passwd;
        var $postData = array();

        function GmailContacts_lib($gUsername, $gPassword) {
            //constructor function
            $this->username = $gUsername;
            $this->passwd = $gPassword;
        }

        function get_gmail_contacts() {
            $emailLists = array();
            //create an array for post data
            $this->postData = array(
                "accountType"   => "HOSTED_OR_GOOGLE",
                "Email"         => $this->username,
                "Passwd"        => $this->passwd,
                "service"       => "cp",
                "source"        => "anything"
            );
            //initialize the curl object
            $curl = curl_init($this->LOGIN_URL);
            //set the curl options
            $this->set_curl_options($curl, CURLOPT_POST, true);
            $this->set_curl_options($curl, CURLOPT_POSTFIELDS, $this->postData);
            $this->set_curl_options($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            $this->set_curl_options($curl, CURLOPT_SSL_VERIFYPEER, false);
            $this->set_curl_options($curl, CURLOPT_RETURNTRANSFER, 1);

            //following variable contains the responses
            $response = curl_exec($curl);
            
            //check if the user has logged in sucessfully 
           //and save auth key if logged in
            preg_match("/Auth=([a-z0-9_\-]+)/i", $response, $matches);
            $auth = $matches[1];
            if( !empty($auth)) {
                $headers = array("Authorization: GoogleLogin auth=".$auth);

                //make the request to google contacts feed with the auth key maximum contacts is 10000
                $curl1 = curl_init($this->FEED_URL);

                //passing the headers of auth key
                $this->set_curl_options($curl1, CURLOPT_HTTPHEADER, $headers);
                //return the result in a variable
                $this->set_curl_options($curl1, CURLOPT_RETURNTRANSFER, 1);

                //results response
                $feed = curl_exec($curl1);
                //parse the feed and return email list array
                $emailLists = $this->parse_response($feed);
            }
            else {
                $emailLists = array("Invalid Username/Password");
            }
            return $emailLists;
        }

        //function to set curl options
        function set_curl_options($ch, $option, $value) {
            //make the post TRUE
            return curl_setopt($ch, $option, $value);
        }

        //function to parse response
        public function parse_response($feed) {
            $contacts = array();
            $doc = new DOMDocument();

            //load the XML response
            $doc->loadXML($feed);
            //check the entry tag
            $nodeList = $doc->getElementsByTagName( 'entry' );

            foreach($nodeList as $node) {
                //children of each entry tag
                $entry_nodes    = $node->childNodes;
                $tempArray      = array();

                foreach($entry_nodes as $child) {
                    //get the tagname of the child
                    $domNodesName = $child->nodeName;
                    switch($domNodesName) {
                        case "title":
                            { $tempArray['fullName'] = $child->nodeValue; }
                        break;
                        case "gd:email":
                            {
                            if (strpos($child->getAttribute('rel'),'home')!==false)
                                    $tempArray['email_1']=$child->getAttribute('address');
                            elseif(strpos($child->getAttribute('rel'),'work')!=false)
                                    $tempArray['email_2']=$child->getAttribute('address');
                            elseif(strpos($child->getAttribute('rel'),'other')!==false)
                                    $tempArray['email_3']=$child->getAttribute('address');
                            }
                        break;
                    }   //end of switch for nodeNames
                }   //end of foreach for entry_nodes child nodes
                if( !empty($tempArray['email_1'])) $contacts[$tempArray['email_1']] = $tempArray;
                if( !empty($tempArray['email_2'])) $contacts[$tempArray['email_2']] = $tempArray;
                if( !empty($tempArray['email_3'])) $contacts[$tempArray['email_3']] = $tempArray;
            }
            return $contacts;
        }
    }
?>