<?php
/*/*$servers = array('urlserver.paybox.com', // primary URL
'urlserver1.paybox.com'); // backup URL
$serverOK = "";
foreach($servers as $server){
$doc = new DOMDocument();
$doc->loadHTMLFile('https://'.$server.'/load.html');
$server_status = "";
$element = $doc->getElementById('server_status');
if($element){
$server_status = $element->textContent;
}
if($server_status == "OK"){
// Server is up and services are available
$serverOK = $server;
break;
}
// else : Server is up but services are not available .
}
if(!$serverOK){
die("Error : no server found");
}*/
?>
<?php
// Get the date at ISO-8601 format
$dateTime = date("c");
// Create the string to be hashed, without URLencoding
$msg = "PBX_SITE=1999888".
"&PBX_RANG=32".
"&PBX_IDENTIFIANT=110647233".
"&PBX_TOTAL=15".
"&PBX_DEVISE=978".
"&PBX_CMD=TEST Paybox".
"&PBX_PORTEUR=php.vivek@spaculus.com".
"&PBX_RETOUR=Mt:M;Ref:R;Auto:A;Erreur:E".
"&PBX_HASH=SHA512".
"&PBX_TIME=".urlencode($dateTime);
// Get the secret HMAC key (stored in a database for instance) and put it into $keyTest;
$keyTest = '';//Secret key of client
// If the key is in ASCII format, convert it to binary
$binKey = pack("H*", $keyTest);

// Calculate the HMAC hash (to be filled into parameter PBX_HMAC) with function hash_hmac and
// the binary key
// Send in the parameter PBX_HASH the hash algorithm which has been used (SHA512 in this case)
// To display the list of algorithms available on your environment, uncomment the following command
//echo "<pre>";
//print_r(hash_algos());
$hmac = strtoupper('7C63C4ACC7F4F2E51913B3AC09096711E7D931BB26495A3942EA9028C9CF8C1A0790243D8B3080EBFF330B340FB0A68CC066302A84C74CBB9A87F8F272FA56CE')  //strtoupper(hash_hmac('sha512', $msg, $binKey));
// The string will be sent in capital letters, so we use strtoupper()
// Create the HTML sheet that will be sent to Paybox System
// NOTE : the sequence of parameters in the request is extremly important, it must fit
// the sequnce of parameters in the hashed string
/*define('PAYBOX_URL', 'https://tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi');
define('PAYBOX_SANDBOX_URL', 'https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi');

define('PAYBOX_DIRECT_URL', 'https://ppps.paybox.com/PPPS.php');
define('PAYBOX_DIRECT_SANDBOX_URL', 'https://preprod-ppps.paybox.com/PPPS.php');
 * https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi?PBX_SITE=1999888&PBX_RANG=32&PBX_IDENTIFIANT=107904482&PBX_PAYBOX=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi&PBX_BACKUP1=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi&PBX_BACKUP2=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi&PBX_TOTAL=18000&PBX_DEVISE=978&PBX_CMD=303496&PBX_PORTEUR=jthorel%40sopragroup.com&PBX_RETOUR=reference%3AR%3Berror%3AE%3Btransaction%3AS%3Bsign%3AK&PBX_EFFECTUE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande&PBX_REFUSE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande&PBX_ANNULE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande&PBX_REPONDRE_A=http%3A%2F%2F178.33.255.224%3A8084%2Ftvvist3%2Fservlet%2Fplugins%2Fpaybox&PBX_TIME=2012-10-12T00%3A16%3A40&PBX_HASH=Sha512&PBX_HMAC=BFA71536F5F477F1A2F6EB5078D8EDF4C54E7A5FD4436393E1F1AF2295888EE235900F57895BB8EB6CD8FB6F06877AB9CC47EAE02327B4B0E1335ACB8BA97258
 * 
 PBX_SITE=1999888&
 PBX_RANG=32
 PBX_IDENTIFIANT=107904482
 PBX_PAYBOX=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi
 PBX_BACKUP1=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi
 PBX_BACKUP2=https%3A%2F%2Fpreprod-tpeweb.paybox.com%2Fcgi%2FMYchoix_pagepaiement.cgi
 PBX_TOTAL=18000&
 PBX_DEVISE=978
 PBX_CMD=303496
 PBX_PORTEUR=jthorel%40sopragroup.com
 PBX_RETOUR=reference%3AR%3Berror%3AE%3Btransaction%3AS%3Bsign%3AK
 PBX_EFFECTUE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande&
 PBX_REFUSE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande&
 PBX_ANNULE=http%3A%2F%2F178.33.255.224%3A8000%2Ftvvist3%2Fjsp%2Fsite%2FPortal.jsp%3Fpage%3Dformengine%26form%3Dtvvist3%26subform%3Dconsultationdemande
 PBX_REPONDRE_A=http%3A%2F%2F178.33.255.224%3A8084%2Ftvvist3%2Fservlet%2Fplugins%2Fpaybox
 PBX_TIME=2012-10-12T00%3A16%3A40
 PBX_HASH=Sha512
 PBX_HMAC=BFA71536F5F477F1A2F6EB5078D8EDF4C54E7A5FD4436393E1F1AF2295888EE235900F57895BB8EB6CD8FB6F06877AB9CC47EAE02327B4B0E1335ACB8BA97258
 * */
 
?>
<!-- <form method="POST" action="https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi"> -->

     <?php
      // $attributes = array('id'=>'frmsignup','name'=>'frmsignup','class'=>'form_horizontal');
      // echo form_open('https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi?PBX_SITE=1999888&PBX_RANG=32&PBX_IDENTIFIANT=107904482&PBX_PAYBOX='.urlencode("https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi").'&PBX_BACKUP1='.urlencode("https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi").
//'PBX_BACKUP2='.urlencode("https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi").'&PBX_TOTAL=1800&PBX_DEVISE=978&PBX_CMD=303496&PBX_PORTEUR=finance@thais.fr&PBX_RETOUR=reference%3AR%3Berror%3AE%3Btransaction%3AS%3Bsign%3AK&PBX_EFFECTUE='.urlencode(site_url("home/paybox_success")).'&PBX_ANNULE='.urlencode(site_url("home/paybox_cancel")).'&PBX_REPONDRE_A='.urlencode(site_url("home/paybox_response")).'&PBX_TIME='.urlencode($dateTime).'&PBX_HASH=Sha512&PBX_HMAC='.$hmac);
    ?>
<!-- <input type="hidden" name="PBX_SITE" value="1999888">
<input type="hidden" name="PBX_RANG" value="32">
<input type="hidden" name="PBX_IDENTIFIANT" value="107904482">
<input type="hidden" name="PBX_PAYBOX" value="https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">
<input type="hidden" name="PBX_BACKUP1" value="https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">
<input type="hidden" name="PBX_BACKUP2" value="https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">
<input type="hidden" name="PBX_TOTAL" value="18000">
<input type="hidden" name="PBX_DEVISE" value="978">
<input type="hidden" name="PBX_PORTEUR" value="php.vivek@spaculus.com">
<input type="hidden" name="PBX_RETOUR" value="<?php echo site_url('home/paybox_return')?>">
<input type="hidden" name="PBX_EFFECTUE" value="<?php echo site_url('home/paybox_success')?>">
<input type="hidden" name="PBX_ANNULE" value="<?php echo site_url('home/paybox_cancel')?>">
<input type="hidden" name="PBX_REPONDRE_A" value="<?php echo site_url('home/paybox_response')?>">
<input type="hidden" name="PBX_HASH" value="SHA512">
<input type="hidden" name="PBX_TIME" value="<? echo $dateTime; ?>">
<input type="hidden" name="PBX_HMAC" value="<? echo $hmac; ?>"> 

<input type="submit" value="Send">
</form>-->
<FORM ACTION = "https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi" METHOD = post> 
<INPUT TYPE = hidden NAME = PBX_MODE VALUE = "1"> <!-- passage par formulaire --> 
<INPUT TYPE = hidden NAME = PBX_SITE VALUE = "1999888"> 
<INPUT TYPE = hidden NAME = PBX_RANG VALUE = "20"> 
<INPUT TYPE = hidden NAME = PBX_IDENTIFIANT VALUE = "107904482"> 
<INPUT TYPE = hidden NAME = PBX_TOTAL VALUE = "1500"> 
<INPUT TYPE = hidden NAME = PBX_DEVISE VALUE = "978"> 
<INPUT TYPE = hidden NAME = PBX_CMD VALUE = "ma_reference_123456"> 
<INPUT TYPE = hidden NAME = PBX_PORTEUR VALUE = "client@test.com"> 
<INPUT TYPE = hidden NAME = PBX_RETOUR VALUE = "montant:M;ref:R;auto:A;trans:T"> 
<INPUT TYPE = hidden NAME = PBX_EFFECTUE VALUE = "http://www.commerce.fr/merci.html"> 
<INPUT TYPE = hidden NAME = PBX_REFUSE VALUE = "http://www.commerce.fr/regret.html"> 
<INPUT TYPE = hidden NAME = PBX_ANNULE VALUE = "http://www.commerce.fr/regret.html"> 
<INPUT TYPE = submit NAME = bouton_paiement VALUE = "paiement"> 
 
</FORM>

