<?php
if ( !class_exists( 'StacklaShortcode' ) ) :

class StacklaShortcode {
	private $shortcodes = array (
		'stackla',
	);

	public function __construct() {
		add_shortcode( 'stackla', array( $this, 'stackla_widget') );
	}

	public function stackla_widget( $atts ) {
        $widget = new StacklaWidget();
        $html = $widget->render ($atts);

		return apply_filters( 'wp-shortcode-stackla-widget', $this->sanitize_output( $html ) );
	}

	public function sanitize_output( $buffer ) {
		$search = array(
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s',       // shorten multiple whitespace sequences
			"/\r/",
			"/\n/",
			"/\t/",
			'/<!--[^>]*>/s',
		);

		$replace = array(
			'>',
			'<',
			'\\1',
			'',
			'',
			'',
			'',
		);

		$buffer = preg_replace( $search, $replace, $buffer );
		return $buffer;
	}
}
endif;