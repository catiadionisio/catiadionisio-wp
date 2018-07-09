<?php
/**
 * Template for posts page
 */
?>

<?php get_header() ?>
<div id="page-content">
	<div class="container">
		<div class="category-dropdown">
			<div class="selected-category">All <i class='fas fa-caret-down'></i></div>

			<div class="dropdown-div hidden">
				<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="selected">All</a>

				<?php
				$categories = get_terms([
				    'taxonomy' => 'category'
				]);
				foreach ($categories as $category) {
					//if ($category->slug != 'sem-categoria') {
						$category_link = get_category_link( $category );
				   		echo '<a href="'.$category_link.'">'.$category->name.'</a>';
					//}
				}
				?>
			</div>
		</div>

		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
        <div class="col col33">
        	<div class="post">
        		<?php
        		if ( has_post_thumbnail() ) {
        			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
        				$thumbnail_url = $thumbnail[0];
        		} else {
        			$thumbnail_url = '';
        		}
        		?>
        		<?php if ($thumbnail_url) { ?>
        			<div class="post-thumbnail-out" style="background-image: url(<?php echo $thumbnail_url; ?>);">
        				<img class="post-thumbnail" src="<?php echo $thumbnail_url; ?>" alt="">
        			</div>
        		<?php } ?>
        		<h3><?php echo get_the_title(); ?></h3>
        		<div class="posts_excerpt"><?php the_excerpt(); ?></div>
        		<div class="text-right">
        			<a href="<?php echo get_permalink(get_the_ID()); ?>" class="btn">Ver mais</a>
        		</div>
        	</div>
        </div>
			<?php endwhile; ?>
		</div><!-- #clr -->

    <div class="pagination">
			<?php pagination_nav(); ?>
		</div>
	</div>
</div>
<?php get_footer() ?>
