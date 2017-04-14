<?php $vc_status = get_post_meta( get_the_ID() , '_wpb_vc_js_status', true); ?>
<?php if( $vc_status != 'false' && $vc_status == true ){ ?>
    <div class="col-md-3  hidden-sm hidden-xs">
        <?php
        get_template_part( 'partials/left-menu');

        ?>
    </div>
    <div class="content-area col-md-9 col-sm-12 col-xs-12">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    <div class="entry-content">
		        <?php the_content(); ?>
		        <?php
		        wp_link_pages( array(
		            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', STM_DOMAIN ) . '</span>',
		            'after'       => '</div>',
		            'link_before' => '<span>',
		            'link_after'  => '</span>',
		            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', STM_DOMAIN ) . ' </span>%',
		            'separator'   => '<span class="screen-reader-text">, </span>',
		        ) );
		        ?>
		    </div>
		
		</article>
	</div>
<?php }else{ ?>
	<?php 
		$blog_sidebar_position = stm_option( 'blog_sidebar_position', 'none' );
		$content_before = $content_after =  $sidebar_before = $sidebar_after = '';

		if( $blog_sidebar_position == 'right' ) {
			$content_before .= '<div class="row">';
			$content_before .= '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">';
			$content_before .= '<div class="col_in __padd-right __three-cols">';

			$content_after .= '</div>'; // col_in
			$content_after .= '</div>'; // col
			$sidebar_before .= '<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">';
			// .sidebar-area
			$sidebar_after .= '</div>'; // col
			$sidebar_after .= '</div>'; // row
		}

		if( $blog_sidebar_position == 'left' ) {
			$content_before .= '<div class="row">';
			$content_before .= '<div class="col-lg-9 col-lg-push-3 col-md-9 col-md-push-3 col-sm-12 col-xs-12">';
			$content_before .= '<div class="col_in __padd-left __three-cols">';

			$content_after .= '</div>'; // col_in
			$content_after .= '</div>'; // col
			$sidebar_before .= '<div class="col-lg-3 col-lg-pull-9 col-md-3 col-md-pull-9 hidden-sm hidden-xs">';
			// .sidebar-area
			$sidebar_after .= '</div>'; // col
			$sidebar_after .= '</div>'; // row
		}		
	?>
    <div class="col-md-3  hidden-sm hidden-xs">
        <?php
        get_template_part( 'partials/left-menu');

        ?>
    </div>
	<div class="content-area col-md-9 col-sm-12 col-xs-12">
		<?php echo $content_before; ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			    <div class="entry-content">
			        <div class="stm_post_info">
						<h1 class="h3"><?php the_title(); ?></h1>
					</div>
					<?php if( get_the_content() ){ ?>
						<div class="text_block clearfix">
							<?php the_content(); ?>
						</div>
					<?php } ?>
					<?php
				        wp_link_pages( array(
				            'before'      => '<div class="page-links"><label>' . __( 'Pages:', STM_DOMAIN ) . '</label>',
				            'after'       => '</div>',
				            'link_before' => '<span>',
				            'link_after'  => '</span>',
				            'pagelink'    => '%',
				            'separator'   => '',
				        ) );
			        ?>
			    </div>
			
			</article>
		<?php echo $content_after; ?>
		<?php echo $sidebar_before; ?>
			<div class="sidebar-area">
				<?php get_sidebar(); ?>
			</div>
		<?php echo $sidebar_after; ?>
	</div>
<?php } ?>