<input type="hidden" name="offset" id="offset" value="0" />
					<input type="hidden" name="limit" id="limit" value="5" />
					<input type="hidden" name="taxival" id="taxival" value="0" />
<script type="text/javascript">
	var base_url_favorite_taxi = '<?php echo site_url('taxiowner/getmoretaxi/?state='.$bar_detail['state'].'&city='.$bar_detail['city'].'&zipcode='.$bar_detail['zipcode']); ?>';
	 var displayFunction = null;
	  var offset = 0;
  var limit = 5;
	function check(){
   $("#infinite-favorite-taxi").scroll(function () {
      var infiniteList = $('#infinite-favorite-taxi');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_taxi(offset+1, limit);
      }
    });
  }
  
   function loadData_taxi(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_taxi(offset, length)');
    } else {
        getRealData_favorite_taxi(o, l, displayFunction);
    }
  }
  
   function getRealData_favorite_taxi(offset, limit, callback) {
  
    var err = {};
    
    if($('#taxival').val()==0 || offset==0)
    {
    $.ajax({
      'url' : base_url_favorite_taxi,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' :5
      },
      'success' : function (data) {
      		if(data=='No')
      	{
      		$('#infinite-favorite-taxi').append("<li style='text-align:center;' class='mart10'>No Record Founds.</li>");
      		$('#taxival').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-favorite-taxi').append(data);
      	}
        
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
</script>
<script>
	
</script>
	<script type="text/javascript">
		$(function(){
		      $('#infinite-favorite-taxi').slimscroll({
		        alwaysVisible: true,
		        height: 320,
		        color: '#f19d12',
		        opacity: .8
		      });
		     }); 
	</script>	      
	<style>
		#infinite-favorite-taxi {
    height: 320px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
	</style>
<div class="padtb10 taxi-popup">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     			 	<div class="result_search">
     					 <button type="button" onclick="removemapdata()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Nearest Taxi Company</div>
	     				
     				</div>
     				
     				<div class="pad_lr10 margin-top-10">
	                    <ul class="result_sub_box" id="infinite-favorite-taxi">
	                    	
	                    	
	                    	
	                    </ul>   	
	                       	
	                       		
     				</div> 
     			</div>
     		</div>
     	</div>
 </div>    				
