<?php
/**
 * Front page (Home). Title/description handled by WP + ef_head_meta().
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$c    = ef_config();
$gall = ef_gallery_images();
?>

<!-- HERO -->
<section class="hero" aria-labelledby="hero-title">
	<div class="container hero__grid">
		<div class="hero__copy">
			<span class="eyebrow"><?php echo esc_html__( 'Barber & Salon · Warszawa Białołęka', 'elegant-fryzjer' ); ?></span>
			<h1 class="hero__title" id="hero-title"><?php esc_html_e( 'Elegancka fryzura blisko domu — na Białołęce', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php echo wp_kses( __( 'Strzyżenie męskie, broda i barber — a także strzyżenie damskie i dziecięce. Salon prowadzi <strong>Julia</strong> — z dbałością o każdy detal i Twój komfort.', 'elegant-fryzjer' ), array( 'strong' => array() ) ); ?></p>
			<div class="hero__actions">
				<?php ef_cta( 'primary' ); ?>
				<?php echo ef_phone_link( true ); ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( ef_url( '/uslugi/' ) ); ?>"><?php esc_html_e( 'Zobacz usługi i cennik', 'elegant-fryzjer' ); ?></a>
			</div>
		</div>
		<div class="hero__media">
			<?php
			// Branding hero photo (theme asset, not a gallery item) — LCP element (eager + high priority).
			// Rollback: swap back to `ef_picture( $gall[0]['base'], $gall[0]['alt'], '(max-width: 860px) 92vw, 520px', true );`
			// to restore the previous real client-photo hero (gallery is untouched either way).
			echo ef_picture( 'hero-barber', esc_html__( 'Elegant Fryzjer — barber & salon', 'elegant-fryzjer' ), '(max-width: 860px) 92vw, 520px', true, get_template_directory_uri() . '/assets/img' );
			?>
			<span class="hero__badge"><?php echo esc_html__( 'Strzyżenia i stylizacja dla całej rodziny', 'elegant-fryzjer' ); ?></span>
		</div>
	</div>
</section>

<!-- SERVICES OVERVIEW -->
<section class="section--panel" aria-labelledby="uslugi-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Co robimy', 'elegant-fryzjer' ); ?></span>
			<h2 id="uslugi-title"><?php esc_html_e( 'Barber i fryzjer dla całej rodziny', 'elegant-fryzjer' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Jedno miejsce dla mężczyzn, kobiet i dzieci — od barberskiego strzyżenia po pielęgnację i stylizację.', 'elegant-fryzjer' ); ?></p>
		</div>
		<div class="grid grid--3">
			<?php foreach ( array_merge( ef_services_block( 'dark' ), ef_services_block( 'light' ) ) as $s ) : ?>
				<article class="card">
					<?php echo ef_service_icon( $s['icon'] ); ?>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p class="muted"><?php echo esc_html( $s['lead'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<p style="margin-top:var(--sp-4)"><a href="<?php echo esc_url( ef_url( '/uslugi/' ) ); ?>"><?php esc_html_e( 'Pełna lista usług i cennik →', 'elegant-fryzjer' ); ?></a></p>
	</div>
</section>

<!-- WHY US -->
<section aria-labelledby="why-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Dlaczego my', 'elegant-fryzjer' ); ?></span>
			<h2 id="why-title"><?php esc_html_e( 'Lokalny salon, w którym czujesz się dobrze', 'elegant-fryzjer' ); ?></h2>
		</div>
		<div class="grid grid--3">
			<article class="card"><h3><?php esc_html_e( 'Dla całej rodziny', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Barber, strzyżenie męskie, damskie i dziecięce w jednym miejscu na Białołęce.', 'elegant-fryzjer' ); ?></p></article>
			<article class="card"><h3><?php esc_html_e( 'Doświadczenie i pasja', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Salon prowadzi Julia — strzyżenia i barber z dbałością o detal.', 'elegant-fryzjer' ); ?></p></article>
			<article class="card"><h3><?php esc_html_e( 'Wygodny dojazd', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php printf( esc_html__( 'W sercu Białołęki — %s.', 'elegant-fryzjer' ), esc_html( $c['street'] ) ); ?></p></article>
		</div>
	</div>
</section>

<!-- FEATURED GALLERY STRIP -->
<section class="section--panel" aria-labelledby="gal-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Nasze realizacje', 'elegant-fryzjer' ); ?></span>
			<h2 id="gal-title"><?php esc_html_e( 'Efekty pracy salonu', 'elegant-fryzjer' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Prawdziwe metamorfozy i strzyżenia wykonane w Elegant Fryzjer.', 'elegant-fryzjer' ); ?></p>
		</div>
		<div class="gallery">
			<?php
			// Featured strip leads with men's/barber work (client mix ~80% men), mixing
			// the original batch with the 2026-07-06 batch, plus one women's shot.
			$featured = array( 1, 8, 12, 16, 23, 25 );
			foreach ( $featured as $fi ) : $g = $gall[ $fi ]; $g_url = ef_uploads_url( $g['month'] ?? '2026/06' ); ?>
				<button class="gallery__item<?php echo ! empty( $g['zoom'] ) ? ' gallery__item--zoom' : ''; ?>" data-full="<?php echo esc_url( $g_url . '/' . $g['base'] . '-1024x1024.jpg' ); ?>" aria-label="<?php printf( esc_attr__( 'Powiększ: %s', 'elegant-fryzjer' ), esc_attr( $g['alt'] ) ); ?>">
					<?php echo ef_picture( $g['base'], $g['alt'], '(max-width: 700px) 90vw, 360px', false, $g_url ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<p style="margin-top:var(--sp-4)"><a href="<?php echo esc_url( ef_url( '/galeria/' ) ); ?>"><?php esc_html_e( 'Zobacz całą galerię →', 'elegant-fryzjer' ); ?></a></p>
	</div>
</section>

<?php /* TODO: Reviews section (real Google/Booksy testimonials only, no fabricated content) goes here once supplied. See memory elegant-fryzjer-launch for context. */ ?>

<?php get_footer(); ?>
