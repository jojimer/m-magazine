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
}
