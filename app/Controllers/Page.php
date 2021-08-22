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
}
