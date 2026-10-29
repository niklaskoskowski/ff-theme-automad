/* Fast Forest – Automad theme */
(() => {
	const navbar = document.querySelector('[data-ff-navbar]');
	if (!navbar) return;

	const toggle = navbar.querySelector('[data-ff-toggle]');
	const nav = navbar.querySelector('.ff-nav');
	const mq = window.matchMedia('(max-width: 1100px)');

	/* Active path + submenu toggles */
	navbar.querySelectorAll('.ff-nav__list li').forEach((li) => {
		const sub = li.querySelector(':scope > ul');
		if (!sub) return;

		li.classList.add('has-children');

		const btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'ff-subtoggle';
		btn.setAttribute('aria-expanded', 'false');
		btn.setAttribute('aria-label', 'Untermenü ' + (li.querySelector(':scope > a')?.textContent || '').trim());
		btn.addEventListener('click', () => {
			const open = li.classList.toggle('is-open');
			btn.setAttribute('aria-expanded', String(open));
		});
		li.insertBefore(btn, sub);
	});

	const active = navbar.querySelector('.ff-nav__list li.is-active');
	let parent = active?.parentElement?.closest('li');
	while (parent) {
		parent.classList.add('is-path');
		if (mq.matches) {
			parent.classList.add('is-open');
			parent.querySelector(':scope > .ff-subtoggle')?.setAttribute('aria-expanded', 'true');
		}
		parent = parent.parentElement?.closest('li');
	}

	/* Mobile menu */
	const setMenu = (open) => {
		navbar.classList.toggle('is-menu-open', open);
		document.body.classList.toggle('ff-menu-open', open);
		toggle?.setAttribute('aria-expanded', String(open));
	};

	toggle?.addEventListener('click', () => setMenu(!navbar.classList.contains('is-menu-open')));

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && navbar.classList.contains('is-menu-open')) {
			setMenu(false);
			toggle?.focus();
		}
	});

	nav?.addEventListener('click', (e) => {
		if (e.target.closest('a') && mq.matches) setMenu(false);
	});

	mq.addEventListener('change', () => setMenu(false));

	/* Solid / hide-on-scroll navbar */
	let lastY = window.scrollY;
	let ticking = false;

	const onScroll = () => {
		const y = window.scrollY;
		navbar.classList.toggle('is-solid', y > 40);

		if (!navbar.classList.contains('is-menu-open') && !navbar.contains(document.activeElement)) {
			navbar.classList.toggle('is-hidden', y > 400 && y > lastY + 4);
			if (y < lastY - 4) navbar.classList.remove('is-hidden');
		}

		lastY = y;
		ticking = false;
	};

	window.addEventListener('scroll', () => {
		if (!ticking) {
			window.requestAnimationFrame(onScroll);
			ticking = true;
		}
	}, { passive: true });

	onScroll();

	/* Sponsor tiles: clamp description, "[…]" expands */
	document.querySelectorAll('.ff-sponsors section am-layout-section').forEach((tile) => {
		const isLink = (el) => {
			const a = el.querySelector('a');
			return a && el.textContent.trim() === a.textContent.trim();
		};
		const texts = [...tile.children].filter((el) => el.matches('p, ul, ol') && !isLink(el));
		tile.querySelectorAll(':scope > p').forEach((el) => { if (isLink(el)) el.classList.add('ff-sponsor__link'); });
		if (!texts.length) return;

		const wrap = document.createElement('div');
		wrap.className = 'ff-sponsor__text is-clamped';
		texts[0].before(wrap);
		texts.forEach((el) => wrap.append(el));

		if (wrap.scrollHeight <= wrap.clientHeight + 4) {
			wrap.classList.remove('is-clamped');
			return;
		}

		const btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'ff-sponsor__more';
		btn.textContent = '[…]';
		btn.setAttribute('aria-expanded', 'false');
		btn.addEventListener('click', () => {
			const open = wrap.classList.toggle('is-clamped') === false;
			btn.textContent = open ? 'weniger' : '[…]';
			btn.setAttribute('aria-expanded', String(open));
		});
		wrap.after(btn);
	});

	/* Recruiting form (recruiting_form.php) */
	const form = document.querySelector('[data-ff-recruiting]');

	if (form) {
		const status = form.querySelector('[data-ff-status]');
		const question = form.querySelector('[data-ff-question]');
		const button = form.querySelector('button[type="submit"]');
		const post = (data) => fetch(window.location.pathname, {
			method: 'POST',
			body: data,
			credentials: 'same-origin',
			headers: { Accept: 'application/json' }
		}).then((r) => r.json());

		const loadChallenge = () => {
			const data = new FormData();
			data.append('ff_action', 'challenge');
			post(data).then((res) => {
				question.textContent = res.question;
				form.elements.ff_token.value = res.token;
				form.elements.ff_answer.value = '';
			}).catch(() => {
				question.textContent = 'Rechenaufgabe konnte nicht geladen werden, bitte Seite neu laden. // Please reload the page.';
			});
		};

		const setError = (name, message) => {
			const el = form.querySelector(`[data-ff-error="${name}"]`);
			if (!el) return;
			el.textContent = message || '';
			el.closest('.ff-form__field')?.classList.toggle('is-invalid', Boolean(message));
		};

		const clearErrors = () => form.querySelectorAll('[data-ff-error]').forEach((el) => setError(el.dataset.ffError, ''));

		const validate = () => {
			let first = null;
			clearErrors();

			form.querySelectorAll('[data-ff-required-group]').forEach((group) => {
				if (!group.querySelector('input:checked')) {
					const name = group.querySelector('input').name.replace('[]', '');
					setError(name, 'Bitte mindestens eine Option wählen. // Please choose at least one option.');
					first = first || group.querySelector('input');
				}
			});

			form.querySelectorAll('input, select, textarea').forEach((el) => {
				if (!el.name || el.name.endsWith('[]') || el.checkValidity()) return;
				setError(el.name, el.type === 'email' && el.value ? 'Bitte gib eine gültige E-Mail-Adresse an. // Please enter a valid email address.' : 'Pflichtfeld // Required');
				first = first || el;
			});

			return first;
		};

		form.addEventListener('change', (e) => {
			const name = e.target.name?.replace('[]', '');
			if (name) setError(name, '');
		});

		form.addEventListener('submit', (e) => {
			e.preventDefault();
			status.textContent = '';
			status.className = 'ff-form__status';

			const invalid = validate();

			if (invalid) {
				invalid.closest('.ff-form__field')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
				invalid.focus({ preventScroll: true });
				status.textContent = 'Bitte prüfe die markierten Felder. // Please check the marked fields.';
				status.classList.add('is-error');
				return;
			}

			const data = new FormData(form);
			data.append('ff_action', 'submit');
			button.disabled = true;
			form.classList.add('is-busy');

			post(data).then((res) => {
				if (res.ok) {
					form.reset();
					form.classList.add('is-sent');
					status.textContent = res.message || '';
					status.classList.add('is-success');
					status.scrollIntoView({ behavior: 'smooth', block: 'center' });
					return;
				}

				Object.entries(res.fields || {}).forEach(([name, message]) => setError(name, message));
				if (res.field) setError(res.field, res.error);
				status.textContent = res.error || 'Fehler // Error';
				status.classList.add('is-error');
				if (res.field === 'ff_answer' || !res.fields) loadChallenge();
			}).catch(() => {
				status.textContent = 'Senden fehlgeschlagen, bitte später erneut versuchen. // Sending failed, please try again later.';
				status.classList.add('is-error');
			}).finally(() => {
				button.disabled = false;
				form.classList.remove('is-busy');
			});
		});

		loadChallenge();
	}

	/* Recruiting admin: status and notes */
	const adminPost = (fields) => {
		const data = new FormData();
		Object.entries(fields).forEach(([k, v]) => data.append(k, v));
		return fetch(window.location.pathname, { method: 'POST', body: data, credentials: 'same-origin' }).then((r) => r.json());
	};

	document.querySelectorAll('[data-ff-status-select]').forEach((select) => {
		select.addEventListener('change', () => {
			select.disabled = true;
			adminPost({ ff_action: 'status', id: select.dataset.ffStatusSelect, status: select.value })
				.then((res) => {
					if (!res.ok) throw new Error(res.error || 'Fehler');
					select.className = `ff-status ff-status--${select.value}`;
					select.closest('tr')?.classList.toggle('is-new', select.value === 'neu');
				})
				.catch((err) => window.alert(`Status konnte nicht gespeichert werden: ${err.message}`))
				.finally(() => { select.disabled = false; });
		});
	});

	document.querySelectorAll('[data-ff-note-save]').forEach((btn) => {
		const field = document.querySelector(`[data-ff-note="${btn.dataset.ffNoteSave}"]`);
		const saved = btn.parentElement.querySelector('[data-ff-saved]');
		btn.addEventListener('click', () => {
			btn.disabled = true;
			adminPost({ ff_action: 'note', id: btn.dataset.ffNoteSave, note: field.value })
				.then((res) => { saved.textContent = res.ok ? 'Gespeichert ✓' : 'Fehler beim Speichern'; })
				.catch(() => { saved.textContent = 'Fehler beim Speichern'; })
				.finally(() => { btn.disabled = false; });
		});
		field?.addEventListener('input', () => { saved.textContent = 'Nicht gespeichert'; });
	});

	/* Recruiting admin: delete entry */
	document.querySelectorAll('[data-ff-delete]').forEach((btn) => {
		btn.addEventListener('click', () => {
			if (!window.confirm('Diese Bewerbung endgültig löschen?')) return;
			const data = new FormData();
			data.append('ff_action', 'delete');
			data.append('id', btn.dataset.ffDelete);
			fetch(window.location.pathname, { method: 'POST', body: data, credentials: 'same-origin' })
				.then((r) => r.json())
				.then((res) => {
					if (res.ok) window.location.href = btn.dataset.ffBack;
					else window.alert(res.error || 'Fehler');
				});
		});
	});

	/* Reveal cards and tiles on scroll */
	if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		const items = document.querySelectorAll('.ff-card, .ff-tile');
		const io = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const el = entry.target;
					el.classList.add('is-visible');
					el.addEventListener('transitionend', () => el.classList.remove('ff-reveal', 'is-visible'), { once: true });
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -8% 0px' });

		items.forEach((el) => {
			el.classList.add('ff-reveal');
			io.observe(el);
		});
	}
})();
