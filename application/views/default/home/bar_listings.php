<div class="wrapper row6 padtb10 has-js">
    <div class="container">
        <div class="margin-top-50 bg_brown">
            <?php echo $this->load->view(getThemeName() . '/home/dashboard_menu'); ?>
            <div class="dashboard_detail">
                <div class="result_search event">
                    <div class="result_search_text"><i class="strip update_domain"></i> Bar Listings</div>
                </div>
                <div class="dashboard_subblock">
                    <div>


                        <div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>

                        <?php
                        $attributes = array('id' => 'form', 'name' => 'add_event');
                        echo form_open_multipart('home/bar_listings', $attributes);
                        ?>
                        <input type="hidden" name="event_id" id="event_id" value=""/>

                        <div class="text-center pad_t15b20">
                            <div class="padtb" style="text-align: left">
                                <!-- <h1 class="step_title">You have Selected a Full Mug Bar</h1> -->
                                <?php //print_r($getbardata);?>

                                <p class="bar_add">Bar Name : <?php echo @$getbardata['bar_title']; ?></p>
                                <p class="bar_add">Bar Address : <?php echo @$getbardata['address']; ?></p>
                                <p class="bar_add">Bar City : <?php echo @$getbardata['city']; ?></p>
                                <p class="bar_add">Bar State : <?php echo @$getbardata['state']; ?></p>
                                <p class="bar_add">Bar Zip Code : <?php echo @$getbardata['zipcode']; ?></p>
                                <div class="col-sm-3">
                                    <label class="control-label">Bar Phone Number: <span class="aestrick"> * </span></label>
                                    </div>
                                    <div class="input_box col-sm-7">
                                        <input type="text" class="form-control form-pad" id="phone" name="phone" style="width:150px">
                                    </div>
                                 <div class="clearfix"></div>  
                                </div>

                                <script type="text/javascript">
                                    function addPhone()
                                    {
                                        old = document.getElementById('scan').href;
                                        if (old.indexOf("&phone") != -1) {
                                            old = old.substring(0, old.indexOf("&phone"));
                                        }
                                        document.getElementById('scan').href = old + "&phone=" + document.getElementById('phone').value;
                                    }
                                </script>

                                <a class="btn btn-lg btn-primary" id="scan" onclick="addPhone();" href="https://www.yext.com/pl/powerlistings/populate?url=scan.html&country=US&name=<?php echo @$getbardata['bar_title']; ?>&address=<?php echo @$getbardata['address']; ?>&zip=<?php echo @$getbardata['zip']; ?>" target="_blank">Scan Now!</a>     
                            </div> 

                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    </form>

                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</script>

