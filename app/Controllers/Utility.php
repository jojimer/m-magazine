<?php 
namespace App\Controllers;

use Sober\Controller\Controller;

class Utility extends Controller
{
  public static function title()
  {
    return get_the_title();
  }

  public static function thumbnail($id,$size) 
  {
    return get_the_post_thumbnail_url($id,$size);
  }

  public static function acf_thumbnail($id,$size) 
  {
    //die(var_dump(wp_get_attachment_image_src($id,$size)));
    return wp_get_attachment_image_src($id,$size)[0];
  }


  public static function getImageSrcSet($id)
  {
    $imagesSet = "";
    $sizes = array(
      "large_thumb" => " 1x, ",
      "medium_large" => " 2x, ",
      "medium" => " 3x"      
    );

    foreach($sizes as $size => $value){
      $imagesSet .= 'url("'.self::acf_thumbnail($id,$size).'")'.$value;
    }

    return $imagesSet;
  }
}