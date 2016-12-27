<?php
ini_set('max_execution_time', 800);
ini_set("memory_limit","256M");
/*
	This is the PHP code for the How to Create Thumbnail Images using PHP Tutorial

	This script creates all of the thumbnail images and the gallery.html page.

	Note: Make sure that PHP has permission to read and write 
	to the directory in which .jpg files are stored and the directory 
	in which you're trying to create thumbnails.	
	
	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	Copyright 2007 WebCheatSheet.com	
*/


function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
{
	
	
	
	$quality = 100;
	$wmsource = false;
	$tn_w = 1920;
	$tn_h = 450;	
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
  
    if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'gif' || strtolower($info['extension']) == 'PNG' || strtolower($info['extension']) == 'JPG' || strtolower($info['extension']) == 'jpeg' || strtolower($info['extension']) == 'png') 
    {
    	//  echo $info['extension'];
      echo "Creating thumbnail for {$fname} <br />";

      // load image and get image size
      if( $info['extension']=="png" || $info['extension']=="PNG")
	  {
	  	 $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
	  }
	  else if( $info['extension']=="gif")
	  {
	  	 $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
	  }
	  else {
		   $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
	  }
     
       $src_w = imagesx($img);
    $src_h = imagesy($img);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $img, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 0, 0, 0);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
       
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);
			
    }
	//imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
	imagejpeg( $final, "{$pathToThumbs}{$fname}" );
   
    }
  }
  // close the directory
  closedir( $dir );
}

function createGallery( $pathToImages, $pathToThumbs ) 
{
  echo "Creating gallery.html <br />";

  $output = "<html>";
  $output .= "<head><title>Thumbnails</title></head>";
  $output .= "<body>";
  $output .= "<table cellspacing=\"0\" cellpadding=\"2\" width=\"500\">";
  $output .= "<tr>";

  // open the directory
  $dir = opendir( $pathToThumbs );

  $counter = 0;
  // loop through the directory
  while (false !== ($fname = readdir($dir)))
  {
    // strip the . and .. entries out
    if ($fname != '.' && $fname != '..') 
    {
      $output .= "<td valign=\"middle\" align=\"center\"><a href=\"{$pathToImages}{$fname}\">";
      $output .= "<img src=\"{$pathToThumbs}{$fname}\" border=\"0\" />";
      $output .= "</a></td>";

      $counter += 1;
      if ( $counter % 4 == 0 ) { $output .= "</tr><tr>"; }
    }
  }
  // close the directory
  closedir( $dir );

  $output .= "</tr>";
  $output .= "</table>";
  $output .= "</body>";
  $output .= "</html>";

  // open the file
  $fhandle = fopen( "gallery.html", "w" );
  // write the contents of the $output variable to the file
  fwrite( $fhandle, $output ); 
  // close the file
  fclose( $fhandle );
}

// call createThumb function and pass to it as parameters the path 
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width. 
// We are assuming that the path will be a relative path working 
// both in the filesystem, and through the web for links
createThumbs(getcwd()."/upload/blog_orig/",getcwd()."/upload/blog1920by450/",100);
// call createGallery function and pass to it as parameters the path 
// to the directory that contains images and the path to the directory
// in which thumbnails will be placed. We are assuming that 
// the path will be a relative path working 
// both in the filesystem, and through the web for links
//createGallery("images/","thumbs/");
?>r