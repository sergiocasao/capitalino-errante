<?php
//Hook Widget
add_action( 'widgets_init', 'spotify_master_widget_buttons' );
//Register Widget
function spotify_master_widget_buttons() {
register_widget( 'spotify_master_widget_buttons' );
}

class spotify_master_widget_buttons extends WP_Widget {
	function __construct(){
	$widget_ops = array( 'classname' => 'Spotify Master Buttons', 'description' => __('Spotify Master Buttons Widget allows you to display the Spotify Profile Connect Button.', 'spotify_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'spotify_master_widget_buttons' );
	parent::__construct( 'spotify_master_widget_buttons', __('Spotify Master Buttons', 'spotify_master'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
	global $wpdb, $blog_id;
		extract( $args );
		//Set Network Options
		$spotify_master_load_size_basic = "spotify_master_load_size_basic";
		$spotify_master_load_size_detailed = "spotify_master_load_size_detailed";
		$spotify_master_load_theme_light = "spotify_master_load_theme_light";
		$spotify_master_load_theme_dark = "spotify_master_load_theme_dark";
		if(is_multisite()){
		add_blog_option ($blog_id, 'spotify_master_load_size_basic', $spotify_master_load_size_basic);
		add_blog_option ($blog_id, 'spotify_master_load_size_detailed', $spotify_master_load_size_detailed);
		add_blog_option ($blog_id, 'spotify_master_load_theme_light', $spotify_master_load_theme_light);
		add_blog_option ($blog_id, 'spotify_master_load_theme_dark', $spotify_master_load_theme_dark);
		}
		else{
		add_option ('spotify_master_load_size_basic', $spotify_master_load_size_basic);
		add_option ('spotify_master_load_size_detailed', $spotify_master_load_size_detailed);
		add_option ('spotify_master_load_theme_light', $spotify_master_load_theme_light);
		add_option ('spotify_master_load_theme_dark', $spotify_master_load_theme_dark);
		}
		//Our variables from the widget settings.
		$spotify_title = isset( $instance['spotify_title'] ) ? $instance['spotify_title'] :false;
		$spotify_title_new = isset( $instance['spotify_title_new'] ) ? $instance['spotify_title_new'] :false;
		$show_spotifybutton = isset( $instance['show_spotifybutton'] ) ? $instance['show_spotifybutton'] :false;
		$spotifybutton_uri = isset( $instance['spotifybutton_uri'] ) ? $instance['spotifybutton_uri'] :false;
		$spotifybutton_size_choice = isset( $instance['spotifybutton_size_choice'] ) ? $instance['spotifybutton_size_choice'] :false;
		$spotifybutton_theme_choice = isset( $instance['spotifybutton_theme_choice'] ) ? $instance['spotifybutton_theme_choice'] :false;
		$spotifybutton_count = isset( $instance['spotifybutton_count'] ) ? $instance['spotifybutton_count'] :false;
		echo $before_widget;
	// Display the widget title
		if ( $spotify_title ){
			if (empty ($spotify_title_new)){
				$spotify_title_new = constant('SPOTIFY_MASTER_NAME');
				echo $before_title . $spotify_title_new . $after_title;
			}
			else{
				echo $before_title . $spotify_title_new . $after_title;
			}
		}
		else{
		}
	//Display Spotify Profile Button
		if ( $show_spotifybutton ){
			if(is_multisite()){
				$spotifybutton_size_choice = get_blog_option($blog_id, 'spotifybutton_size_choice');
				$spotifybutton_theme_choice = get_blog_option($blog_id, 'spotifybutton_theme_choice');
			}
			else{
				$spotifybutton_size_choice = get_option('spotifybutton_size_choice');
				$spotifybutton_theme_choice = get_option('spotifybutton_theme_choice');
			}
			
			if ( $spotifybutton_size_choice == 'spotify_master_load_size_basic' ){
				$spotifybutton_size_create = 'basic';
				$spotifybutton_size_pixels = 'width="200" height="25"';
			}
			else{
				$spotifybutton_size_create = 'detail';
				$spotifybutton_size_pixels = 'width="300" height="56"';
			}
			
			if ( $spotifybutton_theme_choice == 'spotify_master_load_theme_light' ){
				$spotifybutton_theme_create = 'light';
			}
			else{
				$spotifybutton_theme_create = 'dark';
			}
			if ( $spotifybutton_count){
			$spotifybutton_count_create = false;
			}
			else{
			$spotifybutton_count_create = '&show-count=0';
			}
		echo '<iframe src="https://embed.spotify.com/follow/1/?uri='.$spotifybutton_uri.'&size='.$spotifybutton_size_create.'&theme='.$spotifybutton_theme_create.''.$spotifybutton_count_create.'" '.$spotifybutton_size_pixels.' scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe>';
		}
		else{
		}
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
	global $wpdb, $blog_id;
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['spotify_title'] = strip_tags( $new_instance['spotify_title'] );
		$instance['spotify_title_new'] = $new_instance['spotify_title_new'];
		$instance['show_spotifybutton'] = $new_instance['show_spotifybutton'];
		$instance['spotifybutton_uri'] = $new_instance['spotifybutton_uri'];
		$instance['spotifybutton_size_choice'] = $new_instance['spotifybutton_size_choice'];
		$instance['spotifybutton_theme_choice'] = $new_instance['spotifybutton_theme_choice'];
		if(is_multisite()){
		update_blog_option($blog_id, 'spotifybutton_size_choice', $new_instance['spotifybutton_size_choice']);
		update_blog_option($blog_id, 'spotifybutton_theme_choice', $new_instance['spotifybutton_theme_choice']);
		}
		else{
		update_option('spotifybutton_size_choice', $new_instance['spotifybutton_size_choice']);
		update_option('spotifybutton_theme_choice', $new_instance['spotifybutton_theme_choice']);
		}
		$instance['spotifybutton_count'] = $new_instance['spotifybutton_count'];
		return $instance;
	}
	function form( $instance ) {
	global $wpdb, $blog_id;
	//Set up some default widget settings.
	$defaults = array( 'spotify_title_new' => __('Spotify Master', 'spotify_master'), 'spotify_title' => true, 'spotify_title_new' => false, 'show_spotifybutton' => false, 'spotifybutton_uri' => false, 'spotifybutton_size_choice' => false, 'spotifybutton_theme_choice' => false, 'spotifybutton_count' => true );
	$instance = wp_parse_args( (array) $instance, $defaults );
	//multisite options for plugin name
	if(is_multisite()){
		$spotifybutton_size_choice = get_blog_option($blog_id, 'spotifybutton_size_choice');
		$spotify_master_load_size_detailed = get_blog_option($blog_id, 'spotify_master_load_size_detailed');
		$spotify_master_load_size_basic = get_blog_option($blog_id, 'spotify_master_load_size_basic');
		$spotifybutton_theme_choice = get_blog_option($blog_id, 'spotifybutton_theme_choice');
		$spotify_master_load_theme_light = get_blog_option($blog_id, 'spotify_master_load_theme_light');
		$spotify_master_load_theme_dark = get_blog_option($blog_id, 'spotify_master_load_theme_dark');
	}
	else{
		$spotifybutton_size_choice = get_option('spotifybutton_size_choice');
		$spotify_master_load_size_detailed = get_option('spotify_master_load_size_detailed');
		$spotify_master_load_size_basic = get_option('spotify_master_load_size_basic');
		$spotifybutton_theme_choice = get_option('spotifybutton_theme_choice');
		$spotify_master_load_theme_light = get_option('spotify_master_load_theme_light');
		$spotify_master_load_theme_dark = get_option('spotify_master_load_theme_dark');
	}
	$plugin_master_name = constant('SPOTIFY_MASTER_NAME');
	?>
		<br>
		<p><b>Check the buttons to be displayed:</b></p>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['spotify_title'], true ); ?> id="<?php echo $this->get_field_id( 'spotify_title' ); ?>" name="<?php echo $this->get_field_name( 'spotify_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'spotify_title' ); ?>"><b><?php _e('Display Widget Title', 'spotify_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'spotify_title_new' ); ?>"><?php _e('Change Title:', 'spotify_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'spotify_title_new' ); ?>" name="<?php echo $this->get_field_name( 'spotify_title_new' ); ?>" value="<?php echo $instance['spotify_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; width:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_spotifybutton'], true ); ?> id="<?php echo $this->get_field_id( 'show_spotifybutton' ); ?>" name="<?php echo $this->get_field_name( 'show_spotifybutton' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_spotifybutton' ); ?>"><b><?php _e('Spotify Profile Button', 'spotify_master'); ?></b></label><br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'spotifybutton_uri' ); ?>"><?php _e('insert Spotify Profile URI:', 'spotify_master'); ?></label></br>
	<input id="<?php echo $this->get_field_id( 'spotifybutton_uri' ); ?>" name="<?php echo $this->get_field_name( 'spotifybutton_uri' ); ?>" value="<?php echo $instance['spotifybutton_uri']; ?>" style="width:auto;" />
	<div class="description">User or Artist URI example:</div>
	<div class="description"><b>spotify:artist:1vCWHaC5f2uS3yhpwWbIA6</b></div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'spotifybutton_size_choice' ); ?>"><?php _e('Select Button Detail:', 'spotify_master'); ?></label></br>
	<select id="<?php echo $this->get_field_id( 'spotifybutton_size_choice' ); ?>" name="<?php echo $this->get_field_name( 'spotifybutton_size_choice' ); ?>" style="width:140px">
	<option value="<?php echo $spotify_master_load_size_detailed; ?>" <?php echo $spotifybutton_size_choice == 'spotify_master_load_size_detailed' ? 'selected="selected"':''; ?>>Detailed Button</option>
	<option value="<?php echo $spotify_master_load_size_basic; ?>" <?php echo $spotifybutton_size_choice == 'spotify_master_load_size_basic' ? 'selected="selected"':''; ?>>Basic Button</option>
	</select>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'spotifybutton_theme_choice' ); ?>"><?php _e('Select Button Theme:', 'spotify_master'); ?></label></br>
	<select id="<?php echo $this->get_field_id( 'spotifybutton_theme_choice' ); ?>" name="<?php echo $this->get_field_name( 'spotifybutton_theme_choice' ); ?>" style="width:140px">
	<option value="<?php echo $spotify_master_load_theme_light; ?>" <?php echo $spotifybutton_theme_choice == 'spotify_master_load_theme_light' ? 'selected="selected"':''; ?>>Light Theme</option>
	<option value="<?php echo $spotify_master_load_theme_dark; ?>" <?php echo $spotifybutton_theme_choice == 'spotify_master_load_theme_dark' ? 'selected="selected"':''; ?>>Dark Theme</option>
	</select>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['spotifybutton_count'], true ); ?> id="<?php echo $this->get_field_id( 'spotifybutton_count' ); ?>" name="<?php echo $this->get_field_name( 'spotifybutton_count' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'spotifybutton_count' ); ?>"><b><?php _e('Activate Bubble Count', 'spotify_master'); ?></b></label><br>
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
		<p>
		<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; width:18px; vertical-align:middle;" />
		&nbsp;
		<b><?php echo $plugin_master_name; ?> Website</b>
		</p>
		<p><a class="button-secondary" href="https://wordpress.techgasp.com/spotify-master/" target="_blank" title="<?php echo $plugin_master_name; ?> Info Page">Info Page</a> <a class="button-secondary" href="https://wordpress.techgasp.com/spotify-master-documentation/" target="_blank" title="<?php echo $plugin_master_name; ?> Documentation">Documentation</a> <a class="button-primary" href="https://wordpress.techgasp.com/spotify-master/" target="_blank" title="Get Add-ons">Get Add-ons</a></p>
	<?php
	}
 }
?>
