<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15-07-31
 * Time: 4:37 PM
 */

$prefix = get_prefix();
global $post;
?>

<?php get_header(); ?>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>


					<?php endwhile; ?>

					<?php else: ?>
						<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>


<?php get_footer(); ?>