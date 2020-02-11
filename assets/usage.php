<?php 
// Styling and scripts
add_action('booking_script_css', 'booking_script_css_styles');
function booking_script_css_styles(){
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/assets/css/bootstrap.css">';
	echo '<link href="'.get_stylesheet_directory_uri().'/assets/vendor/featherlight/featherlight.min.css" type="text/css" rel="stylesheet" />';
	echo '<script src="'.get_stylesheet_directory_uri().'/assets/vendor/featherlight/featherlight.min.js" type="text/javascript" charset="utf-8"></script>';
	echo '<link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" type="text/css" rel="stylesheet" />';
}
?>




<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/vendor/loadingoverlay.min.js"></script> 
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/vendor/sweetalert.min.js"></script> 
<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>