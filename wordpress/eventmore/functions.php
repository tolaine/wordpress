

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

	if ( is_null( $post_id ) ) return;

	$event = get_post( $event );
	if ( ! is_object( $event ) && ! ($event instanceof WP_Post && tribe_is_event( $event->ID )) ) return;
	
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


	?>
	<ev:tribe_event_meta xmlns:ev="Event">
		<ev:eventId><?php echo $event->ID;  ?></ev:eventId>
		<ev:title><?php echo wp_kses_post( $event->post_title ); ?></ev:title>
		<ev:permalink><?php echo tribe_get_event_link( $event->ID ); ?></ev:permalink>
		<ev:image><?php echo $image_src; ?></ev:image>
		<ev:excerpt><?php echo tribe_events_get_the_excerpt( $event ); ?></ev:excerpt>
		<ev:categories>
		<?php foreach ($categories as $cat ) { ?>
		<ev:category><?php echo $cat; ?></ev:category>
		<?php } ?>
		</ev:categories>
		<ev:startTime><?php echo tribe_get_start_date( $event ); ?></ev:startTime>
		<ev:endTime><?php echo tribe_get_end_date( $event ); ?></ev:endTime>
		<ev:venue>
			<ev:venueName><?php echo $venue_name; ?></ev:venueName>
			<ev:venueUrl><?php echo $venue_url; ?></ev:venueUrl>
			<ev:venueAddress><?php echo $venue_addr; ?></ev:venueAddress>
			<ev:venueZip><?php echo $venue_zip; ?></ev:venueZip>
			<ev:venueCity><?php echo $venue_city; ?></ev:venueCity>
		</ev:venue>
	</ev:tribe_event_meta> 
	<?php 
}


