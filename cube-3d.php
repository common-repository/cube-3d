<?php
/*
Plugin Name: Cube 3D
Plugin URI: 
Version: 1.11
Description: Display 3D cube in your website
Author: Manu225
Author URI: 
Network: false
Text Domain: cube-3d
Domain Path: 
*/

register_activation_hook( __FILE__, 'cube_3d_install' );
register_uninstall_hook(__FILE__, 'cube_3d_desinstall');

function cube_3d_install() {
	
	global $wpdb;
	$cube_3d_table = $wpdb->prefix . "cube_3d";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	$sql = "

        CREATE TABLE `".$cube_3d_table."` (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(50) NOT NULL,
          width int(11) NOT NULL,
          faces_color varchar(10) NOT NULL,
          faces_image varchar(500) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

    ";

    dbDelta($sql);

}

function cube_3d_desinstall() {

	global $wpdb;

	$cube_3d_table = $wpdb->prefix . "cube_3d";

	//suppression des tables

	$sql = "DROP TABLE ".$cube_3d_table.";";

	$wpdb->query($sql);

}

add_action( 'admin_menu', 'register_cube_3d_menu' );
function register_cube_3d_menu() {

	add_menu_page('Cube 3D', 'Cube 3D', 'edit_pages', 'cubes_3d', 'cubes_3d', plugins_url( 'images/icon.png', __FILE__ ), 27);

}

add_action('admin_print_styles', 'cube_3d_css' );
function cube_3d_css() {

    wp_enqueue_style( 'Cube3DStylesheet', plugins_url('css/admin.css', __FILE__) );

}

add_action( 'admin_enqueue_scripts', 'load_script_c3d' );
function load_script_c3d() {

	wp_enqueue_media();

}

function cubes_3d()
{
	global $wpdb;

	$cube_3d_table = $wpdb->prefix . "cube_3d";

	//ajout ou édition d'un cube 3d
	if(sizeof($_POST))
	{
		check_admin_referer( 'edit_c3d' );

		$query = "REPLACE INTO ".$cube_3d_table." (`id`, `name`, `width`, `faces_color`, `faces_image`)
		VALUES (%d, %s, %d, %s, %s)";

		$query = $wpdb->prepare( $query, $_POST['id'], sanitize_text_field(stripslashes_deep($_POST['name'])), $_POST['width'], sanitize_text_field(stripslashes_deep($_POST['faces_color'])), sanitize_text_field(stripslashes_deep($_POST['faces_image'])) );

		$wpdb->query( $query );		

	}


	$query = "SELECT * FROM ".$cube_3d_table." ORDER BY name ASC";

	$cubes = $wpdb->get_results($query);

	include(plugin_dir_path( __FILE__ ) . 'views/cubes_3d_list.php');
}

//Ajax remove cube 3d
add_action( 'wp_ajax_remove_c3d', 'remove_c3d' );
function remove_c3d() {

	check_ajax_referer( 'remove_c3d' );

	if(current_user_can('edit_pages'))
	{
		if(is_numeric($_POST['id']))
		{
			global $wpdb;

			$cube_3d_table = $wpdb->prefix . "cube_3d";

			$query = "DELETE FROM ".$cube_3d_table." WHERE id = %d";

			$query = $wpdb->prepare( $query, $_POST['id'] );

			$wpdb->query( $query );

		}
	}

	wp_die();

}

add_shortcode('cube-3d', 'display_cube_3d');

function display_cube_3d($atts) {

	if(is_numeric($atts['id']))
	{
		global $wpdb;

		$cube_3d_table = $wpdb->prefix . "cube_3d";

		$query = "SELECT * FROM ".$cube_3d_table." WHERE id = %d";

		$query = $wpdb->prepare( $query, $atts['id'] );

		$cube = $wpdb->get_row( $query );

		if($cube)
		{
			wp_enqueue_style( 'Cube3DFrontStylesheet', plugins_url('css/cube-3d.css', __FILE__) );
			ob_start();
			include( plugin_dir_path( __FILE__ ) . 'views/cube-3d.tpl.php' );
			return ob_get_clean();
		}
		else
			return 'Cube 3D ID '.$atts['id'].' not found !';
	}
	else
		return 'ID must be numeric';

}

?>