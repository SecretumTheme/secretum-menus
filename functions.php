<?php
/**
 * Plugin Functions
 *
 * @package Secretum
 * @subpackage SecretumFP
 */


namespace SecretumMenus\Functions {
	/**
	 * Manage Shortcode Attributes & Display Nav Menu
	 * 
	 * @param array $atts Shortcode Attributes
	 *  @param menu (int|string|WP_Term) REQUIRED Desired menu. Accepts a menu ID, slug, name, or object
	 *  @param menu_class (string) CSS class to use for the ul element which forms the menu. Default 'menu'
	 *  @param menu_id (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented
	 *  @param container (string) Whether to wrap the ul, and what to wrap it with. Default 'div'
	 *  @param container_class (string) Class that is applied to the container. Default 'menu-{menu slug}-container'
	 *  @param container_id (string) The ID that is applied to the container
	 *  @param fallback (string) Callback function, default is 'wp_page_menu'
	 *  @param walker (string) Walker class name
	 *  @param depth (int) How many levels of the hierarchy are to be included. 0 means all. Default 0
	 *  @param before (string) Text before the link markup
	 *  @param after (string) Text after the link markup
	 *  @param link_before (string) Text before the link text
	 *  @param link_after (string) Text after the link text
	 *  @param items_wrap (string) List items wwrapped. Defaults to: <ul id="%1$s" class="%2$s">%3$s</ul>
	 *  @param items_class (string) Classes applied to the items if walker="WP_Bootstrap_Navwalker"
	 *  @param item_spacing (string) Preserve whitespace within menu html. Accepts 'preserve' or 'discard'. Default 'preserve'
	 *  @param divider (string) Divider class names, ie: "px-4 py-3 border-left border-primary-light" if walker="WP_Bootstrap_Navwalker"
	 * @param string $content Not Used
	 * @return wp_nav_menu()
	 *
	 */
	function shortcode($atts = array(), $content = false) {
	    // Get Attributes
	    $atts = shortcode_atts(array(
	        "menu"              => false,
	        "container"         => false,
	        "container_class"   => false,
	        "container_id"      => false,
	        "menu_class"        => false,
	        "menu_id"           => false,
	        "fallback"          => false,
	        "walker"            => false,
	        "depth"             => false,
	        "before"            => false,
	        "after"             => false,
	        "link_before"       => false,
	        "link_after"        => false,
	        "items_wrap"        => false,
	        "items_class"       => false,
	        "item_spacing"      => false,
	        "divider"           => false
	    ), $atts);

	    // If Name Set
	    if (!empty($atts['menu'])) {
	        // Set Container Type
	        $container = !empty($atts['container']) ? 'ul' : 'div';

	        // Set Container Class
	        $container_class = !empty($atts['container_class']) ? sanitize_text_field($atts['container_class']) : '';

	        // Set Container ID
	        $container_id = !empty($atts['container_id']) ? sanitize_text_field($atts['container_id']) : '';

	        // Set Menu Class
	        $menu_class = !empty($atts['menu_class']) ? sanitize_text_field($atts['menu_class']) : '';

	        // Set Menu ID
	        $menu_id = !empty($atts['menu_id']) ? sanitize_text_field($atts['menu_id']) : '';

	        // Set Fallback Class
	        $fallback = !empty($atts['fallback']) ? sanitize_text_field($atts['fallback']) : '';

	        // Set Walker Class
	        $walker_class = !empty($atts['walker']) ? sanitize_text_field($atts['walker']) : '';
	        $walker = !empty($walker_class) ? new $walker_class() : '';

	        // Set Depth
	        $depth = !empty($atts['depth']) ? absint($atts['depth']) : 0;

	        // Set Before Item Text
	        $before = !empty($atts['before']) ? sanitize_title($atts['before']) : '';

	        // Set After Item Text
	        $after = !empty($atts['']) ? sanitize_title($atts['after']) : '';

	        // Set Link Before Text
	        $link_before = !empty($atts['link_before']) ? sanitize_title($atts['link_before']) : '';

	        // Set Link After Text
	        $link_after = !empty($atts['link_after']) ? sanitize_title($atts['link_after']) : '';

	        // Item Wrapper
	        $items_wrap = !empty($atts['items_wrap']) ? sanitize_title($atts['items_wrap']) : '<ul id="%1$s" class="%2$s">%3$s</ul>';

	        // Item Class Used Within Navwalkers
	        $items_class = !empty($atts['items_class']) ? $atts['items_class'] : '';

	        // Preserve Spacing
	        $item_spacing = !empty($atts['item_spacing']) ? 'discard' : 'preserve';

	        // Divider/Item Classes
	        $divider = !empty($atts['divider']) ? sanitize_title($atts['divider']) : '';

	        // Return Menu
	        // @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
	        return wp_nav_menu(array(
	            'menu'              => sanitize_html_class($atts['menu']),
	            'container'         => $container,
	            'container_class'   => $container_class,
	            'container_id'      => $container_id,
	            'menu_class'        => $menu_class,
	            'menu_id'           => $menu_id,
	            'fallback_cb'       => $fallback,
	            'walker'            => $walker,
	            'depth'             => $depth,
	            'before'            => $before,
	            'after'             => $after,
	            'link_before'       => $link_before,
	            'link_after'        => $link_after,
	            'items_wrap'        => $items_wrap,
	            'items_class'       => $items_class,
	            'item_spacing'      => $item_spacing,
	            'divider'           => $divider,
	            'echo'              => false
	        ));
	    } 
	}


	/**
	 * Display Shortcode Metabox Content Within Menus Admin
	 *
	 * @param array $args orderby|slug|post_id
	 * @return html Filtered Content
	 */
	function metabox() {
		global $nav_menu_selected_id;
		echo '<input id="secretum-menus-mb-id" type="text" class="regular-text menu-item-textbox" value="[secretum_menus menu=&#x22;' . absint($nav_menu_selected_id) . '&#x22;]" style="width:100%" onclick="select()">';
		echo '<input id="secretum-menus-mb-id" type="text" class="regular-text menu-item-textbox" value="[secretum_menus menu=&#x22;' . absint($nav_menu_selected_id) . '&#x22; container=&#x22;&#x22; container_class=&#x22;&#x22; container_id=&#x22;&#x22; menu_class=&#x22;&#x22; menu_id=&#x22;&#x22; fallback=&#x22;&#x22; walker=&#x22;&#x22; depth=&#x22;&#x22; before=&#x22;&#x22; after=&#x22;&#x22; link_before=&#x22;&#x22; link_after=&#x22;&#x22; items_wrap=&#x22;&#x22; items_class=&#x22;&#x22; item_spacing=&#x22;&#x22; divider=&#x22;&#x22;]" style="width:100%" onclick="select()">';
	}


    /**
     * Activate Plugin
     */
    function activate()
    {
        // Wordpress Version Check
        global $wp_version;

        // Version Check
        if(version_compare($wp_version, SECRETUM_MENUS_WP_MIN_VERSION, "<")) {
            wp_die(__('Activation Failed: The ' . SECRETUM_MENUS_PAGE_NAME . ' plugin requires WordPress version ' . SECRETUM_MENUS_WP_MIN_VERSION . ' or higher. Please Upgrade Wordpress, then try activating this plugin again.', 'secretum-menus'));
        }
    }


    /**
     * Add Links
     *
     * @param array $links Default links for this plugin
     * @param string $file The name of the plugin being displayed
     * @return array $links The links to inject
     */
    function links($links, $file)
    {
        // Get Current URL
        $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        // Only this plugin and on plugins.php page
        if ($file == SECRETUM_MENUS_PLUGIN_BASE && strpos($request_uri, "plugins.php") !== false) {
            // Links To Inject
            $links[] = '<a href="https://github.com/SecretumTheme/secretum-menus/issues" target="_blank">'. __('Report Issues', 'secretum-menus') .'</a>';
        }

        return $links;
    }
}
