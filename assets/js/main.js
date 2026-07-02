/* Elegant Fryzjer — minimal progressive enhancement. No dependencies. */
(function () {
	'use strict';

	/* ---- Theme (dark/light) toggle ----
	   The inline <head> script already set data-theme before paint; here we wire
	   the button: flip the attribute, persist the choice, sync aria-pressed. */
	var root = document.documentElement;
	var themeBtn = document.querySelector('[data-theme-toggle]');
	function syncThemePressed() {
		if (themeBtn) {
			themeBtn.setAttribute('aria-pressed', root.getAttribute('data-theme') === 'dark' ? 'true' : 'false');
		}
	}
	syncThemePressed();
	if (themeBtn) {
		themeBtn.addEventListener('click', function () {
			var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('ef-theme', next); } catch (e) {}
			syncThemePressed();
		});
	}

	/* ---- Language switcher: disclosure dropdown + remember the visitor's pick
	   (the distinct per-language URL is the primary persistence; storing ef-lang
	   just records the preference, no auto-redirect). ---- */
	var langSwitcher = document.querySelector('[data-lang-switcher]');
	if (langSwitcher) {
		var langToggle = langSwitcher.querySelector('[data-lang-toggle]');
		var closeLang = function (focusToggle) {
			if (langSwitcher.classList.contains('is-open')) {
				langSwitcher.classList.remove('is-open');
				if (langToggle) {
					langToggle.setAttribute('aria-expanded', 'false');
					if (focusToggle) langToggle.focus();
				}
			}
		};
		if (langToggle) {
			langToggle.addEventListener('click', function () {
				var open = langSwitcher.classList.toggle('is-open');
				langToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
			document.addEventListener('keydown', function (e) {
				if (e.key === 'Escape') closeLang(true);
			});
			document.addEventListener('click', function (e) {
				if (!langSwitcher.contains(e.target)) closeLang(false);
			});
		}
		// Record the chosen language (and close the menu) when a link is clicked.
		langSwitcher.addEventListener('click', function (e) {
			var link = e.target.closest('[data-ef-lang]');
			if (link) {
				try { localStorage.setItem('ef-lang', link.getAttribute('data-ef-lang')); } catch (err) {}
			}
		});
	}

	/* ---- Mobile navigation toggle ---- */
	var toggle = document.querySelector('.nav-toggle');
	if (toggle) {
		toggle.addEventListener('click', function () {
			var open = document.body.classList.toggle('nav-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		// Close menu on Escape
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
				document.body.classList.remove('nav-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}

	/* ---- Accessible lightbox for the gallery ---- */
	var gallery = document.querySelector('.gallery');
	if (!gallery) return;

	var box = document.createElement('div');
	box.className = 'lightbox';
	box.setAttribute('role', 'dialog');
	box.setAttribute('aria-modal', 'true');
	var i18n = window.EF_I18N || {};
	box.setAttribute('aria-label', i18n.lightboxLabel || 'Powiększone zdjęcie');
	box.innerHTML = '<button class="lightbox__close" aria-label="' + (i18n.close || 'Zamknij') + '">×</button><img class="lightbox__img" alt="">';
	document.body.appendChild(box);

	var img = box.querySelector('.lightbox__img');
	var closeBtn = box.querySelector('.lightbox__close');
	var lastFocused = null;

	function open(src, alt) {
		lastFocused = document.activeElement;
		img.src = src;
		img.alt = alt || '';
		box.classList.add('is-open');
		closeBtn.focus();
	}
	function close() {
		box.classList.remove('is-open');
		img.src = '';
		if (lastFocused) lastFocused.focus();
	}

	gallery.addEventListener('click', function (e) {
		var btn = e.target.closest('.gallery__item');
		if (!btn) return;
		// Prefer the large image referenced via data-full; fall back to the rendered src.
		var full = btn.getAttribute('data-full');
		var im = btn.querySelector('img');
		open(full || (im && im.currentSrc) || (im && im.src), im && im.alt);
	});
	closeBtn.addEventListener('click', close);
	box.addEventListener('click', function (e) { if (e.target === box) close(); });
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && box.classList.contains('is-open')) close();
	});
})();
