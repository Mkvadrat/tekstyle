<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( has_post_thumbnail() ){ ?>
		<div class="post_thumbnail">
            <a href="<?php if($post->ID == 29){echo '/?cat=5';}else{the_permalink();} ?>">
            <?php echo get_the_post_thumbnail( get_the_ID(), 'thumb-335x170' ); ?>
                <h4 class="post_title"><a href="<?php if($post->ID == 29){echo '/?cat=5';}else{the_permalink();} ?>"><?php the_title(); ?></a></h4>
            </a>
        </div>
	<?php } ?>
</li>
<script>
    jQuery(document).ready(function(){
        jQuery('.posts_grid .post_title').each(function(){
        elemHeight = jQuery(this).height()/1.5;
            console.log('test' + elemHeight);
            jQuery(this).css({'margin-top':'-'+elemHeight+'px'});
    });
    });
</script>