<?php

namespace Tofino\Assets;

// Load styles
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\styles');

/**
 * @todo: Allow for deregistering via an array
 * @todo: Maybe replace filemtime with another solution
 */
function styles() {
  $main_css = '/dist/css/main.css';
  wp_register_style('tofino/css', get_template_directory_uri() . $main_css . '?v=' . filemtime(get_template_directory() . $main_css), array(), '', 'all');
  wp_enqueue_style('tofino/css'); // Enqueue it!
}


/**
 * Load admin styles
 */
add_action('login_head', __NAMESPACE__ . '\\admin_styles');
add_action('admin_head', __NAMESPACE__ . '\\admin_styles');

function admin_styles() {
  $admin_css = '/dist/css/wp-admin.css';
  wp_register_style('tofino/css/admin', get_template_directory_uri() . $admin_css . '?v=' . filemtime(get_template_directory() . $admin_css), array(), '', 'all');
  wp_enqueue_style('tofino/css/admin');
}


/**
 * Load scripts
 */
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\scripts');

function scripts() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/dist/js/jquery.js', false, null);
    wp_enqueue_script('jquery');

    $main_js = '/dist/js/main.js';
    wp_register_script('tofino/js', get_template_directory_uri() . $main_js . '?v=' . filemtime(get_template_directory() . $main_js), array('jquery'), '', true); // Custom scripts
    wp_enqueue_script('tofino/js'); // Enqueue it!

    //Set vars for ajax and nonce
    wp_localize_script('tofino/js', 'tofinoJS', array(
      'ajaxUrl'       => admin_url('admin-ajax.php'),
      'nextNonce'     => wp_create_nonce('next_nonce'),
      'cookieExpires' => (ot_get_option('cookie_expires') ? ot_get_option('cookie_expires') : "")
    ));

    $head_js = '/dist/js/head.js';
    wp_register_script('tofino/js/head', get_template_directory_uri() . $head_js . '?v=' . filemtime(get_template_directory() . $head_js), array(), '', false); // Head scripts
    wp_enqueue_script('tofino/js/head'); // Enqueue it!
  }
}
