<?php
extract( shortcode_atts( array(
	'title' => '',
	'counter_value' => '1000',
	'duration' => '2.5',
	'icon'  => '',
	'icon_size'  => '20',
	'icon_height'  => '65',
	'css'   => ''
), $atts ) );

if( ! wp_is_mobile() ){
	wp_enqueue_script( 'countUp.min.js' );
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$id = rand(9,9999);
?>

<div class="stats_counter<?php echo esc_attr( $css_class ); ?>">
	<?php if( $icon ){ ?>
		<div class="icon" style="height: <?php echo esc_attr( $icon_height ); ?>px;"><i style="font-size: <?php echo esc_attr( $icon_size ); ?>px;" class="<?php echo esc_attr( $icon ); ?>"></i></div>
	<?php } ?>
	<?php if( wp_is_mobile() ){ ?>
		<h2 id="counter_<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $counter_value ); ?></h2>
	<?php }else{ ?>
		<h2 id="counter_<?php echo esc_attr( $id ); ?>"></h2>
	<?php } ?>
	<?php if ( $title ) { ?>
		<h6><?php echo balanceTags( $title, true ); ?></h6>
	<?php } ?>
	<?php if( ! wp_is_mobile() ){ ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var counter_<?php echo esc_attr( $id ); ?> = new countUp("counter_<?php echo esc_attr( $id ); ?>", 0, <?php echo esc_attr( $counter_value ); ?>, 0, <?php echo esc_attr( $duration ); ?>, {
					useEasing : true,
					useGrouping: false
				});
				$(window).scroll(function(){
					if( $("#counter_<?php echo esc_attr( $id ); ?>").is_on_screen() ){
						counter_<?php echo esc_attr( $id ); ?>.start();
					}
				});
			});
		</script>
	<?php } ?>
</div>