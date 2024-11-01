<?php 
/**
 *  Plugin Name: Stackla (Simple Embed)
 *  Plugin URI: https://www.stackla.com
 *  Description: Easily embed your existing Stackla Widgets into your Wordpress site.
 *  Author: Stackla
 *  Version: 1.1.1
 *  Author: Stackla
 *  Author URI: http://stackla.com/
 *  License: PLv2 or later
 */

if ( !class_exists('StacklaPlugin') ) :

class StacklaPlugin {

	public function __construct() {
		$this->define_constants();
		$this->includes();

		$this->dir = WP_DIR;
		$this->uri = WP_URI;
		$this->temp_dir = WP_TEMP_DIR;
		$this->temp_uri = WP_TEMP_URL;
		$this->stylesheet_dir = WP_STYLESHEET_DIR;
		$this->stylesheet_uri = WP_STYLESHEET_URL;

		$this->version = '1.0.0';

		// load include files
		$this->shortcode = new StacklaShortcode();
		if( is_admin() ) {
			$this->settings = new StacklaSettings();
		}

        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_settings_link' ) );
	}
	
	public static function instance() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	public function includes() {
		require_once WP_DIR . 'inc/widget.php';
		require_once WP_DIR . 'inc/settings.php';
		require_once WP_DIR . 'inc/shortcode.php';
	}

	public function define_constants() {
		$defines = array(
			'WP_DIR' => plugin_dir_path( __FILE__ ),
			'WP_URI' => plugin_dir_url( __FILE__ ),
			'WP_TEMP_DIR' => trailingslashit( get_template_directory() ),
			'WP_TEMP_URL' => trailingslashit( get_template_directory_uri() ),
			'WP_STYLESHEET_DIR' => trailingslashit( get_stylesheet_directory() ),
			'WP_STYLESHEET_URL' => trailingslashit( get_stylesheet_directory_uri() ),
		);

		foreach( $defines as $k => $v ) {
			if ( !defined( $k ) ) {
				define( $k, $v );
			}
		}
	}

	public function init() {
		
	}

    function plugin_settings_link($links) {
        $url = get_admin_url() . 'admin.php?page=stackla-settings';
        $settings_link = '<a href="'.$url.'">' . __( 'Settings', 'stackla' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
}

$GLOBALS['StacklaPlugin'] = StacklaPlugin::instance();

function Stackla_Widget($args = '')
{
    if (!is_array($args)) {
        $args = [
            'widget_id' => $args
        ];
    }

    $widget = new StacklaWidget();
    echo $widget->render ($args);
}

function stackla_add_admin_class() {
    echo '<script type="text/javascript">
		jQuery(function($){
            $("#toplevel_page_stackla-settings").find("img").css("width","18px");
        });
    </script>';
}

add_action('admin_footer', 'stackla_add_admin_class');

endif;
