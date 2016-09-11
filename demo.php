<?php
/*
Plugin Name: demo plugin
Plugin URI: https://thewpempire.com.
Author: thewpempire
Author URI: https://thewpempire.com
Version: 1.0
License: GPLv3
*/

// i have made plugin but there is little bit difference than what we made in teclab its just
// a simple plugin which add values from form to database and delete it .
// update value are pending so complete it if you want to or if you want to change the file structure its all on you

function call_sidebar_menu()
{
    add_menu_page("demo plugin","demo plugin","read","add_new_user","","");
    add_submenu_page("add_new_user","add","add","read","add_new_user","add_new_user");
    add_submenu_page("add_new_user","view","view","read","view_all_user","view_all_user");
}

function return_plugin_path()
{
    return plugin_dir_path(__FILE__);
}

function add_new_user()
{
   include_once return_plugin_path().'view/add-user.php';
}

function view_all_user()
{
   include_once return_plugin_path().'view/view-user.php';
}

function create_table_for_plugin()
{
	require_once ABSPATH ."wp-admin/includes/upgrade.php";
	global $wpdb;
	$sql = "CREATE TABLE IF NOT EXISTS plugin_tabel
	(
		`id` int(10) NOT NULL AUTO_INCREMENT,
		`name` longtext NOT NULL,
		`email` longtext NOT NULL,
		 PRIMARY KEY (`id`)
	)
	ENGINE=InnoDB	DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
}

function include_script_files()
{
	wp_enqueue_script("jquery");
	wp_enqueue_script("validation.js",plugins_url("assets/js/jquery.validate.js",__FILE__));
}

function include_plugin_ajax_file()
{
	if(isset($_REQUEST["action"]))
		{
			switch($_REQUEST["action"])
			{
				case "plugin_action":

					if(file_exists(return_plugin_path()."lib/plugin-ajax.php"))
					{
						include_once return_plugin_path()."lib/plugin-ajax.php";
					}

				break;
			}
		}
}

register_activation_hook(__FILE__,"create_table_for_plugin");
add_action("admin_init","include_script_files");
add_action("admin_menu","call_sidebar_menu");
add_action("admin_init","include_plugin_ajax_file");
?>

