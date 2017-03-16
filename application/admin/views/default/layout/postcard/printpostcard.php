
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
$code = base64_encode($one_order['postcard_id']);
                                   
                                        
//http://192.168.1.27/ADB/admin/default/images/post_bg1.jpg
$html = '';
// $html .= '<table width="100%" bgcolor="rgb(255,255,255)" border="0" cellspacing="0" cellpadding="0" align="center" style=" padding-right:30px;background-color:rgb(255,255,255);">
  // <tr>
    // <td>
            // <img src="'.$img.'"/>
//             
            // </td>';
// <img src="'.front_base_url().'default/images/post.png" style="float:left;" />$html .= '</tr></table>';

$html .= '<div style="width:6in; height:4in; font-family: Calibri; border: solid 3px #CCCCCC; color: #000; overflow: hidden;  font-size: 11px;letter-spacing: .8px;">

  <div  style="width:3in; float: left;">
    <div style="float: left; padding-left: 6.25%; padding-top: 31.25%">

      <h1 style="font-family: Calibri;  font-size: 18px; letter-spacing: .8px;">Dear Bar Owner,</h1>

       <p style="font-family: Calibri; font-size: 16px; font-weight: normal; margin-bottom: 0;letter-spacing: .8px;text-align: justify; height: 31.25%; width: 88%;" >'.substr(nl2br($one_order['post_message']),0,240).'--><!--Max 240 Characters--></p>

         <label style="font-family: Calibri; font-size: 13px; font-weight: bold; float:left; padding-top: 20%; align-self: center;">To read all messages, <br>claim your bar and use code: '.$code.'</label>
      </div>
    </div>
  <div style="width:3in; float: right;">

    <div style="text-align: center; border: solid 1px #996E13; width: .75in; height: .75in; float: right; font-size: 16px;"><br>Stamp</div>
    <div style="float: right; padding-right: 6.25%; padding-top: 37.5%">
    
      <div style="font-family: Calibri; text-align: center; font-size: 11px;">
                      '.$one_order['bar_title'].' <br/>
                      '.$one_order['address'].' <br/>
                      '.$one_order['city']." ".$one_order['state']." ".$one_order['zipcode'].'        
      </div>

    </div>
  </div>
</div>';
// 
 // print_r($html);
 // die;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
// $dompdf->set_paper('letter', 'portrait');
$dompdf->render();
// 
// print_r($dompdf->render());
// die;


	  $dompdf->stream("Postcard.pdf", array("Attachment"=>"1"));


?>