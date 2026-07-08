<?php
/**
 * Page template: Usługi i cennik (slug: uslugi).
 *
 * Men's services lead (dark block, pinned dark tokens regardless of the site's
 * light/dark toggle — intentional poster-style contrast); women's/kids/care
 * follow in a light block (pinned light tokens). See style.css "PRICE BLOCKS".
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$services = ef_services();
$dark     = ef_services_block( 'dark' );
$light    = ef_services_block( 'light' );
$c        = ef_config();

/** Render one category's pictogram + price table (shared by both blocks). */
function ef_price_group( $s ) {
	?>
	<section class="price-group" id="<?php echo esc_attr( $s['id'] ); ?>" aria-labelledby="h-<?php echo esc_attr( $s['id'] ); ?>">
		<div class="price-group__head">
			<?php echo ef_service_icon( $s['icon'] ); ?>
			<div>
				<h3 id="h-<?php echo esc_attr( $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></h3>
				<p class="price-group__lead"><?php echo esc_html( $s['lead'] ); ?></p>
			</div>
		</div>
		<table class="price-table">
			<caption class="screen-reader-text"><?php printf( esc_html__( 'Cennik: %s', 'elegant-fryzjer' ), esc_html( $s['title'] ) ); ?></caption>
			<tbody>
			<?php foreach ( $s['items'] as $it ) : ?>
				<tr>
					<th scope="row"><?php echo esc_html( $it['name'] ); ?></th>
					<td><?php echo esc_html( $it['price'] ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</section>
	<?php
}
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Cennik', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Usługi i cennik', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Pełna oferta salonu Elegant Fryzjer na Białołęce — strzyżenia, broda i pielęgnacja dla całej rodziny.', 'elegant-fryzjer' ); ?></p>
		</div>

		<!-- quick jump links -->
		<nav aria-label="<?php esc_attr_e( 'Kategorie usług', 'elegant-fryzjer' ); ?>" class="hero__actions" style="margin-bottom:var(--sp-5)">
			<?php foreach ( $services as $s ) : ?>
				<a class="btn btn--ghost" href="#<?php echo esc_attr( $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></a>
			<?php endforeach; ?>
		</nav>
	</div>
</section>

<!-- MEN'S BLOCK — dark, dominant, leads (client mix ~80% men) -->
<section class="price-block price-block--dark" aria-labelledby="block-him-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Dla niego', 'elegant-fryzjer' ); ?></span>
			<h2 id="block-him-title"><?php esc_html_e( 'Strzyżenie, broda i barber', 'elegant-fryzjer' ); ?></h2>
		</div>
		<div class="pricelist">
			<?php foreach ( $dark as $s ) { ef_price_group( $s ); } ?>
		</div>
	</div>
</section>

<!-- WOMEN'S / KIDS / CARE BLOCK — light, secondary but present -->
<section class="price-block price-block--light" aria-labelledby="block-her-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Dla niej i dla najmłodszych', 'elegant-fryzjer' ); ?></span>
			<h2 id="block-her-title"><?php esc_html_e( 'Strzyżenie, stylizacja i pielęgnacja', 'elegant-fryzjer' ); ?></h2>
		</div>
		<div class="pricelist">
			<?php foreach ( $light as $s ) { ef_price_group( $s ); } ?>
		</div>
	</div>
</section>

<!-- INFO ICONS ROW -->
<section class="info-row" aria-labelledby="info-row-title">
	<div class="container">
		<h2 id="info-row-title" class="screen-reader-text"><?php esc_html_e( 'Dlaczego Elegant Fryzjer', 'elegant-fryzjer' ); ?></h2>
		<div class="info-row__grid">
			<div class="info-row__item">
				<?php echo ef_info_icon( 'booking' ); ?>
				<h3><?php esc_html_e( 'Łatwa rezerwacja telefoniczna', 'elegant-fryzjer' ); ?></h3>
			</div>
			<div class="info-row__item">
				<?php echo ef_info_icon( 'punctual' ); ?>
				<h3><?php esc_html_e( 'Punktualność', 'elegant-fryzjer' ); ?></h3>
			</div>
			<div class="info-row__item">
				<?php echo ef_info_icon( 'comfort' ); ?>
				<h3><?php esc_html_e( 'Komfortowa atmosfera', 'elegant-fryzjer' ); ?></h3>
			</div>
			<div class="info-row__item">
				<?php echo ef_info_icon( 'experience' ); ?>
				<h3><?php esc_html_e( 'Doświadczenie', 'elegant-fryzjer' ); ?></h3>
			</div>
		</div>
	</div>
</section>

<!-- FAMILY BANNER -->
<section class="family-banner" aria-labelledby="family-title">
	<div class="container family-banner__inner">
		<span class="icon-badge"><?php ef_pictogram_img( 'family.png', 43, 34 ); ?></span>
		<h2 id="family-title"><?php esc_html_e( 'Cała rodzina w jednym miejscu', 'elegant-fryzjer' ); ?></h2>
		<p><?php esc_html_e( 'Barber dla niego, strzyżenie i stylizacja dla niej, spokojne strzyżenie dla najmłodszych — wszystko w Elegant Fryzjer na Białołęce.', 'elegant-fryzjer' ); ?></p>
	</div>
</section>

<!-- CONTACT STRIP -->
<section class="contact-strip" aria-labelledby="contact-strip-title">
	<div class="container contact-strip__inner">
		<h2 id="contact-strip-title" class="screen-reader-text"><?php esc_html_e( 'Kontakt', 'elegant-fryzjer' ); ?></h2>
		<p class="contact-strip__item"><?php echo ef_phone_link(); // already renders its own ☎ icon — no phone.png here, would duplicate ?></p>
		<p class="contact-strip__item"><?php ef_pictogram_img( 'location.png', 14, 18 ); ?><?php echo esc_html( $c['street'] . ', ' . $c['district'] . ', ' . $c['city'] ); ?></p>
		<div class="contact-strip__cta"><?php ef_cta( 'primary', __( 'Umów wizytę', 'elegant-fryzjer' ) ); ?></div>
	</div>
</section>
<?php get_footer(); ?>
