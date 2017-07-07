<?php
//Automatically login a single WordPress user upon arrival to a specific page.
//Redirect to home page once logged in and prevent viewing of the login page.
//Tested with WP 3.9.1. 


function auto_login() {
	//change these 2 items
	$loginpageid = '1234'; //Page ID of your login page
	$loginusername = 'demo'; //username of the WordPress user account to impersonate

    if (!is_user_logged_in()
    	&& is_page($loginpageid)) { //only attempt to auto-login if at www.site.com/auto-login/ (i.e. www.site.com/?p=1234 )

        //get user's ID
        $user = get_user_by('login', $loginusername);
        $user_id = $user->ID;

        //login
        wp_set_current_user($user_id, $loginusername);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $loginusername);

        //redirect to home page after logging in (i.e. don't show content of www.site.com/?p=1234 )
        wp_redirect( home_url() );
        exit;
    } elseif(is_page($loginpageid)) {
        //prevent viewing of login page even if logged in
        wp_redirect( home_url() );
        exit;
    } else {}
}
add_action('wp', 'auto_login');
