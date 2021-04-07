<?php
/*
 * Add my new menu to the Admin Control Panel
 */

// Hook the 'admin menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
include 'index_url.php';
add_action( 'admin_menu', 'pp_Tambah_Link_Admin' );
 

// Add a new top level menu link to the ACP
function pp_Tambah_Link_Admin()
{
 add_menu_page(
  'Title', // Judul dari halaman
  'produk', // Tulisan yang ditampilkan pada menu
  'manage_options', // Persyaratan untuk dapat melihat link
  'my-plugin-page', // slug dari file untuk menampilkan halaman ketika menu link diklik.
  'tampil',
  '', //icon
  2
 );

}
// untuk menampilkan menu
function tampil()
{
 require_once 'product.php';
}

add_action('admin_menu', 'register_custom_submenu');
function register_custom_submenu() {
add_submenu_page( 
		'my-plugin-page', 
		'slug', 
		'harga', 
		'administrator', 
		'custom-submenu', 
		'harga' );
}
// untuk menampilkan sub menu
function harga()
{
 require_once 'harga.php';
}

// untuk menghapus submenu
function wpdocs_adjust_the_wp_menu() {
    $page = remove_submenu_page( 'index.php', 'update-core.php' );
}
add_action( 'admin_menu', 'wpdocs_adjust_the_wp_menu', 999 );

function delete_plugin() {
    $page = remove_menu_page( 'plugins.php', 'plugins.php' );
}
add_action( 'admin_menu', 'delete_plugin', 999 );

// icon title web
add_action( 'wp_head', 'prefix_favicon', 100 );
add_action( 'admin_head', 'prefix_favicon', 100 );
add_action( 'wp_head', 'prefix_favicon', 100 );
function prefix_favicon() {
    //code of the favicon logic
    ?>
        <link rel="icon" href="https://d33wubrfki0l68.cloudfront.net/89d21e1f2a17001aa475773cbb3e47639494d4c9/475b1/img/logo.svg">
    <?php
}

// remove admin logo
 // Replace Wordpress logo with custom Logo
function my_custom_logo() {
    echo '
    <style type="text/css">
    #wp-admin-bar-kodeo-admin > .ab-item   {
        content: url('. DIR_PLUGIN_CUSTOM . 'assets/images/logo.png)!important;
        
    }
    .edit-post-fullscreen-mode-close.has-icon > svg{
        display:none;
    }
    .edit-post-fullscreen-mode-close.has-icon{
        content: url('. DIR_PLUGIN_CUSTOM . 'assets/images/logo.png)!important;
        background: none;
    }
    #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
        background-position: 0 0;
    }
     </style>
    ';
}
add_action('admin_head', 'my_custom_logo');
add_action('wp_head', 'my_custom_logo');


function remove_admin_bar_links() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

add_action( 'load-index.php', 'hide_welcome_screen' );

function hide_welcome_screen() {
    $user_id = get_current_user_id();

    if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
        update_user_meta( $user_id, 'show_welcome_panel', 0 );
}


add_action('admin_head', 'mytheme_remove_help_tabs');
function mytheme_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_filter('screen_options_show_screen', '__return_false');

add_action('wp_dashboard_setup', 'themeprefix_remove_dashboard_widget' );
/**
 *  Remove Site Health Dashboard Widget
 *
 */
function themeprefix_remove_dashboard_widget() {
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
}

function remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
}
add_action('admin_init', 'remove_dashboard_meta');



