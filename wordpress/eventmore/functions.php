

//  Event Calendar Translations

/**
 * Modify the "bases" used to form event URLs for various views. Wire up our code used to modify event slugs in the rewrite rules.
 *
 * @param array $bases
 * @return array
 */
function rename_event_view_slugs( $bases ) {
	if ( isset( $bases['month'] ) ) $bases['month'] = [ 'kuukausi', 'kuukausi' ];
	if ( isset( $bases['list'] ) )  $bases['list']  = [ 'lista', 'lista' ];
	return $bases;
}
add_filter( 'tribe_events_rewrite_base_slugs', 'rename_event_view_slugs', 20 );


/**
 * Add Events to RSS Feed
 */ 
function add_events_to_rss_feed( $args ) {
  if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )
    $args['post_type'] = array('post', 'tribe_events');
  return $args;
}
add_filter( 'request', 'add_events_to_rss_feed' );

// Add Tribe Event Namespace
add_action( 'rss2_ns', 'events_rss2_namespace' );
 
function events_rss2_namespace() {
    echo 'xmlns:ev="http://purl.org/rss/2.0/modules/event/"'."\n";
}
 
// Add Event Dates to RSS Feed
add_action('rss_item','tribe_rss_feed_add_eventdate');
add_action('rss2_item','tribe_rss_feed_add_eventdate');
add_action('commentsrss2_item','tribe_rss_feed_add_eventdate');
 
function tribe_rss_feed_add_eventdate() {
  if ( ! tribe_is_event() ) return;
  $post_id = get_the_ID();
  ?>
  <ev:tribe_event_meta xmlns:ev="Event">
    <ev:json><?php echo event_to_json($post_id); ?></ev:json>
  </ev:tribe_event_meta>
 
<?php }

/**
 * Returns json representation of one Tribe Event. Full description of event should
 * already be visible in post RSS as xml format. This JSON cointains all other event
 * data required by Eventmore platform.
 *
 * @category Events
 * @param $event
 * @return string
 */
function event_to_json( $event = null ) {
	
	$json = array();
	if ( ! is_null( $event ) ) {
		$event = get_post( $event );
		if ( is_object( $event ) && $event instanceof WP_Post && tribe_is_event( $event->ID ) ) {
			$has_image = false;
			$image_src = '';

			if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $event->ID ) ) {
				$has_image = true;
				$image_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $event->ID ), 'largest' );
				$image_src = $image_arr[0];
			}
			
			$categories = wp_list_pluck( (array) get_the_terms( $event->ID, Tribe__Events__Main::TAXONOMY ), 'name' );
			
			$venue_id = tribe_get_venue_id( $event->ID );
			$venue_name = tribe_get_venue( $venue_id );
			$venue_url  = esc_url_raw( get_permalink( $venue_id ) );
			$venue_addr = tribe_get_address( $venue_id );
			$venue_zip  = tribe_get_zip( $venue_id );
			$venue_city = tribe_get_city( $venue_id );

			$json['eventId']    = $event->ID;
			$json['title']      = wp_kses_post( $event->post_title );
			$json['permalink']  = tribe_get_event_link( $event->ID );
			$json['image']      = $image_src;
			$json['excerpt']    = tribe_events_get_the_excerpt( $event );
			$json['categories'] = $categories;
			$json['startTime']  = tribe_get_start_date( $event );
			$json['endTime']    = tribe_get_end_date( $event );
			$json['venueName']  = $venue_name;
			$json['venueUrl']   = $venue_url;
			$json['venueAddress'] = $venue_addr;
			$json['venueZip']   = $venue_zip;
			$json['venueCity']  = $venue_city;
		}
	}
	$json = tribe_prepare_for_json_deep( $json );
	return json_encode( $json );
}

