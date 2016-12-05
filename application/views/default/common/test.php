<style>
	body{
		background: #ffffff;
	}
</style>
<?php
function Gatewaypaymentech(){
	return "creditcards";
}

function Configpaymentech(){
	
	global $PROCESSOR;
?>
<table border='1' cellpadding='0' cellspacing='4' width='100%'>
	<tr>
		<td width='100%' colspan="2">Paymentech:<input type="hidden" name="modulepaymentech_creditcards" value="Yes"></td>
	</tr>
	<tr>
		<td width='59%'>Merchant #:</td>
		<td width='41%'><input type='text' name='modulepaymentech_merch' size='10' value='<?php echo $PROCESSOR["modulepaymentech_merch"]; ?>'></td>
	</tr>
	<tr>
		<td width='59%'>Terminal ID:</td>
		<td width='41%'><input type='text' name='modulepaymentech_term' size='10' value='<?php echo $PROCESSOR["modulepaymentech_term"]; ?>'></td>
	</tr>
	<tr>
		<td width='59%'>BIN #:</td>
		<td width='41%'><input type='text' name='modulepaymentech_bin' size='10' value='<?php echo $PROCESSOR["modulepaymentech_bin"]; ?>'></td>
	</tr>
	<tr>
		<td width='59%'>Credit Cards Accepted:<br>(separate with a comma)</td>
		<td width='41%'><input type='text' name='modulepaymentech_cardnames' size='40' value='<?php echo $PROCESSOR["modulepaymentech_cardnames"]; ?>'></td>
	</tr>
</table>
<br>
<?php
}

function Checkoutpaymentech($products, $totals, $orderid, $billing){
	global $PROCESSOR, $lang, $config, $MONTHS;;

	// Don't put the authorize on here. It will go on the POST request below
	
	//$url = "https://orbitalvar2.paymentech.net"; // use while in certification/testing
	$url = "https://orbital1.paymentech.net"; // use for production
	$page = 'xml.php';
	
	$exp   = $billing["CCMONTH"] . substr($billing[CCYEAR], 2); // get the expiry date with only the last two chars of the years
	$total = str_replace('.', '', $totals["RAWTOTAL"]); //implied decimal, so take it out
	
	//make a coimpliant card type
	$card_type = $billing["CCTYPE"];
	switch($card_type) {
	  case "Visa" : 
	  	$card_type = "VI";
		break;
	  case "MasterCard" : 
	  	$card_type = "MC";
		break;
	  case "American Express" : 
	  	$card_type = "AX";
		break;
	  case "Discover" : 
	  	$card_type = "DI";
		break;
	  case "JCB" : 
	  	$card_type = "JC";
		break;
	}
	
	$post_string="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Request><NewOrder><IndustryType>EC</IndustryType><MessageType>AC</MessageType><BIN>$PROCESSOR[modulepaymentech_bin]</BIN><MerchantID>$PROCESSOR[modulepaymentech_merch]</MerchantID><TerminalID>$PROCESSOR[modulepaymentech_term]</TerminalID><CardBrand>$card_type</CardBrand><AccountNum>$billing[CCNUMBER]</AccountNum><Exp>$exp</Exp><CardSecValInd>1</CardSecValInd><CardSecVal>$billing[CVVCODE]</CardSecVal><AVSzip>$billing[ZIP]</AVSzip><AVSaddress1>$billing[ADDRESS]</AVSaddress1><AVScity>$billing[CITY]</AVScity><AVSstate>$billing[STATE]</AVSstate><AVSname>$billing[FIRSTNAME] $billing[LASTNAME]</AVSname><OrderID>$orderid</OrderID><Amount>$total</Amount><Comments>Email: $billing[EMAIL] | Comments: $billing[COMMENTS]</Comments><ShippingRef></ShippingRef></NewOrder></Request>";
	
	
	//die(str_replace("\n", "<br />", str_replace("<", "&lt;",  $post_string)));
	
		   $header= "POST /authorize/ HTTP/1.0\r\n";        // HTTP/1.1 should work fine also
		   $header.= "MIME-Version: 1.0\r\n";
		   $header.= "Content-type: application/PTI40\r\n";
		   $header.= "Content-length: "  .strlen($post_string) . "\r\n";
		   $header.= "Content-transfer-encoding: text\r\n";
		   $header.= "Request-number: 1\r\n";
		   $header.= "Document-type: Request\r\n";
		   $header.= "Interface-Version: Test 1.4\r\n";
		   $header.= "Connection: close \r\n\r\n";                // Must have two CR/LF's here
		   $header.= $post_string;
		   
		 
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL,$url);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		   curl_setopt($ch, CURLOPT_HEADER, false);                // You are providing a header manually so turn off auto header generation
			   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $header);
					// The following two options are necessary to properly set up SSL
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	
		   $data = curl_exec($ch);        
			   if (curl_errno($ch)) {
			   print curl_error($ch);
		   } else {
			   curl_close($ch);
		   }
	
	// use XML Parser on $data, and your set!
	
		   $xml_parser = xml_parser_create();
		   xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
		   xml_parser_set_option($xml_parser,XML_OPTION_SKIP_WHITE,1);
		   xml_parse_into_struct($xml_parser, $data, $vals, $index);
		   xml_parser_free($xml_parser);
				
			  print ($data);
			  die;
	
	// $vals = array of XML tags.  Go get em!
}
?>