<?php 
/**
 * Registers a custom post type 'appp_upload'.
 *
 * @since 1.0.0
 *
 * @return void
 */

/**
 * Registers a custom post type 'reward'.
 *
 * @since 1.0.0
 *
 * @return void
 */
function apppresser_register_rewards_post_type() : void {
	$labels = [
		'name' => _x( 'Rewards', 'Post Type General Name', 'apppresser' ),
		'singular_name' => _x( 'Reward', 'Post Type Singular Name', 'apppresser' ),
		'menu_name' => __( 'Rewards', 'apppresser' ),
		'name_admin_bar' => __( 'Rewards', 'apppresser' ),
		'archives' => __( 'Rewards Archives', 'apppresser' ),
		'attributes' => __( 'Rewards Attributes', 'apppresser' ),
		'parent_item_colon' => __( 'Parent Reward:', 'apppresser' ),
		'all_items' => __( 'All Rewards', 'apppresser' ),
		'add_new_item' => __( 'Add New Reward', 'apppresser' ),
		'add_new' => __( 'Add New', 'apppresser' ),
		'new_item' => __( 'New Reward', 'apppresser' ),
		'edit_item' => __( 'Edit Reward', 'apppresser' ),
		'update_item' => __( 'Update Reward', 'apppresser' ),
		'view_item' => __( 'View Reward', 'apppresser' ),
		'view_items' => __( 'View Rewards', 'apppresser' ),
		'search_items' => __( 'Search Rewards', 'apppresser' ),
		'not_found' => __( 'Reward Not Found', 'apppresser' ),
		'not_found_in_trash' => __( 'Reward Not Found in Trash', 'apppresser' ),
		'featured_image' => __( 'Featured Image', 'apppresser' ),
		'set_featured_image' => __( 'Set Featured Image', 'apppresser' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'apppresser' ),
		'use_featured_image' => __( 'Use as Featured Image', 'apppresser' ),
		'insert_into_item' => __( 'Insert into Reward', 'apppresser' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Reward', 'apppresser' ),
		'items_list' => __( 'Rewards List', 'apppresser' ),
		'items_list_navigation' => __( 'Rewards List Navigation', 'apppresser' ),
		'filter_items_list' => __( 'Filter Rewards List', 'apppresser' ),
	];
	$labels = apply_filters( 'reward-labels', $labels );

	$args = [
		'label' => __( 'Reward', 'apppresser' ),
		'description' => __( 'Cupons and QR Codes', 'apppresser' ),
		'labels' => $labels,
		'supports' => [
			'title',
			'editor',
		],
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-star-filled',
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'exclude_from_search' => true,
		'has_archive' => false,
		'can_export' => true,
		'capability_type' => 'post',
		'show_in_rest' => true,
		'template_lock' => 'all',
	];
	$args = apply_filters( 'reward-args', $args );

	register_post_type( 'reward', $args );
}
add_action( 'init', 'apppresser_register_rewards_post_type', 0 );

/**
 * Allow only specific blocks in the reward post type
 *
 * @param array $allowed_block_types
 * @param WP_Post $post
 * @return array
 */
function apppresser_allow_specific_blocks( $allowed_block_types, $editor_context ) {
    // An array of block names to allow
    $allowed_blocks = array(
        'apppresser/rewards',
    );
  
    if ( $editor_context->post->post_type === 'reward' ) {
        return $allowed_blocks;
    }

    return $allowed_block_types;
}
add_filter( 'allowed_block_types_all', 'apppresser_allow_specific_blocks', 10, 2 );