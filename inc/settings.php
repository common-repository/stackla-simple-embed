<?php  
if ( !class_exists( 'StacklaSettings' ) ) :

class StacklaSettings {

	public function __construct(){
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	// Create admin menus for backend
	public function admin_menu(){
		// This page will be under "Settings"
		
		// add top level menu page
		add_menu_page(
			'Stackla',
            'Stackla',
            'manage_options',
            'stackla-settings',
            array( $this, 'create_admin_page' ),
            WP_URI . "/images/icon.png", 
            100
        );
	}

	/**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'stackla_options' );
        ?>
        <div class="wrap">
            <h1>Stackla (Simple Embed)</h1>
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'stackla_options' );
                do_settings_sections( 'stackla-settings' );
            ?>
        </div>
        <?php
	}
	/**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'stackla_options', // Option group
            'stackla_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'stackla-settings' // Page
        );  
        add_settings_field(
            'default_widget_id', // ID
            'Default Widget ID', // Title 
            'stackla-settings', // Page
            'setting_section_id' // Section
        );
	}

	/** 
     * Print the Section text
     */
    public function print_section_info()
    {
        $html = '<div class="description" id="default_widget_id">';
		$html .= 'The Stackla Simple Embed Plugin allows for Customers to quickly and easily embed a Stackla Widget into their Wordpress site using simply shortcode';
        $html .= '<h2>Add a Widget</h2>';
        $html .= 'To find your Widget ID, log into your Stackla Instance and navigate to <strong>Engage > Widgets</strong><br/><br/>';
        $html .= 'From the table that loads, you will be able to see your Widget ID in the ID column<br/><br/>';
        $html .= '<center><img src="' . WP_URI . '/images/widget.jpg"></center><br/<br/>';
        $html .= 'Now that you have your Widget ID, you can easily embed it into your Wordpress Post or Page by inserting the following <code>[stackla widget_id="WIDGET_ID"]</code> shortcode. <br/><br/>';
		$html .= '<code>WIDGET_ID</code> is simply the WIDGET_ID we collected earlier<br/><br/>';
        $html .= 'Example: <code>[stackla widget_id="5387"]</code> <br/><br/>';
		$html .= '<h2>Display content associated with another Filter</h2>';
		$html .= 'Now if you wish to overwrite the Filter associated with your Widget simply add to your shortcode the parameter <code>filter_id="FILTER_ID"</code>. <br/><br/>';
		$html .= 'Example: <code>[stackla widget_id="5387" filter_id="1234"]</code> <br/><br/>';
		$html .= 'To find your FILTER_ID, log into your Stackla Instance and navigate to <strong>Curate > Filter</strong><br/><br/>';
		$html .= '<center><img src="' . WP_URI . '/images/filters.jpg"></center><br/<br/>';
		$html .= 'From the table that loads, you will be able to see your <code>FILTER_ID</code> in the ID column<br/><br/>';
		$html .= '<h2>Display content associated with another Tag</h2>';
		$html .= 'Now if you wish to overwrite the Tag(s) associated with the Filter than has been applied to your Widget simply add to your shortcode the parameter <code>tags_id="TAGS_ID"</code>. <br/><br/>';
		$html .= 'Example: <code>[stackla widget_id="5387" tags_id="8885"]</code> <br/><br/>';
		$html .= 'This feature can support up to 10 tags being dynamically applied.  To list multiple tags, please add comma-seperated<br/><br/>';
		$html .= 'Example: <code>[stackla widget_id="5387" tags_id="8885,8889,9000"]</code> <br/><br/>';
		$html .= 'To find your <code>TAGS_ID</code>, log into your Stackla Instance and navigate to <strong>Curate > Tags</strong><br/><br/>';
		$html .= '<center><img src="' . WP_URI . '/images/tags.jpg"></center><br/<br/>';
		$html .= 'From the table that loads, you will be able to see your <code>TAGS_ID</code> in the ID column<br/><br/>';
		$html .= 'NOTE: This feature will only work if included in your Stackla license<br/><br/>';
		$html .= '<h2>Display only sepecific Tiles from your Stack</h2>';
		$html .= 'Now if you wish to display only specific Tiles from your Stack simply add parameter <code>tile_id="TILE_ID"</code>. <br/><br/>';
		$html .= 'Example: <code>[stackla widget_id="5387" tile_id="5b8c780a61a2cc56d5ea1313"]</code> <br/><br/>';
		$html .= 'This feature can support up to 10 Tiles being added.  To list multiple Tiles, please add comma-seperated<br/><br/>';
		$html .= 'Example: <code>[stackla widget_id="5387" tags_id="5b8c780a61a2cc56d5ea1313,5b8c725bee7fd654b24fb563"]</code> <br/><br/>';
		$html .= 'To find the <code>TILE_ID</code>, log into your Stackla Instance and navigate to <strong>Curate > Content</strong><br/><br/>';
		$html .= 'From the Tile you wish to render, click on the <strong>Tile Menu</strong> and select <strong>Data</strong><br/><br/>';
		$html .= '<center><img src="' . WP_URI . '/images/tile.jpg"></center><br/<br/>';
		$html .= 'The <code>TILE_ID</code> is displayed at the top of the prompt<br/><br/>';
		$html .= 'NOTE: This feature will only work if included in your Stackla license<br/><br/>';
		
             $html .= '<a href="https://my.stackla.com" target="_blank" class="button button-primary">Stackla Admin</a>';
         $html .= '</div>';
        echo $html;
	}


}
endif;