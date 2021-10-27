<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    private static $_postPerPage = 3;

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
        if(!$pagename && is_archive()){
            $post_type = get_queried_object();
            $pagename = $post_type->rewrite['slug'];
        }
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

// HOME PAGE FUNCTIONS
    public static function getHomeContent($offset,$per_page)
    {
        $args = [
            'post_type' => ['news','gallery','shop-product','field-report','vip-deal'],
            'posts_per_page' => $per_page,
            'orderby' => 'rand',
            'order' => 'DESC',
            'post__not_in' => $offset
        ];

        $query = get_posts($args);
        return $query;
    }

    public function randomContent()
    {
        return self::getHomeContent(0,8);
    }

// NEWS FUNCTIONS
    public function newsList()
    {
        $args = [
            'post_type' => 'news',
            'posts_per_page' => self::$_postPerPage,
            'order' => 'DESC'
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

    public static function get_news_template($news)
    {
        return \App\template('component::news.feed',
        [
          "data" => $news,
          "thumbnail" => App::get_news_single_field($news->ID,'url_image','thumbnail'),
          "image_position" => App::get_news_single_field($news->ID,'image_position','thumbnail'),
          "caption" => App::get_news_single_field($news->ID,'excerpt'),
          "views" => App::get_news_single_field($news->ID,'views'),
          "url" => get_permalink($news->ID)
        ]);
    }

// GALLERY FUNCTIONS
    public function galleries()
    {
        $args = [
            'post_type' => 'gallery',
            'posts_per_page' => self::$_postPerPage,
            'order' => 'DESC'
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

    public static function get_gallery_template($gallery)
    {
        $output = \App\template('component::gallery.hero',[
            "data" => $gallery,
            "hero" => App::get_gallery_single_field($gallery->ID,"hero"),
            "url" => get_permalink($gallery->ID)
        ]);

        $output .= \App\template('component::gallery.preview',[
            "images" => App::get_gallery_single_field($gallery->ID,"gallery_content",true),
            "preview_count" => App::get_gallery_single_field($gallery->ID,"preview_count"),
            "year" => get_object_term_cache( $gallery->ID, 'year' ),
            "month" => get_object_term_cache( $gallery->ID, 'month' ),
            "url" => get_permalink($gallery->ID)
        ]);

        return $output;
    }

// SHOP FUNCTIONS
    public function shop_products()
    {
        $args = [
            'post_type' => 'shop-product',
            'posts_per_page' => self::$_postPerPage,
            'order' => 'DESC'
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

    public static function get_shop_template($products)
    {

        $product = App::get_shop_product_single_field($products->ID);
        $output = "";
        if(!empty($product['hero'])){
            $output .= \App\template('component::shop.hero',["hero" => $product['hero'], "ID" => $products->ID]);
        }
        if(!empty($product['categories'])){
            $output .= \App\template('component::shop.categories',["categories" => $product['categories'], "ID" => $products->ID]);
        }
        if(!empty($product['products'])){
            $output .= \App\template('component::shop.products',["products" => $product['products'], "ID" => $products->ID]);
        }

        return $output;
    }

// FIELD REPORT FUNCTIONS
    public function field_report()
    {
        $args = [
            'post_type' => 'field-report',
            'posts_per_page' => self::$_postPerPage,
            'order' => 'DESC'
        ];

        $query = get_posts($args);
        return $query;
    }

    public static function get_field_report_field($id,$field)
    {
        return get_field($field,$id);
    }

    public static function get_field_report_template($report)
    {

        $fr_images = App::get_field_report_field($report->ID,'images');        
        $fr_views = App::get_field_report_field($report->ID,'views');
        $excerpt = (strlen($report->post_excerpt) > 195) ? substr($report->post_excerpt, 0, 190) . '...' : $report->post_excerpt;

        return \App\template('component::field-report.feed',[
            "data" => $report,
            "images" => $fr_images,
            "views" => $fr_views,
            "tags" => get_object_term_cache( $report->ID, 'tags' ),
            "url" => get_permalink($report->ID),
            "author_avatar" => get_avatar_url($report->post_author),
            "author_name" => get_the_author_meta( 'display_name', $report->post_author ),
            "excerpt" => $excerpt,
        ]);
    }

// VIP DEALS FUNCTIONS
    public function vip_deals()
    {
        $args = [
            'post_type' => 'vip-deal',
            'posts_per_page' => self::$_postPerPage,
            'order' => 'DESC'
        ];

        $query = get_posts($args);
        return $query;
    }

    public static function get_vip_deal_field($id)
    {
        return get_field('vip_deal',$id);
    }
    public static function get_vip_deal_template($deal)
    {
        $vip_deal = App::get_vip_deal_field($deal->ID);
        return \App\template('component::vip-deals.feed',[
        "deal" => $vip_deal,
        "tags" => get_object_term_cache( $deal->ID, 'tags' ),
        "url" => get_permalink($deal->ID),
        "ID" => $deal->ID,
      ]);
    }
}
