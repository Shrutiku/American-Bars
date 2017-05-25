<style>
@media (max-width:767px){
.col-sm-4, .col-sm-3, .col-sm-2{ width:100% !important; padding-left: 15px !important;
padding-right: 15px !important; margin-top:5px;}
.btn-primary.search { margin-left: 15px;    margin-top: 5px;}
}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery-sortable.js"></script>
<style>

	body.dragging, body.dragging * {
  cursor: move !important;
}


tbody.example tr td.placeholder {
  position: relative;
  /** More li styles **/
}
tr.example td.placeholder:before {
  position: absolute;
  /** Define arrowhead **/
}
</style>
<script>
	
$(document).ready(function(){


$('.sorted_table').sortable({
  containerSelector: 'table',
  itemPath: '> tbody',
  itemSelector: 'tr',
  placeholder: '<tr class="placeholder"/>',

  onDrop: function (item, container, _super) {
           // var obj = jQuery('.sorted_table tr').map(function(){
           //     return 'trvalue[]=' + jQuery (this).attr("data-id");
           // }).get();
         
          
          var ids = jQuery('.sorted_table tr').map(function() {
            return $(this).attr("data-id");
        }).get();
         console.log(ids);
          
          
           $.ajax({
                url: "<?php echo site_url('bar/reorder');?>",
                type: "post",
                data: {id:ids},
                cache: false,
                dataType: "json",
                success: function () {}
            });
             $("body").removeClass("dragging");
               $("tr").removeClass("dragged");
          //do the ajax call
        }
})
 
// Sortable column heads


	});
</script>
<div class="wrapper row6 padtb10 has-js">
    <div class="container">
        <div class="margin-top-50 bg_brown">
            <?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
                <div class="dashboard_detail">
                    <div class="result_search event"><div class="result_search_text"><i class="strip bar-special"></i> Special Hours</div></div>
                    <div class="dashboard_subblock">
                        <div>
                            <div id="list_show">
                                <div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
                                <form name="add_event" id="product_type" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/bar_special_hours'); ?>" onsubmit="return validate()" autocomplete="off">
                                    <form name="add_event" id="product_type" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/bar_special_hours'); ?>" >
					<?php // print_r($imageGallery);die;
                                            if($getbar_hour!=''){?>
                                                <div class="" id="inner">
                                                <?php $i=0; foreach($getbar_hour as $im){ ?>
                                                    <div id="pi_<?php echo $im->bar_hour_id ?>">	
                                                        <input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="<?php echo $im->bar_hour_id; ?>" />
                                                            <div class="padtb">
        <!--	        				 	<div class="col-sm-3 text-right">
                                                                    <label class="control-label">Days : <span class="aestrick"> * </span></label>
                                                                </div>-->
	        					        				 	
                    <!--                                        <div class="input_box upload_btn">
                                                                    <select required name="days[]" id="days<?php //echo $im->bar_hour_id; ?>" class="select_box">
                                                                        <option value="">-- Select Day-- </option>
                                                                        <option value="Monday" <?php // echo $im->days=="Monday" ? 'selected':'';?>>Monday</option>
                                                                        <option value="Tuesday" <?php // echo $im->days=="Tuesday" ? 'selected':'';?>>Tuesday</option>
                                                                        <option value="Wednesday" <?php // echo $im->days=="Wednesday" ? 'selected':'';?>>Wednesday</option>
                                                                        <option value="Thursday" <?php // echo $im->days=="Thursday" ? 'selected':'';?>>Thursday</option>
                                                                        <option value="Friday" <?php // echo $im->days=="Friday" ? 'selected':'';?>>Friday</option>
                                                                        <option value="Saturday" <?php // echo $im->days=="Saturday" ? 'selected':'';?>>Saturday</option>
                                                                        <option value="Sunday" <?php // echo $im->days=="Sunday" ? 'selected':'';?>>Sunday</option>
                                                                    </select>
                                                                </div>-->
                    <!--                                        <form action="">
                                                                    <input type="checkbox" name="day" value="Monday"> M
                                                                    <input type="checkbox" name="day" value="Tuesday"> Tu
                                                                    <input type="checkbox" name="day" value="Wednesday"> W
                                                                    <input type="checkbox" name ="day" value="Thursday"> Th
                                                                    <input type="checkbox" name="day" value="Friday"> F
                                                                    <input type="checkbox" name="day" value="Saturday"> Sat
                                                                    <input type="checkbox" name="day" value="Sunday"> Sun
                                                                </form>-->
	                       		
                                                                <!-- <div class="input_box upload_user">
                                                                        <img src="" id="img_here" alt="" class="img-responsive"/>
                                                                </div> -->
    <!--                                                        <div class="span3">
                                                                    <?php // if($i==0){ ?>
                                                                    <a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                    <?php // }else{ ?>
                                                                    <a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveAjax('<?php // echo $im->bar_hour_id ?>','<?php // echo $im->rand ?>')"><i class="glyphicon glyphicon-minus"></i></a>
                                                                    <?php // } ?>		
                                                                </div>-->
                                                                <!-- <div class="input_box pull-left">
                                                                    <button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
                                                                </div> -->
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        
<!--                                                            <div class="padtb8">
                                                            <div class="col-sm-3 text-right">
                                                                    <label class="control-label">Select Hours  : <span class="aestrick"> * </span></label>
                                                                </div>
                                                                <div class="col-sm-4" style="width: 23.5%" >
                                                                    <input required type="text" value="<?php echo $im->hour_from; ?>"  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from">
                                                                </div>
                                                                <div class="col-sm-3 text-right"  style="width: 23.5%">	
                                                                    <input required type="text" value="<?php echo $im->hour_to; ?>"  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to">
                                                                </div>	
                                                                <div class="clearfix"></div>
                                                                     <input required type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value=""> 
                                                            </div>-->
                                                            <?php $getval = getBarSpecialHoursByRand($im->rand,'beer'); 
                                                            if(empty($getval)){?>	 	
                                                                <input type="hidden" name="cntprobeer[]" id="cntprobeer" value="0" />
                                                                <div id="contbeer" class="mar_top20bot20">
                                                                    <div id="innerbeer<?php echo $i; ?>" >	
                                                                        <div class="padtb8">
                                                                            <div class="col-sm-1">
                                                                                <label class="control-label" style="font-size: 16px;">Beers:</label>
                                                                            </div>
                                                                            <input type="hidden" name="bid<?php echo $i; ?>[]" id="bid_<?php echo $i; ?>_0" value="" />
                                                                            <div class="col-sm-2" style="padding-left: 15px">	
                                                                                <input type="text" class="form-control tagsbeernew form-pad" id="beerid_<?php echo $i; ?>_0"  name="beerid[]" value="">
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <form action="">
                                                                                    <input type="checkbox" name="day" value="Monday"> M
                                                                                    <input type="checkbox" name="day" value="Tuesday"> Tu
                                                                                    <input type="checkbox" name="day" value="Wednesday"> W
                                                                                    <input type="checkbox" name ="day" value="Thursday"> Th
                                                                                    <input type="checkbox" name="day" value="Friday"> F <br>
                                                                                    <input type="checkbox" name="day" value="Saturday"> Sat
                                                                                    <input type="checkbox" name="day" value="Sunday"> Sun
                                                                                </form>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label class="control-label" style="font-size: 16px;">Time:</label>
                                                                            </div>
                                                                            <div class="col-sm-1" style="width: 13%" >
                                                                                <input required type="text" value="<?php echo $im->hour_from; ?>"  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from">
                                                                            </div>
                                                                            <div class="col-sm-1"  style="width: 13%">	
                                                                                <input required type="text" value="<?php echo $im->hour_to; ?>"  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to">
                                                                            </div>	
                                                                            <div class="col-sm-1" style="width: 5%">
                                                                                <label class="control-label" style="font-size: 16px;">$:</label>
                                                                            </div>
                                                                            <div class="col-sm-1" style="width: 13%">	
                                                                                <input type="text" class="form-control form-pad" id="beerprice" name="beerprice0[]" value="">
                                                                            </div>	
                                                                            <a href="javascript://;" id="" onclick="addrows('<?php echo $i; ?>')" name="add_rowbeer" class="add_rowbeer btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>

                                                                            <div class="clearfix"></div>
                                                                                <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->	 		
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <input type="hidden" name="cntprobeer[]" id="cntprobeer<?php echo $i; ?>" value="<?php echo count($getval); ?>" />
                                                                <div id="contbeer" class="mar_top20bot20">
                                                                    <div id="innerbeer<?php echo $i; ?>" >
                                                                        <?php $j=0; foreach($getval as $beer){?>	
                                                                                <div class="padtb8" id="imgbeer<?php echo $i; ?>_<?php echo $j; ?>">
                                                                                    <div class="col-sm-3 text-right">
                                                                                        <label class="control-label"><?php if($j==0){?>Beers :<?php } ?>  </label>
                                                                                    </div>
                                                                                    <input type="hidden" name="bid<?php echo $i; ?>[]" id="bid_<?php echo $i; ?>_<?php echo $j; ?>" value="<?php echo $beer->sp_beer_id; ?>" />
                                                                                    <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                        <input type="text" class="form-control tagsbeernew form-pad" id="beerid_<?php echo $i; ?>_<?php echo $j; ?>"  name="beerid[]" value="<?php echo getBeernameByID($beer->sp_beer_id); ?>">
                                                                                    </div>	
                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                        <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                    </div>
                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                        <input type="text" class="form-control form-pad" id="beerprice_<?php echo $j; ?>" name="beerprice<?php echo $i; ?>[]" value="<?php echo $beer->sp_beer_price; ?>">
                                                                                    </div>	
                                                                                    <?php if($j==0){ ?>
                                                                                        <a href="javascript://;" id="" onclick="addrows('<?php echo $i; ?>')" name="add_rowbeer" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                    <?php }else{ ?>
                                                                                        <a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removerow('<?php echo $beer->bar_hour_id ?>','beer','<?php echo $j?>','<?php echo $i?>')"><i class="glyphicon glyphicon-minus"></i></a>
                                                                                    <?php } ?>
                                                                                    <div class="clearfix"></div>
                                                                                        <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                </div>
                                                                        <?php $j++; } ?>
                                                                    </div>
                                                                </div> 
	        				 	
                                                            <?php } ?>		
                                                            <?php $getvalcocktail = getBarSpecialHoursByRand($im->rand,'cocktail'); 
                                                                if(empty($getvalcocktail)){?>	 		
                                                                    <input type="hidden" name="cntprococktail[]" id="cntprococktail" value="0" />
                                                                    <div id="contcocktail" class="mar_top20bot20">
                                                                        <div id="innercocktail<?php echo $i; ?>" >
                                                                            <div class="padtb8">
                                                                                <div class="col-sm-3 text-right">
                                                                                    <label class="control-label">Cocktails : </label>
                                                                                </div>
                                                                                <input type="hidden" name="cid<?php echo $i; ?>[]" id="cid_<?php echo $i; ?>_0" value="" />
                                                                                <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                    <input type="text" class="form-control tagscocktailnew form-pad" id="cocktailid_<?php echo $i; ?>_0"  name="cocktailid[]" value="">
                                                                                </div>	
                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                    <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                </div>
                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                    <input type="text" class="form-control form-pad" id="cocktailprice" name="cocktailprice0[]" value="">
                                                                                </div>	
                                                                                <a href="javascript://;" id="" onclick="addrows_cocktail('<?php echo $i; ?>')" name="add_rowcocktail" class="add_rowcocktail btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                <div class="clearfix"></div>
                                                                                    <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } else {?>
                                                                    <input type="hidden" name="cntprococktail[]" id="cntprococktail<?php echo $i; ?>" value="<?php echo count($getvalcocktail); ?>" />
                                                                    <div id="contcocktail" class="mar_top20bot20">
                                                                        <div id="innercocktail<?php echo $i; ?>" >	
                                                                            <?php $c=0; foreach($getvalcocktail as $cocktail ){?>		
                                                                                <div class="padtb8" id="imgcocktail<?php echo $i; ?>_<?php echo $c;?>">
                                                                                    <div class="col-sm-3 text-right">
                                                                                        <label class="control-label"><?php if($c==0){?>Cocktails :<?php } ?> </label>
                                                                                    </div>
                                                                                    <input type="hidden" name="cid<?php echo $i; ?>[]" id="cid_<?php echo $i; ?>_<?php echo $c; ?>" value="<?php echo $cocktail->sp_cocktail_id; ?>" />
                                                                                    <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                        <input type="text" class="form-control tagscocktailnew form-pad" id="cocktailid_<?php echo $i; ?>_<?php echo $c; ?>"  name="cocktailid[]" value="<?php echo getCocktailnameByID($cocktail->sp_cocktail_id); ?>">
                                                                                    </div>
                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                        <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                    </div>
                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                        <input type="text" class="form-control form-pad" id="cocktailprice_<?php echo $c; ?>" name="cocktailprice<?php echo $i; ?>[]" value="<?php echo $cocktail->sp_cocktail_price; ?>">
                                                                                    </div>
                                                                                    <?php if($c==0){ ?>
                                                                                        <a href="javascript://;" id="" onclick="addrows_cocktail('<?php echo $i; ?>')" name="add_rowcocktail" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                    <?php }else{ ?>
                                                                                        <a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removerow('<?php echo $cocktail->bar_hour_id ?>','cocktail','<?php echo $c;?>','<?php echo $i?>')"><i class="glyphicon glyphicon-minus"></i></a>
                                                                                    <?php } ?>
                                                                                    <div class="clearfix"></div>
                                                                                        <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                </div>
                                                                            <?php $c++; } ?>	
                                                                        </div>	
                                                                    </div>
                                                                <?php } ?>		 	
                                                                <?php $getvalliquor = getBarSpecialHoursByRand($im->rand,'liquor'); 
                                                                    if(empty($getvalliquor)){?>				 	
                                                                        <input type="hidden" name="cntproliquor[]" id="cntproliquor" value="0" />
                                                                            <div id="contliquor" class="mar_top20bot20">
                                                                                <div id="innerliquor<?php echo $i; ?>" >
                                                                                    <div class="padtb8">
                                                                                        <div class="col-sm-3 text-right">
                                                                                            <label class="control-label">Liquors : </label>
                                                                                        </div>
                                                                                        <input type="hidden" name="lid<?php echo $i; ?>[]" id="lid_<?php echo $i; ?>_0" value="" />
                                                                                        <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                            <input type="text" class="form-control tagsliquornew form-pad" id="liquorid_<?php echo $i; ?>_0"  name="liquorid[]" value="">
                                                                                        </div>	
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                            <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                        </div>
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                            <input type="text" class="form-control form-pad" id="liquorprice" name="liquorprice0[]" value="">
                                                                                        </div>	
                                                                                        <a href="javascript://;" id="" onclick="addrows_liquor('<?php echo $i; ?>')" name="add_rowliquor" class="add_rowliquor btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                        <div class="clearfix"></div>
                                                                                            <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                    </div>
                                                                                </div>	
                                                                            </div>
                                                                    <?php } else {?>
                                                                        <input type="hidden" name="cntproliquor[]" id="cntproliquor<?php echo $i; ?>" value="<?php echo count($getvalliquor);?>" />
                                                                        <div id="contliquor" class="mar_top20bot20">
                                                                            <div id="innerliquor<?php echo $i; ?>" >	
                                                                                <?php $l=0; foreach($getvalliquor as $liquor ){?>		
                                                                                    <div class="padtb8" id="imgliquor<?php echo $i; ?>_<?php echo $l; ?>">
                                                                                        <div class="col-sm-3 text-right">
                                                                                            <label class="control-label"><?php if($l==0){?>Liquors  :<?php } ?> </label>
                                                                                        </div>
                                                                                        <input type="hidden" name="lid<?php echo $i; ?>[]" id="lid_<?php echo $i; ?>_<?php echo $l; ?>" value="<?php echo $liquor->sp_liquor_id; ?>" />
                                                                                        <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                            <input type="text" class="form-control tagsliquornew form-pad" id="liquorid_<?php echo $i; ?>_<?php echo $l; ?>"  name="liquorid[]" value="<?php echo getLiquornameByID($liquor->sp_liquor_id); ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                            <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                        </div>
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                            <input type="text" class="form-control form-pad" id="liquorprice_<?php echo $l; ?>" name="liquorprice<?php echo $i; ?>[]" value="<?php echo $liquor->sp_liquor_price; ?>">
                                                                                        </div>	
                                                                                        <?php if($l==0){ ?>
                                                                                            <a href="javascript://;" id="" onclick="addrows_liquor('<?php echo $i; ?>')" name="add_rowliquor" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                        <?php }else{ ?>
                                                                                            <a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removerow('<?php echo $liquor->bar_hour_id ?>','liquor','<?php echo $l; ?>','<?php echo $i?>')"><i class="glyphicon glyphicon-minus"></i></a>
                                                                                        <?php } ?>
                                                                                        <div class="clearfix"></div>
                                                                                            <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                    </div>
                                                                                <?php $l++;} ?> 	
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>	 
                                                                    <?php $getvalfood = getBarSpecialHoursByRand($im->rand,'food'); 
                                                                        if(empty($getvalfood)){?>	
                                                                            <input type="hidden" name="cntprofood[]" id="cntprofood" value="<?php echo count($getvalfood); ?>" />
                                                                            <div id="contfood" class="mar_top20bot20">
                                                                                <div id="innerfood<?php echo $i; ?>" >	
                                                                                    <div class="padtb8">
                                                                                        <div class="col-sm-3 text-right">
                                                                                            <label class="control-label">Foods : </label>
                                                                                        </div>
                                                                                        <input type="hidden" name="fid<?php echo $i;?>[]" id="fid_0" value="" />
                                                                                        <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                            <input type="text" class="form-control tagsfood form-pad" id="foodid_<?php echo $i; ?>_0"  name="foodid<?php echo $i; ?>[]" value="">
                                                                                        </div>	
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                            <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                        </div>
                                                                                        <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                            <input type="text" class="form-control form-pad" id="foodprice" name="foodprice<?php echo $i; ?>_0[]" value="">
                                                                                        </div>	
                                                                                        <a href="javascript://;" id="" onclick="addrows_food('<?php echo $i; ?>')" name="add_rowfood" class="add_rowfood btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                        <div class="clearfix"></div>
                                                                                            <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                    </div>
                                                                                </div>	
                                                                            </div>
                                                                        <?php } else {?>
                                                                            <input type="hidden" name="cntprofood[]" id="cntprofood<?php echo $i; ?>" value="0" />
                                                                                <div id="contfood" class="mar_top20bot20">
                                                                                    <div id="innerfood<?php echo $i; ?>" >	
                                                                                        <?php $f=0; foreach($getvalfood as $food ){?>	
                                                                                            <div class="padtb8" id="imgfood<?php echo $i; ?>_<?php echo $f; ?>">
                                                                                                <div class="col-sm-3 text-right">
                                                                                                    <label class="control-label"><?php if($f==0){?>Foods : <?php } ?></label>
                                                                                                </div>
                                                                                                <input type="hidden" name="fid0[]" id="fid_<?php echo $f; ?>" value="" />
                                                                                                <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                                    <input type="text" class="form-control tagsfood form-pad" id="foodid_<?php echo $f; ?>"  name="foodid<?php echo $i; ?>[]" value="<?php echo $food->food_name; ?>">
                                                                                                </div>	
                                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                                    <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                                </div>
                                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                                    <input type="text" class="form-control form-pad" id="foodprice_<?php echo $f; ?>" name="foodprice<?php echo $i; ?>[]" value="<?php echo $food->food_price; ?>">
                                                                                                </div>	
                                                                                                <?php if($f==0){ ?>
                                                                                                    <a href="javascript://;" id="" onclick="addrows_food('<?php echo $i; ?>')" name="add_rowfood" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
												<?php }else{ ?>
                                                                                                    <a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removerow('<?php echo $food->bar_hour_id ?>','food','<?php echo $f; ?>','<?php echo $i?>')"><i class="glyphicon glyphicon-minus"></i></a>
												<?php } ?>
                                                                                                <div class="clearfix"></div>
                                                                                                    <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                            </div>
                                                                                        <?php $f++; } ?>
                                                                                    </div>
                                                                                </div>
                                                                        <?php } ?>
                                                                        <?php $getvalother = getBarSpecialHoursByRand($im->rand,'other'); 
                                                                            if(empty($getvalother)){?>	
                                                                                <input type="hidden" name="cntproother[]" id="cntproother" value="0" />
                                                                                    <div id="contother" class="mar_top20bot20">
                                                                                        <div id="innerother<?php echo $i; ?>" >	
                                                                                            <div class="padtb8">
                                                                                                <div class="col-sm-3 text-right">
                                                                                                    <label class="control-label">Others : </label>
                                                                                                </div>
                                                                                                <input type="hidden" name="oid0[]" id="oid_0" value="" />
                                                                                                <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                                    <input type="text" class="form-control  form-pad" id="otherid_<?php echo $i; ?>_0"  name="otherid<?php echo $i; ?>[]" value="">
                                                                                                </div>	
                                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                                    <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                                </div>
                                                                                                <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                                    <input type="text" class="form-control form-pad" id="otherprice" name="otherprice<?php echo $i; ?>_0[]" value="">
                                                                                                </div>	
                                                                                                <a href="javascript://;" id="" onclick="addrows_other('<?php echo $i; ?>')" name="add_rowother" class="add_rowother btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                                <div class="clearfix"></div>
                                                                                                    <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            <?php } else {?>
                                                                                <input type="hidden" name="cntproother[]" id="cntproother<?php echo $i; ?>" value="<?php echo count($getvalother)?>" />
                                                                                    <div id="contother" class="mar_top20bot20">
                                                                                        <div id="innerother<?php echo $i; ?>" >	
                                                                                            <?php $o=0; foreach($getvalother as $other ){?>	
                                                                                                <div class="padtb8" id="imgother<?php echo $i; ?>_<?php echo $o;?>">
                                                                                                    <div class="col-sm-3 text-right">
                                                                                                        <label class="control-label"><?php if($o==0){?>Others : <?php } ?> </label>
                                                                                                    </div>
                                                                                                    <input type="hidden" name="oid<?php echo $i;?>[]" id="oid_<?php echo $o;?>" value="" />
                                                                                                    <div class="col-sm-3" style="padding-left: 15px;">	
                                                                                                        <input type="text" class="form-control tagsfood form-pad" id="otherid_<?php echo $o;?>"  name="otherid<?php echo $i;?>[]" value="<?php echo $other->other_name;?>">
                                                                                                    </div>	
                                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
                                                                                                        <label class="control-label" style="font-size: 16px;">Price : $ </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
                                                                                                        <input type="text" class="form-control form-pad" id="otherprice_<?php echo $o;?>" name="otherprice<?php echo $i;?>[]" value="<?php echo $other->other_price;?>">
                                                                                                    </div>	
                                                                                                    <?php if($o==0){ ?>
                                                                                                        <a href="javascript://;" id="" onclick="addrows_other('<?php echo $i; ?>')" name="add_rowother" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
                                                                                                    <?php }else{ ?>
                                                                                                        <a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removerow('<?php echo $other->bar_hour_id ?>','other','<?php echo $o;?>','<?php echo $i?>')"><i class="glyphicon glyphicon-minus"></i></a>
                                                                                                    <?php } ?>
                                                                                                    <div class="clearfix"></div>
                                                                                                        <!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
                                                                                                </div>
                                                                                            <?php $o++; }?>
                                                                                        </div>
                                                                                    </div>
                                                                            <?php } ?>	  
                                                                            <div class="line"></div>
                                                        </div>
                                                <?php $i++; } ?>
                                                <input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i-1; ?>" />																
                                                </div>							
                                                <div class="padtb8">
                                                    <div class="col-sm-3"></div>
                                                        <div class="col-sm-7 mart10 text-left">
                                                            <button type="submit" value="Submit" name="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>														
                                            <?php } else {?>
                                                <input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="" />
                                                <div class="text-center pad_t15b20">
                                                    <div id="hide_edit">
                                                    <div id="inner">  	
                                                        <input type="hidden" name="cntpro" id="cntpro" value="0" />
                                                    <div class="padtb">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label">Days : <span class="aestrick"> * </span></label>
                                                    </div>
	        					        				 	
                                                    <div class="input_box upload_btn">
                                                        <select required name="days[]" id="days" class="select_box">
                                                            <option value="">-- Select Day-- </option>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                            <option value="Sunday">Sunday</option>
                                                        </select>							
                                                    </div>
	                       		
	                       		<!-- <div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div> -->
	                       			<a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       		</div>
	                       		
	                       		
	                       		
	                       		<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Select Hours  : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-4" style="width: 23.5%;">
	                       			<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from">
	                       		</div>
	                       		<div class="col-sm-3 text-right" style="width: 23.5%;">	
	                       			<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to">
	                       			
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input required type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value=""> -->
	        				 	</div>
	        				 	
	        				 	<input type="hidden" name="cntprobeer[]" id="cntprobeer" value="0" />
	                       <div id="contbeer" class="mar_top20bot20">
	                       <div id="innerbeer" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Beers : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="bid0[]" id="bid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsbeer form-pad" id="beerid_0"  name="beerid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="beerprice" name="beerprice0[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowbeer" name="add_rowbeer" class="add_rowbeer btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				
	        				 	<input type="hidden" name="cntprococktail[]" id="cntprococktail" value="0" />
	                       <div id="contcocktail" class="mar_top20bot20">
	                       <div id="innercocktail" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Cocktails : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="cid0[]" id="cid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagscocktail form-pad" id="cocktailid_0"  name="cocktailid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="cocktailprice" name="cocktailprice0[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowcocktail" name="add_rowcocktail" class="add_rowcocktail btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	
	        				 	<input type="hidden" name="cntproliquor[]" id="cntproliquor" value="0" />
	                       <div id="contliquor" class="mar_top20bot20">
	                       <div id="innerliquor" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Liquors : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="lid0[]" id="lid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsliquor form-pad" id="liquorid_0"  name="liquorid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="liquorprice" name="liquorprice0[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowliquor" name="add_rowliquor" class="add_rowliquor btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 		<input type="hidden" name="cntprofood[]" id="cntprofood" value="0" />
	                       <div id="contfood" class="mar_top20bot20">
	                       <div id="innerfood" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Foods : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="fid0[]" id="fid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsfood form-pad" id="foodid_0"  name="foodid0[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="foodprice" name="foodprice0[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowfood" name="add_rowfood" class="add_rowfood btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	<input type="hidden" name="cntproother[]" id="cntproother" value="0" />
	                       <div id="contother" class="mar_top20bot20">
	                       <div id="innerother" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Others : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="oid0[]" id="oid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsfood form-pad" id="otherid_0"  name="otherid0[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="otherprice" name="otherprice0[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowother" name="add_rowother" class="add_rowother btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	                       	</div>
	                      </div> 	
	                       	
	                       	
	                       	
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" value="Submit" name="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     		
     		<?php } ?>
     			</form>
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
 
<script>

$(document).ready(function(){	
	
	$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		
   $('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });	
		      
		      
		      	$('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });	
		      
$('#add_row').click(function(){
		var cnt=parseInt($('#cntpro').val())+1;
		
		$('#cntpro').val(cnt);
		
		var html = '';
		
		//html += '<input type="hidden" name="incr" id="incr_'+cnt+'" value="'+cnt+'" />'
		html += '<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="padtb"><div class="col-sm-3 text-right"><label class="control-label">Days  : <span class="aestrick"> * </span></label></div>'  					        				 	
	    html += '<div class="input_box upload_btn">';
	    html += '<select required name="days[]" id="days'+cnt+'" class="select_box"><option value="">-- Select Day-- </option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="span3"><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div><div class="clearfix"></div></div>';
        html += '<div class="padtb8"><div class="col-sm-3 text-right">';
	    html += '<label class="control-label">Select Hours  : <span class="aestrick"> * </span></label></div>';
	    html += '<div class="col-sm-4"  style="width: 23.5%"><input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from'+cnt+'"></div><div class="col-sm-3 text-right"  style="width: 23.5%">';	
	    html += '<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to'+cnt+'"></div><div class="clearfix"></div>';
	    html += '</div>';
	    //html += '</div>';
	    
	    
	    html += '<input type="hidden" name="cntprobeer[]" id="cntprobeer1'+cnt+'" value="0" /><div class="mar_top20bot20" id="contbeer'+cnt+'"><div id="innerbeer'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Beers : </label></div>';
	    html += '<input type="hidden" name="bid'+cnt+'[]" id="bid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsbeer'+cnt+' form-pad" id="beerid_'+cnt+'"  name="beerid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="beerprice'+cnt+'" name="beerprice'+cnt+'[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowbeer'+cnt+'" name="add_rowbeer" class="add_rowbeer btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	      html += '<input type="hidden" name="cntprococktail[]" id="cntprococktail1'+cnt+'" value="0" /><div class="mar_top20bot20" id="contcocktail'+cnt+'"><div id="innercocktail'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Cocktails : </label></div>';
	    html += '<input type="hidden" name="cid'+cnt+'[]" id="cid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagscocktail'+cnt+' form-pad" id="cocktailid_'+cnt+'"  name="cocktailid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="cocktailprice'+cnt+'" name="cocktailprice'+cnt+'[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowcocktail'+cnt+'" name="add_rowcocktail" class="add_rowcocktail btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    
	    html += '<input type="hidden" name="cntproliquor[]" id="cntproliquor1'+cnt+'" value="0" /><div class="mar_top20bot20" id="contliquor'+cnt+'"><div id="innerliquor'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Liquors : </label></div>';
	    html += '<input type="hidden" name="lid'+cnt+'[]" id="lid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsliquor'+cnt+' form-pad" id="liquorid_'+cnt+'"  name="liquorid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="liquorprice'+cnt+'" name="liquorprice'+cnt+'[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowliquor'+cnt+'" name="add_rowliquor" class="add_rowliquor btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    html += '<input type="hidden" name="cntprofood[]" id="cntprofood1'+cnt+'" value="0" /><div class="mar_top20bot20" id="contfood'+cnt+'"><div id="innerfood'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Foods : </label></div>';
	    html += '<input type="hidden" name="fid'+cnt+'[]" id="fid0_'+cnt+'" value="" />' 
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsfood'+cnt+' form-pad" id="foodid_'+cnt+'"  name="foodid'+cnt+'[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="foodprice'+cnt+'" name="foodprice'+cnt+'[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowfood'+cnt+'" name="add_rowfood" class="add_rowfood btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	     html += '<input type="hidden" name="cntproother[]" id="cntproother1'+cnt+'" value="0" /><div class="mar_top20bot20" id="contother'+cnt+'"><div id="innerother'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Others : </label></div>';
	    html += '<input type="hidden" name="oid'+cnt+'[]" id="oid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsother'+cnt+' form-pad" id="otherid_'+cnt+'"  name="otherid'+cnt+'[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="otherprice'+cnt+'" name="otherprice'+cnt+'[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowother'+cnt+'" name="add_rowother" class="add_rowother btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    
	    html += '<div class="line"></div></div></div></div><div class="clear"></div>';
		$('#inner').append(html);
		
		
		$('.tagsbeer'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		
		
		$('.tagscocktail'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		       $('.tagsliquor'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });    
		      
		 
		$('#add_rowbeer'+cnt).click(function(){
	
		var cntbeer=parseInt($('#cntprobeer1'+cnt).val())+1;
		if($('#cntprobeer1'+cnt).val() =='NaN')
		{
		    $('#cntprobeer1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprobeer1'+cnt).val(cntbeer);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgbeer'+cnt+'_'+cntbeer+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="bid'+cnt+'[]" id="bid0_'+cnt+cntbeer+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsbeer'+cnt+cntbeer+'" id="beerid_'+cntbeer+'"  name="beerid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="beerprice_'+cnt+cntbeer+'" name="beerprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivebeer_1('+cnt+','+cntbeer+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerbeer'+cnt).append(html);
		$('.tagsbeer'+cnt+cntbeer).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#bid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgbeer_'+cnt+cntbeer).slideDown();
			
		});
		
		$('#add_rowcocktail'+cnt).click(function(){
	
		var cntcocktail=parseInt($('#cntprococktail1'+cnt).val())+1;
		if($('#cntprococktail1'+cnt).val() =='NaN')
		{
		    $('#cntprococktail1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprococktail1'+cnt).val(cntcocktail);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgcocktail'+cnt+'_'+cntcocktail+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="cid'+cnt+'[]" id="cid0_'+cnt+cntcocktail+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagscocktail'+cnt+cntcocktail+'" id="cocktailid_'+cntcocktail+'"  name="cocktailid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="cocktailprice_'+cnt+cntcocktail+'" name="cocktailprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivecocktail_1('+cnt+','+cntcocktail+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innercocktail'+cnt).append(html);
		$('.tagscocktail'+cnt+cntcocktail).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#cid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgcocktail_'+cnt+cntcocktail).slideDown();
			
		});
		
		
		
		$('#add_rowliquor'+cnt).click(function(){
	
		var cntliquor=parseInt($('#cntproliquor1'+cnt).val())+1;
		if($('#cntproliquor1'+cnt).val() =='NaN')
		{
		    $('#cntproliquor1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproliquor1'+cnt).val(cntliquor);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgliquor'+cnt+'_'+cntliquor+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="lid'+cnt+'[]" id="lid0_'+cnt+cntliquor+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsliquor'+cnt+cntliquor+'" id="liquorid_'+cntliquor+'"  name="liquorid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="liquorprice_'+cnt+cntliquor+'" name="liquorprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveliquor_1('+cnt+','+cntliquor+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerliquor'+cnt).append(html);
		$('.tagsliquor'+cnt+cntliquor).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#lid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgliquor_'+cnt+cntliquor).slideDown();
			
		});
		
			$('#add_rowfood'+cnt).click(function(){
	
		var cntfood=parseInt($('#cntprofood1'+cnt).val())+1;
		if($('#cntprofood1'+cnt).val() =='NaN')
		{
		    $('#cntprofood1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprofood1'+cnt).val(cntfood);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgfood'+cnt+'_'+cntfood+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="fid'+cnt+'[]" id="fid0_'+cnt+cntfood+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsfood'+cnt+cntfood+'" id="foodid_'+cntfood+'"  name="foodid'+cnt+'[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="foodprice_'+cnt+cntfood+'" name="foodprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivefood_1('+cnt+','+cntfood+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerfood'+cnt).append(html);
		$('#imgfood_'+cnt+cntfood).slideDown();
			
		});
		
		$('#add_rowother'+cnt).click(function(){
	
		var cntother=parseInt($('#cntproother1'+cnt).val())+1;
		if($('#cntproother1'+cnt).val() =='NaN')
		{
		    $('#cntproother1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproother1'+cnt).val(cntother);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgother'+cnt+'_'+cntother+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="oid'+cnt+'[]" id="oid0_'+cnt+cntother+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsother'+cnt+cntother+'" id="foodid_'+cntother+'"  name="otherid'+cnt+'[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="otherprice_'+cnt+cntother+'" name="otherprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveother_1('+cnt+','+cntother+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerother'+cnt).append(html);
		$('#imgother_'+cnt+cntfood).slideDown();
			
		});
		
		$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		    
		$('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		        $('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		     
		$('.timepicker-default').timepicker({

            });
		$('#img_'+cnt).slideDown();
			
		});
		
		$('#add_rowbeer').click(function(){
	 
		var cnt=parseInt($('#cntprobeer').val())+1;
		if($('#cntprobeer').val() =='NaN')
		{
		    $('#cntprobeer').val('1');
		    cnt = 1;
		}
		$('#cntprobeer').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgbeer_'+cnt+'" style="display:none;"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="bid0[]" id="bid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsbeer" id="beerid_'+cnt+'"  name="beerid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="beerprice_'+cnt+'" name="beerprice0[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivebeer(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerbeer').append(html);
		$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgbeer_'+cnt).slideDown();
			
		});
		
		
		
		
	
	$('#add_rowcocktail').click(function(){
	
		var cnt=parseInt($('#cntprococktail').val())+1;
		if($('#cntprococktail').val() =='NaN')
		{
		    $('#cntprococktail').val('1');
		    cnt = 1;
		}
		$('#cntprococktail').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgcocktail_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="cid0[]" id="cid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagscocktail" id="cocktailid_'+cnt+'"  name="cocktailid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="cocktailprice_'+cnt+'" name="cocktailprice0[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivecocktail(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innercocktail').append(html);
		$('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgcocktail_'+cnt).slideDown();
			
		});	
		
		$('#add_rowliquor').click(function(){
	
		var cnt=parseInt($('#cntproliquor').val())+1;
		if($('#cntproliquor').val() =='NaN')
		{
		    $('#cntproliquor').val('1');
		    cnt = 1;
		}
		$('#cntproliquor').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgliquor_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="lid0[]" id="lid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsliquor" id="liquorid_'+cnt+'"  name="liquorid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="liquorprice_'+cnt+'" name="liquorprice0[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveliquor(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerliquor').append(html);
		$('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgliquor_'+cnt).slideDown();
			
		});
		
		
		
		
		$('#add_rowfood').click(function(){
	
		var cnt=parseInt($('#cntprofood').val())+1;
		if($('#cntprofood').val() =='NaN')
		{
		    $('#cntprofood').val('1');
		    cnt = 1;
		}
		$('#cntprofood').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgfood_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="fid0[]" id="fid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsfood" id="foodid_'+cnt+'"  name="foodid0[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="foodprice_'+cnt+'" name="foodprice0[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivefood(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerfood').append(html);
		$('#imgfood_'+cnt).slideDown();
			
		});
		
		
		
		$('#add_rowother').click(function(){
	
		var cnt=parseInt($('#cntproother').val())+1;
		if($('#cntproother').val() =='NaN')
		{
		    $('#cntproother').val('1');
		    cnt = 1;
		}
		$('#cntproother').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgother_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="oid0[]" id="oid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsother" id="otherid_'+cnt+'"  name="otherid0[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="otherprice_'+cnt+'" name="otherprice0[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveother(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerother').append(html);
		$('#imgother_'+cnt).slideDown();
			
		});
		
		
	});		
	function removeImageDivebeer(id)
	{
		var cnt=parseInt($('#cntprobeer').val())-1;
		$('#cntprobeer').val(cnt);
		$('#imgbeer_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivebeer_1(id,num)
	{
		var cnt=parseInt($('#cntprobeer'+id).val())-1;
		$('#cntprobeer'+id).val(cnt);
		$('#imgbeer'+id+'_'+num).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivecocktail_1(id,num)
	{
		var cnt=parseInt($('#cntprococktail'+id).val())-1;
		$('#cntprococktail'+id).val(cnt);
		$('#imgcocktail'+id+'_'+num).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDiveliquor_1(id,num)
	{
		var cnt=parseInt($('#cntproliquor'+id).val())-1;
		$('#cntproliquor'+id).val(cnt);
		$('#imgliquor'+id+'_'+num).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivefood_1(id,num)
	{
		var cnt=parseInt($('#cntprofood'+id).val())-1;
		$('#cntprofood'+id).val(cnt);
		$('#imgfood'+id+'_'+num).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDiveother_1(id,num)
	{
		var cnt=parseInt($('#cntproother'+id).val())-1;
		$('#cntproother'+id).val(cnt);
		$('#imgother'+id+'_'+num).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivecocktail(id)
	{
		var cnt=parseInt($('#cntprococktail').val())-1;
		$('#cntprococktail').val(cnt);
		$('#imgcocktail_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDiveliquor(id)
	{
		var cnt=parseInt($('#cntproliquor').val())-1;
		$('#cntproliquor').val(cnt);
		$('#imgliquor_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivefood(id)
	{
		var cnt=parseInt($('#cntprofood').val())-1;
		$('#cntprofood').val(cnt);
		$('#imgfood_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	function removeImageDiveother(id)
	{
		var cnt=parseInt($('#cntproother').val())-1;
		$('#cntproother').val(cnt);
		$('#imgother_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
function removeImageDive(id)
	{
		var cnt=parseInt($('#cntpro').val())-1;
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	function removeImageDiveAjax(id,num)
	{
	     //   alert("removeImageDiveAjax");
	      //  alert(id);
		alertify.confirm("Are you sure you want to delete this bar hours?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removebarhoursall') ?>/'+num,
				success:function(res){
					
				var cnt=parseInt($('#cnt').val())-1;
				$('#cntpro').val(cnt);
				$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your bar hour deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
	
	
	
	function removerow(id,type,num,t)
	{
	     //   alert("removeImageDiveAjax");
	     // alert(num);
		alertify.confirm("Are you sure you want to delete this record ?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removebarhours') ?>/'+id,
				success:function(res){
					//'removeImageDive'+type(num);
					if(type=='beer')
					{
						removeImageDivebeer_1(t,num);
					}
					if(type=='cocktail')
					{
						removeImageDivecocktail_1(t,num);
					}
					if(type=='liquor')
					{
						removeImageDiveliquor_1(t,num);
					}
					if(type=='food')
					{
						removeImageDivefood_1(t,num);
					}
					if(type=='other')
					{
						removeImageDiveother_1(t,num);
					}
				// var cnt=parseInt($('#cnt').val())-1;
				// $('#cntpro').val(cnt);
				// $('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your record deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
	
	
</script>





<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/new-timepicker.css" />
				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/new-bootstrap-timepicker.js"></script>
<script>
function validate(){
		var htm = '';
		var eduInput = document.getElementsByName('days[]');
	
		for (i=0; i<eduInput.length; i++)
			{
			 if (eduInput[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all days field.</p>"
			 	 	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
				}
			}
			
			var eduInput1 = document.getElementsByName('hour_from[]');
	
		for (i=0; i<eduInput1.length; i++)
			{
			 if (eduInput1[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all from hours field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("Please fill all days field.</p>");
			 	// return false;
				}
			}
			
			var eduInput2 = document.getElementsByName('hour_to[]');
	
		for (i=0; i<eduInput2.length; i++)
			{
			 if (eduInput2[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all to hours field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			var eduInput3 = document.getElementsByName('price[]');
	
		for (i=0; i<eduInput3.length; i++)
			{
			 if (eduInput3[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all price field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			var eduInput4 = document.getElementsByName('speciality[]');
	
		for (i=0; i<eduInput4.length; i++)
			{
			 if (eduInput4[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all speciality field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			
			
			
	}
	
	$('.timepicker-default').timepicker({

               // defaultTime : false

            });
		jQuery(document).ready(function() {       
				<?php if($msg=='update'){?>
  		$.growlUI('Your bar happy hours updated successfully .');
    <?php } ?>		
		
		  // FormComponents.init();
		       $('.timepicker-default').timepicker({

               // defaultTime : false

            });
		});
function addrows(cnt){		
		var cntbeer=parseInt($('#cntprobeer'+cnt).val())+1;
		if($('#cntprobeer'+cnt).val() =='NaN')
		{
		    $('#cntprobeer'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprobeer'+cnt).val(cntbeer);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgbeer'+cnt+'_'+cntbeer+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="bid'+cnt+'[]" id="bid0_'+cnt+cntbeer+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsbeer'+cnt+cntbeer+'" id="beerid_'+cntbeer+'"  name="beerid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="beerprice_'+cnt+cntbeer+'" name="beerprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivebeer_1('+cnt+','+cntbeer+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerbeer'+cnt).append(html);
		$('.tagsbeer'+cnt+cntbeer).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#bid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgbeer_'+cnt+cntbeer).slideDown();
			
	}
	
	function addrows_cocktail(cnt){		
		var cntcocktail=parseInt($('#cntprococktail'+cnt).val())+1;
		if($('#cntprococktail'+cnt).val() =='NaN')
		{
		    $('#cntprococktail'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprococktail'+cnt).val(cntcocktail);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgcocktail'+cnt+'_'+cntcocktail+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="cid'+cnt+'[]" id="cid0_'+cnt+cntcocktail+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagscocktail'+cnt+cntcocktail+'" id="cocktailid_'+cntcocktail+'"  name="cocktailid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="cocktailprice_'+cnt+cntcocktail+'" name="cocktailprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivecocktail_1('+cnt+','+cntcocktail+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innercocktail'+cnt).append(html);
		$('.tagscocktail'+cnt+cntcocktail).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#cid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgcocktail_'+cnt+cntcocktail).slideDown();
			
	}
	
	
	function addrows_liquor(cnt){		
		var cntliquor=parseInt($('#cntproliquor'+cnt).val())+1;
		if($('#cntproliquor'+cnt).val() =='NaN')
		{
		    $('#cntproliquor'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproliquor'+cnt).val(cntliquor);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgliquor'+cnt+'_'+cntliquor+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="lid'+cnt+'[]" id="lid0_'+cnt+cntliquor+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsliquor'+cnt+cntliquor+'" id="liquorid_'+cntliquor+'"  name="liquorid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="liquorprice_'+cnt+cntliquor+'" name="liquorprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveliquor_1('+cnt+','+cntliquor+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerliquor'+cnt).append(html);
		$('.tagsliquor'+cnt+cntliquor).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#lid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgliquor_'+cnt+cntliquor).slideDown();
			
	}
	
	
	function addrows_food(cnt){		
		var cntfood=parseInt($('#cntprofood'+cnt).val())+1;
		if($('#cntprofood'+cnt).val() =='NaN')
		{
		    $('#cntprofood'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprofood'+cnt).val(cntfood);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgfood'+cnt+'_'+cntfood+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="fid'+cnt+'[]" id="fid0_'+cnt+cntfood+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsfood'+cnt+cntfood+'" id="foodid_'+cntfood+'"  name="foodid'+cnt+'[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="foodprice_'+cnt+cntfood+'" name="foodprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivefood_1('+cnt+','+cntfood+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerfood'+cnt).append(html);
		$('#imgfood_'+cnt+cntfood).slideDown();
			
	}
	
	function addrows_other(cnt){		
		var cntother=parseInt($('#cntproother'+cnt).val())+1;
		if($('#cntproother'+cnt).val() =='NaN')
		{
		    $('#cntproother'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproother'+cnt).val(cntother);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgother'+cnt+'_'+cntother+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="oid'+cnt+'[]" id="oid0_'+cnt+cntother+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsother'+cnt+cntother+'" id="otherid_'+cntother+'"  name="otherid'+cnt+'[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="otherprice_'+cnt+cntother+'" name="otherprice'+cnt+'[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveother_1('+cnt+','+cntother+')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerother'+cnt).append(html);
		$('#imgother_'+cnt+cntother).slideDown();
			
	}
	
	
	$('.tagsbeernew').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]+'_'+myArray[2]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		      
		      $('.tagscocktailnew').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]+'_'+myArray[2]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		      
		      $('.tagsliquornew').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]+'_'+myArray[2]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
	</script>
	

