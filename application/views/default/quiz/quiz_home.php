<div class="wrapper row5 quiz">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Trivia</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
     		<?php $getimagename = getimagenamebanner();?>	
     		<?php
     		
     		
     		 $url='';
									if($getimagename->find_trivia_state==1 && $getimagename->trivia!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->trivia)){ 
										
										 $url = base_url().'upload/bar_pages_banner/'.$getimagename->trivia;
									} else {
										$url = '../images/bar-bg.jpg';
										?>
										
									
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
            	<?php }
									
									 ?>
     		<style>
     			.bar-block {
     				
    background: url("<?php echo $url;?>") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
}
     		</style>
     		<div class="bar-block br-yellow mar_top20">
     			<div class="bar-sub">
	     			<div class="text-center">
	     				<a class="btn btn-lg btn-primary" href="<?php echo site_url('trivia/start');?>">Start Trivia</a>
	     			</div>
     			</div>
     		</div>
     		<div class="mar_top20">
	     				<?php $getad = getadvertisementtrivia('trivia','0'); 
	     				if($getad){
	     				$i=1; foreach($getad as $r)
						{
							$m = '';
							$m1 = 'margin-right: 80px';
	     						if($i==1)
								{
									$m = 'margin-left: 20px';
								}
								if($i==3)
								{
									
									$m1 = 'margin-right: 0px';
								}	
	     				$count = getadvertisementByIDCount(@$r->advertisement_id,$r->type);
						if($r->type=='click')
						{
							$cnt = $r->number_click;
						}
						else
						{
							$cnt = $r->number_visit;
						}
						$getad_new = getadvertisementByID(@$r->advertisement_id,'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt && $r->type=='visit')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$r->advertisement_id,'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement',$array);
							
								$array1 = array('total_visit'=>$r->total_visit+1);
							$this->db->where('advertisement_id',$r->advertisement_id);
							$this->db->update('advertisement_master',$array1);
						}
	     				if($count < $cnt){ ?>
	     					<?php if(($r->advertisement_image!='' && file_exists(base_path().'upload/advertisement_thumb/'.$r->advertisement_image))){ ?>
	     					<div class="col-sm-4 col-md-4 text-center mar_bot10">	<a target="_blank" <?php if($r->type=='click'){?>onclick="add_click('<?php echo $r->advertisement_id;?>');"<?php } ?> href="<?php echo $r->url; ?>"><img   src="<?php echo base_url().'upload/advertisement_thumb/'.$r->advertisement_image; ?>" class="img-responsive"/></a></div>
	     					<?php } ?>	
	     					<?php }  else {
	     						
	     						?>
	     						<div class="col-sm-4 col-md-4 text-center mar_bot10">
		     			<!-- <img  src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/> -->
		     			</div>
		     			  <?php } $i++; }
                              if(count($getad)==1)
							  { ?>
							  	<div class="col-sm-4 col-md-4 text-center mar_bot10">
		     			  		 <!-- <img  src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/> -->	
		     			  	 </div>
		     			  	 <div class="col-sm-4 col-md-4 text-center mar_bot10">
							  	 <!-- <img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/> -->
							  </div>	 
							  <?php }
							  else if(count($getad)==2)
							  { ?>
							  	<div class="col-sm-4 col-md-4 text-center mar_bot10">
							  	 <!-- <img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/> -->
							  	 </div>
							  <?php }
                                } else {?>
                             <!-- <div class="col-sm-4 col-md-4 text-center mar_bot10">
		     			  		<img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/>	
		     			  	 </div>
		     			  	 <div class="col-sm-4 col-md-4 text-center mar_bot10">
		     			   		<img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/>
		     			   	 </div>	
		     			   	 <div class="col-sm-4 col-md-4 text-center mar_bot10">
		     			    	<img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/>	
		     			    </div> -->
		     			    <div class="clearfix"></div>
		     			  	<?php } ?>
		     		</div>
    
     	</div>
     	
   	</div>
   	
   	<script>
	function add_click(id)
		{
		 //  window.location.href = '<?php //echo site_url('resource/lists');?>'; 
		   $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('home/add_clcik')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		    
		     
		  }
	   });
	  }
</script>	