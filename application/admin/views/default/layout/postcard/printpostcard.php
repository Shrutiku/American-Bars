
<?php require_once APPPATH.'/dompdf-master/dompdf_config.inc.php';?>
<?php
global $_dompdf_show_warnings, $_dompdf_debug, $_DOMPDF_DEBUG_TYPES;

//$img = "http://www.placehold.it/175x132/EFEFEF/AAAAAA&text=no+image";

$img = front_base_url()."default/images/post_bg1.jpg";
$img1 = '';


if(file_exists(base_path().'upload/postcard_thumb_70by70/'.$one_order['image']))
					{

$img1 = front_base_url()."upload/postcard_thumb_70by70/".$one_order['image'];
					}

//http://192.168.1.27/ADB/admin/default/images/post_bg1.jpg
$html = '';
// $html .= '<table width="100%" bgcolor="rgb(255,255,255)" border="0" cellspacing="0" cellpadding="0" align="center" style=" padding-right:30px;background-color:rgb(255,255,255);">
  // <tr>
    // <td>
            // <img src="'.$img.'"/>
//             
            // </td>';
// <img src="'.front_base_url().'default/images/post.png" style="float:left;" />$html .= '</tr></table>';

$html .= '<div style="width:600px; height:300px; font-family: Calibri; margin:130px auto; border: solid 3px #CCCCCC; color: #000; overflow:hidden;  font-size: 11px;letter-spacing: .8px;">';
$html .= '<table><tr><td  style="width:300px">';
$html .='<div style="float: left;padding: 10px; border-right: solid 1px #996E13;padding-top: 0px;">
  			<h1 style="font-family: Calibri;  font-size: 11px; letter-spacing: .8px;">Dear Bar Owner,</h1>
  			<div style="font-family: Calibri; font-size: 11px;font-weight: normal;margin-bottom: 0;letter-spacing: .8px;text-align: justify;height: 215px; " >'.substr(nl2br($one_order['post_message']),0,1000).'</div>
  			<label style="font-family: Calibri; margin-top:25px; font-size: 11px; 	font-weight: bold; float:left;">'.$one_order['post_title'].'</label>
  			</div></td><td style="width:300px">
  			<div style="float: left;padding: 10px; ">
  			
  			<div style="border: solid 1px #996E13;width: 95px;height: 100px;float: right; margin-left:150px; margin-top:-50px; padding: 10px;font-size: 16px;">Place Stamp Here</div>
  			<div style="clear:both;"></div><br>
  			<div style="font-family: Calibri; text-align: center; margin-top:20px; font-size: 11px;">
	     							'.$one_order['bar_title'].' <br/>
	     							'.$one_order['address'].' <br/>
	     							'.$one_order['city']." ".$one_order['state']." ".$one_order['zipcode'].' 
	     	
  		</div>
  		</div></td></tr></table>';
$html .= '</div>';
// 
 // print_r($html);
 // die;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('letter', 'portrait');
$dompdf->render();
// 
// print_r($dompdf->render());
// die;


	  $dompdf->stream("Postcard.pdf", array("Attachment"=>"1"));


?>