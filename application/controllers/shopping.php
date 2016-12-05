<?php
require(APPPATH.'PayPal-PHP-SDK/paypal/rest-api-sdk-php/sample/bootstrap.php');
require(APPPATH.'Paypal-PayFlow-API-Wrapper-Class-master/Class.PayFlow.php');
//require ('Paypal/common.php');
use PayPal\Api\CreditCard;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
//start of Shopping controller for search , sale and etc.
class Shopping extends CI_Controller{
	//load model(shopping model)
	function Shopping()
	{
		parent::__construct();
		//die('<div align="center"><h2>Welcome To E-commerce Wine</h2></div>');
		$this->load->model('shopping_model');
		$this->load->helper('cache');
		$this->load->library('cart');
		
		$getpaypalsetting = paypalsetting();
		
		$this->apiContext = new ApiContext(
		new OAuthTokenCredential(
			$getpaypalsetting->client_id,
			$getpaypalsetting->secret_key
		)
	);
	
	   $this->apiContext->setConfig(
		array(
			'mode' => $getpaypalsetting->site_status,
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => FCPATH.'application/logs/PayPal.log',
			'log.LogLevel' => 'FINE'
		)
	);
	}
	//end of product function
	function index()
	{
		redirect('shopping/products');
		$data=array();
		$data['active_menu']='shopping';
		$theme = getThemeName();
		$meta_setting=meta_setting();
		$data['keyword']= '';
		
		if($_POST){
			//echo '<pre>'; print_r($_POST); echo '</pre>';
			$data['keyword']= $this->input->post('keyword'); 
			$data['getallproduct'] = $this->shopping_model->getProductBySearch();	
			//echo '<pre>'; print_r($data['getallproduct']); echo '</pre>';
		} else {
			$data['getallproduct'] = $this->shopping_model->getAllproduct();
		}

		//$data['getallproduct'] = $this->shopping_model->getAllproduct();
		$pageTitle       = $meta_setting->title.''.' :: Shopping';
	  	$metaDescription ='Ewine';
		$metaKeyword='Ewine';

		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->template->write_view('header',$theme .'/layout/common/header_shop',$data,TRUE);
		$this->template->write_view('content_center',$theme .'/layout/shopping/allproduct',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);

		$this->template->render();
	}

    function getCategoryByParentID()
	{
	
		$string = $this->shopping_model->getcatByParentID();
		echo $string;
		die;
	}
	
	
	function SearchProduct()
	{
		$data=array();
		$theme = getThemeName();
		$data['getallproduct'] = $this->shopping_model->getProductBySearch();
		echo $this->load->view($theme .'/layout/shopping/allproduct_ajax',$data,TRUE);
		die;
	}

	/* 
	 * Function : addTocart
	 *  Desc : For add to Number of product in cart
	 * 
	 */ 
	function addTocart()
	{
		$one_product=$this->shopping_model->getOneProduct($this->input->post('id'));
		$cartdata=$this->cart->contents();
		$get = 0;
		if($cartdata){
			foreach($cartdata as $v)
			{
				$sec_product=$this->shopping_model->getOneProduct($v['id']);
				//exit;
				foreach($sec_product as $j)
				{
					
					$get = $j;
					//exit;
				}
			}
		}
		
		if($this->cart->total()==0)
		{
			$i = 0;
		}
		else
		{
			$i = $one_product['bar_id'];
		}	
		if($one_product['quantity']==0)
		{
			//echo json_encode(array('count'=>0));
			echo json_encode(array('count'=>0,'status'=>'fail'));
		}
		else {
		
		//echo $get."fd";echo $one_product['bar_id']."fd";
			
		if($get==$i)
		{	
		$set=0;
		$id =  $_REQUEST['id'];
		$qty  =  1;
      
			$getcolor = $this->input->post('color_id');
			$getsize = $this->input->post('size_id');
		
		
		 
		//$getsize = getsinglesize(); 
		
		
		if($set==0)
		{
			if($this->input->post('qnty')==0)
			{
				$qty = 1;
			}
			else {
				$qty = $this->input->post('qnty');
			}
			$data=array(
						'id'=>$_REQUEST['id'],
						'qty'=>$qty,
						'price'=>$one_product['price'],
						'name'=>$one_product['product_name'],
						'options' => array('bar_id' => $_REQUEST['bar_id'],'color_id'=>$getcolor,'size_id'=>$getsize),
						'product_id'=> $id
				);
				
			$this->cart->insert($data);
		}
		
		 
		
		echo json_encode(array('count'=>count($this->cart->contents()),'status'=>'success'));
			
		}
		else {
			echo json_encode(array('count'=>count($this->cart->contents()),'status'=>'fail'));
		}
		}	
	}
    
    function addToCartDetail($id,$qty)
    {
        $one_product=$this->product_model->getOneProduct($id);
        $cartdata=$this->cart->contents();
        //echo "<pre>";print_r($cartdata);exit;
        $set=0;
        if($cartdata)
        {
            foreach($cartdata as $cdata)
            {
                if($cdata['id']==$this->input->post('id'))
                {
                    $set=1;
                    $data=array('rowid'=> $cdata['rowid'],
                                'qty'  => $cdata['qty']+$qty
                        );
                  
				    $this->cart->update($data);
                }
            }
        }
        if($set==0)
        {
		 if($qty > 0)
            {
                $query=$this->db->query("select * from ".$this->db->dbprefix('product_price')." where product_id='".$id."' and (".$qty." between qty_from and qty_to)");
                $result=$query->row_array();
                if($query->num_rows()>0){
                   // echo "$ ".$result['product_price']*$qty;
                 
                }else{
                    $query=$this->db->get_where('product',array('product_id'=>$id));
                    $result=$query->row_array();
                //    echo "$ ".$result['product_price']*$qty;
                  //  exit;
                }
            }else{
                $query=$this->db->get_where('product',array('product_id'=>$id));
                $result=$query->row_array();
        //       echo "$ ".$result['product_price']*$qty;
          //      exit;
            }		
		
		
		
		
            $data=array(
                        'id'=>$id,
                        'qty'=>$qty,
                        'price'=>$result['product_price'],
                        'name'=>$one_product['product_name'],
                        'image'=>$one_product['image_name'],
						'product_id'=> $id
                );
            $this->cart->insert($data);
        }
         
      echo "success";exit;
    }


	function cart(){
        $getpaypalsetting = paypalsetting();
		$this->session->set_flashdata('url', base64_encode(current_url()));	
		//!check_user_authentication()?redirect("home"):'';
		 if($this->cart->total() == 0)
		   {
		   	redirect('shopping/products');
		   }

		 if($this->cart->contents()){
           if($this->cart->total() <= 0)
		   {
		   	redirect('shopping/products');
		   }
		 } 
		$data=array();
		$res = '';
		$theme = getThemeName();
		$site_setting = site_setting();
		$meta_setting=meta_setting();
		$pageTitle       = $meta_setting->title.''.' :: Cart';
	  	$metaDescription ='Ewine';
		$metaKeyword='Ewine';
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);
		$data["error"] = '';
		
		$data['msg'] = '';
		$this->form_validation->set_rules('cc_type','Credit Card Type', 'required');
	  	$this->form_validation->set_rules('card_number','Credit Card Number', 'required');
	 	$this->form_validation->set_rules('ex_month','Expire Month', 'required');
	 	$this->form_validation->set_rules('ex_year','Expire Year', 'required');
	 	$this->form_validation->set_rules('cvv', 'Cvv Number', 'required');
		$this->form_validation->set_rules('address1', 'Address1', 'required');
		$this->form_validation->set_rules('address2', 'Address1', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
        if($this->form_validation->run() == FALSE)
		{
				if(validation_errors())
				{													
					$data["error"] = validation_errors();
				}
				else
				{		
					$data["error"] = "";							
				}
					$data['cc_type']=$this->input->post('cc_type');
					$data['card_number']=$this->input->post('card_number');
					$data['ex_month']=$this->input->post('ex_month');
					$data['ex_year']=$this->input->post('ex_year');
					$data['cvv']=$this->input->post('cvv');
					$data['address1']=$this->input->post('address1');
					$data['address2']=$this->input->post('address2');
					$data['city']=$this->input->post('city');
					$data['state']=$this->input->post('state');
					$data['country']=$this->input->post('country');
					$data['zipcode']=$this->input->post('zipcode');
		}
        else
		{
			$getuser = get_user_info(get_authenticateUserID());
			//print_r($getuser);
			//echo $getuser->first_name;
			//die;
			$PayFlow = new PayFlow($getpaypalsetting->vendor,'Paypal', $getpaypalsetting->paypal_username,$getpaypalsetting->paypal_password, 'single');

			$PayFlow->setEnvironment('test');                           // test or live
			$PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
			$PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
			$PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
			
			
			$PayFlow->setAmount((number_format($this->cart->total(),2)), FALSE);
			$PayFlow->setCCNumber($this->input->post('card_number'));
			$PayFlow->setCVV($this->input->post('cvv'));
			$PayFlow->setExpiration($this->input->post('ex_month').substr($this->input->post('ex_year'), 2,4));
			
			if($PayFlow->processTransaction())
			{
				//print_r($PayFlow->getResponse());
			//	print_r($PayFlow->getResponse())."SD";
			//die;
				$res = $PayFlow->getResponse();
				
				$qty = 1;
		   
		   $data = array(
		       'user_id'=>get_authenticateUserID(),
			   'order_number'=>'ORD-'.get_authenticateUserID().'-'.rand(1000,9999),
			   'order_date'=> date('Y-m-d H:i:s'),
			   'created_by'=>get_authenticateUserID(),
			   'created_on'=>date('Y-m-d H:i:s'),
			   "address1"=>$this->input->post('address1'),
							"address2"=>$this->input->post('address2'),
							"country"=>$this->input->post('country'),
							"state"=>$this->input->post('state'),
							"city"=>$this->input->post('city'),
							"zipcode"=>$this->input->post('zipcode'),
			   'status' => 'Pending',
			   'total'=> $this->cart->total(),
			   'qty' =>$qty,	               
		   );
		
           $this->db->insert('order_master',$data);
           $order_id =  mysql_insert_id();
		   
		   foreach($this->cart->contents() as $cart){
			   $data = array(
			       'order_id'=>$order_id,
				   'product_id'=>$cart['id'],
				   'quantity' =>$cart['qty'],  
				   'price'=> $cart['price'], 
				   'bar_id'=> $cart['options']['bar_id'],
				   'color_id'=> $cart['options']['color_id'],
				   'size_id'=> $cart['options']['size_id'], 
				   'total'=>$cart['subtotal'],                
			   );
	           $this->db->insert('order_detail',$data);
			   $one_product=$this->shopping_model->getOneProduct($cart['id']);
			   
			   $update = array('quantity'=>$one_product['quantity']-$cart['qty']);
			   $this->db->where('store_id',$cart['id']);
			   $this->db->update('store',$update);
		   }
			   
			   $data_trans=array(
							"txn_id"=>$res['PROFILEID'],
							"order_id"=>$order_id,
							"user_id"=>get_authenticateUserID(),
							"price"=>$cart['price'],
							"transaction_status"=>'success',
							
							"transaction_ip"=>$_SERVER['REMOTE_ADDR'],
							"transaction_date"=>date("Y-m-d H:i:s")
						);	  
			$this->db->insert("transaction_order",$data_trans);
			
			$get_order_detatis = $this->shopping_model->getOrderDetails($order_id);
			
			  $order_detail= '<table width="65%" border="1"><tr><td width="50%" >Name</td> <td width="10%">Quantity</td> <td width="20%">Price</td width="20%"><td>Total</td></tr>';
		foreach($get_order_detatis as $sct)    
        {
			$order_detail .= '<tr><td><a href="'.base_url().'shopping/details/'.$sct->product_slug.'">'.$sct->product_name.'</a></td><td>'.$sct->qe.'</td><td>'.$site_setting->currency_symbol."".number_format($sct->price,2).'</td><td>'.$site_setting->currency_symbol."".number_format($sct->price*$sct->qe,2).'</td></tr>';
		}
		$order_detail.= '</table>';	
			
			    $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order successfully completed'");
				$email_temp=$email_template->row();				
			
				
				$email_address_from=$email_temp->from_address;
				$email_address_reply=$email_temp->reply_address;
				
				$email_subject=$email_temp->subject;				
				$email_message=$email_temp->message;
				

				$user_name = $getuser->first_name." ".$getuser->last_name;
				$email_to =$getuser->email;
				
			
				$email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{username}',$user_name,$email_message);
				$email_message=str_replace('{amount}',$site_setting->currency_symbol."".number_format($this->cart->total(),2),$email_message);
				$email_message=str_replace('{order_detail}',$order_detail,$email_message);
				$email_message=str_replace('{site_name}',$site_setting->site_name,$email_message);
				
				$str=$email_message;
	
				
				/** custom_helper email function **/
				//echo $str; die; 
				if($email_temp->status=='active'){					
				email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			/*End mail send*/	
			
			/*Mail Send*/
				// $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='administrator conformation email'");
				// $email_temp=$email_template->row();				
// 			
// 				
				// $email_address_from=$user_data->email; //$email_temp->from_address;
				// $email_address_reply=$user_data->email; //$email_temp->reply_address;
// 				
				// $email_subject=$email_temp->subject;				
				// $email_message=$email_temp->message;
// 				
// 				
// 				
				// $user_name = $user_data->first_name." ".$user_data->last_name;
				// $email_to = $email_temp->from_address; //$user_data->email;
// 				
				// $email_message=str_replace('{break}','<br/>',$email_message);
				// $email_message=str_replace('{username}',$user_name,$email_message);
				// $email_message=str_replace('{amount}',$_POST["mc_gross"],$email_message);
				// $email_message=str_replace('{payer_email}',$_POST["payer_email"],$email_message);
				// $email_message=str_replace('{order_detail}',$order_detail,$email_message);
				// $email_message=str_replace('{site_name}',$site_setting->site_name,$email_message);
// 				
				// $str=$email_message;
// 	
				// /** custom_helper email function **/
				// //echo $str; die; 					
				// email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			   $data["msg"] = 'success';
			   $data["error"] ='';
			   $this->cart->destroy();
			}
			else {
				$data["error"] = "Please Enter proper credit card details.";
			}	
			
		}

        if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view('content_center',$theme .'/shopping/cart',$data,TRUE);
		$this->template->write_view('footer',$theme .'/common/footer',$data,TRUE);

		$this->template->render();
	}

	function update_cart(){

		$item =$_POST['rowid'];
		$type =$_POST['type'];
		$qty =$_POST['qty'];
		$bar_id = $_POST['bar_id'];
		$color_id = $_POST['color_id'];
		$size_id = $_POST['size_id'];
		$id =$_POST['id'];
		$id1 =$_POST['id1'];
		$one_product=$this->shopping_model->getOneProduct($id);
		
		if($one_product['quantity'] <= $qty && $type=='Add')
		{
			echo 0;
		}
		else {
		if($type == 'Add'){
			
			$qty++;
			$data = array(
               'rowid' => $item,
               'qty'  => $qty
        	);
		} else {
			$qty--;
			$data = array(
               'rowid' => $item,
               'qty'  => $qty
        	);
		}
		$this->cart->update($data);	
		
		if(array_key_exists('id', $_POST)){
			$id =$_POST['id'];
			$one_product=$this->shopping_model->getOneProduct($id);
			 $col = explode(',', $one_product['color']);
			 	$size = explode(',', $one_product['size']);
		//$colorlist = getColor($col);
		//$sizelist = getSize($size);
			$site_setting = site_setting();
			$str='';
			$price = $one_product['price'] * $qty;
			
			$add_str = "'".$id."','".$item."','".$one_product['price']."','Add','".$bar_id."','".$color_id."','".$size_id."','".$id1."'";
			$minus_str = "'".$id."','".$item."','".$one_product['price']."','Minus','".$bar_id."','".$color_id."','".$size_id."','".$id1."'";
			
			
			$up_col =  "'".$id."','".$item."','".$one_product['price']."','Minus','".$bar_id."',this.value,'".$size_id."','".$id1."'";
			$up_size =  "'".$id."','".$item."','".$one_product['price']."','Minus','".$bar_id."','".$color_id."',this.value,'".$id1."'";
		     $sel123 ='';
			//$sel ='';
			$sel = '<select data-placeholder="Select Color" onchange="update_color('.$up_col.');" class="m_wrap select_box wid360"  id="color" name="color">';
		if($col!=''){
			foreach ($col as $s) {
				$selected1 = '';
				if($s==$color_id)
				{
					$selected1 = 'selected';
				}
				$sel .='<option '.$selected1.'  value="'.$s.'">'.ucwords($s).'</option>';
				}
		}
		$sel .= '</select>';
		$sel1='';
			$sel1 .= '<select data-placeholder="Select Size" onchange="update_color('.$up_size.');" class="m_wrap select_box wid360"  id="color" name="color">';
		if($size!=''){
			foreach ($size as $sz) {
				$selected = '';
				if($sz==$size_id)
				{
					$selected = 'selected';
				}
				$sel1.='<option '.$selected.' value="'.$sz.'">'.ucwords($sz).'</option>';
			}
		}
 		$sel1 .= '</select>';
			
			$str .='<td><a href='.site_url('shopping/details/'.$one_product['product_slug']).'>'.get_product_name($id).'</a></td>
					<td>'.getBarName($bar_id).'</td>
					<td>'.$site_setting->currency_symbol.' '.number_format($one_product['price'],2).'</td>
			  		<td>
		  				<input type="hidden" name="total_qty_'.$id1.'" id="total_qty_'.$id1.'" value="'.$qty.'" >
		  				<a href="javascript://" class="margin-right-10 keep_title plusbtn" onclick="update_cart('.$add_str.');"> + </a>
		  				<div class="table_quantity margin-top-15 margin-right-10 plus-minustext" id="qty_'.$id1.'">'.$qty.'</div>
		  				<a href="javascript://" class="blog_title plusbtn" onclick="update_cart('.$minus_str.');"> - </a>
		  				</td>

			  		<td class="last">'.$site_setting->currency_symbol.' <span id="price_'.$id1.'" >'.number_format($price,2).'</span></td>
			  		<td>
		  				<a href="javascript://"  onclick="removecart('.$add_str.');"><i class="glyphicon glyphicon-trash"></i></a>
		  				</td>';
			echo $str; //TRUE;
			
			
		} else {
			echo $qty;
		}
		}
		
	}

function update_cart_size(){

		$item =$_POST['rowid'];
		$color_id = $_POST['color_id'];
		
		
			$data = array(
               'rowid' => $item,
               'qty'  => 0,
        	);
		$this->cart->update($data);	
		$item =$_POST['rowid'];
		$type =$_POST['type'];
		$qty =$_POST['qty'];
		$bar_id = $_POST['bar_id'];
		$size_id = $_POST['size_id'];
		$one_product=$this->shopping_model->getOneProduct($_REQUEST['id']);
		
		$data=array(
						'id'=>$_REQUEST['id'],
						'qty'=>$qty,
						'price'=>$one_product['price'],
						'name'=>$one_product['product_name'],
						'options' => array('bar_id' => $_REQUEST['bar_id'],'color_id'=>$color_id,'size_id'=>$size_id),
						'product_id'=> $_REQUEST['id']
				);
		$this->cart->insert($data);
		
		
		//echo json_encode(array('count'=>count($this->cart->contents())));
		
		
	}

function update_cart_color(){

		$item =$_POST['rowid'];
		$color_id = $_POST['color_id'];
		
		
			$data = array(
               'rowid' => $item,
               'qty'  => 0,
        	);
		$this->cart->update($data);	
		$item =$_POST['rowid'];
		$type =$_POST['type'];
		$qty =$_POST['qty'];
		$bar_id = $_POST['bar_id'];
		$size_id = $_POST['size_id'];
		$one_product=$this->shopping_model->getOneProduct($_REQUEST['id']);
		
		$data=array(
						'id'=>$_REQUEST['id'],
						'qty'=>$qty,
						'price'=>$one_product['price'],
						'name'=>$one_product['product_name'],
						'options' => array('bar_id' => $_REQUEST['bar_id'],'color_id'=>$color_id,'size_id'=>$size_id),
						'product_id'=> $_REQUEST['id']
				);
			$this->cart->insert($data);
		
		
		echo json_encode(array('count'=>count($this->cart->contents())));
		
			//print_r($this->cart->contents());
		
	}
	
	function remove_cart() {
		
	        $data = array(
	            'rowid'   => $this->input->post('rowid'),
	            'qty'     => 0
	        );
	        $this->cart->update($data);
			
		echo json_encode(array("status"=>"success","total"=>$this->cart->total()));
		//$this->session->set_flashdata('msg', 'remove_cart');			
	    //redirect('shopping');
	}

	// function pay(){
// 		
		 // $getuser = get_user_info(get_authenticateUserID());
		 // print_r($getuser)
		 // if($this->cart->total() == 0)
		   // {
		   	// redirect('home');
		   // }
// 
		 // if($this->cart->contents()){
           // if($this->cart->total() <= 0)
		   // {
		   	// redirect('home');
		   // }
// 		   
// 		   
		   // $card = new CreditCard();
			// $type = strtolower($this->input->post('cc_type'));
			// $number = strtolower($this->input->post('card_number'));
			// $month = strtolower($this->input->post('ex_month'));
			// $year = strtolower($this->input->post('ex_year'));
			// $cvv_number = strtolower($this->input->post('cvv'));
// 			
// 			
			// $card->setType($type)
			// ->setNumber($number)
			// ->setExpireMonth($month)
			// ->setExpireYear($year)
			// ->setCvv2($cvv_number)
			// ->setFirstName($this->input->post('first_name'))
			// ->setLastName($this->input->post('last_name'));
// 			
// 			
		// try {
// 		
		// //print_r($GLOBALS['apiContext']);
		// $card_data = $card->create($GLOBALS['apiContext']);
// 		
// 		
	 	// $card = $card_data;
		// $creditCardToken = new CreditCardToken();
		// $creditCardToken->setCreditCardId($card->getId());
		// $fi = new FundingInstrument();
		// $fi->setCreditCardToken($creditCardToken);
// 		
		// $payer = new Payer();
		// $payer->setPaymentMethod("credit_card")
			// ->setFundingInstruments(array($fi));
// 		
//          
		// $amount = new Amount();
		// $amount->setCurrency("USD")
			// ->setTotal($this->input->post('amount'));
// 			
		 // // $amount->setCurrency("USD")
		// // ->setTotal('0.01');
			// //->setDetails($details);
// 		
		// $transaction = new Transaction();
		// $transaction->setAmount($amount)
			    	// ->setDescription("Payment description");
					// //->setItemList($itemList)
// 			
		// $payment = new Payment();
		// $payment->setIntent("sale")
			// ->setPayer($payer)
			// ->setTransactions(array($transaction));
// 
// 			
// 
			// try {
				// //print_r($payment->create($GLOBALS['apiContext']));
				// //echo "try";
			// //die;
			// $res = $payment->create($GLOBALS['apiContext']);
// 			
			// // print_r($res);
			// // die;
			// /*
			 // *	transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
			 // */
		// } catch (Exception $ex) {
			// //var_dump($ex->getData());	
			// //exit(1);
			// //echo "catch";
			// //die;
			// $data["error"] = "Please Enter proper credit card details.";
			// //var_dump($ex->getData());	
			// //exit(1);
		// }
// 		
			// } catch (Exception $ex) {
			// $data["error"] = "Please Enter proper credit card details.";
				// //var_dump($ex->getData());
				// //exit(1);
			// }
		// //	echo "<pre>";
		// //	print_r($res);
	    // //	echo $card->getId(); 
		// //	die;
// 		
		// //echo "getout";
		// //	die;
		// // echo "<pre>";
		// // print_r($res);
// 		
		// //mail_to('php.viral@spaculus.info','paypal response',$res);
		// $msg_new = 'state => '.$res->state.'  ' ;
		// $msg_new .= 'id => '.$res->id.'  ' ;
		// email_send('php.viral@spaculus.info','php.viral@spaculus.info','php.viral@spaculus.info','paypal',$msg_new);
		// //die;
// 		
// 		
		// if($res=="")
		    // {
		    	// $data["error"]='<p>Payment Fail Please Enter Proper Credit Card Information.</p>';
				// //echo 'in';die;
			// }
		 // elseif($res->state!="approved" )
// 		 
		 // {
		 	// $data["error"]='<p>Payment Fail</p>';
		 // }else{
		   // $qty = 1;
// 		   
		   // $data = array(
		       // 'user_id'=>get_authenticateUserID(),
			   // 'order_number'=>'ORD-'.get_authenticateUserID().'-'.rand(1000,9999),
			   // 'order_date'=> date('Y-m-d H:i:s'),
			   // 'created_by'=>get_authenticateUserID(),
			   // 'created_on'=>date('Y-m-d H:i:s'),
			   // 'status' => 'Pending',
			   // 'total'=> $this->cart->total(),
			   // 'qty' =>$qty,	               
		   // );
// 		
           // $this->db->insert('order_master',$data);
           // $order_id =  mysql_insert_id();
// 		   
		   // foreach($this->cart->contents() as $cart){
			   // $data = array(
			       // 'order_id'=>$order_id,
				   // 'product_id'=>$cart['id'],
				   // 'quantity' =>$cart['qty'],  
				   // 'price'=> $cart['price'], 
				   // 'total'=>$cart['subtotal'],                
			   // );
	           // $this->db->insert('order_detail',$data);
		   // }
		// }
	// }

	function review(){

		$this->session->set_flashdata('url', base64_encode(current_url()));	
		!check_user_authentication()?redirect("home/login"):'';
		$this->cart->destroy(); 
		
		$data=array();
		
		if($_POST){
			$data=array(
				'user_id'=>get_authenticateUserID(),
				'order_id'=>$this->input->post('order_id'),
				'review'=>$this->input->post('review'),
				'review_rating'=>$this->input->post('rating'),
				'add_date'=>date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('review',$data);
			redirect('user/profile');	
		}
		
		$theme = getThemeName();
		$meta_setting=meta_setting();
		$pageTitle       = $meta_setting->title.''.' :: Review';
	  	$metaDescription ='Ewine';
		$metaKeyword='Ewine';
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('content_center',$theme .'/layout/shopping/review',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);

		$this->template->render();
	}
	
	function product_review(){
		if(!check_user_authentication()){
			$url = 'shopping/product_detail/'.$_POST['id'];
			
			$this->session->set_flashdata('url', '');
			$this->session->set_flashdata('url', base64_encode($url));
			//echo $this->session->flashdata('url');
		
			redirect('home/login');
		}
         
		if($_POST){
			$data=array(
				'user_id'=>get_authenticateUserID(),
				'product_id'=>$_POST['id'],
				'review'=>$_POST['review'],
				'review_rating'=>$_POST['rating'],
				'rating_enjoy'=>$_POST['rating_enjoy'],
				'rating_money'=>$_POST['rating_money'],
				
				'add_date'=>date('Y-m-d H:i:s'),
			);
			$this->db->insert('review',$data);
			$this->session->set_flashdata('msg', 'success');
			redirect('shopping/product_detail/'.$_POST['id']);	
		}
	}

	function history($type,$limit=10,$offset=0){
		
		$this->session->set_flashdata('url', base64_encode(current_url()));	
		!check_user_authentication()?redirect("home/login"):'';
		
		if($type == 'order' || $type == 'review' || $type == 'transaction'  || $type == 'favorite' ){

			$this->load->library('pagination');
			$config['uri_segment']='5';
			$config['base_url'] = base_url().'shopping/history/'.$type.'/'.$limit.'/';
			
			if($type == 'order'){
				$this->db->where('user_id',get_authenticateUserID());
				//$config['total_rows'] = $this->db->count_all('order_master');
				$query = $this->db->get_where('order_master', array('user_id'=>get_authenticateUserID()));
				$config['total_rows'] = $query->num_rows(); 
				$data['orders'] = $this->shopping_model->getOrderHistory($limit,$offset);
			} elseif($type == 'review'){
				$this->db->where('user_id',get_authenticateUserID());
				//$config['total_rows'] = $this->db->count_all('review');
				$query = $this->db->get_where('review', array('user_id'=>get_authenticateUserID()));
				$config['total_rows'] = $query->num_rows(); 
				$data['reviews'] = $this->shopping_model->getReviewHistory($limit,$offset);
			} elseif($type == 'transaction'){
				$this->db->where('user_id',get_authenticateUserID());
				//$config['total_rows'] = $this->db->count_all('transaction');
				$query = $this->db->get_where('transaction', array('user_id'=>get_authenticateUserID()));
				$config['total_rows'] = $query->num_rows();  
				$data['transactions'] = $this->shopping_model->getTransactionHistory($limit,$offset);
			} 
			elseif($type == 'favorite'){
				$this->db->where('user_id',get_authenticateUserID());
				//$config['total_rows'] = $this->db->count_all('favorite');
				$query = $this->db->get_where('favorite', array('user_id'=>get_authenticateUserID()));
				$config['total_rows'] = $query->num_rows();  
				$data['favorites'] = $this->shopping_model->getFavoriteHistory($limit,$offset);
				
				//echo '<pre>'; print_r();
			} 
            else {
                redirect('home');
            }
			
			$config['per_page'] = $limit;			
			$this->pagination->initialize($config);		
			$data['page_link'] = $this->pagination->create_links();
			$data['type'] = $type;
			$data['limit'] = $limit;
			$data['offset'] = $offset;
			
			$data['site_setting'] = site_setting();
			$theme = getThemeName();
			$meta_setting=meta_setting();
			$pageTitle       = $meta_setting->title.''.' :: '.ucfirst($type).' History';
		  	$metaDescription ='Ewine';
			$metaKeyword='Ewine';
			$this->template->write('pageTitle',$pageTitle,TRUE);
			$this->template->write('metaDescription',$metaDescription,TRUE);
			$this->template->write('metaKeyword',$metaKeyword,TRUE);
	
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('content_center',$theme .'/layout/shopping/history',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
	
			$this->template->render();
		} else {
			redirect('home');
		}
	}
	function details($slug=0){
		if($slug=="" || $slug=="0")
		{
			redirect('shopping/product');
		}
		
		$store_id = getProductID($slug);
		
		$data['site_setting'] = site_setting();
		$data['product'] = $this->shopping_model->getOneProduct($store_id);
		$data["product_gallery"] = $this->shopping_model->getGalleryImages($store_id);
		
		$theme = getThemeName();
		$meta_setting=meta_setting();
		// $pageTitle       = $meta_setting->title.''.' :: Order Detail';
	  	// $metaDescription ='American Dive Bars';
		// $metaKeyword='American Dive Bars';
		
		$pageTitle= $data["product"]['store_meta_title'];
		$metaDescription= $data["product"]['store_meta_description'];
		$metaKeyword=$data["product"]['store_meta_keyword'];
		
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->template->write_view('header',$theme .'/common/header',$data,TRUE);
		$this->template->write_view('content_center',$theme .'/shopping/details',$data,TRUE);
		$this->template->write_view('footer',$theme .'/common/footer',$data,TRUE);

		$this->template->render();
	}
	
	function productdetails($slug=0,$bar_id=''){
		if($slug=="" || $slug=="0")
		{
			redirect('shopping/product');
		}
		
		$store_id = getProductID($slug);
		
		$data['site_setting'] = site_setting();
		$data['product'] = $this->shopping_model->getOneProduct($store_id);
		$data["product_gallery"] = $this->shopping_model->getGalleryImages($store_id);
		$data["bar_id"] = $bar_id;
		$data["bar_detail"] = getBarInfoByID($bar_id);
		if($data["bar_detail"]=='')
		{
			redirect('shopping/product');
		}
		$theme = getThemeName();
		$meta_setting=meta_setting();
		$pageTitle       = $meta_setting->title.''.' :: Order Detail';
	  	$metaDescription ='American Dive Bars';
		$metaKeyword='American Dive Bars';
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->template->write_view('header',$theme .'/common/header',$data,TRUE);
		$this->template->write_view('content_center',$theme .'/shopping/productdetails',$data,TRUE);
		$this->template->write_view('footer',$theme .'/common/footer',$data,TRUE);

		$this->template->render();
	}
	function order_delete($id=0,$limit=20,$offset=0){
		
		$this->db->delete('order_detail',array('order_id'=>$id));
		$this->db->delete('transaction',array('order_id'=>$id));
		$this->db->delete('review',array('order_id'=>$id));
		$this->db->delete('order_master',array('order_id'=>$id));
		
		$this->session->set_flashdata('msg', 'delete');
		redirect('shopping/history/order/'.$limit.'/'.$offset);
		
	}
	
	function addToFavorite(){

		
		$id = $_POST['id'];
		$user_id = get_authenticateUserID();
		if($user_id > 0){
			if(!checkFavoriteProduct($id)){
				$data=array(
					"user_id"=>$user_id,
					"product_id"=>$id,
					"is_deleted"=>0,	
				);	  
				$this->db->insert("favorite",$data);
				echo json_encode(array('count'=>1));
			} else {
				
				$this->db->delete('favorite',array('product_id'=>$id,'user_id'=>$user_id));
				echo json_encode(array('count'=>2));
			}
		} else {
			if(array_key_exists('url', $_POST)){
				$this->session->set_flashdata('url', $_POST['url']);
			} else { 
				$this->session->set_flashdata('url', base64_encode(site_url('shopping')));
			}
			echo json_encode(array('count'=>3));	
		}
			
	}

	function product_detail($id=''){
	    
		if($id=="")
        {
            redirect('shopping');
        }
        $chk_product = $this->shopping_model->getOneProduct($id);
        if($chk_product == '')
        {
            redirect('shopping');
        }

		$data['id'] = $id;
		
		
		$data['site_setting'] = site_setting();
		$data['product'] = $this->shopping_model->getOneProduct($id);
		
		
		$theme = getThemeName();
		$meta_setting=meta_setting();
		$pageTitle       = $meta_setting->title.''.' :: Product Detail';
	  	$metaDescription ='Ewine';
		$metaKeyword='Ewine';
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->template->write_view('header',$theme .'/layout/common/header_shop',$data,TRUE);
		$this->template->write_view('content_center',$theme .'/layout/shopping/product_detail',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);

		$this->template->render();
	}
	
	function reorder($order_id){

		$orders = $this->shopping_model->getOrderDetail($order_id);
		$cartdata=$this->cart->contents();
		
		if($orders){
			foreach($orders as $order){
				$set=0;
				if($cartdata)
				{
					foreach($cartdata as $cdata)
					{
						if($cdata['id']==$order->product_id)
						{
							$set=1;
							$data=array(
										'rowid'=> $cdata['rowid'],
										'qty'  => $cdata['qty']+1
									   );
							$this->cart->update($data);
						}
					}
				}
	
				if($set==0)
				{
					$data=array(
								'id'=>$order->product_id,
								'qty'=>$order->quantity,
								'price'=>get_product_price($order->product_id),
								'name'=>get_product_name($order->product_id),
								'product_id'=> $order->product_id
							   );
					$this->cart->insert($data);
				}
			}
		}
		
		redirect('shopping/cart');

		
	}

    	public function products($limit='12',$alpha = 'no',$options= '',$offset=0,$msg='') {
		
		//echo "hello"; die;
		// if(!check_user_authentication())
		// { redirect('home'); }	 
		
		$data['msg'] = base64_decode($msg);
		
		if($alpha != "no" && $alpha != "" )
		{
		     $alpha = base64_decode($alpha);
		}
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='beer';
		
		
		if($_POST)
		{			
		    $keyword = $this->input->post("keyword"); 			
			$order = explode("#",$this->input->post("order_by"));
			
			 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "store_id";
				     $sort_type = "DESC";		
				}				
		 		$limit = $this->input->post("limit");		
		}
		else
		{		
				if($options != "")
				{
				
					$get_option = explode("@",base64_decode($options));
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
					$keyword = $get_option[2];					
				}
				else
			    {
					 $sort_by = "store_id";
					 $sort_type = "DESC";	
					 //$type = "0";
					 $keyword = '0';
				}			 
		}
		
		$this->load->library('pagination');
		$options = base64_encode($sort_by."@".$sort_type."@".$keyword);

		$config['uri_segment']='6';
		$config['base_url'] = base_url().'shopping/product/'.$limit.'/'.$alpha."/".$options.'/';
		$config['total_rows'] = $this->shopping_model->get_total_product_count($keyword,$alpha);
		
		$data["total_rows"] = $config['total_rows'];
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->shopping_model->get_product_result($offset,$limit,$sort_by,$sort_type,$keyword,$alpha);
	
		$data['msg'] = $msg;
		$data["task_type"] = '';
		
		$data["options"] = $options;
		$data['offset'] = $offset;
		$data['error']='';
		if($this->input->post('limit') != '')
		{
			$data['limit']=$this->input->post('limit');
		}
		else
		{
			$data['limit']=$limit;
		}
		if($keyword == "0"){$keyword = '';}
	    $data['keyword'] = $keyword;
		
		$data['redirect_page']='product';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="product";
	    $data["order_by"] = $sort_by."#".$sort_type;
		$data["alpha"] = $alpha;
		
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/shopping/lists', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

}