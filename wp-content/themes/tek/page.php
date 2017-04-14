<?php stm_get_header(); ?>
<div class="col-md-3  hidden-sm hidden-xs">
    <?php
    get_template_part( 'partials/left-menu');
    ?>
</div>
<div class="content-area col-md-9 col-sm-9 col-xs-12">
		<?php
			while ( have_posts() ) {
				the_post();

				get_template_part( 'partials/content', 'page' );

			}
		?>

	</div>

<?php get_footer(); ?>
