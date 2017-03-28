
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



$barowner = '';

//          working
//        if ($one_order['bar_first_name'] !== "") {
//            $barowner = $one_order['bar_first_name'];
//        } else {
//            $barowner = 'Bar Owner';
//        }
        
        if ($one_order['bar_first_name'] == "") {
            $barowner = 'Bar Owner';
        } else {
            $barowner = $one_order['bar_first_name'];
        }

// HTML2PDF Conv Method

//$html .= '<div style="width:4in; height:6in; font-family: courier; color: #000; overflow: hidden; font-size: 11px; letter-spacing: .8px; <!--border: solid 1px #996E13;--> <!--rotate: 90;--> <!--transform: rotate(90deg) scale(1.03);-->">';
//$html .= '<div style="width: 0in; height:100%;rotate:90; <!--border: solid 1px #996E13;-->"></div>
//        <div style="width:1.9in;rotate:90; height:100%;">
//            <div style="<!--border: solid 1px #996E13;--> width: 100%; height:1.5in;"></div>
//            <div style="text-align: left;">
//              <div style="font-family: courier; text-align: left; font-size: 16px; <!--border: solid 1px #996E13;-->"><p>
//                              '.$one_order['bar_first_name']." ".$one_order['bar_last_name'].' <br/>
//                              '.$one_order['bar_title'].' <br/>
//                              '.$one_order['address'].' <br/>
//                              '.$one_order['city'].", ".$one_order['state']." ".$one_order['zipcode'].'</p>
//                </div></div>
//        </div>
//          <div style="width:.5in; height:100%;rotate:90; <!--border: solid 1px #996E13-->"></div>
//          <div style="width:3in; height:100%; <!--border: solid 1px #996E13;-->rotate:90;">
//            <div style="text-align: center; <!--border: solid 1px #996E13;--> width: 100%; height: .75in; font-size: 16px;"></div>
//            <div style="">
//
//              <p style="font-family: courier; font-weight: bold; font-size: 20px; letter-spacing: .8px;">Dear '.$barowner.',</p>
//
//               <p style="font-family: courier; font-size: 16px; letter-spacing: .8px;text-align: left;" >'.substr(nl2br($one_order['post_message']),0,100).'.....<br></p>
//
//                 <p style="font-family: courier; font-size: 17px; font-weight: bold; text-align: right; color: #4CAF50;">To read the rest of this message, claim your bar with this code:<br>'.$code.'</p>
//              </div>
//            </div>
//        <div style="width:.6in; height:100%;rotate:90; <!--border: solid 1px #996E13-->"></div>';
//$html .= '</div>';
 
//$html2pdf = new HTML2PDF('P', 'A4', 'en');
//$html2pdf->writeHTML($html);
//$html2pdf->Output('Postcard.pdf')

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

<div style="width:6in; height:4in; font-family: Calibri; color: #000; overflow: hidden;  font-size: 11px;letter-spacing: .8px; transform: rotate(90deg) scale(1); margin-top: 1in; margin-left: -1in;">

  <div  style="width:3.25in; float: left;">
    <div style="float: left; padding-left: 4.25%; padding-top: 25%">
      <h1 style="font-family: Calibri;  font-size: 18px; letter-spacing: .8px;">Dear <?php echo $barowner;?>,</h1>
      <p style="font-family: Calibri; font-size: 16px; font-weight: normal; margin-bottom: 0;letter-spacing: .8px;text-align: justify; height: 31.25%; width: 88%;" ><?php echo substr(nl2br($one_order['post_message']),0,100);?><!--Max 100 Characters-->.....</p>
      <label style="font-family: Calibri; font-size: 19px; font-weight: bold; float:left; margin-top: -2%; text-align: right; color: #4CAF50;">To read the rest of this message, claim your bar with this code:<br><?php echo $code;?></label>    
    </div>
  </div>
    
    <!--<div style="width:0.2in;"></div> <!-- Padding for divider -->

  <div style="width:2.5in; float: right;">
    <!--<div style="text-align: center; border: solid 1px #996E13; width: .75in; height: .75in; float: right; font-size: 16px;"><br>Stamp</div>-->
    <div style="padding-top: 50%">
      <div style="font-family: Calibri; text-align: center; font-size: 14px; padding-top: 25%; padding-right: 6.25%">          
            <?php echo $one_order['bar_first_name']." ".$one_order['bar_last_name'];?>
            <?php echo $one_order['bar_title'];?><br/>
            <?php echo $one_order['address'];?><br/>
            <?php echo $one_order['city'].", ".$one_order['state']." ".$one_order['zipcode'];?>       
      </div>
    </div>
  </div>

</div>