<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
	public static function title()
    {
    	return get_the_title();
    }

    public static function thumbnail($id,$size) 
    {
        return get_the_post_thumbnail_url($id,$size);
    }

}
