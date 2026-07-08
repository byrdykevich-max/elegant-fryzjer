<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
	/* No-flash theme: set data-theme on <html> before first paint.
	   A saved visitor choice wins; otherwise fall back to the OS preference. */
	(function(){document.documentElement.classList.add('js');try{var t=localStorage.getItem('ef-theme');if(t!=='light'&&t!=='dark'){t=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}document.documentElement.setAttribute('data-theme',t);}catch(e){}})();
	</script>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
	// Favicon / site icon set — EF monogram (brand gold on dark). Versioned with EF_VER for cache-busting.
	$ef_icons = get_template_directory_uri() . '/assets/icons';
	?>
	<link rel="icon" href="<?php echo esc_url( $ef_icons . '/favicon.ico?ver=' . EF_VER ); ?>" sizes="any">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( $ef_icons . '/ef.svg?ver=' . EF_VER ); ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $ef_icons . '/favicon-32.png?ver=' . EF_VER ); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $ef_icons . '/favicon-16.png?ver=' . EF_VER ); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $ef_icons . '/apple-touch-icon.png?ver=' . EF_VER ); ?>">
	<link rel="manifest" href="<?php echo esc_url( $ef_icons . '/site.webmanifest?ver=' . EF_VER ); ?>">
	<?php if ( is_front_page() ) :
		// Preload the hero (LCP element) so the browser fetches it before it discovers the <img> in the body.
		$ef_hero = get_template_directory_uri() . '/assets/img/hero-barber';
	?>
	<link rel="preload" as="image" type="image/webp"
	      imagesrcset="<?php echo esc_url( $ef_hero . '-768x768.webp' ); ?> 768w, <?php echo esc_url( $ef_hero . '-1024x1024.webp' ); ?> 1024w"
	      imagesizes="(max-width: 860px) 92vw, 520px">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Przejdź do treści', 'elegant-fryzjer' ); ?></a>

<header class="site-header" id="site-header">
	<div class="container site-header__inner">

		<a class="brand" href="<?php echo esc_url( ef_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Elegant Fryzjer — strona główna', 'elegant-fryzjer' ); ?>">
			<span class="brand__name">Elegant&nbsp;Fryzjer</span>
			<span class="brand__sub"><?php echo esc_html__( 'Salon & Barber · Białołęka', 'elegant-fryzjer' ); ?></span>
		</a>

		<div class="header-actions">
			<nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Menu główne', 'elegant-fryzjer' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'primary-nav__list',
					'fallback_cb'    => 'ef_nav_fallback',
					'depth'          => 1,
				) );
				?>
				<div class="primary-nav__cta">
					<?php ef_cta( 'primary' ); ?>
				</div>
			</nav>

			<?php ef_language_switcher(); ?>

			<!-- Theme toggle. aria-pressed reflects "dark active"; main.js keeps it in sync. -->
			<button class="theme-toggle" type="button" data-theme-toggle
			        aria-label="<?php esc_attr_e( 'Przełącz tryb jasny lub ciemny', 'elegant-fryzjer' ); ?>" aria-pressed="false">
				<svg class="icon-moon" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false">
					<path fill="currentColor" d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>
				</svg>
				<svg class="icon-sun" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false">
					<path fill="currentColor" d="M12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-15a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1zm0 18a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1zM2 12a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1zm18 0a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2h-1a1 1 0 0 1-1-1zM4.9 4.9a1 1 0 0 1 1.4 0l.7.7A1 1 0 1 1 5.6 7l-.7-.7a1 1 0 0 1 0-1.4zm12 12a1 1 0 0 1 1.4 0l.7.7a1 1 0 0 1-1.4 1.4l-.7-.7a1 1 0 0 1 0-1.4zM19.1 4.9a1 1 0 0 1 0 1.4l-.7.7A1 1 0 1 1 17 5.6l.7-.7a1 1 0 0 1 1.4 0zM7 17a1 1 0 0 1 0 1.4l-.7.7a1 1 0 0 1-1.4-1.4l.7-.7a1 1 0 0 1 1.4 0z"/>
				</svg>
				<span class="screen-reader-text"><?php esc_html_e( 'Przełącz motyw', 'elegant-fryzjer' ); ?></span>
			</button>

			<!-- Mobile menu toggle (JS enhances; button + aria-expanded) -->
			<button class="nav-toggle" aria-expanded="false" aria-controls="primary-nav">
				<span class="nav-toggle__bars" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'elegant-fryzjer' ); ?></span>
			</button>
		</div>
	</div>
</header>

<main id="main" class="site-main">
<?php
/** Fallback menu if no menu assigned yet — keeps nav usable before WP menu is set. */
function ef_nav_fallback() {
	$items = array(
		'/uslugi/'  => __( 'Usługi i cennik', 'elegant-fryzjer' ),
		'/o-nas/'   => __( 'O nas', 'elegant-fryzjer' ),
		'/galeria/' => __( 'Galeria', 'elegant-fryzjer' ),
		'/kontakt/' => __( 'Kontakt', 'elegant-fryzjer' ),
	);
	echo '<ul class="primary-nav__list">';
	foreach ( $items as $path => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( ef_url( $path ) ), esc_html( $label ) );
	}
	echo '</ul>';
}
