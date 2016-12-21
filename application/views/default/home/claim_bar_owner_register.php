
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

<script type="text/javascript">
    $(document).ready(function () {

        $('#bar_category').select2({
            placeholder: "Select Bar Type Categories",
            allowClear: true
        });
//===== Usual validation engine=====//
        $("#step_1").validate({
            rules: {
                // bar_meta_title: {
                // required: true,
                // },
                // bar_meta_keyword: {
                // required: true,
                // },
                // bar_meta_description: {
                // required: true,
                // },					
                errorClass: 'error fl_right'
            }
        });
    });
</script>
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
$getad_banner = getadvertisementBannerSearchBar('bar_owner_register');

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
                    <h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Verify Your Phone Number</h1>
                    
                    <div class="pad20">
<?php
if ($error != "") {
    echo "<div class='error1 text-center'>" . $error . "</div>";
}
if ($msg != "" && $msg != "1V1" && !is_numeric($msg)) {
    echo "<div class='success text-center'>" . $msg . "</div>";
}
?>
                        <form class="form-horizontal" role="form" name="step_1" id="step_1" action="<?php echo site_url("home/claim_bar_owner_register/" . $new_bar_id); ?>" method="post">
                            <div class="padtb" style="text-align: left">
                                    <p class="bar_add">Bar Name : <?php echo @$bar_title; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">Bar Address : <?php echo @$address; ?></p>
                                    <p class="bar_add">City : <?php echo $city; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">State : <?php echo @$state; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">Zip Code : <?php echo @$zip; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">Bar Description : <?php echo @$desc; ?></p>
                                <div class="clearfix"></div>
                                <p class="bar_add col-sm-12"</p>
                                
                                <p class="bar_add yellow_title">We're almost done. We'll send an activation code via SMS to your mobile phone.</p>

                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                    <label class="control-label">Phone Number: <span class="aestrick"> * </span></label>
                                    </div>
                                    <div class="input_box col-sm-3">
                                        <input type="text" class="form-control form-pad" id="phone" name="phone" style="width:150px">
                                    </div>    
                                    <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" />Send</button>
                                    <!-- </div> -->
                                    <div class="clearfix"></div>  
                                </div>
                            </div>
                            <div class="padtb8">
                                <!-- <div class="col-sm-3"></div> -->
                                <!-- <div class="col-sm-7 mart10"> -->

                                <a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home'); ?>"><i class="previous-arrow-icon"></i> Cancel</a>
                                <button class="btn btn-lg btn-primary btn-next next-right"  type="submit" name="submit"  id="submit" />Next <i class="next-arrow-icon"></i></button>
                                <!-- </div> -->
                                <div class="clearfix"></div>
                            </div>

                            <input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id'] ?>" />
                            <input type="hidden" name="user_id" id="user_id" value="" />
                            <input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
                            <input type="hidden" name="new_bar_id" id="new_bar_id" value="<?php echo $new_bar_id; ?>" />

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ************************************************************************ -->


<script>
    $(document).ready(function () {
        $('.tags').autocomplete({

            source: function (request, response) {
                $.ajax({
                    url: '<?php echo site_url('bar/auto_suggest_bar_lab/'); ?>',
                    dataType: "json",
                    data: {
                        em: request.term,
                    },
                    success: function (data) {
                        if (data == '')
                        {
                            $("#first_name1").val('');
                            $("#last_name1").val('');
                            $("#email1").val('');
                            $("#address1").val('');
                            $("#city1").val('');
                            $("#state1").val('');
                            $("#zipcode1").val('');
                            $("#desc").val('');
                            //$("#submit").removeattr('disabled','disabled');
                            $('#submit').prop("disabled", false);
                            if ($("#first_name1").val('') != '')
                            {
                                $("#first_name1").prop("disabled", false);
                            }
                            if ($("#last_name1").val('') != '')
                            {
                                $("#last_name1").prop("disabled", false);
                            }

                            //  $("#email1").prop("disabled", false); 
                            if ($("#address1").val('') != '')
                            {
                                $("#address1").prop("disabled", false);
                            }
                            if ($("#city1").val('') != '')
                            {
                                $("#city1").prop("disabled", false);
                            }
                            if ($("#state1").val('') != '')
                            {
                                $("#state1").prop("disabled", false);
                            }
                            //  $("#desc").prop("disabled", false); 

                            if ($("#zipcode1").val('') != '')
                            {
                                $("#zipcode1").prop("disabled", false);
                            }

                            //$("#submit").attr('enabled','enabled');
                        }
                        response($.map(data, function (item) {
                            return {
                                label: item.label,
                                id: item.id,
                                value: item.value
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                //	alert(ui.item.id);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bar/getbarinfoByID') ?>",
                    data: {id: ui.item.id},
                    dataType: 'JSON',
                    success: function (response) {

                        $("#first_name1").val(response.bar_first_name);
                        $("#last_name1").val(response.bar_last_name);
                        $("#email1").val(response.email);
                        $("#address1").val(response.address);
                        $("#city1").val(response.city);
                        $("#state1").val(response.state);
                        $("#desc").val(response.bar_desc);
                        $("#zipcode1").val(response.zipcode);
                        if (response.bar_first_name != '')
                        {
                            $("#first_name1").attr('disabled', 'disabled');
                        }
                        if (response.bar_last_name != '')
                        {
                            $("#last_name1").attr('disabled', 'disabled');
                        }

                        //  $("#email1").prop("disabled", false); 
                        if (response.address != '')
                        {
                            $("#address1").attr('disabled', 'disabled');
                        }
                        if (response.city != '')
                        {
                            $("#city1").attr('disabled', 'disabled');
                        }
                        if (response.state != '')
                        {
                            $("#state1").attr('disabled', 'disabled');
                        }
                        //  $("#desc").prop("disabled", false); 

                        if (response.zipcode != '')
                        {
                            $("#zipcode1").attr('disabled', 'disabled');
                        }
                        //$("#submit").attr('disabled','disabled');

                    }
                });

                //  $("#to_user_id1").val(ui.item.id);  // ui.item.value contains the id of the selected label
            },
            autoFocus: true,
            minLength: 0
        });


    });
</script>	