
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin/default/assets/plugins/select2/select2_metro.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>admin/default/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>admin/default/assets/plugins/select2/select2.min.js"></script>
<style>
    .select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices
    {
        border: 0px;
    }
    .select2-container-multi .select2-choices, .select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices

    {
        background:none !important;
        border: none !important;
    }
</style>

<!-- ########################################################################################### -->
<!-- content -->
<?php
/* $getimagename = getimagenamebanner();?>	
  <?php
  if($getimagename->beer_directory_state==1 && $getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
  <img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
  <?php
  } else {?>
  <!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/> -->
  <?php } */
$v = 0;
$getad_banner = '';
$getad_banner = getadvertisementBannerSearchBar('bar_owner_info');

if ($getad_banner) {
    ?>
    <div class="wrapper row4">
        <div class="container clearfix">
            <div id="slider-fixed-banner" class="carousel slide">
                <div class="carousel-inner">
                    <div class="active item">

                        <?php
                        $count = getadvertisementBannerByIDCount(@$getad_banner['banner_pages_id'], $getad_banner['type']);
                        if ($getad_banner['type'] == 'click') {
                            $cnt = $getad_banner['number_click'];
                        } else {
                            $cnt = $getad_banner['number_visit'];
                        }

                        $getad_new = getadvertisementByID_banner(@$getad_banner['banner_pages_id'], 'visit');

                        if (($getad_new == 0 || $getad_new < 5) && $count < $cnt && $getad_banner['type'] == 'visit' && $getad_banner['type'] != '') {
                            $array = array('ip' => $_SERVER['REMOTE_ADDR'], 'datetime' => date('Y-m-d H:i:s'), 'banner_pages_id' => $getad_banner['banner_pages_id'], 'click_type' => 'visit');
                            $this->db->insert('count_clcik_advertisement_banner', $array);

                            $array1 = array('total_visit' => $getad_banner['total_visit'] + 1);
                            $this->db->where('banner_pages_id', $getad_banner['banner_pages_id']);
                            $this->db->update('banner_pages_master', $array1);
                        }

                        $v = 1;
                        if ($getad_banner && $count < $cnt) {
                            ?>
                            <?php if (($getad_banner['banner_pages_image'] != '' && file_exists(base_path() . 'upload/banner_pages_thumb/' . $getad_banner['banner_pages_image']))) { ?>
                                <a target="_blank" <?php if ($getad_banner['type'] == 'click') { ?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id']; ?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url() . 'upload/banner_pages_thumb/' . $getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
                            <?php } ?>	
                        <?php } else { ?>
                            <img src="<?php echo base_url() . 'upload/banner_pages_thumb/' . $getad_banner['banner_pages_image']; ?>" class="img-responsive"/>

                        <?php } ?>


                        <div class="clearfix"></div>    
                    </div>
                </div>
                <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->

            </div>
        </div>
    </div>
<?php } ?>
<div class="wrapper row5 beer-list" style="border:<?php echo $v == 0 ? 'none' : ''; ?>">
    <div class="container">
        <div class="result_box clearfix mar_top30bot20">
            <div class="login_block br_green_yellow">
                <div class="result_search">
                    <i class="strip login_icon"></i><div class="result_search_text">Registration</div>
                </div>
                <div>
                    <h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Account Information</h1>
                    
                    <div class="pad20">
<?php
if ($error != "") {
    echo "<div class='error1 text-center'>" . $error . "</div>";
}
?>
                        <form class="form-horizontal" role="form" name="info" id="info" action="<?php echo site_url("home/claimbar_owner_info/" . base64_encode($bar_id)); ?>" method="post">
                            <div class="padtb" style="text-align: left">
                                <p class="bar_add">You're verified! We're are almost done!</p>
                                <p class="bar_add">We're about to send you your account information.</p>
                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                <label class="control-label">Email: <span class="aestrick"> * </span></label>
                                </div>
                                <div class="input_box col-sm-3 padding-bottom-15">
                                    <input type="text" class="form-control form-pad" id="email" name="email" style="width:150px">
                                </div> 
                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                <label class="control-label">First Name: <span class="aestrick"> * </span></label>
                                </div>
                                <div class="input_box col-sm-3 padding-bottom-15">
                                    <input type="text" class="form-control form-pad" id="firstname" name="firstname" style="width:150px">
                                </div> 
                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                <label class="control-label">Last Name: <span class="aestrick"> * </span></label>
                                </div>
                                <div class="input_box col-sm-3">
                                    <input type="text" class="form-control form-pad" id="lastname" name="lastname" style="width:150px">
                                </div> 
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="padtb8">    
                                <!-- <div class="col-sm-3"></div> -->
                                <!-- <div class="col-sm-7 mart10"> -->
                                <button class="btn btn-lg btn-primary btn-next pull-right"  type="submit" name="submit"  id="submit" />Send</button>
                                <a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home'); ?>"><i class="previous-arrow-icon"></i> Cancel</a>
                                <!-- </div> -->
                                <div class="clearfix"></div>
                            </div>

                            <input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id'] ?>" />
                            <input type="hidden" name="user_id" id="user_id" value="" />
                            <input type="hidden" name="bar_id" id="bar_id" value="<?php echo @$bar_id; ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ************************************************************************ -->