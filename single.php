<?php
/**
 * Single template: /porady/{post}/ — Polish-only tips blog post.
 * Native `post` type, no comments (see inc/blog.php §4), no hreflang
 * (ef_current_relpath() in inc/i18n.php only recognises pages/front page).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	$cats = get_the_category();
	?>
<article class="post" aria-labelledby="post-title">

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-hero">
		<?php the_post_thumbnail( 'ef-blog-hero', array(
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'decoding'      => 'async',
			'class'         => 'post-hero__img',
		) ); ?>
	</div>
	<?php endif; ?>

	<div class="container" style="max-width:760px">
		<div class="section__head">
			<?php if ( ! empty( $cats ) ) : ?>
			<span class="eyebrow"><a class="eyebrow__link" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a></span>
			<?php endif; ?>
			<h1 id="post-title"><?php the_title(); ?></h1>
			<p class="post-meta muted">
				<?php
				printf(
					/* translators: %s: publish date */
					esc_html__( 'Opublikowano: %s', 'elegant-fryzjer' ),
					esc_html( get_the_date() )
				);
				if ( get_the_modified_date( 'Y-m-d' ) !== get_the_date( 'Y-m-d' ) ) {
					echo ' · ';
					printf(
						/* translators: %s: last modified date */
						esc_html__( 'Aktualizacja: %s', 'elegant-fryzjer' ),
						esc_html( get_the_modified_date() )
					);
				}
				?>
			</p>
		</div>

		<div class="entry-content post-content">
			<?php the_content(); ?>
		</div>

		<div class="post-cta">
			<?php ef_cta( 'primary' ); ?>
			<?php echo ef_phone_link( true ); ?>
		</div>

		<?php ef_author_box(); ?>
	</div>
</article>
<?php endwhile; get_footer(); ?>
