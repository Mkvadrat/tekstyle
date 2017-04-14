<?php
extract( shortcode_atts( array(
	'css' => ''
), $atts ) );
wp_enqueue_script( 'isotope' );

$id = rand();

$project_categories_array = get_terms( 'project_category' );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if( ! $project_categories_array ){
	return false;
}

?>
<div class="project_grid_wrapper container<?php echo esc_attr( $css_class ); ?>">
	<div id="project_grid_filter_<?php echo esc_attr( $id ); ?>" class="project_grid_filter clearfix">
		<ul class="clearfix">
			<li class="active"><a href="#all"><?php _e( 'All Projects', STM_DOMAIN ); ?></a></li>
			<?php if( $project_categories_array ){ ?>
				<?php foreach( $project_categories_array as $cat ){ ?>
					<li><a href="#<?php echo esc_attr( $cat->slug ); ?>"><?php echo balanceTags( $cat->name, true ); ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
		<a href="#" class="project_grid_switcher">
			<i class="fa fa-arrow-left left"></i>
			<i class="fa fa-arrow-right right"></i>
		</a>
	</div>
	<?php
		$projects = new WP_Query(
			array(
				'post_type' => 'project',
				'posts_per_page' => -1
			)
		);
	?>
	<?php if( $projects->have_posts() ){ ?>
		<div id="project_grid_<?php echo esc_attr( $id ); ?>" class="project_grid clearfix">
			<?php while ( $projects->have_posts() ) { $projects->the_post(); ?>
				<?php
					$project_class = '';
					$term_list = wp_get_post_terms( get_the_ID(), 'project_category' );
					if( $term_list ){
						foreach ( $term_list as $term ) {
							$project_class .= ' ' . $term->slug;
						}
					}
				?>
				<div class="project all<?php echo esc_attr( $project_class ); ?>">
					<div class="project_wr">
						<?php the_post_thumbnail( 'thumb-640x445' ); ?>
						<div class="overlay"></div>
						<h4><?php the_title(); ?></h4>
						<a href="<?php the_permalink(); ?>" class="button view_more"><?php _e( 'View More', STM_DOMAIN ); ?></a>
					</div>
				</div>
			<?php } wp_reset_query(); ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				var $container = $('#project_grid_<?php echo esc_attr( $id ); ?>');
				$(window).load(function() {
					$container.isotope({
						itemSelector: '.project',
						transitionDuration: '0.7s'
					});
					$(".project_grid_switcher").live('click', function () {
						$(this).toggleClass('active');
						var $container_wrapper = $(this).closest('.project_grid_wrapper');
						if( $('body').hasClass('boxed_layout') ){
							$container_wrapper.toggleClass('wide');
						}else{
							$container_wrapper.toggleClass('wide container');
						}
						$container_wrapper.find('.project_grid_filter').toggleClass('container');
						$container.isotope('layout');
						$container.closest('.project_grid_wrapper').animate({'height': $container.height() + $('#project_grid_filter_<?php echo esc_attr( $id ); ?>').height() + 60}, 300);
						return false;
					});

					var $container_filter = $('#project_grid_filter_<?php echo esc_attr( $id ); ?> ul a').live('click', function () {
						$(this).closest('ul').find('li.active').removeClass('active');
						$(this).parent().addClass('active');
						var sort = $(this).attr('href');
						var sort = sort.substring(1);
						$container.isotope({
							filter: '.' + sort
						});
						return false;
					});
					$container.closest('.project_grid_wrapper').animate({'height': $container.height() + $('#project_grid_filter_<?php echo esc_attr( $id ); ?>').height() + 60}, 300);
					$container.closest('.project_grid_wrapper').find('.projects_preloader').fadeOut(300);
				});
			});
		</script>
	<?php } ?>
	<div class="projects_preloader"></div>
</div>