<?php

global $woocommerce;

$post_id = get_the_ID();

$is_shop = false;
$is_product = false;

if( function_exists( 'is_shop' ) && is_shop() ){
	$is_shop = true;
}

if( function_exists( 'is_product' ) && is_product() ){
	$is_product = true;
}

if( is_home() || is_category() || is_search() ){
    $post_id = get_option( 'page_for_posts' );
}

if( $is_shop ) {
	$post_id = get_option( 'woocommerce_shop_page_id' );
}

$title = '';

if( is_home() ){
    if( ! get_option( 'page_for_posts' ) ){
        $title = __( 'News & Events', STM_DOMAIN );
    }else{
        $title = get_the_title( $post_id );
    }
}elseif( $is_product ){
	$title = get_the_title( $post_id );
}elseif( is_category() ){
    $title = single_cat_title( '', false );
}elseif( is_tag() ) {
	$title = single_tag_title( '', false );
}elseif( is_search() ) {
	$title = __( 'Search', STM_DOMAIN );
}elseif ( is_day() ) {
	$title = get_the_time('d');
} elseif ( is_month() ) {
	$title = get_the_time('F');
} elseif ( is_year() ) {
	$title = get_the_time('Y');
}elseif( is_single() && is_singular('post') ){
	if( ! get_option( 'page_for_posts' ) ){
		$title = __( 'News & Events', STM_DOMAIN );
	}else{
		$title = get_the_title( get_option( 'page_for_posts' ) );
	}
}else{
    $title = get_the_title( $post_id );
}

if ( get_post_meta( $post_id, 'title', true ) != 'hide' ) {

    $title_style                         = array();
    $title_style_h1                      = array();
    $title_style_subtitle                = array();
    $title_box_bg_color                  = get_post_meta( $post_id, 'title_box_bg_color', true );
    $title_box_font_color                = get_post_meta( $post_id, 'title_box_font_color', true );
    $title_box_line_color                = get_post_meta( $post_id, 'title_box_line_color', true );
    $title_box_custom_bg_image           = get_post_meta( $post_id, 'title_box_custom_bg_image', true );
    $title_box_bg_position               = get_post_meta( $post_id, 'title_box_bg_position', true );
    $title_box_bg_repeat                 = get_post_meta( $post_id, 'title_box_bg_repeat', true );
    $title_box_overlay                   = get_post_meta( $post_id, 'title_box_overlay', true );
    $title_box_small                     = get_post_meta( $post_id, 'title_box_small', true );
    $sub_title                           = get_post_meta( $post_id, 'sub_title', true );
    $breadcrumbs                         = get_post_meta( $post_id, 'breadcrumbs', true );
    $breadcrumbs_font_color              = get_post_meta( $post_id, 'breadcrumbs_font_color', true );
    $title_box_button_url                = get_post_meta( $post_id, 'title_box_button_url', true );
    $title_box_button_text               = get_post_meta( $post_id, 'title_box_button_text', true );
    $title_box_button_border_color       = get_post_meta( $post_id, 'title_box_button_border_color', true );
    $title_box_button_font_color         = get_post_meta( $post_id, 'title_box_button_font_color', true );
    $title_box_subtitle_font_color       = get_post_meta( $post_id, 'title_box_subtitle_font_color', true );
    $title_box_button_font_color_hover   = get_post_meta( $post_id, 'title_box_button_font_color_hover', true );
	$title_box_button_font_arrow_color   = get_post_meta( $post_id, 'title_box_button_font_arrow_color', true );
	$prev_next_buttons                   = get_post_meta( $post_id, 'prev_next_buttons', true );
	$prev_next_buttons_border_color      = get_post_meta( $post_id, 'prev_next_buttons_border_color', true );
	$prev_next_buttons_arrow_color_hover = get_post_meta( $post_id, 'prev_next_buttons_arrow_color_hover', true );

    if ( $title_box_bg_color ) {
        $title_style['bg_color'] = 'background-color: ' . $title_box_bg_color . ';';
    }

    if ( $title_box_font_color ) {
        $title_style_h1['font_color'] = 'color: ' . $title_box_font_color . ';';
    }

    if ( $title_box_subtitle_font_color ) {
	    $title_style_subtitle['font_color'] = 'color: ' . $title_box_subtitle_font_color . ';';
    }

    if ( $title_box_custom_bg_image = wp_get_attachment_image_src( $title_box_custom_bg_image, 'full' ) ) {

        $title_style['bg_image']   = 'background-image: url(' . $title_box_custom_bg_image[0] . ');';

        if ( $title_box_bg_position ) {
            $title_style['bg_position'] = 'background-position: ' . $title_box_bg_position . ';';
        }

        if ( $title_box_bg_repeat ) {
            $title_style['bg_repeat'] = 'background-repeat: ' . $title_box_bg_repeat . ';';
        }

    }
    ?>
    <div class="entry-header clearfix<?php if($title_box_small || $is_shop || $is_product){ echo ' small'; } ?>" <?php if( get_header_style() != 'header_style_transparent' ){ echo balanceTags( 'style="' . implode( ' ', $title_style ) . '"' ); }; ?>>
        <?php if( $title_box_overlay && get_header_style() != 'header_style_transparent' ){ echo '<div class="overlay"></div>'; } ?>
        <div class="entry-content">
            <div class="stm_post_info">
                <h1 class="h3"><?php echo balanceTags( $title, true ); ?></h1>
                <?php if( $sub_title && ! is_search() ){ ?>
                    <div class="sub_title" style="<?php echo implode( ' ', $title_style_subtitle ); ?>"><?php echo balanceTags( $sub_title, true ); ?></div>
                <?php } ?>
                <button type="button" class="pull-right mail-button" data-toggle="modal" data-target=".mail-modal">Написать письмо</button>

            </div>
        </div>
    </div>
<?php } ?>