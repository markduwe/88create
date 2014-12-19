<?php get_header(); ?>
<?php
$background_color = get_background_color();
$background_image = get_background_image();
?>
<style type="text/css" id="custom-css">
.header { background: #<?php echo $background_color; ?> url("<?php header_image(); ?>") no-repeat center center; background-size: cover;}
</style>
<div class="grid">
	<div class="col-1-1">
		<div id="filterlist"></div>
		<ul id="filters" class="aligncenter">
		    <li><a href="#" data-filter="*" class="selected">Everything</a></li>
			<?php 
				$terms = get_terms('type');
				$count = count($terms);
				if ( $count > 0 ) {
					foreach ( $terms as $term ) {
						echo "<li><a href='#' data-show='".$term->slug."' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
					}
				} 
			?>
		</ul>
	</div>
</div>

<div class="grid" id="portfolio">
	
	<?php 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'work',
			'posts_per_page' => -1,
			'paged' => $paged
		); 
		$work = new WP_Query($args);
		if ($work->have_posts()) : while ($work->have_posts()) : $work->the_post(); 
		$terms = wp_get_post_terms( $work->post->ID, array( 'type' ) );
	?>
	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio' ); $url = $thumb['0']; ?>
	
	<?php if ( 'video' == get_post_format() ) { ?>
	
		<div <?php post_class('col-2-3 portfolio'); ?>>
			<?php $video = get_post_meta( $post->ID, '_cmb_v', true ); echo wp_oembed_get( $video ); ?>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		</div>
	
	<?php } else { ?>
	
		<div <?php post_class('col-1-3 portfolio'); ?>>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="project">
				<div class="thumbnail">
					<img class="lazy" data-original="<?php echo $url; ?>">
				</div>
			</a>
		</div>
	
	<?php } ?>
	
	<?php endwhile; ?>

</div>

<div class="navigation">
	<div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
	<div class="alignright"><?php next_posts_link('Next Entries &raquo;','') ?></div>
</div>

<?php endif; ?>
	
<?php get_footer(); ?>