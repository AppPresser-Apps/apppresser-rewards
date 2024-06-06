<?php

// Check if a reward post type has a ACF meta field with a date that is current and change post status to publish
function check_reward_post_status() {
	$args = array(
		'post_type'      => 'reward', // Replace 'reward' with your custom post type
		'posts_per_page' => -1,
		'post_status'    => 'any',
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			// Get the ACF field value
			$dates = get_field( 'reward_dates' );

			if ( ! empty( $dates['valid_from'] ) && ! empty( $dates['valid_to'] ) ) {

				$current_date = strtotime( gmdate( 'Y-m-d' ) );
				$from_date    = strtotime( gmdate( $dates['valid_from'] ) );
				$to_date      = strtotime( gmdate( $dates['valid_to'] ) );

				// error_log( print_r( $current_date, true ) );
				// error_log( print_r( $from_date, true ) );
				// error_log( print_r( $to_date, true ) );

				if ( $current_date > $from_date && $current_date < $to_date ) {
                    error_log( print_r( 'publish reward', true ) );
					wp_update_post(
						array(
							'ID'          => get_the_ID(),
							'post_status' => 'publish',
						)
					);
				} elseif ( $current_date > $from_date ) {
                    error_log( print_r( 'unpublish reward', true ) );
					wp_update_post(
						array(
							'ID'          => get_the_ID(),
							'post_status' => 'draft',
						)
					);
				}
			}
		}
		wp_reset_postdata();
	}
}
//add_action( 'init', 'check_reward_post_status' );

// Schedule the cron job to run daily
function schedule_reward_post_status_check() {
	if ( ! wp_next_scheduled( 'check_reward_post_status' ) ) {
		wp_schedule_event( time(), 'daily', 'check_reward_post_status' );
	}
}
// add_action('init', 'schedule_reward_post_status_check');

// Unschedule the cron job
function unschedule_reward_post_status_check() {
	wp_clear_scheduled_hook( 'check_reward_post_status' );
}
// add_action('init', 'unschedule_reward_post_status_check');
