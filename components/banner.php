<# Fast Forest – page header banner (title over dark image) #>
<@~ set { :ffBannerImg: false } ~@>
<@~ set { :ffBannerImg: @{ imageHeader } } ~@>
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
	</div>
</section>
