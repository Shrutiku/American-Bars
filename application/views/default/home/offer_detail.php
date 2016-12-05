   <div class="container">
        <div class="jumbotron">
            <div class="row-fluid">
                <div class="breadcrumb-list">
                        <ul>
                            <li> <a href="<?php echo site_url('home/nosoffer')?>">Nos Offres </a> &gt;</li>
                            <li> <a href="javascript://"> Offre <?php echo $offer_info->package_name;?></a> </li>
                        </ul>
                    </div>
                <div class="tab_title"> <h2> Offre <?php echo $offer_info->package_name;?></h2></div> 
                <div class="offer-block">
                   
                          <div class="media">
                               <p><?php echo $offer_info->package_desc;?></p>
                            </div>
                          <div class="media">
                                <div class="col-md-3">
                                    <h1 class="tex-red"> <?php echo $offer_info->package_price.' '.$site_setting->currency_symbol;?>/an* </h1>
                                </div>
                                <div class="action-btn pull-right"> 
                                    <a href="<?php echo site_url("home/upgrade/".$offer_id); ?>" role="button" class="buton btn-pink">Souscrire à cette offre ! </a>
                                    <p class="text-right viewall_offer"> <a href="<?php echo site_url('home/nosoffer')?>"> Voir toutes les offres </a> </p>
                                 </div>
                                 <div class="clearfix"> </div>
                            </div>
                          
                </div>
                
                
            </div>
       </div> 
     </div> <!-- /container -->