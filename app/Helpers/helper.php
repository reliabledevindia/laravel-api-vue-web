<?php

if (! function_exists('app_name')) {
	/**
	 * Helper to grab the application name
	 *
	 * @return mixed
	 */
	function app_name() {
		return config('app.name');
	}
}

if ( ! function_exists('pr'))
{
    /**
     * Access the print_r helper
     */
    function pr($data)
    {
        echo "<pre>";
        print_r($data);die;
         
    }
}

function get_guard(){
    if(Auth::guard('admin')->check())
        {return "admin";}
    elseif(Auth::guard('web')->check())
        {return "web";}
    else
        { return '';}
}
