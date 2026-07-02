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
			<p class="lead"><?php echo wp_kses( __( 'Strzyżenie męskie, broda i barber — a także strzyżenie damskie, dziecięce i koloryzacja. Salon prowadzi <strong>Julia</strong> — z dbałością o każdy detal i Twój komfort.', 'elegant-fryzjer' ), array( 'strong' => array() ) ); ?></p>
			<div class="hero__actions">
				<?php ef_cta( 'primary' ); ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( ef_url( '/uslugi/' ) ); ?>"><?php esc_html_e( 'Zobacz usługi i cennik', 'elegant-fryzjer' ); ?></a>
			</div>
		</div>
		<div class="hero__media">
			<?php
			// First approved gallery image as the LCP element (eager + high priority).
			echo ef_picture( $gall[0]['base'], $gall[0]['alt'], '(max-width: 860px) 92vw, 520px', true );
			?>
			<span class="hero__badge"><?php echo esc_html__( 'Metamorfozy koloru & strzyżenia', 'elegant-fryzjer' ); ?></span>
		</div>
	</div>
</section>

<!-- SERVICES OVERVIEW -->
<section class="section--panel" aria-labelledby="uslugi-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Co robimy', 'elegant-fryzjer' ); ?></span>
			<h2 id="uslugi-title"><?php esc_html_e( 'Barber i fryzjer dla całej rodziny', 'elegant-fryzjer' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Jedno miejsce dla kobiet, mężczyzn i dzieci — od codziennego strzyżenia po pełną metamorfozę koloru i usługi barberskie.', 'elegant-fryzjer' ); ?></p>
		</div>
		<div class="grid grid--3">
			<?php
			$overview = array(
				array( __( 'Strzyżenie damskie', 'elegant-fryzjer' ), __( 'Strzyżenie, modelowanie i pielęgnacja dopasowane do Twoich włosów.', 'elegant-fryzjer' ) ),
				array( __( 'Strzyżenie męskie', 'elegant-fryzjer' ), __( 'Klasyczne i nowoczesne cięcia, stylizacja od ręki.', 'elegant-fryzjer' ) ),
				array( __( 'Barber — broda', 'elegant-fryzjer' ), __( 'Modelowanie i stylizacja brody, tradycyjne golenie.', 'elegant-fryzjer' ) ),
				array( __( 'Strzyżenie dziecięce', 'elegant-fryzjer' ), __( 'Spokojnie i bez stresu — także dla najmłodszych.', 'elegant-fryzjer' ) ),
				array( __( 'Koloryzacja', 'elegant-fryzjer' ), __( 'Balayage, rozjaśnianie i metamorfozy koloru po konsultacji.', 'elegant-fryzjer' ) ),
				array( __( 'Stylizacja i modelowanie', 'elegant-fryzjer' ), __( 'Układanie na specjalne okazje i na co dzień.', 'elegant-fryzjer' ) ),
			);
			foreach ( $overview as $o ) : ?>
				<article class="card">
					<h3><?php echo esc_html( $o[0] ); ?></h3>
					<p class="muted"><?php echo esc_html( $o[1] ); ?></p>
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
			<article class="card"><h3><?php esc_html_e( 'Doświadczenie i pasja', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Salon prowadzi Julia — strzyżenia i koloryzacja z dbałością o detal.', 'elegant-fryzjer' ); ?></p></article>
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
			// Featured strip leads with men's/barber work (client mix ~80% men), then
			// women's colour work. Indices 0–2 are the men's photos; the hero already
			// uses index 0, so the strip starts at the other two men's shots (2, 1).
			$featured = array( 2, 4, 5, 7, 11, 16 );
			foreach ( $featured as $fi ) : $g = $gall[ $fi ]; ?>
				<button class="gallery__item<?php echo ! empty( $g['zoom'] ) ? ' gallery__item--zoom' : ''; ?>" data-full="<?php echo esc_url( ef_uploads_url() . '/' . $g['base'] . '-1024x1024.jpg' ); ?>" aria-label="<?php printf( esc_attr__( 'Powiększ: %s', 'elegant-fryzjer' ), esc_attr( $g['alt'] ) ); ?>">
					<?php echo ef_picture( $g['base'], $g['alt'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<p style="margin-top:var(--sp-4)"><a href="<?php echo esc_url( ef_url( '/galeria/' ) ); ?>"><?php esc_html_e( 'Zobacz całą galerię →', 'elegant-fryzjer' ); ?></a></p>
	</div>
</section>

<!-- LOCATION + HOURS SNIPPET -->
<section aria-labelledby="loc-title">
	<div class="container contact-grid">
		<div>
			<span class="eyebrow"><?php esc_html_e( 'Odwiedź nas', 'elegant-fryzjer' ); ?></span>
			<h2 id="loc-title"><?php esc_html_e( 'Adres i godziny', 'elegant-fryzjer' ); ?></h2>
			<ul class="info-list">
				<li><span class="k"><?php esc_html_e( 'Adres', 'elegant-fryzjer' ); ?></span><span><?php echo esc_html( $c['street'] . ', ' . $c['district'] . ', ' . $c['city'] ); ?></span></li>
				<li><span class="k"><?php esc_html_e( 'Telefon', 'elegant-fryzjer' ); ?></span><span><?php echo ef_phone_link(); ?></span></li>
			</ul>
			<div class="hero__actions">
				<?php ef_cta( 'primary' ); ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( ef_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Mapa i dojazd', 'elegant-fryzjer' ); ?></a>
			</div>
		</div>
		<div>
			<p class="site-footer__h" style="color:var(--ink)"><?php esc_html_e( 'Godziny otwarcia', 'elegant-fryzjer' ); ?>
				<?php if ( empty( $c['hours_confirmed'] ) ) : ?><span class="badge-todo"><?php esc_html_e( '[do potwierdzenia]', 'elegant-fryzjer' ); ?></span><?php endif; ?>
			</p>
			<table class="hours">
				<?php $labels = ef_day_labels(); foreach ( $c['hours'] as $d => $r ) : ?>
					<tr><th scope="row"><?php echo esc_html( $labels[ $d ] ); ?></th><td><?php echo $r ? esc_html( $r[0] . '–' . $r[1] ) : esc_html__( 'nieczynne', 'elegant-fryzjer' ); ?></td></tr>
				<?php endforeach; ?>
			</table>
			<?php ef_hours_note(); ?>
		</div>
	</div>
</section>

<!-- REVIEWS (placeholder — no fabricated testimonials) -->
<section class="section--panel" aria-labelledby="rev-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Opinie', 'elegant-fryzjer' ); ?></span>
			<h2 id="rev-title"><?php esc_html_e( 'Co mówią klienci', 'elegant-fryzjer' ); ?></h2>
		</div>
		<div class="card">
			<p class="muted">[PLACEHOLDER — sekcja opinii. Wstawimy tu prawdziwe opinie z Google / Booksy po Twojej akceptacji. Nie dodajemy zmyślonych recenzji.]</p>
		</div>
	</div>
</section>

<?php get_footer(); ?>
