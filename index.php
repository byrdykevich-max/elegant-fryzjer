<?php
/**
 * Fallback template (required by WordPress). The site uses front-page.php and
 * page-{slug}.php templates; this covers any other query (e.g. 404, archives).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<section>
	<div class="container" style="max-width:760px">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Nie znaleziono strony', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Strona, której szukasz, nie istnieje.', 'elegant-fryzjer' ); ?></p>
			<p><a class="btn btn--primary" href="<?php echo esc_url( ef_url( '/' ) ); ?>"><?php esc_html_e( 'Wróć na stronę główną', 'elegant-fryzjer' ); ?></a></p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
