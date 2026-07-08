<?php if ( ! defined( 'ABSPATH' ) ) { exit; } $c = ef_config(); $labels = ef_day_labels(); ?>
</main><!-- #main -->

<!-- Conversion band: repeated primary CTA before the footer -->
<section class="cta-band" aria-labelledby="cta-band-title">
	<div class="container cta-band__inner">
		<h2 id="cta-band-title" class="cta-band__title"><?php esc_html_e( 'Gotowa/gotowy na nowy look?', 'elegant-fryzjer' ); ?></h2>
		<p class="cta-band__text"><?php esc_html_e( 'Umów wizytę w Elegant Fryzjer na Białołęce.', 'elegant-fryzjer' ); ?></p>
		<div class="cta-band__actions">
			<?php ef_cta( 'primary' ); ?>
			<a class="btn btn--ghost" href="<?php echo esc_url( ef_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Jak dojechać', 'elegant-fryzjer' ); ?></a>
		</div>
	</div>
</section>

<footer class="site-footer" role="contentinfo">
	<div class="container site-footer__grid">

		<div class="site-footer__col">
			<p class="brand__name brand__name--footer">Elegant Fryzjer</p>
			<p class="muted"><?php echo esc_html( $c['tagline'] ); ?></p>
			<?php if ( $c['instagram'] || $c['facebook'] ) : ?>
			<p class="social">
				<?php if ( $c['instagram'] ) : ?>
					<a href="<?php echo esc_url( $c['instagram'] ); ?>" target="_blank" rel="noopener me"><?php ef_pictogram_img( 'instagram.png', 18, 18 ); ?>Instagram</a>
				<?php endif; ?>
				<?php if ( $c['facebook'] ) : ?>
					<a href="<?php echo esc_url( $c['facebook'] ); ?>" target="_blank" rel="noopener me">Facebook</a>
				<?php endif; ?>
			</p>
			<?php endif; ?>
		</div>

		<address class="site-footer__col">
			<p class="site-footer__h"><?php esc_html_e( 'Adres', 'elegant-fryzjer' ); ?></p>
			<p>
				<?php echo esc_html( $c['street'] ); ?><br>
				<?php echo esc_html( trim( $c['postal'] . ' ' . $c['city'] ) ); ?><br>
				<?php echo esc_html( $c['district'] ); ?>
			</p>
			<p><?php echo ef_phone_link(); // escaped inside helper ?></p>
		</address>

		<div class="site-footer__col">
			<p class="site-footer__h">
				<?php esc_html_e( 'Godziny otwarcia', 'elegant-fryzjer' ); ?>
				<?php if ( empty( $c['hours_confirmed'] ) ) : ?>
					<span class="badge-todo" title="<?php esc_attr_e( 'Do potwierdzenia przez właściciela', 'elegant-fryzjer' ); ?>"><?php esc_html_e( '[do potwierdzenia]', 'elegant-fryzjer' ); ?></span>
				<?php endif; ?>
			</p>
			<table class="hours">
				<tbody>
				<?php foreach ( $c['hours'] as $d => $range ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $labels[ $d ] ); ?></th>
						<td><?php echo $range ? esc_html( $range[0] . '–' . $range[1] ) : esc_html__( 'nieczynne', 'elegant-fryzjer' ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php ef_hours_note(); ?>
		</div>

		<nav class="site-footer__col" aria-label="<?php esc_attr_e( 'Stopka', 'elegant-fryzjer' ); ?>">
			<p class="site-footer__h"><?php esc_html_e( 'Nawigacja', 'elegant-fryzjer' ); ?></p>
			<ul class="footer-nav">
				<li><a href="<?php echo esc_url( ef_url( '/uslugi/' ) ); ?>"><?php esc_html_e( 'Usługi i cennik', 'elegant-fryzjer' ); ?></a></li>
				<li><a href="<?php echo esc_url( ef_url( '/o-nas/' ) ); ?>"><?php esc_html_e( 'O nas', 'elegant-fryzjer' ); ?></a></li>
				<li><a href="<?php echo esc_url( ef_url( '/galeria/' ) ); ?>"><?php esc_html_e( 'Galeria', 'elegant-fryzjer' ); ?></a></li>
				<li><a href="<?php echo esc_url( ef_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Kontakt', 'elegant-fryzjer' ); ?></a></li>
				<li><a href="<?php echo esc_url( ef_url( '/polityka-prywatnosci/' ) ); ?>"><?php esc_html_e( 'Polityka prywatności', 'elegant-fryzjer' ); ?></a></li>
			</ul>
		</nav>

	</div>
	<div class="site-footer__bar">
		<div class="container">
			<p class="muted">© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Elegant Fryzjer · <?php echo esc_html( $c['street'] . ', ' . $c['district'] . ', ' . $c['city'] ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
