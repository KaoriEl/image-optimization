<?php

use Imagine\Image\Box;
use Imagine\Image\Point;

require_once __DIR__ . '/vendor/autoload.php';
$imagine = new Imagine\Gd\Imagine();

try {
    $all_files = rsearch("./uploads/","/^.*\.(jpg|png)$/");
// print_r($all_files);
} catch(\UnexpectedValueException $e) {
    echo $e->getMessage();
}

for ($i = 0; $i < count($all_files); $i++) {
    $image_name = $all_files[$i];
    $supported_format = array('gif', 'jpg', 'jpeg', 'png');
    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $size = getimagesize($image_name);
    if ($size[0] == "640" || $size[0] == "1024" ) {
        echo "i = " . $i . "\n";
        echo "The image is already compressed \n";
    } else {

        if ($size[0] > "1024" && $size[0] != "1024"  ){

            $resizeHeight = $size[1] ;
            $resizeWidth = $size[0] ;
            $SubWith = $resizeWidth - 1024;
            $percentWidth =  $SubWith * 100 / $resizeWidth;
            $percentHeight = $percentWidth / 100 * $resizeHeight;
            $newHeight = $resizeHeight - $percentHeight;
            $roundHeight = round($newHeight);
            echo "------------------------------------------------------------- \n";
            echo "+/-" . gmp_sign("$roundHeight") . "\n";
            echo "------------------------------------------------------------- \n";
            echo " width > 1024 \n";
            echo "------------------------------------------------------------- \n";
            echo "Initial width: \n", $resizeWidth , " ";
            echo "Initial height: \n", $resizeHeight, " ";
            echo "Width - Our constant width: \n", $SubWith , " ";
            echo "Percentage of width: \n", $percentWidth, " ";
            echo "Percentage of heght: \n", $percentHeight, " ";
            echo "Length - percentage of original length: \n", $roundHeight, " ";
            echo "------------------------------------------------------------- \n";
            if (in_array($ext, $supported_format)) {

                try {
                    $image = $imagine->open($image_name);
                } catch (Imagine\Exception\InvalidArgumentException $exception) {
                    error_log($exception->getMessage());
                } catch (Imagine\Exception\RuntimeException $exception) {
                    error_log($exception->getMessage());
                }
                if (exif_imagetype($image_name) == IMAGETYPE_JPEG) {
                    $image->resize(new Box(1024, $roundHeight)) -> save($image_name, array('jpeg_quality' => 70));
                }
            }


        }
        elseif ($size[0] > "640") {


            $resizeHeight = $size[1] ;
            $resizeWidth = $size[0] ;
            $SubWith = $resizeWidth - 640;
            $percentWidth =  $SubWith * 100 / $resizeWidth;
            $percentHeight = $percentWidth / 100 * $resizeHeight;
            $newHeight = $resizeHeight - $percentHeight;
            $roundHeight = round($newHeight);
            echo "------------------------------------------------------------- \n";
            echo "+/-" . gmp_sign("$roundHeight") . "\n";
            echo "------------------------------------------------------------- \n";
            echo " width > 1024 \n";
            echo "------------------------------------------------------------- \n";
            echo "Initial width: ", $resizeWidth , "\n ";
            echo "Initial height: ", $resizeHeight, "\n ";
            echo "Width - Our constant width:", $SubWith , "\n ";
            echo "Percentage of width: ", $percentWidth, "\n ";
            echo "Percentage of heght: ", $percentHeight, "\n ";
            echo "Length - percentage of original length: ", $roundHeight, "\n ";
            echo "------------------------------------------------------------- \n";
            if (in_array($ext, $supported_format)) {

                try {
                    $image = $imagine->open($image_name);
                } catch (Imagine\Exception\InvalidArgumentException $exception) {
                    error_log($exception->getMessage());
                } catch (Imagine\Exception\RuntimeException $exception) {
                    error_log($exception->getMessage());
                }
                if (exif_imagetype($image_name) == IMAGETYPE_JPEG) {
                    $image->resize(new Box(640, $roundHeight)) -> save($image_name, array('jpeg_quality' => 70));
                }
            }
        }
        
    }
  

}

function rsearch($folder, $pattern) {
    $dir = new RecursiveDirectoryIterator($folder);
    $ite = new RecursiveIteratorIterator($dir);
    $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
    $fileList = array();
    foreach($files as $file) {
        $fileList[] = $file[0];
    }
    return $fileList;
}
