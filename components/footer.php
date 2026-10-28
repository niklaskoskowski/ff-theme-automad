<# Fast Forest – footer #>
<footer class="ff-footer">
	<div class="ff-footer__inner">
		<div class="ff-footer__brand">
			<a class="ff-brand" href="<@ with '/' @>@{ url }<@ end @>" aria-label="@{ sitename } – Startseite">
				<@~ with @{ imageLogo } { height: 112 } ~@>
					<img class="ff-brand__img" src="@{ :fileResized }" alt="@{ sitename }" loading="lazy">
				<@~ else ~@>
					<span class="ff-brand__text">@{ brand | def (@{ sitename }) }</span>
				<@~ end ~@>
			</a>
			<@ if @{ urlInstagram } or @{ urlLinkedin } or @{ urlFacebook } or @{ urlYoutube } or @{ urlVimeo } @>
				<ul class="ff-social" aria-label="Social Media">
					<@ if @{ urlInstagram } @>
						<li><a href="@{ urlInstagram }" target="_blank" rel="noopener" aria-label="Instagram">
							<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" class="ff-fill"/></svg>
						</a></li>
					<@ end @>
					<@ if @{ urlLinkedin } @>
						<li><a href="@{ urlLinkedin }" target="_blank" rel="noopener" aria-label="LinkedIn">
							<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10.5V17M8 7.5v.01M11.5 17v-6.5M11.5 13.5c0-1.7 1.2-3 2.75-3S17 11.8 17 13.5V17"/></svg>
						</a></li>
					<@ end @>
					<@ if @{ urlFacebook } @>
						<li><a href="@{ urlFacebook }" target="_blank" rel="noopener" aria-label="Facebook">
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8z"/></svg>
						</a></li>
					<@ end @>
					<@ if @{ urlYoutube } @>
						<li><a href="@{ urlYoutube }" target="_blank" rel="noopener" aria-label="YouTube">
							<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="M10 9.5v5l4.5-2.5z" class="ff-fill"/></svg>
						</a></li>
					<@ end @>
					<@ if @{ urlVimeo } @>
						<li><a href="@{ urlVimeo }" target="_blank" rel="noopener" aria-label="Vimeo">
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 8.5l1 1.2s2-1.5 2.6-.7c.6.7 2.6 9 3.3 10.4.6 1.2 2.3 2.8 4.2.3C16 17.3 21.5 9.8 21.8 6.1c.3-3.7-4.6-3.4-6.2.5 2.5-1.5 3.5.7 2.1 3.2-1.3 2.5-2.6 4.2-3.2 4.2-.7 0-1.2-1.6-1.9-4.6-.8-3.1-.8-8.6-4-8-3 .5-5.6 5.1-5.6 5.1z"/></svg>
						</a></li>
					<@ end @>
				</ul>
			<@ end @>
		</div>
		<@ if @{ +footer } @>
			<div class="ff-footer__content ff-prose">
				@{ +footer }
			</div>
		<@ end @>
	</div>
	<div class="ff-footer__bottom">
		<span>
			<@~ if @{ textCopyright } ~@>
				@{ textCopyright }
			<@~ else ~@>
				&copy; @{ :now | dateFormat ('Y') } @{ sitename }
			<@~ end ~@>
		</span>
		<# @{ selectFooterLink } #>
		<@ newPagelist { excludeHidden: false, match: '{ "selectFooterLink": "/show/" }', sort: ':index asc' } @>
		<@ if @{ :pagelistCount } @>
			<nav class="ff-footer__links" aria-label="Rechtliches">
				<@ foreach in pagelist ~@>
					<a href="@{ url }">@{ title }</a>
				<@~ end @>
			</nav>
		<@ end @>
	</div>
</footer>
