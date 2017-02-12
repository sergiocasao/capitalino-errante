<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class spotify_master_admin_widgets_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
	$plugin_master_name = constant('SPOTIFY_MASTER_NAME');
?>
<table class="widefat" cellspacing="0">
	<thead>
		<tr>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Screenshot', 'spotify_master'); ?></h2></th>
			<th><h2><img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" /><?php _e('&nbsp;Description', 'spotify_master'); ?></h2></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th><a class="button-primary" href="<?php echo get_site_url(); ?>/wp-admin/widgets.php" title="To Widgets Page" style="float:left;">To Widgets Page</a></p></th>
			<th><a class="button-primary" href="<?php echo get_site_url(); ?>/wp-admin/widgets.php" title="To Widgets Page" style="float:right;">To Widgets Page</a></p></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-buttons.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Buttons Widget</h3><p>The perfect widget if you only want to display the Spotify Profile Connect Button. A great way to connect people or display your cool Spotify profile.</p><p>This widget works great when published under any of the below players. Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-dashboard.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Administrator Dashboard Widget</h3><p>Cool player widget to listen to your favourite Spotify musics while working on your Wordpress Administrator. Check add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-discography.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Spotify Discography Widget</h3><p>Fast loading widget to display and play artists discography. A great way to connect people to Spotify Profiles and Discographies.</p><p>Check add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-basic.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Basic Player Widget</h3><p>The Basic spotify Player Widget was specially designed for fast loading times and is perfect to display a single music or a minimized player. All player options are on automatic settings so it's easy and fast to deploy by any wordpress administrator.</p><p>This widget is fully <b>Mobile Responsive</b>, check add-ons page.</p></td>
		</tr>
		<tr class="alternate">
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-advanced.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Advanced Player Widget</h3><p>The "top of the line" Advanced Spotify Player Widget was specially designed to display Spotify Musics, Playlists, Albums or Artists and to you grant access to the Spotify Player Size and includes the Spotify Profile if you decide to display it. <p>Extremely easy to use, this widget is fully <b>Mobile Responsive</b>, check add-ons page.</p></td>
		</tr>
		<tr>
			<td style="vertical-align:middle"><img src="<?php echo plugins_url('images/techgasp-spotifymaster-admin-widget-play.png', dirname(__FILE__)); ?>" alt="<?php echo $plugin_master_name; ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td style="vertical-align:middle"><h3>Easy Play Widget</h3><p>Specially designed to display Spotify Musics, Playlists, Albums or Artists. Easy to use and packed with options, all your fans have to do is hit “Play” to enjoy the music.</p><p>This widget is fully <b>Mobile Responsive</b>, check the add-ons page.</p></td>
		</tr>
	</tbody>
</table>
<?php
		}
}
