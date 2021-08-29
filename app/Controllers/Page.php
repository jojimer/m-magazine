<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
	public static function title()
    {
    	return get_the_title();
    }

    public static function slug()
    {
    	$pagename = get_query_var('pagename');
    	return (!$pagename) ? "home" : $pagename;
    }

    public function newsList()
    {
        $args = [
            'post_type' => 'news',
            'post_per_page' => 4,
            'order_by' => 'DESC'
        ];

        $query = get_posts($args);
        return $query;
    }

    public static function thumbnail($id,$size) 
    {
        return get_the_post_thumbnail_url($id,$size);
    }

    public static function get_acf_single_field($id,$field,$group = '')
    {
        if(strlen($group) < 1) {
            $field_value = get_field($field,$id);
            $field_value = (strlen($field_value) > 195) ? 
            substr($field_value, 0, 190) . '...' : $field_value;
            return $field_value;
        }elseif($field == 'url_image'){
            $group_data = get_field($group,$id);
            if ( is_array( $group_data ) && array_key_exists( $field, $group_data ) ) {
                return $group_data[ $field ];
            }elseif( is_array( $group_data ) && array_key_exists( 'uploaded_image', $group_data ) ){
                return $group_data['uploaded_image'];
            }else{
                return NULL;
            }
        }else{
            $group_data = get_field($group,$id);
            if ( is_array( $group_data ) && array_key_exists( $field, $group_data ) ) {
                return $group_data[ $field ];
            }
        }       
    }
}
