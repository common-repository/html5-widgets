<?php
/*
Plugin Name: HTML5 Widgets
Plugin URI: http://wizardinternetsolutions.com/plugins/html5-widgets/
Description: Allows you to select the proper html5 wrapper for each widget, weather it be aside, section, nav etc. 
Author: Wizard Internet Solutions
Version: 0.9.1
Author URI: http://wizardinternetsolutions.com
*/
// wp-includes/widgets.php:273
add_action('in_widget_form',         array('HTML5Widgets', 'in_widget_form'), 10, 3); 
add_filter('widget_update_callback', array('HTML5Widgets', 'widget_update_callback'), 10, 4);
add_filter('dynamic_sidebar_params', array('HTML5Widgets', 'dynamic_sidebar_params'), 10, 1000);
add_filter('sidebar_admin_setup',    array('HTML5Widgets', 'sidebar_admin_setup'));
class HTML5Widgets {
	function sidebar_admin_setup() {
		global $wp_registered_widget_controls;
		foreach ($wp_registered_widget_controls as $widget_id => $options) {
			if (is_array($options['callback'])) {
				continue;
			}
			$wp_registered_widget_controls[$widget_id]['_params']   = $wp_registered_widget_controls[$widget_id]['params'];
			$wp_registered_widget_controls[$widget_id]['_callback'] = $wp_registered_widget_controls[$widget_id]['callback'];
			$wp_registered_widget_controls[$widget_id]['params']    = $widget_id;
			$wp_registered_widget_controls[$widget_id]['callback']  = array(__CLASS__, 'intercept');
		}
	}
	/**
     * Modify the before_widget & after_widget
     */
	function dynamic_sidebar_params($params) {
		global $wp_registered_sidebars, $wp_registered_widgets;
		$widget_id = $params[0]['widget_id'];
		$widget = $wp_registered_widgets[$widget_id];
		$instance = $widget['callback'][0]->get_settings();
		$instance = $instance[$params[1]['number']];
		$type = $instance['html5_widget_type'];
		if($type=='none') $type = 'div';
		$before_search = array('/<div(.*?class="widget[^>])(.*?>)/','/<article(.*?class="widget[^>])(.*?>)/','/<li(.*?class="widget[^>])(.*?>)/');
		$after_search = array('</div>','</article>','</li>');
		$params[0]['before_widget'] = preg_replace('/<(article|div|li)(.*?class="widget[^>])(.*?>)/', '<'.$type.'$2$3' , $params[0]['before_widget'], 1);
		$params[0]['after_widget'] = preg_replace('/<\/(article|div|li)>$/', '</'.$type.'>' , $params[0]['after_widget'], 1);
		return $params;
	}
	/**
     * Our hook which allows us to intercept and inject into widgets which
     * do not use WP_Widget
     */
	 /*
	function intercept($widget_id) {
		global $wp_registered_widget_controls;
		$callback = $wp_registered_widget_controls[$widget_id]['_callback'];
		$params   = $wp_registered_widget_controls[$widget_id]['_params'];

		$return   = call_user_func_array($callback, $params);

		$options = get_option('html5_widget_type', array());

		if (! array_key_exists($widget_id, $options)) {
			$options[$widget_id] = '';
		}

		$old_class = $new_class = $options[$widget_id];

		if (array_key_exists($widget_id . '-class', $_POST)) {
			$new_class = $options[$widget_id] = $_POST[$widget_id . '-class'];
		}

		self::form($widget_id . '-class', $widget_id . '-class', $new_class);

		if ($old_class != $new_class) {
			update_option('html5_widget_type', $options);
		}

		return $return;
	} */
	/**
     * Hook used by WP_Widget and its children
     */
	function in_widget_form($widget, $return, $instance) {
		$instance = wp_parse_args( (array) $instance, array( 'html5_widget_type' => '' ) );
		$html5_widget_type = strip_tags($instance['html5_widget_type']);
		$return = null;
		self::form($widget->get_field_id('html5_widget_type'), $widget->get_field_name('html5_widget_type'), $html5_widget_type);
	}
	/**
     * Add Options to WP Widgets
     */
	function form($id, $name, $value) { 
    	$val = esc_attr($value); ?>
		<p>
			<label>
				HTML5 Widget Type:
                <select id="<?php echo $id; ?>" name="<?php echo $name; ?>">
                  <option <?php if($val == 'none') echo 'selected="yes" '?>value="none">None</option>
                  <option <?php if($val == 'aside') echo 'selected="yes" '?>value="aside">Aside</option>
                  <option <?php if($val == 'article') echo 'selected="yes" '?>value="article">Article</option>
                  <option <?php if($val == 'section') echo 'selected="yes" '?>value="section">Section</option>
                  <option <?php if($val == 'nav') echo 'selected="yes" '?>value="nav">Navigation</option>
                </select>
			</label>
		</p>
<?php
	}
	/**
     * Update Settings on Save
     */
	function widget_update_callback($instance, $new_instance, $old_instance, $widget) {
		if (array_key_exists('html5_widget_type', $new_instance)) {
			$instance['html5_widget_type'] = str_replace(',', ' ', $new_instance['html5_widget_type']);
		}
		return $instance;
	}
}