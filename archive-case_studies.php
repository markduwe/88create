<?php get_header(); ?>

<?php
$args = array (
	'pagename' => 'Case Studies',
);
$workPage = new WP_Query( $args );
if ( $workPage->have_posts() ) {
	while ( $workPage->have_posts() ) {
		$workPage->the_post();
?>
<style>
	body {
		background: <?php global $post; $colour = get_post_meta( $post->ID, '_cmb_colour', true ); echo $colour; ?> url(<?php global $post; $bg = get_post_meta( $post->ID, '_cmb_bg', true ); echo $bg; ?>);
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center top;
		background-attachment: fixed;
	}
	header {
		background: <?php global $post; $colour = get_post_meta( $post->ID, '_cmb_colour', true ); echo $colour; ?> url(<?php global $post; $bg = get_post_meta( $post->ID, '_cmb_bg', true ); echo $bg; ?>);
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center top;
		background-attachment: fixed;
	}
</style>
<?php
	}
} else {
	// no posts found
}
wp_reset_postdata();
?>

<div class="grid" id="portfolio">
	
	<?php 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'case_studies',
			'posts_per_page' => -1,
			'paged' => $paged
		); 
		$work = new WP_Query($args);
		if ($work->have_posts()) : while ($work->have_posts()) : $work->the_post(); 
		$terms = wp_get_post_terms( $work->post->ID, array( 'type' ) );
	?>
	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio' ); $url = $thumb['0']; ?>
	
		<div <?php post_class('col-1-2 portfolio'); ?> data-filters="<?php foreach ( $terms as $term ) : ?><?php echo $term->slug; ?><?php endforeach; ?>">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="project">
				<div class="thumbnail">
					<img class="lazy" data-original="<?php echo $url; ?>"><i class="icon-zoomin"></i>
				</div>
			</a>
		</div>
	
	<?php endwhile; ?>

</div>

<div class="navigation">
	<div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
	<div class="alignright"><?php next_posts_link('Next Entries &raquo;','') ?></div>
</div>

<?php endif; ?>
	
<?php get_footer(); ?>