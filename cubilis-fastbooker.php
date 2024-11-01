<?php
/**
 * Plugin Name: Cubilis Fastbooker
 * Plugin URI: https://www.cubilis.com
 * Description: Cubilis Fastbooker widget allows you to easily integrate the Cubilis Booking Engine on your website. Using this widget, visitors are able to find available rooms based on their arrival and departure date. An active Cubilis subscription is required, please contact sales@stardekk.be if you don't have an activate account yet.
 * Version: v.2.4.0
 * Author: Stardekk
 * Author URI: https://www.stardekk.be
 * License: GPLv2
 * Text Domain: cubilis-fastbooker
 * Domain Path: /languages/
 */
 
 // Die if file is called directly
 if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register internalization
function cubilis_fastbooker_register_text_domain() {
	load_plugin_textdomain( 'cubilis-fastbooker', false, dirname(plugin_basename( __FILE__ )) . '/languages/' ); 
}

// Register an admin menu
function cubilis_fastbooker_register_menu() {
	add_menu_page('Cubilis', 'Cubilis', 'manage_options', 'cubilis_fastbooker_menu', 'cubilis_fastbooker_create_menu', plugins_url( plugin_basename(dirname( __FILE__ ))) . '/assets/cubilis_klein.png');
}

// Create an admin menu
function cubilis_fastbooker_create_menu() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( _e( 'You do not have sufficient permissions to view this page.', 'cubilis-fastbooker' ) );
	}
	
	include('admin/cubilis_fastbooker_menu.php');
}

function cubilis_fastbooker_enqueue_scripts_and_styles() {
	// Load jQuery
	wp_enqueue_script('jquery');

	// Load datepicker
	wp_register_script('cubilis-fastbooker-datepicker', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/js/datepicker.js'), null,'1.0', true);
	wp_enqueue_script('cubilis-fastbooker-datepicker');

	// Load custom js and css
	wp_register_script('cubilis-fastbooker-widget-js', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/js/widget.js'), array('jquery', 'cubilis-fastbooker-datepicker'),'1.0', false);
	wp_enqueue_script('cubilis-fastbooker-widget-js');

	wp_register_style('cubilis-fastbooker-widget-css', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/css/widget.css'), null, '1.0', 'all');
	wp_enqueue_style('cubilis-fastbooker-widget-css');
}

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'cubilis_fastbooker_enqueue_scripts_and_styles');

// Load internalization
add_action( 'plugins_loaded', 'cubilis_fastbooker_register_text_domain' );

// Register an admin menu
add_action("admin_menu", "cubilis_fastbooker_register_menu");
							
// Includes Widget
include('widget/cubilis_fastbooker_widget.php');

// Register Widget
add_action( 'widgets_init', function(){
		register_widget( 'Cubilis_Fastbooker_Widget' );
});