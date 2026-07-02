<?php
/**
 * Page template: Polityka prywatności / RODO (slug: polityka-prywatnosci).
 *
 * Content describes what THIS site actually does (contact form, click-to-load
 * map, no tracking cookies) — not WordPress core's generic comment/login/
 * Gravatar boilerplate, which doesn't apply here and doesn't even mention the
 * contact form, the one real data-collection point on the site.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$c = ef_config();
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'RODO', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Polityka prywatności', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Jak przetwarzamy dane osobowe odwiedzających i klientów salonu Elegant Fryzjer.', 'elegant-fryzjer' ); ?></p>
		</div>

		<div style="max-width:70ch">
			<h2><?php esc_html_e( 'Administrator danych', 'elegant-fryzjer' ); ?></h2>
			<p>
				<?php
				printf(
					/* translators: %s: business street address */
					esc_html__( 'Administratorem danych osobowych przetwarzanych za pośrednictwem strony elegantfryzjer.pl jest podmiot prowadzący salon Elegant Fryzjer, %s.', 'elegant-fryzjer' ),
					esc_html( $c['street'] . ', ' . trim( $c['postal'] . ' ' . $c['city'] ) . ' (' . $c['district'] . ')' )
				);
				?>
				<?php esc_html_e( 'Kontakt w sprawach ochrony danych: telefonicznie lub przez formularz kontaktowy na stronie.', 'elegant-fryzjer' ); ?>
			</p>

			<h2><?php esc_html_e( 'Formularz kontaktowy', 'elegant-fryzjer' ); ?></h2>
			<p><?php esc_html_e( 'Za pośrednictwem formularza kontaktowego zbieramy imię i nazwisko, adres e-mail oraz treść wiadomości. Dane te są wykorzystywane wyłącznie w celu udzielenia odpowiedzi na przesłane zapytanie i nie są wykorzystywane do celów marketingowych bez odrębnej zgody.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Podstawą prawną przetwarzania jest art. 6 ust. 1 lit. f) RODO — prawnie uzasadniony interes administratora polegający na udzieleniu odpowiedzi na przesłane zapytanie.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Wiadomości z formularza są przesyłane bezpośrednio na skrzynkę e-mail administratora i nie są zapisywane w bazie danych strony. Przechowujemy je tak długo, jak jest to potrzebne do obsługi zapytania i ewentualnej dalszej korespondencji.', 'elegant-fryzjer' ); ?></p>

			<h2><?php esc_html_e( 'Komu przekazujemy dane', 'elegant-fryzjer' ); ?></h2>
			<p><?php esc_html_e( 'Korzystamy z zewnętrznego hostingu oraz automatycznych kopii zapasowych witryny przechowywanych na koncie Google Drive administratora — w tym zakresie dane mogą być czasowo przetwarzane przez dostawcę hostingu oraz Google jako podmioty przetwarzające.', 'elegant-fryzjer' ); ?></p>

			<h2><?php esc_html_e( 'Pliki cookie i mapa dojazdu', 'elegant-fryzjer' ); ?></h2>
			<p><?php esc_html_e( 'Strona nie wykorzystuje plików cookie do śledzenia ani profilowania odwiedzających. Wybór jasnego lub ciemnego motywu wyświetlania zapisywany jest wyłącznie lokalnie w przeglądarce (local storage) i nigdy nie jest przesyłany na serwer.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Mapa dojazdu (Mapy Google) na stronie Kontakt ładuje się dopiero po kliknięciu przycisku „Pokaż mapę dojazdu” — dopiero wtedy nawiązywane jest połączenie z Google i zaczyna obowiązywać polityka prywatności Google.', 'elegant-fryzjer' ); ?></p>

			<h2><?php esc_html_e( 'Twoje prawa', 'elegant-fryzjer' ); ?></h2>
			<p><?php esc_html_e( 'Zgodnie z RODO masz prawo dostępu do swoich danych, ich sprostowania, usunięcia, ograniczenia przetwarzania, przenoszenia danych oraz wniesienia sprzeciwu wobec przetwarzania. Przysługuje Ci również prawo wniesienia skargi do Prezesa Urzędu Ochrony Danych Osobowych.', 'elegant-fryzjer' ); ?></p>

			<h2><?php esc_html_e( 'Zmiany w polityce', 'elegant-fryzjer' ); ?></h2>
			<p><?php esc_html_e( 'Niniejsza polityka może być okresowo aktualizowana wraz ze zmianami na stronie. Aktualna wersja jest zawsze dostępna pod tym adresem.', 'elegant-fryzjer' ); ?></p>
		</div>
	</div>
</section>
<?php get_footer(); ?>
