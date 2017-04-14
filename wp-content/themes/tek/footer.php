</div> <!--.container-->
</div> <!--#main-->
</div> <!--.content_wrapper-->
<?php if( ! is_404() ){ ?>
	<footer id="footer">
	    <?php get_sidebar( 'footer' ); ?>
	    <div class="footer_wrapper">
	        <div class="container" style="padding-left: 0px;">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-8 col-sm-8 hidden-xs sub-menus" style="padding-left: 0px;">
                    <?php
                    wp_nav_menu( array(
                            'theme_location' => 'left_menu',
                            'container' => false,
                            'menu_class' => 'main_menu_nav'
                        )
                    );
                    ?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-left: 25px;">
                    <div class="header_socials">
                        <a target="_blank" href="https://www.vk.com/">
                            <img src="/wp-content/themes/tek/assets/images/soc-vk.png"></i>
                        </a>
                        <a target="_blank" href="https://www.facebook.com/">
                            <img src="/wp-content/themes/tek/assets/images/soc-fb.png"></i>
                        </a>
                        <a target="_blank" href="https://www.twitter.com/">
                            <img src="/wp-content/themes/tek/assets/images/soc-tw.png"></i>
                        </a>
                        <a target="_blank" href="https://www.mail.ru/">
                            <img src="/wp-content/themes/tek/assets/images/soc-mail.png"></i>
                        </a>
                    </div>
                    <div class="footer-info">
                    <br />
                    <div class="col-xs-6">
                    <span>строительные и ремонтные <br />работы в Крыму "ТЭК Стиль"</span>
                    <br /><br />
                    <span>Адрес: </span><span class="italic">д.4, ул.Леси Украинки,</span><br />
                    <span>г.Симферополь, Крым, Россия</span><br /><br />
                    </div>
                        <div class="col-xs-6">
                    <span>Тел: </span><span class="italic">+7 3652 51 56 77</span><br />
                    <span>Тел: </span><span class="italic">+7 9788 36 42 45</span><br /><br />
                    <span>Эл. почта: </span><span class="italic"><a href="mailto:tek14-vitcrimea@mail.ru">tek14-vitcrimea@mail.ru</a></span><br />
                    </div>
                    </div>
                </div>
            </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="copyright">
                            <span class="col-xs-12">&copy; ТЭК Стиль Все права защищены</span>
                            <span class="col-xs-12 pull-right">Сделано в <a href="http://mkvadrat.com/" target="_blank">MKVADRAT</a></span>
                        </div>
                </div>
	        </div>
	    </div>
	</footer>
<?php } ?>
</div> <!--#wrapper-->
<?php wp_footer(); ?>

<div class="modal fade mail-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?php echo do_shortcode( '[contact-form-7 id="111" title="Contact form 1"]' ); ?>
        </div>
    </div>
</div>
</body>
</html>
