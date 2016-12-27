<?php $theme_url = $urls= base_url().getThemeName(); ?>
  <!-- ************************************************************************ -->
  <style>
      .panel-body p{ font-size: 12px !important;}
  </style>
  <div class="main-container">
    <div class="container">
        <div class="jumbotron">
            <section class="white-box margin-top-20less">
              <div class="tab_title"> <h2> <?php echo FAQ; ?></h2></div>
                <div class="faq-detail">
                    <div class="panel-group" id="accordion">

                      <?php if($all_faq)
                      {
                          foreach($all_faq as $af)
                          {?>
                           <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $af->faq_id;?>">
                                  <?php echo $af->faq_question;?>
                                </a>
                              </h4>
                            </div>
                            <!--For collapse add class "collapse in"-->
                            <div id="collapse_<?php echo $af->faq_id;?>" class="panel-collapse collapse">
                              <div class="panel-body">
                                <p class="normal-txt">  
                                 <?php echo $af->faq_answer;?>
                                </p>
                              </div>
                            </div>
                          </div>        
                         <?php 
                          }
                      }?>  
                      
                    </div>
                  <div class="clearfix"> </div>
                   
                </div>
            </section>
       </div> 
     </div> <!-- /container -->
  </div>

