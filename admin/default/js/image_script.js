$(document).ready(function() {
    $(function() {
        $("#bar_banner_file").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_article").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_article;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_trivia").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_trivia;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#photo_image").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_bar").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_bar;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_resource").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_resource;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_taxi").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_taxi;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_beer").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_beer;
                reader.readAsDataURL(this.files[0]);
            }
        });
         $("#find_liquor").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_liquor;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        $("#find_cocktail").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_cocktail;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        $("#find_suggest_bar").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_suggest_bar;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
          $("#find_contact_us").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_contact_us;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
         $("#find_gallery").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_gallery;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        $("#find_media").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_media;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        $("#find_forum").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded_forum;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoaded(e) {
        $('#message').css("display", "none");
        $('#preview').css("display", "block");
        $('#previewimg').attr('src', e.target.result);
    };
    
    function imageIsLoaded_liquor(e) {
        $('#message').css("display", "none");
        $('#preview_liquor').css("display", "block");
        $('#previewimg_liquor').attr('src', e.target.result);
    };
       function imageIsLoaded_trivia(e) {
        $('#message').css("display", "none");
        $('#preview_trivia').css("display", "block");
        $('#previewimg_trivia').attr('src', e.target.result);
    };
    
      function imageIsLoaded_article(e) {
        $('#message').css("display", "none");
        $('#preview_article').css("display", "block");
        $('#previewimg_article').attr('src', e.target.result);
    };
    
     function imageIsLoaded_resource(e) {
        $('#message').css("display", "none");
        $('#preview_resource').css("display", "block");
        $('#previewimg_resource').attr('src', e.target.result);
    };
    
     function imageIsLoaded_bar(e) {
        $('#message').css("display", "none");
        $('#preview_bar').css("display", "block");
        $('#previewimg_bar').attr('src', e.target.result);
    };
    
    function imageIsLoaded_taxi(e) {
        $('#message').css("display", "none");
        $('#preview_taxi').css("display", "block");
        $('#previewimg_taxi').attr('src', e.target.result);
    };
    
     function imageIsLoaded_beer(e) {
        $('#message').css("display", "none");
        $('#preview_beer').css("display", "block");
        $('#previewimg_beer').attr('src', e.target.result);
    };
    
     function imageIsLoaded_cocktail(e) {
        $('#message').css("display", "none");
        $('#preview_cocktail').css("display", "block");
        $('#previewimg_cocktail').attr('src', e.target.result);
    };
    
     function imageIsLoaded_suggest_bar(e) {
        $('#message').css("display", "none");
        $('#preview_suggest_bar').css("display", "block");
        $('#previewimg_suggest_bar').attr('src', e.target.result);
    };
    
     function imageIsLoaded_contact_us(e) {
        $('#message').css("display", "none");
        $('#preview_contact_us').css("display", "block");
        $('#previewimg_contact_us').attr('src', e.target.result);
    };
    
     function imageIsLoaded_gallery(e) {
        $('#message').css("display", "none");
        $('#preview_gallery').css("display", "block");
        $('#previewimg_gallery').attr('src', e.target.result);
    };
    
     function imageIsLoaded_media(e) {
        $('#message').css("display", "none");
        $('#preview_media').css("display", "block");
        $('#previewimg_media').attr('src', e.target.result);
    };
    
     function imageIsLoaded_forum(e) {
        $('#message').css("display", "none");
        $('#preview_forum').css("display", "block");
        $('#previewimg_forum').attr('src', e.target.result);
    };


    $("#deleteimg").click(function() {
        $('#preview').css("display", "none");
        $('#file').val("");
    });

//Function for displaying details of uploaded image.
    $("#submit").click(function() {
        $('#preview').css("display", "none");
        $('#message').css("display", "block");
    });
});
