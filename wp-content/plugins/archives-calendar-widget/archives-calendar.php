<?php
/*
Plugin Name: Archives Calendar Widget
Plugin URI: http://labs.alek.be/
Description: Display archives as a calendar.
Version: 0.4.0
Author: Aleksei Polechin (alek´)
Author URI: http://alek.be
License: GPLv3

/***** LICENSE *****

	Archives Calendar Widget for Wordpress
	Copyright (C) 2013  Aleksei Polechin (http://alek.be)

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
****/

require('arw-options.php');

$_AC_POST_TYPE_FILTER = 'post';

add_filter( 'generate_rewrite_rules', 'generate_archiveCalendar_rewrite_rules' );
function generate_archiveCalendar_rewrite_rules( $wp_rewrite ) {

    $resources_rules = array(
        'resources/archive/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$' => 'index.php?post_type=resources&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]',
        'resources/archive/([0-9]{4})/([0-9]{1,2})/?$' => 'index.php?post_type=resources&year=$matches[1]&monthnum=$matches[2]',
        'resources/archive/([0-9]{4})/?$' => 'index.php?post_type=v&year=$matches[1]' 
    );

    $wp_rewrite->rules = $resources_rules + $wp_rewrite->rules;
}

function archiveCalendarMonthFilter($url, $year, $month) {
    global $_AC_POST_TYPE_FILTER;
    $url_parsed = parse_url($url);
    
    $link = $url_parsed['scheme'] . '://' . $url_parsed['host'];
    
    if (isset($url_parsed['port']))
        $link .= ':' . $url_parsed['port'];
    $link .= '/' . $_AC_POST_TYPE_FILTER . '/archive' . $url_parsed['path'];
    if (isset($url_parsed['query']))
        $link .= '?' . $url_parsed['query'];
    if (isset($url_parsed['fragment']))
        $link .= '?' . $url_parsed['fragment'];
    
    return $link;
    
    return $url . '?post_type=' . $_AC_POST_TYPE_FILTER;
}

// LOCALISATION
add_action('init', 'archivesCalendar_init');
function archivesCalendar_init() {
	load_plugin_textdomain('arwloc', false, dirname(plugin_basename(__FILE__)).'/languages');
}

// ACTIVATION
function archivesCalendar_activation($network_wide){
	global $wpdb;
	if (isMU()){ //isMU verifyes id the site is in Multisite mode
		// check if it is a network activation - if so, run the activation function for each blog id
		if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids =  $wpdb->get_results("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blogid) {
				$blog_id = $blogid->blog_id;
				switch_to_blog($blog_id);
				_archivesCalendar_activate();
			}
			switch_to_blog($old_blog);
			return;
		}   
	} 
	_archivesCalendar_activate();
}
function _archivesCalendar_activate()
{
	global $wpdb;	
	if(!get_option( 'archivesCalendar' ))
		$options = array(
			"css" => 1,
			"theme" => "default",
			"jquery" => 0,
			"js" => 1,
			"show_settings" => 1,
			"shortcode" => 0,
			"javascript" => "jQuery(document).ready(function($){\n\t$('.calendar-archives').archivesCW();\n});"
		);
	else
		$options = get_option( 'archivesCalendar' );
		
	if(isMU()) {
		update_blog_option($wpdb -> blogid, 'archivesCalendar', $options);
		add_blog_option($wpdb -> blogid, 'archivesCalendar', $options);
	}
	else {
		update_option('archivesCalendar', $options);
		add_option('archivesCalendar', $options);
	}
}
register_activation_hook(__FILE__, 'archivesCalendar_activation');

function archivesCalendar_new_blog($blog_id) {
	global $wpdb;
	if (is_plugin_active_for_network('archives-calendar/archives-calendar.php'))
	{
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		_archivesCalendar_activate();
		switch_to_blog($old_blog);
	}
}
add_action( 'wpmu_new_blog', 'archivesCalendar_new_blog', 10, 6); // in case of creation of a new site in WPMU


// UNINSTALL 
function archivesCalendar_uninstall(){
	global $wpdb;
	if (isMU())
	{
		$old_blog = $wpdb->blogid;
		$blogids =  $wpdb->get_results("SELECT blog_id FROM $wpdb->blogs");
		foreach ($blogids as $blogid) {
			$blog_id = $blogid->blog_id;
			switch_to_blog($blog_id);
			_archivesCalendar_uninstall();
		}
		switch_to_blog($old_blog);
		return;
	} 
	_archivesCalendar_uninstall();
}
function _archivesCalendar_uninstall(){
	global $wpdb;
	if (isMU()) delete_blog_option($wpdb->blogid, 'archivesCalendar');
	else delete_option('archivesCalendar');
}
register_uninstall_hook(__FILE__, 'archivesCalendar_uninstall');

// ADD Settings link in Plugins page when the plugin is activated
if(!function_exists('plugin_settings_link')){
	function plugin_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=archives_calendar">'.__( 'Settings' ).'</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
}
$acplugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$acplugin", 'plugin_settings_link' );


$archivesCalendar_options = get_option('archivesCalendar');

function archivesCalendar_jquery()
{
    wp_enqueue_script('jquery');
}

function archivesCalendar_jquery_plugin()
{
	wp_register_script( 'archivesCW', plugins_url(). '/archives-calendar-widget/jquery.archivesCW.min.js', 
                array('jquery') );
	wp_enqueue_script( 'archivesCW');
}

function archivesCalendar_js() {
	global $archivesCalendar_options;
?>
<script type="text/javascript">
	<?php echo $archivesCalendar_options['javascript']; ?>
</script>
<?php
}

function archives_calendar_styles(){
	$archivesCalendar_options = get_option('archivesCalendar');
	wp_register_style( 'archives-cal-css', plugins_url('themes/'.$archivesCalendar_options['theme'].'.css', __FILE__));
	wp_enqueue_style('archives-cal-css');
}

if($archivesCalendar_options['css'] == 1)	add_action('wp_enqueue_scripts', 'archives_calendar_styles');
if($archivesCalendar_options['js'] == 1) add_action('wp_head', 'archivesCalendar_js');
if($archivesCalendar_options['jquery'] == 1) add_action( 'wp_enqueue_scripts', 'archivesCalendar_jquery' );
// in all cases the jQuery plugin must be included
add_action( 'wp_enqueue_scripts', 'archivesCalendar_jquery_plugin' );



/***** WIDGET CLASS *****/
class Archives_Calendar extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'archives_calendar',
			'Archives Calendar',
			array( 'description' => __( 'Show archives as calendar', 'arwloc' ), )
		);
	}
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		$instance['function'] = 'no';
		echo archive_calendar($instance);
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['prev_text'] = $new_instance['prev_text'];
		$instance['next_text'] = $new_instance['next_text'];
		$instance['post_count'] = $new_instance['post_count'];
		$instance['month_view'] = $new_instance['month_view'];
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'      => __( 'Archives' ),
			'next_text' => '>',
			'prev_text' => '<',
			'post_count' => 1,
			'month_view' => 0,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$prev = $instance['prev_text'];
		$next = $instance['next_text'];
		$count = $instance['post_count'];
		$month_view = $instance['month_view'];
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'prev_text' ); ?>"><?php _e( 'Previous button text:', 'arwloc' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'prev_text' ); ?>" name="<?php echo $this->get_field_name( 'prev_text' ); ?>" type="text" value="<?php echo esc_attr( $prev ); ?>" />
		<label for="<?php echo $this->get_field_id( 'next_text' ); ?>"><?php _e( 'Next button text:', 'arwloc' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'next_text' ); ?>" name="<?php echo $this->get_field_name( 'next_text' ); ?>" type="text" value="<?php echo esc_attr( $next ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Show number of posts:', 'arwloc' ); ?></label> 
		<select name="<?php echo $this->get_field_name( 'post_count' ); ?>" >
			<option <?php selected( 1, $count ); ?> value="1">
				<?php _e( 'Yes', 'arwloc' ); ?>
			</option>
			<option <?php selected( 0, $count ); ?> value="0">
				<?php _e( 'No', 'arwloc' ); ?>
			</option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'month_view' ); ?>"><?php _e( 'Show' ).': '; ?></label> 
		<select name="<?php echo $this->get_field_name( 'month_view' ); ?>" >
			<option <?php selected( 1, $month_view ); ?> value="1">
				<?php _e( 'Months' ); ?>
			</option>
			<option <?php selected( 0, $month_view ); ?> value="0">
				<?php _e( 'Years' ); ?>
			</option>
		</select>
		</p>
		<?php 
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "Archives_Calendar" );' ) );

/***** WIDGET CONSTRUCTION FUNCTION *****/
/* can be called directly archive_calendar($args) */
function archive_calendar($args = array())
{
	global $wpdb, $_AC_POST_TYPE_FILTER;
	$aloc = 'arwloc';

	$defaults = array(
		'next_text' => '>',
		'prev_text' => '<',
		'post_count' => true,
		'month_view' => false,
                'post_type' => 'post',
	);
	$args = wp_parse_args( (array) $args, $defaults );
        $_AC_POST_TYPE_FILTER = $args['post_type'];

	if($args['month_view'] == false)
		$cal = archives_year_view($args);
	else
		$cal = archives_month_view($args);

	if($function == "no")
		return $cal;
	echo $cal;
}

/* displays years */
function archives_year_view($args)
{
	global $wpdb, $wp_locale, $_AC_POST_TYPE_FILTER;
        if ($_AC_POST_TYPE_FILTER != 'post')
            add_filter( 'month_link', 'archiveCalendarMonthFilter', 10, 3 );
	extract($args);

	$aloc = 'arwloc';

	$mnames[0] = '';

	for($i=1; $i<13; $i++)
	{
		$monthdate = '1970-'. sprintf('%02d', $i) .'-01';		
		$mnames[$i] = $wp_locale->get_month_abbrev( $wp_locale->get_month(intval($i)) );
	}
	/* month names definitions in case if localisation of wordpress is not apreciated by users */
	//$mnames = array( '', __('Jan', $aloc), __('Feb', $aloc), __('Mar', $aloc), __('Apr', $aloc), __('May', $aloc), __('Jun', $aloc), __('Jul', $aloc), __('Aug', $aloc), __('Sep', $aloc), __('Oct', $aloc), __('Nov', $aloc), __('Dec', $aloc) );	

	$results = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month FROM $wpdb->posts WHERE post_type='" . $_AC_POST_TYPE_FILTER . "' AND post_status='publish' AND post_password='' ORDER BY year DESC, month DESC");
	
	$years = array();
	foreach ($results as $date)
	{
		if($post_count)
		{
			$postcount = $wpdb->get_results("SELECT COUNT(ID) AS count FROM $wpdb->posts WHERE post_type='" . $_AC_POST_TYPE_FILTER . "' AND post_status='publish' AND post_password='' AND YEAR(post_date) = $date->year AND MONTH(post_date) = $date->month");
			$count = $postcount[0]->count;
		}
		else 
			$count = 0;
		$years[$date->year][$date->month] = $count;
	}

	$totalyears = count($years);

	$yearNb = array();
	foreach ($years as $year => $months)
		$yearNb[] = $year;
	
	if(is_archive())
	{
		global $post;
		$archiveYear = date('Y', strtotime($post->post_date)); // year to be visible
	}
	else
		$archiveYear = $yearNb[0]; // if no current year -> show the more recent

	$nextyear = ($totalyears > 1) ? '<a href="#" class="next-year"><span>'.$next_text.'</span></a>' : '';
	$prevyear = ($totalyears > 1) ? '<a href="#" class="prev-year"><span>'.$prev_text.'</span></a>' : '';
	
	$cal = "\n<!-- Archives Calendar Widget by Aleksei Polechin - alek´ - http://alek.be -->\n";
	$cal.= '<div class="calendar-archives" id="arc-'.$title.'-'.mt_rand(10,100).'">';
	$cal.= '<div class="cal-nav">'.$prevyear.'<div class="year-nav">';
		//$cal .=  '<a href="'.get_year_link($archiveYear).'" class="year-title">'.$archiveYear.'</a>';
                $cal .=  '<span class="year-title">'.$archiveYear.'</span>';
		$cal .= '<div class="year-select">';
		$i=0;
		foreach( $yearNb as $year )
		{
			$current = ($archiveYear == $year) ? " current" : "";
			$cal.= '<a href="'.get_year_link($year).'" class="year '.$year.$current.'" rel="'.$i.'" >'.$year.'</a>';
			$i++;
		}
		$cal.= '</div>';
		if ($totalyears > 1)
			$cal.= '<div class="arrow-down" title="'.__("Select archives year", $aloc).'"><span>&#x25bc;</span></div>';
	$cal.= '</div>'.$nextyear.'</div>';
	$cal.= '<div class="archives-years">';

	$i=0;

	foreach ($years as $year => $months)
	{
		$lastyear = ($i == $totalyears-1 ) ? " last" : "";
		$current = ($archiveYear == $year) ? " current" : "";

		$cal .= '<div class="year '.$year.$lastyear.$current.'" rel="'.$i.'">';
		for ( $month = 1; $month <= 12; $month++ )
		{
			$last = ( $month%4 == 0 ) ? ' last' : '';
			if($post_count)
			{
				if(isset($months[$month])) $count = $months[$month];
				else $count = 0;
				$posts_text = ($count == 1) ? __('Post', 'archives_calendar') : __('Posts', 'arwloc');

				$postcount = '<span class="postcount"><span class="count-number">'.$count.'</span> <span class="count-text">'.$posts_text.'</span></span>';
			}
			else
				$postcount = "";
			if(isset($months[$month]))
				$cal .= '<div class="month'.$last.'"><a href="'.get_month_link($year, $month).'"><span class="month-name">'.$mnames[$month].'</span>'.$postcount.'</a></div>';
			else
				$cal .= '<div class="month'.$last.' empty"><span class="month-name">'.$mnames[$month].'</span>'.$postcount.'</div>';
		}
		$cal .= "</div>\n";
		$i++;
	}
	$cal .= "</div></div>";
        remove_filter( 'month_link', 'archiveCalendarMonthFilter', 10, 3 );

	return $cal;
}

/* displays months */
function archives_month_view($args)
{
	global $wpdb, $wp_locale, $post, $_AC_POST_TYPE_FILTER;
        if ($_AC_POST_TYPE_FILTER != 'post')
            add_filter( 'month_link', 'archiveCalendarMonthFilter', 10, 3 );
	extract($args);

	// Select all months where are posts
	$months = $wpdb->get_results("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year FROM $wpdb->posts WHERE post_type='" . $_AC_POST_TYPE_FILTER . "' AND post_status='publish' AND post_password='' ORDER BY year DESC, month DESC");

	$totalmonths = count($months);

	if(is_archive())
	{
		$archiveMonth = date('m', strtotime($post->post_date)); // year to be visible
		$archiveYear = date('Y', strtotime($post->post_date)); // year to be visible
	}
	else
	{
		$archiveYear = $months[0]->year; // if no current year -> show the more recent
		$archiveMonth = $months[0]->month; // year to be visible
	}

	$nextmonth = ($totalmonths > 1) ? '<a href="#" class="next-year"><span>'.$next_text.'</span></a>' : '';
	$prevmonth = ($totalmonths > 1) ? '<a href="#" class="prev-year"><span>'.$prev_text.'</span></a>' : '';
	
	$cal = "\n<!-- Archives Calendar Widget by Aleksei Polechin - alek´ - http://alek.be -->\n";
	$cal.= '<div class="calendar-archives" id="arc-'.$title.'-'.mt_rand(10,100).'">';
	$cal.= '<div class="cal-nav months">'.$prevmonth.'<div class="year-nav months">';
		$cal .=  '<a href="'.get_month_link( intval($archiveYear), intval($archiveMonth) ).'" class="year-title">'.$wp_locale->get_month(intval($archiveMonth)).' '.$archiveYear.'</a>';
		$cal .= '<div class="year-select">';
		$i=0;
		foreach( $months as $month )
		{
			$current = ($archiveYear == $month->year && $archiveMonth == $month->month) ? " current" : "";
			$cal.= '<a href="'.get_month_link( intval($month->year), intval($month->month) ).'" class="year '.$month->year.' '.$month->month.$current.'" rel="'.$i.'" >'.$wp_locale->get_month(intval($month->month)).' '.$month->year.'</a>';
			$i++;
		}
		$cal.= '</div>';
		if ($totalmonths > 1) $cal.= '<div class="arrow-down" title="'.__("Select archives year", $aloc).'"><span>&#x25bc;</span></div>';
	$cal.= '</div>'.$nextmonth.'</div>';

	// Display week days names
	$week_begins = intval(get_option('start_of_week'));
	for ($wdcount=0; $wdcount<=6; $wdcount++ )
	{
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}
	$i=1;
	$cal .= '<div class="week-row">';
	foreach ( $myweek as $wd )
	{
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$last = ($i%7 == 0) ? " last" : "";
		$cal .= '<span class="day weekday'.$last.'">'.$day_name.'</span>';
		$i++;
	}

	$cal.= '</div><div class="archives-years">';

	// for each month
	for($i = 0; $i < $totalmonths; $i++)
	{
		$lastyear = ($i == $totalmonths-1 ) ? " last" : "";
		$current = ($archiveYear == $months[$i]->year && $archiveMonth == $months[$i]->month) ? " current" : "";

		// select days with posts
		$sql = "SELECT DAY(post_date) AS day
		 FROM $wpdb->posts 
		 WHERE post_type='" . $_AC_POST_TYPE_FILTER . "' 
		 AND YEAR(post_date) = ".$months[$i]->year."
		 AND MONTH(post_date) = ".$months[$i]->month."
		 AND post_status='publish' 
		 AND post_password=''
		 GROUP BY day";
		$days = $wpdb->get_results( $sql, ARRAY_N);

		$dayswithposts = array();
		for($j = 0; $j< count($days); $j++)
		{
			$dayswithposts[] = $days[$j][0];
		}


		$cal .= '<div class="year '.$months[$i]->month.' '.$months[$i]->year.$lastyear.$current.'" rel="'.$i.'">';
		// 1st of month date
		$firstofmonth = $months[$i]->year.'-'. intval($months[$i]->month) .'-01';
		// first weekday of the month
		$firstweekday = date('w', strtotime("$firstofmonth"));

		$cal .= '<div class="week-row">';

		$k = 0; // total grid days counter
		$j = $week_begins;

		while( $j != $firstweekday )
		{
			$k++;
			$last = ($k%7 == 0) ? " last" : "";
			$cal .= '<span class="day noday'.$last.'">&nbsp;</span>';
			$j++;
			if($j == 7)
				$j = 0;
		}

		$monthdays = month_days($months[$i]->year, $months[$i]->month);

		for($j = 1; $j <= $monthdays; $j++)
		{
			$k++;
			$last = ($k%7 == 0) ? " last" : "";

			if(in_array ( $j , $dayswithposts ) )
				$cal .= '<span class="month day'.$last.'"><a href="'.get_day_link( $months[$i]->year, $months[$i]->month, $j ).'">'.$j.'</a></span>';
			else
				$cal .= '<span class="month day'.$last.' empty">'.$j.'</span>';

			if($k%7 == 0)
				$cal .= "</div>\n<div class=\"week-row\">\n";
		}

		while( $k < 42)
		{
			$k++;
			$last = ($k%7 == 0) ? " last" : "";
			$cal .= '<span class="day noday'.$last.'">&nbsp;</span>';	
			if($k%7 == 0)
				$cal .= "</div>\n<div class=\"week-row\">\n";		
		}
			$cal .= "</div>\n";
		$cal .= "</div>\n";
	}

	$cal .= "</div></div>";	

        remove_filter( 'month_link', 'archiveCalendarMonthFilter', 10, 3 );
	return $cal;
}


/***** SHORTCODE *****/
if($archivesCalendar_options['shortcode']){
	add_filter( 'widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');
}

function archivesCalendar_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'next_text' => '>',
		'prev_text' => '<',
		'post_count' => true,
		'month_view' => false
	), $atts ) );

	$post_count = ($post_count == "true") ? true : false;
	$month_view = ($month_view == "true") ? true : false;
	$defaults = array(
		'next_text' => $next_text,
		'prev_text' => $prev_text,
		'post_count' => $post_count,
		'month_view' => $month_view,
		'function' => 'no',
	);
	
	return archive_calendar($defaults);
}
add_shortcode( 'arcalendar', 'archivesCalendar_shortcode' );

function month_days($year, $month)
{
    switch(intval($month))
	{
		case 4: case 6: case 9: case 11:
			return 30;
		case 2:
		if( $year%400==0 || ( $year%100 != 00 && $year%4==0 ) )
			return 29;
		return 28;

		default:
			return 31;
	}
}
function ac_checked($option, $value = 1){
	$options = get_option('archivesCalendar');
	if($options[$option] == $value) echo 'checked="checked"';
}

if (!function_exists('isMU')){
	function isMU(){
		if (function_exists('is_multisite') && is_multisite()) return true;
		else return false;
	}
}
?>