<# Fast Forest – page header banner (title over dark image)
Background: first image in +hero, otherwise imageHeader (page or global default).
Other +hero blocks (paragraphs, buttons) are rendered below the title.
#>
<@~ set { :ffBannerImg: false } ~@>
<@~ set { :ffBannerImg: @{ +hero | findFirstImage | def (@{ imageHeader }) } } ~@>
<@~ set { :ffHeroText: false } ~@>
<@~ set { :ffHeroText: @{ +hero | replace ('#(<am-stretched>)?<figure.*?</figure>(</am-stretched>)?#is', '') } } ~@>
<section class="ff-banner<@ if not @{ :ffBannerImg } @> ff-banner--plain<@ end @>">
	<@~ with @{ :ffBannerImg } { width: 2400 } ~@>
		<img class="ff-banner__bg" src="@{ :fileResized }" alt="" width="@{ :widthResized }" height="@{ :heightResized }">
	<@~ end ~@>
	<div class="ff-banner__content">
		<@ if @{ :ffEyebrow } @>
			<p class="ff-eyebrow">@{ :ffEyebrow }</p>
		<@ end @>
		<h1 class="ff-banner__title">@{ title }</h1>
		<@ if @{ textSubtitle } @>
			<p class="ff-banner__lead">@{ textSubtitle }</p>
		<@ end @>
		<@ if @{ :ffHeroText | stripTags } @>
			<div class="ff-banner__blocks">@{ +hero | replace ('#(<am-stretched>)?<figure.*?</figure>(</am-stretched>)?#is', '') }</div>
		<@ end @>
	</div>
</section>
