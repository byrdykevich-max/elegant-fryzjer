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
		'booksy_url'      => '', // np. 'https://elegantfryzjer.booksy.com'

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

		// --- Geo (approximate; Google geocodes from the address too) ---
		'geo_lat'         => '52.3210', // [PLACEHOLDER – przybliżone] zweryfikuj dokładne współrzędne
		'geo_lng'         => '21.0510', // [PLACEHOLDER – przybliżone]

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
		array(
			'id'    => 'damskie',
			'title' => __( 'Strzyżenie damskie', 'elegant-fryzjer' ),
			'lead'  => __( 'Strzyżenie, modelowanie i pielęgnacja dopasowane do struktury Twoich włosów.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie damskie + modelowanie', 'elegant-fryzjer' ), 'price' => '90 zł' ),
				array( 'name' => __( 'Modelowanie / układanie', 'elegant-fryzjer' ),           'price' => '60 zł' ),
				array( 'name' => __( 'Strzyżenie grzywki', 'elegant-fryzjer' ),                 'price' => '40 zł' ),
			),
		),
		array(
			'id'    => 'meskie',
			'title' => __( 'Strzyżenie męskie', 'elegant-fryzjer' ),
			'lead'  => __( 'Klasyczne i nowoczesne strzyżenia męskie, stylizacja od ręki.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie męskie', 'elegant-fryzjer' ),          'price' => '70 zł' ),
				array( 'name' => __( 'Strzyżenie maszynką', 'elegant-fryzjer' ),        'price' => '50 zł' ),
			),
		),
		array(
			'id'    => 'barber',
			'title' => __( 'Barber — broda i zarost', 'elegant-fryzjer' ),
			'lead'  => __( 'Stylizacja brody, modelowanie i tradycyjne golenie.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie brody / trymowanie', 'elegant-fryzjer' ), 'price' => '50 zł' ),
				array( 'name' => __( 'Strzyżenie włosów + broda', 'elegant-fryzjer' ),     'price' => '110 zł' ),
				array( 'name' => __( 'Golenie maszynką / brzytwą', 'elegant-fryzjer' ),    'price' => '80 zł' ),
			),
		),
		array(
			'id'    => 'dzieciece',
			'title' => __( 'Strzyżenie dziecięce', 'elegant-fryzjer' ),
			'lead'  => __( 'Spokojnie i bez stresu — strzyżenie dla najmłodszych.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Strzyżenie dziecięce (do 12 lat)', 'elegant-fryzjer' ), 'price' => '50 zł' ),
			),
		),
		array(
			'id'    => 'koloryzacja',
			'title' => __( 'Koloryzacja i rozjaśnianie', 'elegant-fryzjer' ),
			'lead'  => __( 'Koloryzacja, balayage, rozjaśnianie i metamorfozy koloru. Cena zależna od długości i gęstości włosów — dokładną wycenę podajemy po konsultacji.', 'elegant-fryzjer' ),
			'items' => array(
				array( 'name' => __( 'Koloryzacja jednolita', 'elegant-fryzjer' ),            'price' => 'od 150 zł' ),
				array( 'name' => __( 'Balayage / sombre', 'elegant-fryzjer' ),                'price' => 'od 250 zł' ),
				array( 'name' => __( 'Rozjaśnianie / dekoloryzacja', 'elegant-fryzjer' ),     'price' => 'od 200 zł' ),
				array( 'name' => __( 'Koloryzacja kreatywna', 'elegant-fryzjer' ),            'price' => 'od 300 zł' ),
			),
		),
	);
}
