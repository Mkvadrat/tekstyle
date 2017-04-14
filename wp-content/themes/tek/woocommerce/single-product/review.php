<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '87' ), '', get_comment_author_email( $comment->comment_ID ) ); ?>

		<div class="comment-text">

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<div class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></div>

			<?php else : ?>

				<div class="meta">
					<strong class="author" itemprop="author"><?php comment_author(); ?></strong>
					<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
							<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo balanceTags( $rating, true ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
						</div>

					<?php endif; ?>
					<?php

						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )
								echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

					?><time class="published-date" itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( __( get_option( 'date_format' ), 'woocommerce' ) ); ?></time>
				</div>

			<?php endif; ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>
		</div>
	</div>
