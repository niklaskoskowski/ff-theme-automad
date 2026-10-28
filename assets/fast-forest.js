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
