<?php global $stm_option; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
	<div class="content_wrapper">
		<?php if( ! is_404() ){ ?>
			<header id="header">
				<?php if( get_header_style() != 'header_style_dark' && get_header_style() != 'header_style_white' ){ ?>
					<div class="header_top">
						<div class="container">

							<div class="logo block-01">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="/wp-content/themes/tek/assets/images/logo_default.png" alt="ТЭК Стиль" /></a>
							</div>
                            <div class="icon_text block-02">
                                <div class="text">
                                    <span>д.4, ул.Леси Украинки,</span><br />
                                    <span>г.Симферополь, Крым, Россия</span><br />
                                    <span>+7 3652 51 56 77</span><br />
                                    <span>+7 9788 36 42 45</span><br />
                                    <span>tek14-vitcrimea@mail.ru</span>
                                </div>
                            </div>
                            <div class="header_info">
                                <?php echo do_shortcode( '[espro-slider id=237]' ); ?>
                                <!--
                                <img src="/wp-content/themes/tek/assets/images/top-bg.png">
                                <span>Построим вместе!</span>
                                -->
                            </div>
						</div>

                    </div>
				<?php } ?>
				<div class="top_nav">
					<div class="container">
						<div class="top_nav_wrapper clearfix">
							<?php
								wp_nav_menu( array(
										'theme_location' => 'primary_menu',
										'container' => false,
										'menu_class' => 'main_menu_nav'
									)
								);
							?>
						</div>
					</div>
				</div>
				<div class="mobile_header">
					<div class="logo_wrapper clearfix">
                        <div id="menu_toggle">
                            <button></button>
                        </div>
						<div class="logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="/wp-content/themes/tek/assets/images/logo_default.png" alt="ТЭК Стиль" /></a>
						</div>
					</div>
					<div class="header_info">
						<div class="top_nav_mobile">
							<?php
							wp_nav_menu( array(
									'theme_location' => 'primary_menu',
									'container' => false,
									'menu_class' => 'main_menu_nav'
								)
							);
							?>
						</div>
					</div>
				</div>
			</header>
		<?php } ?>
		<div id="main">
			<div class="container">