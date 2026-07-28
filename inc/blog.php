<?php
/**
 * Polish-only tips blog ("Porady") under /porady/.
 *
 * Native WordPress `post` type, routed at /porady/%postname%/. The blog index
 * (/porady/) is served through a small custom rewrite layer, mirroring the
 * /en//uk/ pattern in inc/i18n.php. Single posts and category archives ride
 * on WordPress's own permastruct + category rewrite rules (set up below) —
 * no custom routing needed for those.
 *
 * Deliberately does NOT touch show_on_front / page_for_posts: those gate
 * is_front_page(), which the hreflang/canonical/JSON-LD logic in inc/i18n.php
 * and inc/schema.php depends on. Changing them would risk silently breaking
 * the 15-URL hreflang cluster.
 *
 * Blog posts/archives are Polish-only by construction, not by a special-case
 * guard: ef_current_relpath() (inc/i18n.php) only recognises is_front_page()/
 * is_page(), so a `post` singular or a category archive already gets zero
 * hreflang tags and no language-switcher alternate.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* -------------------------------------------------------------------------
 * 1) One-time setup: permalink structure, category base, the 4 categories,
 *    and the "Porady" nav item. Gated on EF_VER so the DB writes only run
 *    once per deploy, before ef_maybe_flush_rewrites() (inc/i18n.php, init
 *    priority 99) flushes rewrite rules.
 * ---------------------------------------------------------------------- */
function ef_blog_categories() {
	return array(
		'pielegnacja-wlosow' => array(
			'name'        => 'Pielęgnacja włosów',
			'description' => 'Porady o pielęgnacji włosów i skóry głowy.',
		),
		'broda' => array(
			'name'        => 'Broda',
			'description' => 'Porady o pielęgnacji i stylizacji brody.',
		),
		'strzyzenie' => array(
			'name'        => 'Strzyżenie',
			'description' => 'Porady o strzyżeniu i stylizacji fryzury.',
		),
		'dzieci' => array(
			'name'        => 'Dzieci',
			'description' => 'Porady o strzyżeniu i pielęgnacji włosów najmłodszych.',
		),
	);
}

function ef_maybe_setup_blog() {
	if ( get_option( 'ef_blog_ver' ) === EF_VER ) {
		return;
	}

	// Use WP_Rewrite's own setters, not update_option() directly: $wp_rewrite is
	// constructed early in bootstrap and caches these values in memory, so a raw
	// update_option() changes the DB row but leaves stale in-memory structures —
	// the subsequent flush_rewrite_rules() (inc/i18n.php, init priority 99) would
	// then regenerate rules from the *old* structure/category_base, silently
	// breaking /porady/kategoria/{slug}/ routing (and single-post permalinks).
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/porady/%postname%/' );
	$wp_rewrite->set_category_base( 'porady/kategoria' );

	foreach ( ef_blog_categories() as $slug => $cat ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term( $cat['name'], 'category', array(
				'slug'        => $slug,
				'description' => $cat['description'],
			) );
		}
	}

	ef_maybe_add_porady_nav_item();

	update_option( 'ef_blog_ver', EF_VER );
}
add_action( 'init', 'ef_maybe_setup_blog', 1 );

/** Add "Porady" to the primary menu once, as a real (wp-admin editable) menu item. */
function ef_maybe_add_porady_nav_item() {
	$menu_id = 2; // "Główne" — the menu assigned to theme_mods nav_menu_locations['primary'].
	$menu    = get_term( $menu_id, 'nav_menu' );
	if ( ! $menu || is_wp_error( $menu ) ) {
		return; // menu missing/renamed — don't guess, leave for manual setup
	}
	foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
		if ( in_array( 'porady-nav-item', (array) $item->classes, true ) ) {
			return; // already added
		}
	}
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'    => __( 'Porady', 'elegant-fryzjer' ),
		'menu-item-url'      => home_url( '/porady/' ),
		'menu-item-classes'  => 'porady-nav-item',
		'menu-item-status'   => 'publish',
		'menu-item-position' => 5, // after Kontakt (positions 0/2/3/4 — see wp_posts menu items)
	) );
}

/* -------------------------------------------------------------------------
 * 2) Polish-only nav item: hide it on /en/ and /uk/ — there is no translated
 *    blog to send those visitors to. Runs after ef_localize_menu()
 *    (inc/i18n.php, default priority) so other items are already
 *    language-prefixed by the time this filters the list.
 * ---------------------------------------------------------------------- */
function ef_hide_porady_nav_outside_pl( $items ) {
	if ( 'pl' === ef_lang() ) {
		return $items;
	}
	return array_values( array_filter( $items, function ( $item ) {
		return ! in_array( 'porady-nav-item', (array) $item->classes, true );
	} ) );
}
add_filter( 'wp_nav_menu_objects', 'ef_hide_porady_nav_outside_pl', 20 );

/* -------------------------------------------------------------------------
 * 3) Routing: /porady/ (index) and /porady/page/N/ (pagination).
 * ---------------------------------------------------------------------- */
function ef_blog_query_vars( $vars ) {
	$vars[] = 'ef_blog';
	return $vars;
}
add_filter( 'query_vars', 'ef_blog_query_vars' );

function ef_blog_rewrite_rules() {
	add_rewrite_rule( '^porady/?$', 'index.php?ef_blog=1', 'top' );
	add_rewrite_rule( '^porady/page/([0-9]+)/?$', 'index.php?ef_blog=1&paged=$matches[1]', 'top' );
}
add_action( 'init', 'ef_blog_rewrite_rules' );

function ef_blog_pre_get_posts( $query ) {
	if ( ! $query->is_main_query() || ! $query->get( 'ef_blog' ) ) {
		return;
	}
	$query->set( 'post_type', 'post' );
	$query->set( 'posts_per_page', 9 );
	// NOTE: do NOT set $query->is_home = false here. WP_Query::parse_query()
	// treats any unrecognised main-query request as the blog home when
	// show_on_front === 'posts' (true on this site) — that's also what makes
	// is_front_page() true for this route. Forcing is_home off removes that,
	// but WP::handle_404() then has no recognised is_* flag left to match and
	// 404s the request instead. Correct fix: leave is_home/is_front_page alone
	// (keeps the 200 + template selection working) and explicitly exempt this
	// route from the front-page-specific hreflang/canonical/title output at
	// its render sites instead — see ef_current_relpath() (inc/i18n.php),
	// ef_head_meta() (functions.php) and the hero preload (header.php).
}
add_action( 'pre_get_posts', 'ef_blog_pre_get_posts' );

function ef_blog_template_include( $template ) {
	if ( get_query_var( 'ef_blog' ) ) {
		$custom = get_template_directory() . '/porady.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}
	return $template;
}
add_filter( 'template_include', 'ef_blog_template_include' );

/* -------------------------------------------------------------------------
 * 4) Comments OFF for posts (native RSS stays on — untouched). Belt & braces:
 *    filter comments_open()/pings_open() regardless of the per-post
 *    comment_status field (Phase 3 drafts also set comment_status=closed
 *    individually at creation).
 * ---------------------------------------------------------------------- */
function ef_blog_comments_closed( $open, $post_id ) {
	return 'post' === get_post_type( $post_id ) ? false : $open;
}
add_filter( 'comments_open', 'ef_blog_comments_closed', 10, 2 );
add_filter( 'pings_open', 'ef_blog_comments_closed', 10, 2 );

/* -------------------------------------------------------------------------
 * 5) noindex near-empty category archives (fewer than 3 published posts) —
 *    a thin-content guard, independent of the site-wide blog_public switch.
 * ---------------------------------------------------------------------- */
function ef_blog_robots_meta() {
	if ( is_category() ) {
		$term = get_queried_object();
		if ( $term && $term->count < 3 ) {
			echo '<meta name="robots" content="noindex,follow">' . "\n";
		}
	}
}
add_action( 'wp_head', 'ef_blog_robots_meta', 2 );

/* -------------------------------------------------------------------------
 * 6) Hero image size for post featured images (1200×675 — matches the
 *    BlogPosting `image` ≥1200×675 requirement). WordPress core (6.5+; this
 *    install is 7.0.2) auto-generates a WebP sub-size for JPEG uploads and
 *    prefers it in the rendered srcset automatically — no custom <picture>
 *    markup needed here, unlike the hand-built gallery pipeline in
 *    inc/gallery.php + ef_picture(), which predates that core feature.
 * ---------------------------------------------------------------------- */
add_image_size( 'ef-blog-hero', 1200, 675, true );

/* -------------------------------------------------------------------------
 * 7) Reusable scalp-health disclaimer block, via [ef_scalp_disclaimer].
 *    Placed manually inside post content where relevant — never
 *    auto-inserted — so it only appears on posts that actually need it.
 * ---------------------------------------------------------------------- */
function ef_scalp_disclaimer_shortcode() {
	ob_start();
	?>
	<aside class="disclaimer-box" role="note">
		<p>
			<strong><?php esc_html_e( 'Ważne:', 'elegant-fryzjer' ); ?></strong>
			<?php esc_html_e( 'Ten wpis ma charakter ogólnoinformacyjny i nie zastępuje konsultacji medycznej. Jeśli obserwujesz utrzymujące się dolegliwości skóry głowy (np. uporczywe swędzenie, łuszczenie, zaczerwienienie lub nasilone wypadanie włosów), skontaktuj się z dermatologiem lub trychologiem. Nie diagnozujemy chorób skóry ani nie gwarantujemy efektów — nasza rola ogranicza się do pielęgnacji i stylizacji włosów.', 'elegant-fryzjer' ); ?>
		</p>
	</aside>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ef_scalp_disclaimer', 'ef_scalp_disclaimer_shortcode' );

/* -------------------------------------------------------------------------
 * 8) Author box — Julia. Only owner-confirmed facts already live on /o-nas/
 *    (10+ years, Białołęka, direct consultation style). Links to the
 *    canonical bio page instead of duplicating it.
 * ---------------------------------------------------------------------- */
function ef_author_box() {
	?>
	<aside class="author-box" aria-labelledby="author-box-title">
		<p id="author-box-title" class="author-box__eyebrow"><?php esc_html_e( 'Autorka', 'elegant-fryzjer' ); ?></p>
		<p class="author-box__name">Julia</p>
		<p class="author-box__bio muted">
			<?php esc_html_e( 'Ponad dziesięć lat doświadczenia i profesjonalne kwalifikacje fryzjerskie. Prowadzi Elegant Fryzjer na warszawskiej Białołęce.', 'elegant-fryzjer' ); ?>
		</p>
		<a class="author-box__link" href="<?php echo esc_url( ef_url( '/o-nas/' ) ); ?>"><?php esc_html_e( 'Poznaj Julię →', 'elegant-fryzjer' ); ?></a>
	</aside>
	<?php
}

/* -------------------------------------------------------------------------
 * 9) Post card — shared by porady.php (index) and category.php (archive).
 * ---------------------------------------------------------------------- */
function ef_post_card( $post_id ) {
	$cats = get_the_category( $post_id );
	?>
	<article class="card post-card">
		<a class="post-card__media" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" tabindex="-1" aria-hidden="true">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $post_id, 'ef-blog-hero', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?>
			<?php endif; ?>
		</a>
		<?php if ( ! empty( $cats ) ) : ?>
			<span class="post-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
		<?php endif; ?>
		<h3 class="post-card__title"><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
		<p class="post-card__excerpt muted"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), 24 ) ); ?></p>
	</article>
	<?php
}

/* -------------------------------------------------------------------------
 * 10) Simple prev/next pagination, shared by porady.php and category.php.
 * ---------------------------------------------------------------------- */
function ef_blog_pagination() {
	$links = paginate_links( array(
		'prev_text' => __( '← Poprzednie', 'elegant-fryzjer' ),
		'next_text' => __( 'Następne →', 'elegant-fryzjer' ),
		'type'      => 'array',
	) );
	if ( ! $links ) {
		return;
	}
	echo '<nav class="pagination" aria-label="' . esc_attr__( 'Nawigacja stron', 'elegant-fryzjer' ) . '"><ul class="pagination__list">';
	foreach ( $links as $link ) {
		echo '<li>' . $link . '</li>';
	}
	echo '</ul></nav>';
}

/* -------------------------------------------------------------------------
 * 11) BlogPosting JSON-LD — one per post, replacing (not adding to) the
 *     site-wide HairSalon schema on that URL (see the is_singular('post')
 *     guard in inc/schema.php's ef_schema_jsonld()).
 * ---------------------------------------------------------------------- */
function ef_blog_posting_jsonld() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	$post_id = get_queried_object_id();
	$c       = ef_config();
	$url     = get_permalink( $post_id );

	// headline must match the H1 (single.php: the_title()) and stay ≤110 chars.
	$headline = get_the_title( $post_id );
	if ( function_exists( 'mb_strlen' ) && mb_strlen( $headline ) > 110 ) {
		$headline = mb_substr( $headline, 0, 110 );
	}

	$image = null;
	if ( has_post_thumbnail( $post_id ) ) {
		// 'ef-blog-hero' is a hard-cropped 1200×675 size (see §6 above) — meets
		// the ≥1200×675 BlogPosting image requirement exactly.
		$img_data = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'ef-blog-hero' );
		if ( $img_data ) {
			$image = array(
				'@type'  => 'ImageObject',
				'url'    => $img_data[0],
				'width'  => $img_data[1],
				'height' => $img_data[2],
			);
		}
	}

	$cats = get_the_category( $post_id );

	$data = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'BlogPosting',
		'@id'              => $url . '#article',
		'headline'         => $headline,
		'description'      => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
		'datePublished'    => get_the_date( 'c', $post_id ),
		'dateModified'     => get_the_modified_date( 'c', $post_id ),
		'inLanguage'       => 'pl-PL',
		'author'           => array(
			'@type' => 'Person',
			'name'  => 'Julia',
			'url'   => ef_url( '/o-nas/' ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => $c['name'],
			'logo'  => array(
				'@type' => 'ImageObject',
				'url'   => get_template_directory_uri() . '/assets/icons/icon-512.png',
			),
		),
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => $url,
		),
	);
	if ( $image ) {
		$data['image'] = $image;
	}
	if ( ! empty( $cats ) ) {
		$data['articleSection'] = $cats[0]->name;
	}

	echo "\n<script type=\"application/ld+json\">\n"
		. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT )
		. "\n</script>\n";
}
add_action( 'wp_head', 'ef_blog_posting_jsonld', 20 );
