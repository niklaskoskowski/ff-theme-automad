<# Fast Forest – Startseite: Vollbild-Hero, Inhalt, News, Kontakt #>
<@~ components/base.php ~@>

<@~ snippet hero ~@>
	<@~ set { :ffHeroImg: false } ~@>
	<@~ set { :ffHeroImg: @{ imageHero | def (@{ imageHeader }) } } ~@>
	<section class="ff-hero<@ if not @{ :ffHeroImg } @> ff-hero--plain<@ end @>">
		<@~ with @{ :ffHeroImg } { width: 2560 } ~@>
			<img class="ff-hero__bg" src="@{ :fileResized }" alt="" fetchpriority="high" width="@{ :widthResized }" height="@{ :heightResized }">
		<@~ end ~@>
		<div class="ff-hero__content">
			<@ if @{ textHeroEyebrow } @>
				<p class="ff-eyebrow">@{ textHeroEyebrow }</p>
			<@ end @>
			<h1 class="ff-hero__title">@{ textHeroTitle | def (@{ title }) }</h1>
			<@ if @{ textHeroSubtitle } @>
				<p class="ff-hero__lead">@{ textHeroSubtitle }</p>
			<@ end @>
			<@ if @{ urlHeroButton } @>
				<a class="ff-btn" href="@{ urlHeroButton }">@{ textHeroButton | def ('Mehr erfahren') }</a>
			<@ end @>
		</div>
		<a class="ff-hero__scroll" href="#inhalt" aria-label="Zum Inhalt scrollen"></a>
	</section>
<@~ end ~@>

<@~ snippet afterContent ~@>
	<@ if not @{ checkboxHideNews } @>
		<@ set { :ffNewsUrl: @{ urlNewsContext | def ('/news') } } @>
		<@ newPagelist {
			type: 'children',
			context: @{ :ffNewsUrl },
			sort: 'date desc',
			limit: @{ numberNewsCount | def (3) }
		} @>
		<@ if @{ :pagelistCount } @>
			<section class="ff-section ff-section--muted" aria-labelledby="ff-news-title">
				<div class="ff-container">
					<div class="ff-section__head am-block">
						<h2 id="ff-news-title" class="ff-heading">@{ textNewsTitle | def ('News') }</h2>
						<p>@{ textNewsSubtitle | def ('Aktuelles aus der Werkstatt') }</p>
					</div>
					<div class="ff-cards am-block">
						<@ foreach in pagelist @>
							<@ components/card.php @>
						<@ end @>
					</div>
					<p class="am-block ff-section__more">
						<a class="ff-btn ff-btn--ghost" href="@{ :ffNewsUrl }">Alle News</a>
					</p>
				</div>
			</section>
		<@ end @>
	<@ end @>

	<@ if @{ +contact } @>
		<section class="ff-contact" aria-label="Kontakt">
			<@~ with @{ imageContact } { width: 2400 } ~@>
				<img class="ff-contact__bg" src="@{ :fileResized }" alt="" loading="lazy">
			<@~ end ~@>
			<div class="ff-container ff-contact__inner">
				@{ +contact }
			</div>
		</section>
	<@ end @>
<@~ end ~@>
