$(function(){

    var ul = $('#upload ul');

   // $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        //$(this).parent().find('input').click();
       // alert("sdfds");
        //$(this).parent().find('input')[0].click();;
        //var evObj = document.createEvent('MouseEvents');
    //evObj.initMouseEvent('click', true, true, window);
   // a.dispatchEvent(evObj);
    //});

	$('#drop a').click(function(){
    var a = document.getElementById('upload_select');
    // Change here -----------------------^^^
    var evObj = document.createEvent('MouseEvents');
    evObj.initEvent('click', true, true, window);
    a.dispatchEvent(evObj);
});

    // Initialize the jQuery File Upload plugin
    $('#drag_img').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {
			//alert(e);
			//alert(data);
            var tpl = $('<li class="working"><input type="text" value="0" data-width="35" data-height="35"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

           // Append the file name and file size
           //Append .... in image name
           var imagename=data.files[0].name;
           var imgname=""; 
          
          var nameSplit = imagename.split(".");
          nameSplit = nameSplit[0]; 
          	
           if(nameSplit.length > 6)
           {   
           		    
           		imgname = nameSplit.substring(0, 5);
           		imgname = imgname.concat('...');
           }
           else
           {           		     	
           		imgname = nameSplit;
           }          
           //End code of Append .... in image name
           
            tpl.find('p').text(imgname)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob(); 
            
            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){
            	
                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                	
                    tpl.remove();
                    $.ajax({
					/*url:'<?php echo site_url('student/removeDocumentAjax_span') ?>/'+id,
					alert("hello");
					//window.location.reload();
					success:function(res){
						if(res){
						window.location.reload();
						}
					}*/
					});	
                });

            });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
                 
            }
        },

        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
        }

    });


    // Prevent the default action when a file is dropped on the window
    // $(document).on('drop dragover', function (e) {
        // e.preventDefault();
    // });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});