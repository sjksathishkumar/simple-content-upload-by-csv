<?php
/*
Plugin Name: Simple Content Upload By CSV
Plugin URI: http://amezingapps.com/
Description: Upload your content data either it is custom post type, post or page. create csv with title and description and upload it
Author: Md. Meraj Ahmed
Author URI: http://amezingapps.com/
Version: 0.1
Copyright (c) 2014 Md. Meraj Ahmed 
*/
define( 'PLUGIN_DIR', dirname(__FILE__) );
define( 'PLUGIN_URI', plugin_dir_url(__FILE__) );

function ucbc_install() {
add_option('ucbc_version','0.1');
}

add_action('wp_ajax_formsubmit', 'ucbc_wp_ajax_formsubmit');
function ucbc_wp_ajax_formsubmit(){
global $wpdb;
  
 if($_FILES['csv_file']['name']!='') { 
  	$post_type = $_POST['contet_type'];
	$upload_dir = wp_upload_dir();
	$target_path = $upload_dir['path'];
	/* Add the original filename to our target path. 
	Result is "uploads/filename.extension" */

	$rand_name = rand().basename($_FILES['csv_file']['name']);

	$target_path = $target_path.'/'.$rand_name;
	/// file type 

	$extension = explode(".",$_FILES['csv_file']['name']);

	//print_r($extension); die;

	if($extension[1]=='csv')
	{
		if(move_uploaded_file($_FILES['csv_file']['tmp_name'], $target_path))
		{
			////////// file uploaded now insert data into database

			//read the CSV file to Stream

			$filePath = $target_path;
			$row = 1;

			if (($handle = fopen("$filePath", "r")) !== FALSE)
			{
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{
						$num = count($data);
						$row++;
						$title=$data[0];
						$description=$data[1];

					//input the red data from CSV in to Database

					   $data_post = array(
					  'post_title'    => wp_strip_all_tags($title),
					  'post_content'  => $description,
					  'post_type'   => $post_type,
					  'post_status'   => 'publish',
					);

					// Insert the post into the database
					wp_insert_post( $data_post );

	
				} 
				fclose($handle);
			}
			die("Data Uploaded Sucessfully!!!");
		}
		else
		{
			die("There was an error uploading the file, please try again!");
		}
	}
	else
	 {
		die("File Type Not Supported, Please Upload Csv File!");
	 }
	 
	 }else{
	 
	 die("Please Upload File");
	 }
}



function ucbc_admin_enqueue_scripts(){
  wp_register_script( 'ucbc-jquery-form-validate', PLUGIN_URI.'js/jquery.validate.min.js', array('jquery-form') );
  wp_register_script( 'ucbc-ucbc-form',     PLUGIN_URI.'js/ubc-form.js',    array('ucbc-jquery-form-validate'));
  wp_enqueue_script('ucbc-jquery-form-validate');
  wp_enqueue_script('ucbc-ucbc-form');
}

///load admin
function ucbc_admin() {
include('ucbc_admin.php');
}

function ucbc_menu() {
$menu = add_options_page('Upload Content', 'Upload Content', 'manage_options', 'my-plugin.php', 'ucbc_admin');
add_action('admin_print_styles-'.$menu, 'ucbc_admin_enqueue_scripts');
}

add_action('admin_menu', 'ucbc_menu');
