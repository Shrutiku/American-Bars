  <div class="main-container">
   
    <div class="container">
  		<div class="jumbotron">
        	<div class="row-fluid">
            	<div class="tab_title"> <h2> Nos Offres</h2></div> 
               	<div class="offer-block">
                	 <?php 
            			 if($all_offer)
						 {
						 	foreach($all_offer as $offer)
							{
            			 ?>
                	
                    <div class="col-lg-4">
            			 <h2>Offre <?php echo $offer->package_name; ?></h2>
                         <div class="white-box green-brd min_height220">
                      <?php echo $offer->package_desc; ?>
 
 					<h1 class="text-center tex-green"> <?php echo $site_setting->currency_symbol.$offer->package_price ?> </h1>
                      </div>
                      <div class="action-btn text-center"> 
                        <a class="buton btn-pink " role="button" href="<?php echo site_url("signup/".base64_encode($offer->package_id)); ?>">Souscrire</a>
                      </div>
                      
                     
                    </div>
                    
                    <?php }
                      }
                     ?>
                  
                     
                </div>
               	
            </div>
       </div> 
     </div> <!-- /container -->
  </div>