<?php
/**
 * Page template: Galeria (slug: galeria).
 * Only RODO-safe, face-free photos (see inc/gallery.php). Lightbox via main.js.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$gall = ef_gallery_images();
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Galeria', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Nasze realizacje', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Prawdziwe metamorfozy, koloryzacje i strzyżenia wykonane w salonie Elegant Fryzjer. Kliknij zdjęcie, aby powiększyć.', 'elegant-fryzjer' ); ?></p>
		</div>

		<div class="gallery">
			<?php foreach ( $gall as $g ) : $g_url = ef_uploads_url( $g['month'] ?? '2026/06' ); ?>
				<button class="gallery__item<?php echo ! empty( $g['zoom'] ) ? ' gallery__item--zoom' : ''; ?>"
				        data-full="<?php echo esc_url( $g_url . '/' . $g['base'] . '-1024x1024.jpg' ); ?>"
				        aria-label="<?php printf( esc_attr__( 'Powiększ zdjęcie: %s', 'elegant-fryzjer' ), esc_attr( $g['alt'] ) ); ?>">
					<?php echo ef_picture( $g['base'], $g['alt'], '(max-width: 700px) 45vw, 300px', false, $g_url ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="hero__actions" style="margin-top:var(--sp-5)">
			<?php ef_cta( 'primary' ); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
