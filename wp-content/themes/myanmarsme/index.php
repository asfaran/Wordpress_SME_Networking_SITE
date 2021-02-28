<?php
get_header();
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container  page-body">
	<div id="primary" class="content-area">
		<div class="row" style="background-color: #f8f9fe">
			<div class="col-md-12" style="text-align: center;">
				<?php
				if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				* use this in a child theme, then include a file called called content-___.php
				* (where ___ is the post format) and that will be used instead.
				*/
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
					// Page thumbnail and title.
					the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
					?>

					<div class="entry-content">
						<?php
						the_content();
						?>
					</div>
					<!-- .entry-content -->
				</article>
				<!-- #post-## -->


				<?php 

				endwhile;

				endif;
				?>
			</div>
		</div>
		<!-- #content -->
	</div>
</div>
<!-- END PAGE CONTAINER -->


<?php get_footer(); ?>
