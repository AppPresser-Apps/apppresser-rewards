<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */



?>

<div <?php echo get_block_wrapper_attributes(); ?>>
<h3><?php echo $attributes['rewardTitle']; ?></h3>


<?php
if ( ! is_user_logged_in() ) {
	return;
}
?>

<?php
	$args = array(
		'post_type'      => 'reward',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 100,
		'tax_query'      => array(
			array(
				'taxonomy' => 'reward-category',
				'field'    => 'slug',
				'terms'    => $attributes['rewardType'],
			),
		),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			// Get the ACF field value
			$dates     = get_field( 'reward_dates' );
			$all_users = get_field( 'all_users' );
			$users     = get_field( 'users' );

			if ( ! empty( $dates['valid_from'] ) && ! empty( $dates['valid_to'] ) ) {

				$current_date = strtotime( gmdate( 'Y-m-d' ) );
				$from_date    = strtotime( gmdate( $dates['valid_from'] ) );
				$to_date      = strtotime( gmdate( $dates['valid_to'] ) );

				if ( $current_date > $from_date && $current_date < $to_date ) {

					if ( $all_users || ( is_array( $users ) && in_array( get_current_user_id(), $users, true ) ) ) {
						echo the_content();
					}
				} else {
					echo $attributes['rewardMessage'];
				}
			} else {
				echo $attributes['rewardMessage'];
			}
		}
		wp_reset_postdata();
	} else {
		echo $attributes['rewardMessage'];
	}
	?>
	
</div>
