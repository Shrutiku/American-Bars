
<?php require_once APPPATH.'/libraries/html2pdf/html2pdf.class.php';?>
<?php
ob_start();

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
// $html .= '<div>testestestestestestestestest</div>';
//$html .= '<div style="width:6in; height:4in; font-family: Calibri; color: #000; overflow: hidden; font-size: 11px;letter-spacing: .8px;">';
//$html .= 'test</div>';






$html .= '<div style="width:6in; height:4in; font-family: courier; color: #000; overflow: hidden; font-size: 11px; letter-spacing: .8px; border: solid 1px #996E13; <!--rotate: 90;--> <!--transform: rotate(90deg) scale(1.03);-->">';
$html .='<div  style="width:45%; float: left; border: solid 1px #996E13;">
            <div style="float: left; padding-left: 6.25%; padding-top: 31.25%">

              <h1 style="font-family: courier; font-weight: bold font-size: 20px; letter-spacing: .8px;">Dear Bar Owner,</h1>

               <p style="font-family: courier; font-size: 16px; margin-bottom: 0;letter-spacing: .8px;text-align: justify; height: 31.25%; width: 88%;" >'.substr(nl2br($one_order['post_message']),0,100).'.....</p>

                 <label style="font-family: courier; font-size: 22px; font-weight: bold; float:left; margin-top: -2%; align-self: center; color: #4CAF50;">To read the rest of this message, claim your bar with this code:<br>'.$code.'</label>
              </div>
            </div>
          <div style="width:45%; float: right; border: solid 1px #996E13;">

            <div style="text-align: center; border: solid 1px #996E13; width: .75in; height: .75in; float: right; font-size: 16px;"><br>Stamp</div>
            <div style="float: right; padding-top: 37.5%">

              <div style="font-family: courier; text-align: center; font-size: 14px; padding-left: 6%">
                              '.$one_order['bar_title'].' <br/>
                              '.$one_order['address'].' <br/>
                              '.$one_order['city'].", ".$one_order['state']." ".$one_order['zipcode'].'        
              </div>

            </div>
          </div>';
$html .= '</div>';
 
$html2pdf = new HTML2PDF('P', 'A4', 'en');
$html2pdf->writeHTML($html);
$html2pdf->Output('Postcard.pdf')

// print_r($html);
// die;
//$dompdf = new DOMPDF();
//$dompdf->load_html($html);
//$dompdf->set_paper('letter', 'portrait');
//$dompdf->render();
// 
// print_r($dompdf->render());
// die;


//	  $dompdf->stream("Postcard.pdf", array("Attachment"=>"1"));


?>