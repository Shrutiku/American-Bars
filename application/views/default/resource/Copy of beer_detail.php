<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>

<script>
	$(document).ready(function() {
		
	var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
    	alert('dsad');
    	
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
     }); 
</script>

<?php
		          		if($beer_detail['beer_image']!="" && file_exists(base_path().'upload/beer_thumb/'.@$beer_detail['beer_image']))
					{?>
		            	<?php $img =  base_url().'/upload/beer_thumb/'.$beer_detail['beer_image']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/beer_thumb/no_image.png'; ?>
		            		<?php } ?>
		            		
		            		
		            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;} */
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<script type="text/javascript">
	
function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('beer/detail/'.$beer_detail['beer_slug']); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
		  $(document).ready(function() {
		  	
		        $('#menu').click(function() {
		    