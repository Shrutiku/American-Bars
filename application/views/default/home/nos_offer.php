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
            			 <?php if($user_info)
            			 {
            			     if($user_info->offer_id == $offer->package_id)
                             {?>
                                <div class="white-box red-brd min_height220">        
                             <?php }
                             else{?>
                                 <div class="white-box green-brd min_height220">
                             <?php }
            			 }
            			 else
            			 {?>
            			     <div class="white-box green-brd min_height220">
            			 <?php }?>
            			 
            			 
                      <?php echo substr($offer->package_desc,0, 300); ?>
 					<h1 class="text-center tex-green"> <?php echo $site_setting->currency_symbol.$offer->package_price ?> </h1>
                      </div>
                      <div class="action-btn text-center"> 
                      <?php
                      if(get_user_type() != 'doctor')
                      { 
                      ?>
                      <?php if($user_info)
                         {
                             if($user_info->offer_id == $offer->package_id)
                             {?>
                                <!--Because patient subscibe these offer-->
                       <?php }
                             else{?>
                              <!--<a class="buton btn-pink " role="button" href="<?php echo site_url("home/upgrade/".base64_encode($offer->package_id)); ?>">Souscrire</a>-->
                              <a class="buton btn-pink " role="button" href="<?php echo site_url("home/offerdetail/".base64_encode($offer->package_id)); ?>">Souscrire</a>   
                             <?php }
                       }
                       else
                       {?>
                           <a class="buton btn-pink " role="button" href="<?php echo site_url("signup/".base64_encode($offer->package_id)); ?>">Souscrire</a>
                       <?php }?> 
                      <?php }?> 
                      </div>
                      
                     
                    </div>
                    
                    <?php }
                      }
                     ?>
                   <!-- <div class="col-lg-4">
            			 <h2>Offre duo</h2>
                         <div class="white-box green-brd">
                      <p>Aenean convallis neque nec orci venenatis, eleifend dignissim est gravida. Vestibulum euismod, ligula ac eleifend volutpat, odio ligula cursus ! </p>
                      <p>- diam, vitae vehicula neque nulla vel ligula. Vestibulum cursus, risus et tempor mattis, velit orci iaculis magna, 
 in ultrices ipsum lacus et dui. </p>
 <p>- Suspendisse potenti. Maecenas aliquet tincidunt ligula, sed varius neque. Cras ac consequat nulla. </p>
 <p>- Suspendisse egestas eleifend posuere. Donec accumsan augue euismod ipsum lobortis molestie. </p>
 <p>- Quisque vestibulum diam sit amet scelerisque sodales. Phasellus eu lacus id odio posuere dictum.</p>
 
 					<h1 class="text-center tex-green"> 15€/an </h1>
                      </div>
                      <div class="action-btn text-center"> 
                        <a class="buton btn-pink " role="button" href="#">Souscrire</a>
                      </div>
                      
                     
                    </div>
                    
                   <!-- <div class="col-lg-4">
            			 <h2>Offre duo + suivi</h2>
                         <div class="white-box red-brd">
                      <p>Aenean convallis neque nec orci venenatis, eleifend dignissim est gravida. Vestibulum euismod, ligula ac eleifend volutpat, odio ligula cursus ! </p>
                      <p>- diam, vitae vehicula neque nulla vel ligula. Vestibulum cursus, risus et tempor mattis, velit orci iaculis magna, 
 in ultrices ipsum lacus et dui. </p>
 <p>- Suspendisse potenti. Maecenas aliquet tincidunt ligula, sed varius neque. Cras ac consequat nulla. </p>
 <p>- Suspendisse egestas eleifend posuere. Donec accumsan augue euismod ipsum lobortis molestie. </p>
 <p>- Quisque vestibulum diam sit amet scelerisque sodales. Phasellus eu lacus id odio posuere dictum.</p>
 
 					<h1 class="text-center tex-red"> 15€/an </h1>
                      </div>
                      <div class="action-btn text-center"> 
                        <a class="buton btn-pink " role="button" href="#">Souscrire</a>
                      </div>
                      
                     
                    </div>-->
                     
                </div>
               	
            </div>
            <!-- extra content-->
            <div class="actions-control">
              <p class="tex-red"><strong>Prochainement disponible : offre Trio</strong></p>
              <p class="normal-txt">Aenean Convallis neque nec orci venenatis, eleifend dignissim est gravida.Vestibulum euismod, ligula ac eleifend volutpat, odio
ligula cursus !</p>
                <p class="normal-txt">-diam, vitaw vehicula neque nulla vel ligula. Vestibulum cursus, risus et tempor mattis, velit orci iaculis magna.</p>
           </div>
           <!-- end of extra content-->
       </div> 
     </div> <!-- /container -->
  </div>