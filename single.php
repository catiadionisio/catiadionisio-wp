<?php
/**
 * Single post
 */
?>

<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="page-content">
	<div class="container">
		<h1><?php the_title() ?></h1>
		<?php the_content(); ?>
	</div>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>
