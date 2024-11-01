<?php  
if ( !class_exists( 'StacklaWidget' ) ) :

class StacklaWidget {
    var $options;
    var $args = [];
    var $widget_id = '';
	var $filter_id = '';
    var $defaultOptions = [
        'powered_by' => 0
    ];

	public function __construct() {

        $options = get_option( 'stackla_options' );

        if(!is_array($options)) {
            $options = [];
        }

        $this->options = array_merge($this->defaultOptions, $options);

//        var_dump($options);die;

        add_action( 'wp_footer', array( $this, 'footer') );
	}

    /**
     * @param array $args
     * @return string
     */
    public function render($args = [])
    {
        $this->args = array_merge($this->args, $args);

        $this->setWidget();
		$this->setFilter();
		$this->setTags();
		$this->setTiles();

        $html = '<div class="stackla-widget"  data-ct="" data-id="'.$this->widget_id.'" data-filter="'.$this->filter_id.'" data-tags="'.$this->tags_id.'" data-tile-id="'.$this->tile_id.'" data-ttl="30" style="width: 100%; overflow: hidden;">';
        $html .= '</div>';
        return $html;
	}

    public function footer()
    {
        $html = '<script>';
        $html .= '(function (d, id) { var t, el = d.scripts[d.scripts.length - 1].previousElementSibling; if (el) el.dataset.initTimestamp = (new Date()).getTime(); if (d.getElementById(id)) return; t = d.createElement("script"); t.src = "//assetscdn.stackla.com/media/js/widget/fluid-embed.js"; t.id = id; (d.getElementsByTagName("head")[0] || d.getElementsByTagName("body")[0]).appendChild(t); }(document, "stackla-widget-js"));';
		$html .= '</script>';
        echo $html;
	}
	
	
	
    private function setWidget()
    {
        if (!empty($this->args['widget_id'])) {
            $this->widget_id = $this->args['widget_id'];
        } else if (isset($this->option) && !empty($this->option['default_widget_id'])) {
            $this->widget_id = $this->option['default_widget_id'];
        } 
    }
	
	private function setFilter()
    {
        if (!empty($this->args['filter_id'])) {
            $this->filter_id = $this->args['filter_id'];
        } else if (isset($this->option) && !empty($this->option['default_filter_id'])) {
            $this->filter_id = $this->option['default_filter_id'];
        } 
    }
	
	private function setTags()
    {
        if (!empty($this->args['tags_id'])) {
            $this->tags_id = $this->args['tags_id'];
        } else if (isset($this->option) && !empty($this->option['default_tags_id'])) {
            $this->tags_id = $this->option['default_tags_id'];
        } 
    }
	
	private function setTiles()
    {
        if (!empty($this->args['tile_id'])) {
            $this->tile_id = $this->args['tile_id'];
        } else if (isset($this->option) && !empty($this->option['default_tile_id'])) {
            $this->tile_id = $this->option['default_tile_id'];
        } 
    }
}

endif;
