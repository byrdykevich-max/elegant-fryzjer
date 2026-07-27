<?php
/**
 * Central business configuration for the Elegant Fryzjer theme.
 *
 * EDIT THIS FILE to update business facts site-wide (NAP, phone, hours, booking).
 * Everything the templates and JSON-LD schema render comes from here, so there is
 * exactly one place to change a phone number, an address, or the booking link.
 *
 * Anything marked [PLACEHOLDER] is a fact I (the builder) was not given — replace it.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // no direct access

function ef_config() {
	return array(
		// --- Identity ---
		'name'            => 'Elegant Fryzjer', // brand name — never translated
		'tagline'         => __( 'Salon fryzjerski w Białołęce', 'elegant-fryzjer' ),

		// --- Legal identity (registered business — used only on the privacy policy page) ---
		'legal_name'      => 'Elegant Fryzjer Yuliya Burdukevich', // official CEIDG registered name, owner-confirmed 2026-07-02
		'nip'             => '5243075503', // owner-confirmed 2026-07-02

		// --- NAP (Name / Address / Phone) — used in footer, Kontakt page, and schema ---
		'street'          => 'ul. Mariana Hemara 5',
		'postal'          => '03-289',
		'city'            => 'Warszawa',
		'district'        => 'Białołęka',     // dzielnica — shown in the visible address; NOT addressRegion
		'region'          => 'Mazowieckie',   // województwo — JSON-LD addressRegion (schema.org PostalAddress)
		'country'         => 'PL',

		// --- Booking CTA (single swappable component) ---
		// Leave 'booksy_url' empty -> primary CTA is click-to-call (or contact form if no phone).
		// Paste your Booksy URL here -> it instantly becomes the primary CTA site-wide.
		'booksy_url'      => 'https://booksy.com/pl-pl/353136_elegant-fryzjer_fryzjer_3_warszawa',

		// Phone: set BOTH when you have the real number. Until then the click-to-call
		// is suppressed (we will NOT dial a fake number) and the CTA falls back to the form.
		'phone_tel'       => '+48511247513',             // for tel: links (no spaces)
		'phone_display'   => '+48 511 247 513',

		// --- Contact ---
		// Contact form delivers to the WordPress admin email regardless of this value.
		'email'           => '', // opcjonalny publiczny e-mail, np. 'kontakt@elegantfryzjer.pl'

		// --- Google Search Console verification ---
		// Paste ONLY the token from GSC "HTML tag" method (the content="..." value,
		// not the whole tag). Empty = no tag rendered. Works even while noindexed.
		'gsc_verification' => 'GVSWAltlEP7IgCO2kEH8Czfi5-HWxWEpjzOu0EA26zU', // GSC HTML-tag token

		// --- Social ---
		'instagram'       => 'https://www.instagram.com/juli_fryzjer/', // real (źródło zdjęć)
		'facebook'        => '', // [PLACEHOLDER] — wklej link do profilu FB jeśli jest

		// --- Geo ---
		// Geocoded 2026-07-02 from the real address (ul. Mariana Hemara 5, 03-289 Warszawa) via
		// OpenStreetMap/Nominatim — exact house-number + postcode match, not an approximation.
		'geo_lat'         => '52.3255881',
		'geo_lng'         => '21.0448901',

		// --- Opening hours ---
		// [PLACEHOLDER] — confirm real hours. 'hours_confirmed' => true gdy potwierdzone
		// (usuwa wtedy etykietę „do potwierdzenia" w stopce/Kontakcie).
		'hours_confirmed' => true,
		'hours'           => array(
			// dzień => array('HH:MM','HH:MM') lub null gdy nieczynne
			'Mo' => array( '10:00', '18:00' ),
			'Tu' => array( '10:00', '18:00' ),
			'We' => array( '10:00', '18:00' ),
			'Th' => array( '10:00', '18:00' ),
			'Fr' => array( '10:00', '18:00' ),
			'Sa' => array( '10:00', '14:00' ),
			'Su' => null,
		),
	);
}

/** Polish day labels for display. */
function ef_day_labels() {
	return array(
		'Mo' => __( 'Poniedziałek', 'elegant-fryzjer' ), 'Tu' => __( 'Wtorek', 'elegant-fryzjer' ), 'We' => __( 'Środa', 'elegant-fryzjer' ),
		'Th' => __( 'Czwartek', 'elegant-fryzjer' ), 'Fr' => __( 'Piątek', 'elegant-fryzjer' ), 'Sa' => __( 'Sobota', 'elegant-fryzjer' ), 'Su' => __( 'Niedziela', 'elegant-fryzjer' ),
	);
}

/**
 * Service catalogue — drives the Usługi/cennik page sections AND the schema offer catalog.
 * Prices are business facts (NOT translated): set here once, identical in every language.
 * 'from' prices use the "od" prefix, e.g. "od 150 zł". Update a number here to change it site-wide.
 */
function ef_services() {
	return array(
		// --- Men's (dark block; leads, dominant — client mix ~80% men) ---
		array(
			'id'    => 'meskie',
			'block' => 'dark',
			'icon'  => 'man',
			'title' => __( 'Strzyżenie męskie', 'elegant-fryzjer' ),
			'lead'  => __( 'Klasyczne i nowoczesne strzyżenia męskie, stylizacja od ręki. Mycie włosów wliczone w cenę.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie męskie (1 nakładka)', 'elegant-fryzjer' ),                 'price' => '60 zł' ),
				array( 'name' => __( 'Strzyżenie męskie', 'elegant-fryzjer' ),                               'price' => '80 zł' ),
				array( 'name' => __( 'Strzyżenie męskie (nożyczki)', 'elegant-fryzjer' ),                    'price' => '100 zł' ),
				array( 'name' => __( 'Farbowanie siwych włosów (kamuflaż)', 'elegant-fryzjer' ),             'price' => '80 zł' ),
			),
		),
		array(
			'id'    => 'broda',
			'block' => 'dark',
			'icon'  => 'scissors',
			'title' => __( 'Broda i zarost', 'elegant-fryzjer' ),
			'lead'  => __( 'Korekta, modelowanie i precyzyjny kontur brody.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Korekta brody / zarostu', 'elegant-fryzjer' ), 'price' => 'od 35 zł' ),
				array( 'name' => __( 'Modelowanie brody', 'elegant-fryzjer' ),       'price' => 'od 45 zł' ),
				array( 'name' => __( 'Premium (modelowanie, kontur, płynne przejścia)', 'elegant-fryzjer' ), 'price' => 'od 55 zł' ),
			),
		),
		array(
			'id'    => 'pakiety',
			'block' => 'dark',
			'icon'  => 'chair',
			'title' => __( 'Pakiety', 'elegant-fryzjer' ),
			'lead'  => __( 'Strzyżenie i broda w jednej wizycie, w niższej łącznej cenie.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie męskie + broda (korekta)', 'elegant-fryzjer' ),     'price' => '110 zł' ),
				array( 'name' => __( 'Strzyżenie męskie + broda (modelowanie)', 'elegant-fryzjer' ), 'price' => '120 zł' ),
				array( 'name' => __( 'Strzyżenie męskie + broda (premium)', 'elegant-fryzjer' ),     'price' => '130 zł' ),
				array( 'name' => __( 'Strzyżenie męskie + farbowanie siwych włosów (kamuflaż)', 'elegant-fryzjer' ), 'price' => '160 zł' ),
			),
		),
		// --- Women's, children's & care (light block; secondary but present) ---
		array(
			'id'    => 'damskie',
			'block' => 'light',
			'icon'  => 'woman',
			'title' => __( 'Strzyżenie damskie', 'elegant-fryzjer' ),
			'lead'  => __( 'Strzyżenie i modelowanie dopasowane do struktury Twoich włosów.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie damskie', 'elegant-fryzjer' ),                'price' => 'od 100 do 130 zł' ),
				array( 'name' => __( 'Strzyżenie grzywki', 'elegant-fryzjer' ),                 'price' => '25 zł' ),
				array( 'name' => __( 'Mycie + stylizacja / układanie', 'elegant-fryzjer' ),     'price' => 'od 60 do 110 zł' ),
			),
		),
		array(
			'id'    => 'dzieciece',
			'block' => 'light',
			'icon'  => 'children',
			'title' => __( 'Strzyżenie dziecięce', 'elegant-fryzjer' ),
			'lead'  => __( 'Spokojnie i bez stresu — strzyżenie dla najmłodszych.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie dziecięce (do 10 lat)', 'elegant-fryzjer' ), 'price' => '70 zł' ),
			),
		),
	);
}

/** Service categories belonging to one visual block ('dark' = men's, 'light' = women's/kids/care). */
function ef_services_block( $block ) {
	return array_values( array_filter( ef_services(), function ( $s ) use ( $block ) {
		return $s['block'] === $block;
	} ) );
}
