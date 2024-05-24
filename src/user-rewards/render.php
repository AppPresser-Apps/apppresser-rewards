<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */



?>

<div <?php echo get_block_wrapper_attributes(); ?>>
<h3><?php echo $attributes['rewardTitle']; ?></h3>

<?php 
	$args = array(
		'post_type' => 'reward',
		'post_status' => 'any',
		'posts_per_page' => 100,
		'tax_query' => array(
			array(
				'taxonomy' => 'reward-category',
				'field' => 'slug',
				'terms' => $attributes['rewardType'],
			),
		),
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			echo the_content();
		}
		wp_reset_postdata();
	} else {
		echo $attributes['rewardMessage'];
	}
?>
	
</div>
