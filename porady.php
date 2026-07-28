<?php
/**
 * Blog index template: /porady/ (custom route — see inc/blog.php §3).
 * Polish-only; no hreflang (this route never resolves via ef_current_relpath()
 * in inc/i18n.php, so no alternates/canonical juggling is needed here).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$cats = get_categories( array( 'taxonomy' => 'category', 'hide_empty' => false, 'exclude' => array( 1 ) ) ); // exclude default Uncategorized
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Blog', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Porady', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Praktyczne porady o pielęgnacji włosów, brody i strzyżeniu — od zespołu Elegant Fryzjer na Białołęce.', 'elegant-fryzjer' ); ?></p>
		</div>

		<?php if ( $cats ) : ?>
		<nav aria-label="<?php esc_attr_e( 'Kategorie porad', 'elegant-fryzjer' ); ?>" class="hero__actions" style="margin-bottom:var(--sp-5)">
			<?php foreach ( $cats as $cat ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
			<?php endforeach; ?>
		</nav>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); ef_post_card( get_the_ID() ); endwhile; ?>
			</div>
			<?php ef_blog_pagination(); ?>
		<?php else : ?>
			<p class="muted"><?php esc_html_e( 'Wkrótce pojawią się tu pierwsze porady — zajrzyj ponownie niebawem.', 'elegant-fryzjer' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();
get_footer();
