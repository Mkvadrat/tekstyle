<?php

if( function_exists( 'vc_set_default_editor_post_types' ) ){
	vc_set_default_editor_post_types( array( 'page', 'post', 'service', 'project', 'sidebar', 'vacancy' ) );
}

add_action( 'vc_before_init', 'stm_vc_set_as_theme' );

function stm_vc_set_as_theme() {
	vc_set_as_theme( true );
}

if ( is_admin() ) {
	if ( ! function_exists( 'stm_vc_remove_teaser_metabox' ) ) {
		function stm_vc_remove_teaser_metabox() {
			$post_types = get_post_types( '', 'names' );
			foreach ( $post_types as $post_type ) {
				remove_meta_box( 'vc_teaser', $post_type, 'side' );
			}
		}
		add_action( 'do_meta_boxes', 'stm_vc_remove_teaser_metabox' );
	}
}

if( function_exists( 'add_shortcode_param' ) ){
	add_shortcode_param('stm_animator', 'stm_animator_param' );
}

function stm_animator_param( $settings, $value ){
	$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
	$animations = json_decode( file_get_contents( get_template_directory() . '/assets/js/animate-config.json' ), true );
	if( $animations ){
		$output = '<select name="'.$param_name.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';
		foreach ( $animations as $key => $val ) {
			if ( is_array( $val ) ) {
				$labels = str_replace( '_', ' ', $key );
				$output .= '<optgroup label="' . ucwords( __( $labels, STM_DOMAIN ) ) . '">';
				foreach ( $val as $label => $style ) {
					$label = str_replace( '_', ' ', $label );
					if ( $label == $value ) {
						$output .= '<option selected value="' . $label . '">' . __( $label, STM_DOMAIN ) . '</option>';
					} else {
						$output .= '<option value="' . $label . '">' . __( $label, STM_DOMAIN ) . '</option>';
					}
				}
			} else {
				if ( $key == $value ) {
					$output .= "<option selected value=" . $key . ">" . __( $key, STM_DOMAIN ) . "</option>";
				} else {
					$output .= "<option value=" . $key . ">" . __( $key, STM_DOMAIN ) . "</option>";
				}
			}
		}

		$output .= '</select>';
	}
	return $output;
}

add_action( 'admin_init', 'stm_update_existing_shortcodes' );

function stm_update_existing_shortcodes(){

	if( function_exists( 'vc_map_update' ) ){
		vc_map_update( 'vc_cta_button2', array(
			'deprecated' => false
		) );
		vc_map_update( 'vc_button2', array(
			'deprecated' => false
		) );
	}

	if ( function_exists( 'vc_add_params' ) ) {

		vc_add_params( 'vc_gallery', array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Gallery type', STM_DOMAIN ),
				'param_name' => 'type',
				'value'    => array(
					__( 'Image grid', STM_DOMAIN ) => 'image_grid',
					__( 'Slick slider', STM_DOMAIN ) => 'slick_slider',
					__( 'Slick slider 2', STM_DOMAIN ) => 'slick_slider_2'
				)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Thumbnail size', STM_DOMAIN ),
				'param_name' => 'thumbnail_size',
				'dependency' => array(
					'element' => 'type',
					'value' => array( 'slick_slider_2' )
				),
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		));

		vc_add_params( 'vc_column_inner', array(
			array(
				'type' => 'column_offset',
				'heading' => __( 'Responsiveness', 'js_composer' ),
				'param_name' => 'offset',
				'group' => __( 'Width & Responsiveness', 'js_composer' ),
				'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer' )
			)
		));

		vc_add_params( 'vc_separator', array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Type', STM_DOMAIN ),
				'param_name' => 'type',
				'value'    => array(
					__( 'Type 1', STM_DOMAIN ) => 'type_1',
					__( 'Type 2', STM_DOMAIN ) => 'type_2'
				)
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			),
		) );

		vc_add_params( 'vc_video', array(
			array(
				'type' => 'textarea_raw_html',
				'heading' => __( 'Iframe', STM_DOMAIN ),
				'param_name' => 'link',
				'value' => ''
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Preview Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
		) );

		vc_add_params( 'vc_wp_pages', array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		) );
		
		vc_add_params( 'vc_custom_heading', array(
			array(
				'type'       => 'vc_link',
				'heading'    => __( 'Link', STM_DOMAIN ),
				'weight'	 => 2,
				'param_name' => 'link'
			)
		) );

		vc_add_params( 'vc_basic_grid', array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'js_composer' ),
				'param_name' => 'gap',
				'value' => array(
					__( '0px', 'js_composer' ) => '0',
					__( '1px', 'js_composer' ) => '1',
					__( '2px', 'js_composer' ) => '2',
					__( '3px', 'js_composer' ) => '3',
					__( '4px', 'js_composer' ) => '4',
					__( '5px', 'js_composer' ) => '5',
					__( '10px', 'js_composer' ) => '10',
					__( '15px', 'js_composer' ) => '15',
					__( '20px', 'js_composer' ) => '20',
					__( '25px', 'js_composer' ) => '25',
					__( '30px', 'js_composer' ) => '30',
					__( '35px', 'js_composer' ) => '35',
					__( '40px', 'js_composer' ) => '40',
					__( '45px', 'js_composer' ) => '45',
					__( '50px', 'js_composer' ) => '50',
					__( '55px', 'js_composer' ) => '55',
					__( '60px', 'js_composer' ) => '60',
				),
				'std' => '30',
				'description' => __( 'Select gap between grid elements.', 'js_composer' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			)
		) );

		vc_add_params( 'vc_cta_button2', array(
			array(
				'type' => 'checkbox',
				'heading' => __('Stretch', STM_DOMAIN),
				'param_name' => 'stretch',
				'value' => array(
					__( 'Yes', STM_DOMAIN ) => 'yes'
				),
			)
		));

	}

	if( function_exists( 'vc_remove_param' ) ){
		vc_remove_param( 'vc_cta_button2', 'h2' );
		vc_remove_param( 'vc_cta_button2', 'content' );
		vc_remove_param( 'vc_cta_button2', 'btn_style' );
		vc_remove_param( 'vc_cta_button2', 'color' );
		vc_remove_param( 'vc_cta_button2', 'size' );
		vc_remove_param( 'vc_cta_button2', 'css_animation' );
	}

    if( function_exists( 'vc_remove_element' ) ){
        vc_remove_element( "vc_cta_button" );
    }

}

if ( function_exists( 'vc_map' ) ) {
	add_action( 'init', 'vc_stm_elements' );
}

function vc_stm_elements(){

	$project_categories_array = get_terms( 'project_category' );
	$project_categories = array(
		__( 'All', STM_DOMAIN ) => 'all'
	);
	if( $project_categories_array && ! is_wp_error( $project_categories_array )  ){
		foreach( $project_categories_array as $cat ){
			$project_categories[$cat->name] = $cat->slug;
		}
	}
	
	$testimonial_categories_array = get_terms( 'testimonial_category' );
	$testimonial_categories = array(
		__( 'All', STM_DOMAIN ) => 'all'
	);
	if( $testimonial_categories_array && ! is_wp_error( $testimonial_categories_array )  ){
		foreach( $testimonial_categories_array as $cat ){
			$testimonial_categories[$cat->name] = $cat->slug;
		}
	}

	vc_map( array(
		'name'        => __( 'Project Details', STM_DOMAIN ),
		'base'        => 'stm_project_details',
		'as_parent'   => array('only' => 'stm_project_details_item'),
		'show_settings_on_create' => false,
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', STM_DOMAIN ),
				'param_name' => 'style',
				'value' => array(
					__( 'Style 1', STM_DOMAIN ) => 'style_1',
					__( 'Style 2', STM_DOMAIN ) => 'style_2',
					__( 'Style 3', STM_DOMAIN ) => 'style_3',
				)
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		),
		'js_view' => 'VcColumnView'
	) );

	vc_map( array(
		'name'        => __( 'Item', STM_DOMAIN ),
		'base'        => 'stm_project_details_item',
		'as_child' => array('only' => 'stm_project_details'),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Label', STM_DOMAIN ),
				'param_name' => 'label'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Value', STM_DOMAIN ),
				'param_name' => 'value'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Company History', STM_DOMAIN ),
		'base'        => 'stm_company_history',
		'as_parent'   => array('only' => 'stm_company_history_item'),
		'show_settings_on_create' => false,
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		),
		'js_view' => 'VcColumnView'
	) );

	vc_map( array(
		'name'        => __( 'Item', STM_DOMAIN ),
		'base'        => 'stm_company_history_item',
		'as_child' => array('only' => 'stm_company_history'),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Year', STM_DOMAIN ),
				'param_name' => 'year'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Description', STM_DOMAIN ),
				'param_name' => 'description'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Projects Grid', STM_DOMAIN ),
		'base'        => 'stm_projects_grid',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Our Partners', STM_DOMAIN ),
		'base'        => 'stm_partners',
		'as_parent'   => array('only' => 'stm_partners_item'),
		'show_settings_on_create' => false,
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		),
		'js_view' => 'VcColumnView'
	) );

	vc_map( array(
		'name'        => __( 'Item', STM_DOMAIN ),
		'base'        => 'stm_partners_item',
		'as_child' => array('only' => 'stm_partners'),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Logo', STM_DOMAIN ),
				'param_name' => 'logo'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Description', STM_DOMAIN ),
				'param_name' => 'description'
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', STM_DOMAIN ),
				'param_name' => 'link'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Staff', STM_DOMAIN ),
		'base'        => 'stm_staff',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Name', STM_DOMAIN ),
				'param_name' => 'name'
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Staff Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'image_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Job Title', STM_DOMAIN ),
				'param_name' => 'job'
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Description', STM_DOMAIN ),
				'param_name' => 'description'
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Full Description', STM_DOMAIN ),
				'param_name' => 'full_description'
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', STM_DOMAIN ),
				'param_name' => 'style',
				'value' => array(
					__( 'Style 1', STM_DOMAIN ) => 'style_1',
					__( 'Style 2', STM_DOMAIN ) => 'style_2'
				)
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Facebook', STM_DOMAIN ),
				'param_name' => 'facebook',
				'group'      => __( 'Socials', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Twitter', STM_DOMAIN ),
				'param_name' => 'twitter',
				'group'      => __( 'Socials', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Linkedin', STM_DOMAIN ),
				'param_name' => 'linkedin',
				'group'      => __( 'Socials', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Contacts', STM_DOMAIN ),
		'base'        => 'stm_contacts_widget',
		'icon'        => 'icon-wpb-wp',
		'category'    => __( 'STM Widgets', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Address', STM_DOMAIN ),
				'param_name' => 'address'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Phone', STM_DOMAIN ),
				'param_name' => 'phone'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Fax', STM_DOMAIN ),
				'param_name' => 'fax'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Email', STM_DOMAIN ),
				'param_name' => 'email'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Services', STM_DOMAIN ),
		'base'        => 'stm_services_widget',
		'icon'        => 'icon-wpb-wp',
		'category'    => __( 'STM Widgets', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Info Box', STM_DOMAIN ),
		'base'        => 'stm_info_box',
		'icon'        => 'stm_info_box',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Text', STM_DOMAIN ),
				'param_name' => 'content'
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', STM_DOMAIN ),
				'param_name' => 'link'
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Link Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Icon Box', STM_DOMAIN ),
		'base'        => 'stm_icon_box',
		'icon'        => 'stm_icon_box',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Style', STM_DOMAIN ),
				'param_name' 		=> 'style',
				'value'				=> array(
					__( 'Icon Top', STM_DOMAIN ) => 'icon_top',
					__( 'Icon Left', STM_DOMAIN ) => 'icon_left'
				)
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Size', STM_DOMAIN ),
				'param_name' 		=> 'icon_size',
				'value'				=> '65',
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Height', STM_DOMAIN ),
				'param_name' 		=> 'icon_height',
				'value'				=> '65',
				'description'       => __( 'Enter icon height in px', STM_DOMAIN ),
				'dependency' => array(
					'element' => 'style',
					'value' => array( 'icon_top' )
				)
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Width', STM_DOMAIN ),
				'param_name' 		=> 'icon_width',
				'value'				=> '50',
				'description'       => __( 'Enter icon width in px', STM_DOMAIN ),
				'dependency' => array(
					'element' => 'style',
					'value' => array( 'icon_left' )
				)
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Text', STM_DOMAIN ),
				'param_name' => 'content'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Icon Button', STM_DOMAIN ),
		'base'        => 'stm_icon_button',
		'icon'        => 'stm_icon_button',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', STM_DOMAIN ),
				'param_name' => 'link'
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Sub Text', STM_DOMAIN ),
				'param_name' 		=> 'sub_text',
				'value'				=> ''
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Size', STM_DOMAIN ),
				'param_name' 		=> 'icon_size',
				'value'				=> '19',
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Height', STM_DOMAIN ),
				'param_name' 		=> 'icon_height',
				'value'				=> '29',
				'description'       => __( 'Enter icon height in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Extra class name', STM_DOMAIN ),
				'param_name' 		=> 'class',
				'value'				=> '',
				'description'       => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Stats Counter', STM_DOMAIN ),
		'base'        => 'stm_stats_counter',
		'icon'        => 'stm_stats_counter',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Counter Value', STM_DOMAIN ),
				'param_name' 		=> 'counter_value',
				'value'				=> '1000'
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Duration', STM_DOMAIN ),
				'param_name' 		=> 'duration',
				'value'				=> '2.5'
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Size', STM_DOMAIN ),
				'param_name' 		=> 'icon_size',
				'value'				=> '44',
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Height', STM_DOMAIN ),
				'param_name' 		=> 'icon_height',
				'value'				=> '44',
				'description'       => __( 'Enter icon height in px', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Testimonials', STM_DOMAIN ),
		'base'        => 'stm_testimonials',
		'icon'        => 'stm_testimonials',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Count', STM_DOMAIN ),
				'param_name' => 'count',
				'value' => 1
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Category', STM_DOMAIN),
				'param_name' => 'category',
				'value' => $testimonial_categories
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Projects', STM_DOMAIN ),
		'base'        => 'stm_projects',
		'icon'        => 'stm_projects',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'dropdown',
				'heading' => __('Category', STM_DOMAIN),
				'param_name' => 'category',
				'value' => $project_categories
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Category Filter', STM_DOMAIN),
				'param_name' => 'category_filter',
				'value' => array(
					__( 'Show', STM_DOMAIN ) => 'show'
				),
				'dependency' => array(
					'element' => 'category',
					'value' => array( 'all' )
				)
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Full Width', STM_DOMAIN),
				'param_name' => 'full_width',
				'value' => array(
					__( 'Enable', STM_DOMAIN ) => 'Enable'
				)
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title',
				'dependency' => array(
					'element' => 'category_filter',
					'value' => array( 'show' )
				)
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Title Link', STM_DOMAIN ),
				'param_name' => 'title_link',
				'dependency' => array(
					'element' => 'category_filter',
					'value' => array( 'show' )
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Title Color', STM_DOMAIN ),
				'param_name' => 'title_color',
				'dependency' => array(
					'element' => 'category_filter',
					'value' => array( 'show' )
				)
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Title Strip Color', STM_DOMAIN ),
				'param_name' => 'title_strip_color',
				'dependency' => array(
					'element' => 'category_filter',
					'value' => array( 'show' )
				)
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Infinite', STM_DOMAIN),
				'param_name' => 'infinite',
				'value' => array(
					__( 'Enable', STM_DOMAIN ) => 'enable'
				),
				'description' => __('Enable infinite loop sliding', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Arrows', STM_DOMAIN),
				'param_name' => 'arrows',
				'value' => array(
					__( 'Enable', STM_DOMAIN ) => 'enable'
				),
				'description' => __('Enable Prev/Next Arrows', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Dots', STM_DOMAIN),
				'param_name' => 'dots',
				'value' => array(
					__( 'Show', STM_DOMAIN ) => 'show'
				),
				'description' => __('Show dot indicators', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __('Autoplay', STM_DOMAIN),
				'param_name' => 'autoplay',
				'value' => 0,
				'description' => __('Autoplay Speed in milliseconds', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __('Number of Columns (Normal Desktop)', STM_DOMAIN),
				'param_name' => 'columns_desktop',
				'value' => 3,
				'description' => __('Number of items the carousel will display. Default: at <980px - 3 items.', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __('Number of Columns (Normal Desktop)', STM_DOMAIN),
				'param_name' => 'columns_desktop',
				'value' => 3,
				'description' => __('Number of items the carousel will display. Default: at <980px - 3 items.', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __('Number of Columns (Tablet)', STM_DOMAIN),
				'param_name' => 'columns_tablet',
				'value' => 2,
				'description' => __('Number of items the carousel will display. Default: at <768px - 2 items.', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type' => 'textfield',
				'heading' => __('Number of Columns (Mobile)', STM_DOMAIN),
				'param_name' => 'columns_mobile',
				'value' => 1,
				'description' => __('Number of items the carousel will display. Default: at <479px - 1 item.', STM_DOMAIN),
				'group' => __( 'Carousel Settings', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Image @2X', STM_DOMAIN ),
				'param_name' => 'bg_image_retina',
				'group' => __( 'Design options', STM_DOMAIN )
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Background Position', STM_DOMAIN ),
				'param_name' => 'bg_position',
				'group' => __( 'Design options', STM_DOMAIN )
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Background Size', STM_DOMAIN ),
				'param_name' => 'bg_size',
				'group' => __( 'Design options', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Extra class name', STM_DOMAIN ),
				'param_name' 		=> 'class',
				'value'				=> '',
				'description'       => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Contact', STM_DOMAIN ),
		'base'        => 'stm_contact',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Name', STM_DOMAIN ),
				'param_name' => 'name'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'image_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Job', STM_DOMAIN ),
				'param_name' => 'job'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Phone', STM_DOMAIN ),
				'param_name' => 'phone'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Email', STM_DOMAIN ),
				'param_name' => 'email'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Skype', STM_DOMAIN ),
				'param_name' => 'skype'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Post Info', STM_DOMAIN ),
		'base'        => 'stm_post_info',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Post Tags', STM_DOMAIN ),
		'base'        => 'stm_post_tags',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Share', STM_DOMAIN ),
		'base'        => 'stm_share',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title',
				'value'      => __( 'Share', STM_DOMAIN )
			),
			array(
				'type'       => 'textarea_raw_html',
				'heading'    => __( 'Code', STM_DOMAIN ),
				'param_name' => 'code',
				'value'      => "<span class='st_facebook_large' displayText=''></span>
<span class='st_twitter_large' displayText=''></span>
<span class='st_googleplus_large' displayText=''></span>
<span class='st_sharethis_large' displayText=''></span>"
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Post Author Box', STM_DOMAIN ),
		'base'        => 'stm_post_author_box',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Post Comments', STM_DOMAIN ),
		'base'        => 'stm_post_comments',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
			)
		)
	) );

	$stm_sidebars_array = get_posts( array( 'post_type' => 'sidebar', 'posts_per_page' => -1 ) );
	$stm_sidebars = array( __( 'Select', STM_DOMAIN ) => 0 );
	if( $stm_sidebars_array ){
		foreach( $stm_sidebars_array as $val ){
			$stm_sidebars[ get_the_title( $val ) ] = $val->ID;
		}
	}

	vc_map( array(
		'name'        => __( 'STM Sidebar', STM_DOMAIN ),
		'base'        => 'stm_sidebar',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Code', STM_DOMAIN ),
				'param_name' => 'sidebar',
				'value'      => $stm_sidebars
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Vacancies', STM_DOMAIN ),
		'base'        => 'stm_vacancies',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Vacancy Details', STM_DOMAIN ),
		'base'        => 'stm_vacancy_details',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Pricing Tables', STM_DOMAIN ),
		'base'        => 'stm_pricing_tables',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Prefix', STM_DOMAIN ),
				'param_name' => 'price_prefix'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Price', STM_DOMAIN ),
				'param_name' => 'price'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Separator', STM_DOMAIN ),
				'param_name' => 'price_separator'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Postfix', STM_DOMAIN ),
				'param_name' => 'price_postfix'
			),
			array(
				'type'       => 'vc_link',
				'heading'    => __( 'Button', STM_DOMAIN ),
				'param_name' => 'button'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Label State', STM_DOMAIN ),
				'param_name' => 'label_state'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Label Text', STM_DOMAIN ),
				'param_name' => 'label_text'
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Text', STM_DOMAIN ),
				'param_name' => 'content'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

	vc_map( array(
		'name' => 'STM ' . __( 'Pages', STM_DOMAIN ),
		'base' => 'stm_pages',
		'icon' => 'icon-wpb-wp',
		'category' => __( 'STM Widgets', STM_DOMAIN ),
		'class' => 'wpb_vc_stm_widget',
		'weight' => - 50,
		'description' => __( 'Your sites WordPress Pages', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'js_composer' ),
				'param_name' => 'title',
				'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order by', 'js_composer' ),
				'param_name' => 'sortby',
				'value' => array(
					__( 'Page title', 'js_composer' ) => 'post_title',
					__( 'Page order', 'js_composer' ) => 'menu_order',
					__( 'Page ID', 'js_composer' ) => 'ID'
				),
				'description' => __( 'Select how to sort pages.', 'js_composer' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Include', STM_DOMAIN ),
				'param_name' => 'include',
				'description' => __( 'Enter page IDs to be excluded (Note: separate values by commas (,)).', 'js_composer' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
			)
		)
	) );

	vc_map( array(
		"name"                    => __( 'Animation Block', STM_DOMAIN ),
		"base"                    => 'stm_animation_block',
		"class"                   => 'animation_block',
		"as_parent"               => array( 'except' => 'stm_animation_block' ),
		"category"                => __( 'STM', STM_DOMAIN ),
		"params"                  => array(
			array(
				"type"       => "stm_animator",
				"class"      => "",
				"heading"    => __( "Animation", STM_DOMAIN ),
				"param_name" => "animation",
				"value"      => ""
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "Animation Duration (s)", STM_DOMAIN ),
				"param_name"  => "animation_duration",
				"value"       => 3,
				"description" => __( "How long the animation effect should last. Decides the speed of effect.", STM_DOMAIN ),
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "Animation Delay (s)", STM_DOMAIN ),
				"param_name"  => "animation_delay",
				"value"       => 0,
				"description" => __( "Delays the animation effect for seconds you enter above.", STM_DOMAIN ),
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "Viewport Position (%)", STM_DOMAIN ),
				"param_name"  => "viewport_position",
				"value"       => "90",
				"description" => __( "The area of screen from top where animation effects will start working.", STM_DOMAIN ),
			)
		),
		"js_view" => 'VcColumnView'
	) );

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Stm_Project_Details extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_Stm_Company_History extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_Stm_Partners extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_Stm_Animation_Block extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Stm_Project_Details_Item extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Company_History_Item extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Projects_Grid extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Partners_Item extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Staff extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Contacts_Widget extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Services_Widget extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Info_Box extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Icon_Box extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Posts extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Stats_Counter extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Testimonials extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Projects extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Contact extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Info extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Tags extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Share extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Author_Box extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Comments extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Sidebar extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Vacancies extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Vacancy_Details extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Icon_Button extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Pricing_Tables extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Pages extends WPBakeryShortCode {
	}
}


add_filter( 'vc_iconpicker-type-fontawesome', 'stm_construct_icons' );

function stm_construct_icons( $fonts ){

	$fonts['Construct Icons'] = array(
		array( "stm-house-1" => __( "House 1", STM_DOMAIN ) ),
		array( "stm-house-2" => __( "House 2", STM_DOMAIN ) ),
		array( "stm-house-3" => __( "House 3", STM_DOMAIN ) ),
		array( "stm-house-4" => __( "House 4", STM_DOMAIN ) ),
		array( "stm-house-5" => __( "House 5", STM_DOMAIN ) ),
		array( "stm-house-6" => __( "House 6", STM_DOMAIN ) ),
		array( "stm-house-7" => __( "House 7", STM_DOMAIN ) ),
		array( "stm-house-8" => __( "House 8", STM_DOMAIN ) ),
		array( "stm-school-1" => __( "School 1", STM_DOMAIN ) ),
		array( "stm-school-2" => __( "School 2", STM_DOMAIN ) ),
		array( "stm-school-3" => __( "School 3", STM_DOMAIN ) ),
		array( "stm-garage-1" => __( "Garage 1", STM_DOMAIN ) ),
		array( "stm-clinic-1" => __( "Clinic 1", STM_DOMAIN ) ),
		array( "stm-hospital-1" => __( "Hospital 1", STM_DOMAIN ) ),
		array( "stm-temple-1" => __( "Temple 1", STM_DOMAIN ) ),
		array( "stm-builder-1" => __( "Builder 1", STM_DOMAIN ) ),
		array( "stm-builder-2" => __( "Builder 2", STM_DOMAIN ) ),
		array( "stm-builder-3" => __( "Builder 3", STM_DOMAIN ) ),
		array( "stm-gardening-1" => __( "Gardening 1", STM_DOMAIN ) ),
		array( "stm-key-1" => __( "Key 1", STM_DOMAIN ) ),
		array( "stm-paint-1" => __( "Paint 1", STM_DOMAIN ) ),
		array( "stm-parking-1" => __( "Parking 1", STM_DOMAIN ) ),
		array( "stm-trophy-1" => __( "Trophy 1", STM_DOMAIN ) ),
		array( "stm-trophy-2" => __( "Trophy 2", STM_DOMAIN ) ),
		array( "stm-trophy-3" => __( "Trophy 3", STM_DOMAIN ) ),
		array( "stm-eco" => __( "Eco", STM_DOMAIN ) ),
		array( "stm-interior" => __( "Interior", STM_DOMAIN ) ),
		array( "stm-restaurant" => __( "Restaurant", STM_DOMAIN ) ),
		array( "stm-flag" => __( "Flag", STM_DOMAIN ) ),
		array( "stm-handshake" => __( "Handshake", STM_DOMAIN ) ),
		array( "stm-innovation" => __( "Innovation", STM_DOMAIN ) ),
		array( "stm-like" => __( "Like", STM_DOMAIN ) ),
		array( "stm-eye" => __( "Eye", STM_DOMAIN ) ),
		array( "stm-shield" => __( "Shield", STM_DOMAIN ) ),
		array( "stm-checkmark_1" => __( "CheckMark", STM_DOMAIN ) ),
		array( "stm-bargraph" => __( "BarGraph", STM_DOMAIN ) ),
	);

    return $fonts;
}

add_filter( 'vc_load_default_templates', 'vc_left_sidebar_template' );

function vc_left_sidebar_template( $data ) {
	$template               = array();
	$template['name']       = __( 'Content with left sidebar', STM_DOMAIN );
	$template['content']    = <<<CONTENT
        [vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column width="1/1" css=".vc_custom_1431077531940{padding-left: 45px !important;}" el_class="right_column" offset="vc_col-lg-9 vc_col-md-9"][/vc_column][/vc_row]
CONTENT;

	array_unshift( $data, $template );
	return $data;
}

add_filter( 'vc_load_default_templates', 'vc_right_sidebar_template' );

function vc_right_sidebar_template( $data ) {
	$template               = array();
	$template['name']       = __( 'Content with right sidebar', STM_DOMAIN );
	$template['content']    = <<<CONTENT
        [vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1" css=".vc_custom_1431077644772{padding-right: 45px !important;}" el_class="left_column" offset="vc_col-lg-9 vc_col-md-9"][/vc_column][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][/vc_row]
CONTENT;

	array_unshift( $data, $template );
	return $data;
}