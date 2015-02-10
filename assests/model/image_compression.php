<?php

    // -- Class Name : SimpleImage
    // -- Purpose : 
    // -- Created On : 
	class SimpleImage {
        var $image;
        var $image_type;
        

// -- Function Name : load
// -- Params : $filename
// -- Purpose : 
        function load($filename) {
            $image_info = getimagesize($filename);
            $this->image_type = $image_info[2];
            
            if( $this->image_type == IMAGETYPE_JPEG ) {
                $this->image = imagecreatefromjpeg($filename);
            }

            elseif( $this->image_type == IMAGETYPE_GIF ) {
                $this->image = imagecreatefromgif($filename);
            }

            elseif( $this->image_type == IMAGETYPE_PNG ) {
                $this->image = imagecreatefrompng($filename);
            }

        }

        

// -- Function Name : save
// -- Params : $filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null
// -- Purpose : 
        function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
            
            if( $image_type == IMAGETYPE_JPEG ) {
                imagejpeg($this->image,$filename,$compression);
            }

            elseif( $image_type == IMAGETYPE_GIF ) {
                imagegif($this->image,$filename);
            }

            elseif( $image_type == IMAGETYPE_PNG ) {
                imagepng($this->image,$filename);
            }

            
            if( $permissions != null) {
                chmod($filename,$permissions);
            }

        }

        

// -- Function Name : output
// -- Params : $image_type=IMAGETYPE_JPEG
// -- Purpose : 
        function output($image_type=IMAGETYPE_JPEG) {
            
            if( $image_type == IMAGETYPE_JPEG ) {
                imagejpeg($this->image);
            }

            elseif( $image_type == IMAGETYPE_GIF ) {
                imagegif($this->image);
            }

            elseif( $image_type == IMAGETYPE_PNG ) {
                imagepng($this->image);
            }

        }

        

// -- Function Name : getWidth
// -- Params : 
// -- Purpose : 
        function getWidth() {
            return imagesx($this->image);
        }

        

// -- Function Name : getHeight
// -- Params : 
// -- Purpose : 
        function getHeight() {
            return imagesy($this->image);
        }

        

// -- Function Name : resizeToHeight
// -- Params : $height
// -- Purpose : 
        function resizeToHeight($height) {
            $ratio = $height / $this->getHeight();
            $width = $this->getWidth() * $ratio;
            $this->resize($width,$height);
        }

        

// -- Function Name : resizeToWidth
// -- Params : $width
// -- Purpose : 
        function resizeToWidth($width) {
            $ratio = $width / $this->getWidth();
            $height = $this->getheight() * $ratio;
            $this->resize($width,$height);
        }

        

// -- Function Name : scale
// -- Params : $scale
// -- Purpose : 
        function scale($scale) {
            $width = $this->getWidth() * $scale/100;
            $height = $this->getheight() * $scale/100;
            $this->resize($width,$height);
        }

        

// -- Function Name : resize
// -- Params : $width,$height
// -- Purpose : 
        function resize($width,$height) {
            $new_image = imagecreatetruecolor($width, $height);
            imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
            $this->image = $new_image;
        }

        

// -- Function Name : resizeTransparentImage
// -- Params : $width,$height
// -- Purpose : 
        function resizeTransparentImage($width,$height) {
            $new_image = imagecreatetruecolor($width, $height);
            
            if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) {
                $current_transparent = imagecolortransparent($this->image);
                
                if($current_transparent != -1) {
                    $transparent_color = imagecolorsforindex($this->image, $current_transparent);
                    $current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                    imagefill($new_image, 0, 0, $current_transparent);
                    imagecolortransparent($new_image, $current_transparent);
                }

                elseif( $this->image_type == IMAGETYPE_PNG) {
                    imagealphablending($new_image, false);
                    $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                    imagefill($new_image, 0, 0, $color);
                    imagesavealpha($new_image, true);
                }

            }

            imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
            $this->image = $new_image;
        }

    }

    ?>
