<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function slug()
    {
        $pagename = get_query_var('pagename');
        $pagename = (!$pagename) ? get_query_var('post_type') : $pagename;
        return (!$pagename) ? "home" : $pagename;
    }

    public static function getClass()
    {
        $classes = get_body_class();
        $output = "";
        foreach($classes as $key => $class) {
            $output .= $class." ";
        }

        return $output;
    }

// NEWS FUNCTIONS
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

    public static function get_news_single_field($id,$field,$group = '',$single = false)
    {
        if(strlen($group) < 1) {
            $field_value = get_field($field,$id);
            if($field == 'excerpt' && !$single){
                $field_value = (strlen($field_value) > 195) ? 
                substr($field_value, 0, 190) . '...' : $field_value;
            }
            
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

// GALLERY FUNCTIONS
    public function galleries()
    {
        $args = [
            'post_type' => 'gallery',
            'post_per_page' => 4,
            'order_by' => 'DESC'
        ];

        $query = get_posts($args);
        return $query;
    }

    public static function get_gallery_single_field($id,$field,$reapeter = false)
    {
        if(!$reapeter) {
            return get_field($field,$id);
        }else{
            $array_data = get_field($field,$id);
            if ( is_array( $array_data ) ) {
                return $array_data;
            }else{
                return NULL;
            }
        }
    }

// SHOP FUNCTIONS
    public function shop_products()
    {
        $args = [
            'post_type' => 'shop-product',
            'post_per_page' => 4,
            'order_by' => 'DESC'
        ];

        $query = get_posts($args);
        return $query;
    }

    public static function get_shop_product_single_field($id)
    {
        $array = [];
        $rows = get_field('shop_blocks',$id);

        // Check rows exists.
        if( count($rows) > 0 ){
            foreach( $rows as $i => $row ) {
                if ( is_array( $row ) && in_array( 'hero', $rows['choose_shop_blocks'] ) ) {
                    $array['hero'] = $rows['hero'];
                }

                if ( is_array( $row  ) && in_array( 'categories', $rows['choose_shop_blocks'] ) ) {
                    $array['categories'] = $rows['categories'];
                }

                if ( is_array( $row  ) && in_array( 'products', $rows['choose_shop_blocks'] ) ) {
                    $array['products'] = $rows['products'];
                }
            }

            return $array;
        }else{
            return NULL;
        }
    }
}
