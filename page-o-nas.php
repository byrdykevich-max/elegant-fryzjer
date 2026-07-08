<?php
/**
 * Page template: O nas / Julia (slug: o-nas).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$gall = ef_gallery_images();
?>
<section aria-labelledby="page-title">
	<div class="container hero__grid">
		<div>
			<span class="icon-badge" style="display:flex;width:48px;height:48px"><?php ef_pictogram_img( 'barber-pole.png', 17, 40, 'about-icon' ); ?></span>
			<span class="eyebrow"><?php esc_html_e( 'O nas', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Salon prowadzi Julia', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Elegant Fryzjer to kameralny salon fryzjerski i barber na warszawskiej Białołęce, w którym liczy się indywidualne podejście i dobre samopoczucie klienta.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Specjalizujemy się w strzyżeniach damskich, męskich i dziecięcych oraz usługach barberskich — modelowaniu i stylizacji brody.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Julia ma ponad dziesięć lat doświadczenia i profesjonalne kwalifikacje fryzjerskie. Specjalizuje się w strzyżeniach męskich i usługach barberskich — fade’ach, klasycznych cięciach, modelowaniu i goleniu brody — z taką samą starannością podchodząc do strzyżeń damskich i dziecięcych.', 'elegant-fryzjer' ); ?></p>
			<p><?php esc_html_e( 'Jej podejście jest bezpośrednie: słucha, doradza w oparciu o Twoje realne włosy, a nie chwilowe trendy, i szczerze mówi, co naprawdę będzie Ci pasować. Celem nie jest tylko dobra fryzura w fotelu — ale taka, która sprawdza się jeszcze tydzień później.', 'elegant-fryzjer' ); ?></p>
			<div class="hero__actions">
				<?php ef_cta( 'primary' ); ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( ef_url( '/galeria/' ) ); ?>"><?php esc_html_e( 'Zobacz realizacje', 'elegant-fryzjer' ); ?></a>
			</div>
		</div>
		<div class="hero__media">
			<?php
			// Men's cut (no identifiable faces) as the about image — keeps the
			// About page men-led too. (Index 0, the salon-interior men's shot, is the homepage hero.)
			$about = $gall[1]; // men's haircut
			echo ef_picture( $about['base'], $about['alt'], '(max-width: 860px) 92vw, 480px' );
			?>
		</div>
	</div>
</section>

<section class="section--panel" aria-labelledby="values-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Nasze podejście', 'elegant-fryzjer' ); ?></span>
			<h2 id="values-title"><?php esc_html_e( 'Na czym nam zależy', 'elegant-fryzjer' ); ?></h2>
		</div>
		<div class="grid grid--3">
			<article class="card"><h3><?php esc_html_e( 'Konsultacja', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Zanim zaczniemy, rozmawiamy o Twoich oczekiwaniach i kondycji włosów.', 'elegant-fryzjer' ); ?></p></article>
			<article class="card"><h3><?php esc_html_e( 'Jakość', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Sprawdzone produkty i staranne wykończenie każdej fryzury.', 'elegant-fryzjer' ); ?></p></article>
			<article class="card"><h3><?php esc_html_e( 'Komfort', 'elegant-fryzjer' ); ?></h3><p class="muted"><?php esc_html_e( 'Spokojna, przyjazna atmosfera — także dla dzieci.', 'elegant-fryzjer' ); ?></p></article>
		</div>
	</div>
</section>
<?php get_footer(); ?>
