<?php 
class Main_shortcode{
	function __construct(){
		add_shortcode( 'multistep-form-selection', array($this ,'main_shortcode' ) );
	}

	public function main_shortcode( $atts = array()) {
		$atts = shortcode_atts( array(
			'id' => 'value',
		), $atts, 'multistep-form-selection' );
		ob_start();
		include MAINPATH.'template/template-herbal-natural-form.php';
		$output = ob_get_clean();
		return $output;
	}

}
new Main_shortcode;