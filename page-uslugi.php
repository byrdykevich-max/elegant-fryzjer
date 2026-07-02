<?php
/**
 * Page template: Usługi i cennik (slug: uslugi).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$services = ef_services();
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><?php esc_html_e( 'Cennik', 'elegant-fryzjer' ); ?></span>
			<h1 id="page-title"><?php esc_html_e( 'Usługi i cennik', 'elegant-fryzjer' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Pełna oferta salonu Elegant Fryzjer na Białołęce. Ceny koloryzacji zależą od długości i gęstości włosów — dokładną wycenę podajemy po krótkiej konsultacji.', 'elegant-fryzjer' ); ?></p>
		</div>

		<!-- quick jump links -->
		<nav aria-label="<?php esc_attr_e( 'Kategorie usług', 'elegant-fryzjer' ); ?>" class="hero__actions" style="margin-bottom:var(--sp-5)">
			<?php foreach ( $services as $s ) : ?>
				<a class="btn btn--ghost" href="#<?php echo esc_attr( $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="pricelist">
			<?php foreach ( $services as $s ) : ?>
				<section class="price-group" id="<?php echo esc_attr( $s['id'] ); ?>" aria-labelledby="h-<?php echo esc_attr( $s['id'] ); ?>">
					<h2 id="h-<?php echo esc_attr( $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></h2>
					<p class="price-group__lead"><?php echo esc_html( $s['lead'] ); ?></p>
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
			<?php endforeach; ?>
		</div>

		<div class="hero__actions" style="margin-top:var(--sp-5)">
			<?php ef_cta( 'primary', __( 'Umów wizytę', 'elegant-fryzjer' ) ); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
