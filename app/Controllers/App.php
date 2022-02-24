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
        if(!$pagename && is_archive() && !is_tax()){
            $post_type = get_queried_object();
            $pagename = $post_type->rewrite['slug'];
        }elseif(!is_front_page() && is_page()){
            $pagename = 'page';
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
    private static function getHomeContent($offset,$per_page)
    {
        $args = [
            'post_type' => ['news','gallery','shop-product','field-report','vip-deal'],
            'posts_per_page' => $per_page,
            'orderby' => 'date',
            'order' => 'DESC',
            'post__not_in' => $offset,
        ];

        $query = get_posts($args);
        return $query;
    }

    public function randomContent()
    {   
        $term = "";
        $orderby = 'rand';

        if(is_tax()){
          $term =  array(
                array(
                    'taxonomy' => get_query_var('taxonomy'),
                    'field'    => 'slug',
                    'terms'    => get_query_var('term'),
                ),
            );

          $orderby = '';
        }

        return self::getHomeContent(0,8,$orderby,$term);
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

    public static function get_news_single_field($id,$field,$single = false)
    {
        $field_value = get_field($field,$id);
        if($field == 'excerpt' && !$single){
            $field_value = (strlen($field_value) > 195) ? 
            substr($field_value, 0, 190) . '...' : $field_value;
        }
        
        return $field_value;
    }

    public static function get_news_template($news)
    {
      $thumbnail = App::get_news_single_field($news->ID,'thumbnail');
      $image_src = App::get_news_single_field($news->ID,$thumbnail);
      $image = ($thumbnail === 'url_image') ? 'url("'.$image_src.'") 1x' : Utility::getImageSrcSet($image_src);

      return \App\template('component::news.feed',
      [
        "data" => $news,
        "thumbnail" => $image,
        "image_position" => App::get_news_single_field($news->ID,'image_position'),
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

    public static function field_report_by_author($reports)
    {
        $countReports = count($reports);

        // Get All Reports
        $html = '<div class="profile-field-report-content">';
        foreach($reports as $key => $report){
            $display = ($key >= 4) ? 'd-none' : '';
            $html .= App::get_field_report_template($report,$display);
        }
        $html .= '</div>'; 

        $html .= '<div class="field-reports-loading d-none"><i class="fas fa-circle-notch"></i></div>';

        // Get Pagination
        if($countReports > 4) {
            $html .= '<div id="field-reports-pagination"><ul>';
            $numb = 1;            
            for($i = 0; $i < $countReports; $i++){
                if(!($i % 4 != 0)){
                    $page = 3+$i;         
                    $active = ($numb === 1) ? 'active-pagination' : '';
                    $html .= '<li class="'.$active.'" data-page="'.$page.'">'.$numb.'</li>';
                    $numb++;
                }                
            }
            $html .= '</ul></div>';
            $html .= '<script type="text/javascript">
                jQuery(document).on("click","#field-reports-pagination li",function(){
                        let allContent = jQuery("div.profile-field-report-content>div");
                        allContent.addClass("d-none");
                        jQuery("#field-reports-pagination li").removeClass("active-pagination");
                        let pageNumb = jQuery(this).data("page");
                        jQuery(this).addClass("active-pagination");
                        jQuery("div.profile-field-report-content").addClass("d-none");
                        jQuery("div.field-reports-loading").removeClass("d-none");

                        setTimeout(function(){                            
                            for(let i = 0; i < 4; i++){
                                jQuery(allContent[pageNumb-i]).removeClass("d-none");
                            }
                            window.scrollTo(0,0);
                            jQuery("div.field-reports-loading").addClass("d-none");
                            jQuery("div.profile-field-report-content").removeClass("d-none");
                        },500);
                    })
            </script>';
        }        

        return $html;
    }

    public static function get_field_report_field($id,$field)
    {
        return get_field($field,$id);
    }

    public static function get_field_report_template($report,$display = '')
    {

        $fr_images = App::get_field_report_field($report->ID,'images');
        $uwp_avatar = uwp_get_usermeta( $report->post_author, 'avatar_thumb', '' );
        $avatar = ($uwp_avatar) ? '/app/uploads/'.$uwp_avatar : get_avatar_url($report->post_author);
        $fr_views = App::get_field_report_field($report->ID,'views');
        $excerpt = (strlen($report->post_excerpt) > 195) ? substr($report->post_excerpt, 0, 190) . '...' : $report->post_excerpt;

        return \App\template('component::field-report.feed',[
            "data" => $report,
            "images" => $fr_images,
            "views" => $fr_views,
            "tags" => get_object_term_cache( $report->ID, 'tags' ),
            "url" => get_permalink($report->ID),
            "author_avatar" => $avatar,
            "author_name" => get_the_author_meta( 'display_name', $report->post_author ),
            "excerpt" => $excerpt,
            "display" => $display,
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

// Get User comments by Author ID
    public static function get_all_comments_of_author($author_id)
    {
        $args = [
            'user_id' => $author_id,
            'post_type' => ['news','field-report','vip-deal'],
            'orderby' => 'comment_post_ID'
        ];
        $comments = get_comments($args);
        $templated_comments = self::get_comments_by_author_template($comments);

        $html = '';
        if(count($comments) !== 0) :
            // Get All Comments
            $html = '<div class="profile-all-comments p-4">';

            // Loop Sorted Comments
            foreach($templated_comments as $comments) :
                $html .= '<div class="post-comments-wrap-by-author mb-5">';
                $html .= $comments->html;
                $html .= '</div>';
            endforeach;

            $html .= '</div>';
            $html .= '<div class="all-comments-loading d-none"><i class="fas fa-circle-notch"></i></div>';
            //return var_dump($templated_comments);
        endif;
        
        return $html;
    }

// Get Comment by Author Template
    private static function get_comments_by_author_template($comments)
    {   
        $prev_postID = '';        
        $comments_sorted = [];
        foreach($comments as $key => $comment){
            $html = '';          
            if(empty($prev_postID) || !empty($prev_postID) && $prev_postID !== $comment->comment_post_ID){                
                $post = get_post($comment->comment_post_ID);
                $url = ($post->post_type == 'vip-deal' || 'field-report') ? $post->post_type.'s' : $post->post_type;
                $url = '/'.$url.'/'.$post->post_name;
                $html .= '<h4 class="comment-post-title"><a href="'.$url.'">'.$post->post_title.'</a></h4>';
            }
            $html .= '<div class="comment-wrap-by-author py-3 px-4 bg-light my-3">';
            $html .= '<p class="comment-date font-weight-bold">'.date('F j, Y', strtotime($comment->comment_date)).'</p>';
            $html .= '<p class="comment-content mb-1">'.$comment->comment_content.'</p>';
            $html .= '</div>';
            if(empty($prev_postID) || !empty($prev_postID) && $prev_postID !== $comment->comment_post_ID){
                $comments_sorted[$comment->comment_post_ID] = (object)[
                    'html' => $html,
                    'latest_comment' => $comment->comment_date
                ];
                $prev_postID = $comment->comment_post_ID;
            }else{
                $comments_sorted[$comment->comment_post_ID]->html .= $html;
            }
        }
        usort($comments_sorted, function($a, $b) {
            return $a->latest_comment < $b->latest_comment; }
        );
        return $comments_sorted;
    }
}

