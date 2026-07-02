<?php
/**
 * Page template: Kontakt (slug: kontakt).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$c      = ef_config();
$labels = ef_day_labels();
$sent   = isset( $_GET['wyslano'] ) ? sanitize_key( $_GET['wyslano'] ) : '';
$map_q  = rawurlencode( 'Elegant Fryzjer, ' . $c['street'] . ', ' . $c['city'] );
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Kontakt', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Skontaktuj się z nami', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Umów wizytę lub zadaj pytanie — odpowiemy najszybciej, jak to możliwe.', 'elegant-fryzjer' ); ?></p>
		</div>

		<div class="contact-grid">
			<!-- LEFT: NAP + hours + actions -->
			<div>
				<address>
					<ul class="info-list">
						<li><span class="k"><?php esc_html_e( 'Adres', 'elegant-fryzjer' ); ?></span><span><?php echo esc_html( $c['street'] ); ?>, <?php echo esc_html( trim( $c['postal'] . ' ' . $c['city'] ) ); ?>, <?php echo esc_html( $c['district'] ); ?></span></li>
						<li><span class="k"><?php esc_html_e( 'Telefon', 'elegant-fryzjer' ); ?></span><span><?php echo ef_phone_link(); ?></span></li>
						<?php if ( $c['instagram'] ) : ?>
						<li><span class="k">Instagram</span><span><a href="<?php echo esc_url( $c['instagram'] ); ?>" target="_blank" rel="noopener">@juli_fryzjer</a></span></li>
						<?php endif; ?>
					</ul>
				</address>

				<p class="site-footer__h" style="color:var(--ink);margin-top:var(--sp-4)"><?php esc_html_e( 'Godziny otwarcia', 'elegant-fryzjer' ); ?>
					<?php if ( empty( $c['hours_confirmed'] ) ) : ?><span class="badge-todo"><?php esc_html_e( '[do potwierdzenia]', 'elegant-fryzjer' ); ?></span><?php endif; ?>
				</p>
				<table class="hours">
					<?php foreach ( $c['hours'] as $d => $r ) : ?>
						<tr><th scope="row"><?php echo esc_html( $labels[ $d ] ); ?></th><td><?php echo $r ? esc_html( $r[0] . '–' . $r[1] ) : esc_html__( 'nieczynne', 'elegant-fryzjer' ); ?></td></tr>
					<?php endforeach; ?>
				</table>
				<?php ef_hours_note(); ?>

				<div class="hero__actions" style="margin-top:var(--sp-4)">
					<?php ef_cta( 'primary' ); ?>
				</div>
			</div>

			<!-- RIGHT: contact form -->
			<div id="kontakt-form">
				<h2><?php esc_html_e( 'Napisz do nas', 'elegant-fryzjer' ); ?></h2>
				<?php if ( $sent === 'ok' ) : ?>
					<p class="form-note form-note--ok" role="status"><?php esc_html_e( 'Dziękujemy! Wiadomość została wysłana — odezwiemy się wkrótce.', 'elegant-fryzjer' ); ?></p>
				<?php elseif ( $sent === 'blad' ) : ?>
					<p class="form-note form-note--err" role="alert"><?php esc_html_e( 'Nie udało się wysłać wiadomości. Sprawdź pola i spróbuj ponownie.', 'elegant-fryzjer' ); ?></p>
				<?php endif; ?>

				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
					<input type="hidden" name="action" value="ef_contact">
					<?php wp_nonce_field( 'ef_contact', 'ef_contact_nonce' ); ?>
					<!-- honeypot (hidden from humans) -->
					<div class="hp" aria-hidden="true"><label><?php esc_html_e( 'Nie wypełniaj', 'elegant-fryzjer' ); ?> <input type="text" name="ef_website" tabindex="-1" autocomplete="off"></label></div>

					<div class="field">
						<label for="ef_name"><?php esc_html_e( 'Imię i nazwisko', 'elegant-fryzjer' ); ?></label>
						<input id="ef_name" name="ef_name" type="text" required autocomplete="name">
					</div>
					<div class="field">
						<label for="ef_email"><?php esc_html_e( 'E-mail', 'elegant-fryzjer' ); ?></label>
						<input id="ef_email" name="ef_email" type="email" required autocomplete="email">
					</div>
					<div class="field">
						<label for="ef_message"><?php esc_html_e( 'Wiadomość', 'elegant-fryzjer' ); ?></label>
						<textarea id="ef_message" name="ef_message" rows="5" required></textarea>
					</div>
					<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Wyślij wiadomość', 'elegant-fryzjer' ); ?></button>
					<p class="muted" style="font-size:.85rem;margin-top:var(--sp-2)"><?php esc_html_e( 'Wysyłając formularz zgadzasz się na kontakt w sprawie zapytania.', 'elegant-fryzjer' ); ?> <a href="<?php echo esc_url( ef_url( '/polityka-prywatnosci/' ) ); ?>"><?php esc_html_e( 'Polityka prywatności', 'elegant-fryzjer' ); ?></a></p>
				</form>
			</div>
		</div>

		<!-- MAP: privacy-friendly, loads Google embed only on click -->
		<h2 style="margin-top:var(--sp-6)"><?php esc_html_e( 'Jak dojechać', 'elegant-fryzjer' ); ?></h2>
		<div class="map-consent" id="map-consent">
			<p class="muted"><?php esc_html_e( 'Mapa Google ładuje się dopiero po kliknięciu (ochrona prywatności / RODO).', 'elegant-fryzjer' ); ?></p>
			<button class="btn btn--primary" id="map-load" type="button"
			        data-src="https://maps.google.com/maps?q=<?php echo $map_q; ?>&output=embed">
				<?php esc_html_e( 'Pokaż mapę dojazdu', 'elegant-fryzjer' ); ?>
			</button>
			<p style="margin-top:var(--sp-2)"><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $map_q; ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Otwórz w Mapach Google →', 'elegant-fryzjer' ); ?></a></p>
		</div>
	</div>
</section>

<script>
/* Click-to-load map: no third-party request until the user opts in. */
document.getElementById('map-load')?.addEventListener('click', function () {
	var wrap = document.getElementById('map-consent');
	var src  = this.getAttribute('data-src');
	wrap.outerHTML = '<div class="map-embed"><iframe title="<?php echo esc_js( __( 'Mapa dojazdu do salonu Elegant Fryzjer', 'elegant-fryzjer' ) ); ?>" src="' + src + '" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>';
});
</script>
<?php get_footer(); ?>
