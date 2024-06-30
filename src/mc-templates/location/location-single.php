<?php
/**
 * Template: Single Location.
 *
 * @category Templates
 * @package  My Calendar
 * @author   Joe Dolson
 * @license  GPLv2 or later
 * @link     https://www.joedolson.com/my-calendar/
 */

/**
 * Location templates access any template tags using the function `mc_template_tag`. The object $event is available in all templates.
 */
?>
<div class="mc-location mc-view-location">
    <div style="display:flex;justify-content:right;">
    	<div class="mc-location-hcard column" style="width:60%">' . mc_hcard( $data, 'true', 'true', 'location' ) . '</div>
	    <div class="mc-location-gmap column">' . mc_generate_map( $data, 'location' ) . '</div>
    </div>
	<div class="mc-location-upcoming"><h2>' . __( 'Upcoming Events', 'my-calendar' ) . '</h2>' . $data['events'] . '</div>
</div>
