<# Fast Forest – navbar
Three levels deep. Children are not listed for pages with the "news" template
or with "checkboxHideChildrenInNav" enabled. Uses ":current" / ":currentPath"
for active states.
#>
<@~ snippet ffNavLink ~@>
	<a href="@{ url }"<@ if @{ :current } @> aria-current="page"<@ end @>>@{ title }</a>
<@~ end ~@>

<@~ snippet ffNavState ~@>
	<@~ if @{ :current } @> is-active<@ end ~@>
	<@~ if @{ :currentPath } @> is-path<@ end ~@>
<@~ end ~@>

<@~ snippet ffNavHasChildren ~@>
	<@~ set { :ffHasChildren: false } ~@>
	<@~ if not @{ checkboxHideChildrenInNav } and @{ template } != 'news' ~@>
		<@~ newPagelist { type: 'children', context: @{ url } } ~@>
		<@~ if @{ :pagelistCount } ~@>
			<@~ set { :ffHasChildren: true } ~@>
		<@~ end ~@>
	<@~ end ~@>
<@~ end ~@>

<header class="ff-navbar" data-ff-navbar>
	<div class="ff-navbar__inner">
		<a class="ff-brand" href="<@ with '/' @>@{ url }<@ end @>" aria-label="@{ sitename } – Startseite">
			<@~ with @{ imageLogo } { height: 112 } ~@>
				<img class="ff-brand__img" src="@{ :fileResized }" alt="@{ sitename }">
			<@~ else ~@>
				<span class="ff-brand__text">@{ brand | def (@{ sitename }) }</span>
			<@~ end ~@>
		</a>
		<button class="ff-navbar__toggle" type="button" aria-expanded="false" aria-controls="ff-nav" data-ff-toggle>
			<span class="ff-navbar__bars" aria-hidden="true"><span></span><span></span><span></span></span>
			<span class="ff-sr">Menü</span>
		</button>
		<nav class="ff-nav" id="ff-nav" aria-label="Hauptnavigation">
			<# @{ checkboxHideChildrenInNav } #>
			<ul class="ff-nav__list">
				<@ newPagelist { type: 'children', context: '/' } @>
				<@ foreach in pagelist @>
					<@ ffNavHasChildren @>
					<li class="ff-nav__item<@ ffNavState @><@ if @{ :ffHasChildren } @> has-children<@ end @>">
						<@ ffNavLink @>
						<@ if @{ :ffHasChildren } @>
							<ul class="ff-nav__sub">
								<@ foreach in pagelist @>
									<@ ffNavHasChildren @>
									<li class="ff-nav__item<@ ffNavState @><@ if @{ :ffHasChildren } @> has-children<@ end @>">
										<@ ffNavLink @>
										<@ if @{ :ffHasChildren } @>
											<ul class="ff-nav__sub">
												<@ foreach in pagelist @>
													<li class="ff-nav__item<@ ffNavState @>">
														<@ ffNavLink @>
													</li>
												<@ end @>
											</ul>
										<@ end @>
									</li>
								<@ end @>
							</ul>
						<@ end @>
					</li>
				<@ end @>
			</ul>
			<@ if @{ urlNavButton } @>
				<a class="ff-btn ff-btn--small ff-nav__cta" href="@{ urlNavButton }">@{ textNavButton | def ('Jetzt bewerben') }</a>
			<@ end @>
		</nav>
	</div>
</header>
