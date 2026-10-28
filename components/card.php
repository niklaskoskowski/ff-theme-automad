<# Fast Forest – news/page card. Used inside "foreach in pagelist". #>
<@~ set { :ffTeaser: false } ~@>
<@~ set { :ffTeaser: @{ imageTeaser | def (@{ +hero | findFirstImage }) | def (@{ +main | findFirstImage }) | def (@{ imageHeader }) } } ~@>
<@~ set { :ffExcerpt: false } ~@>
<@~ set { :ffExcerpt: @{ textTeaser | def (@{ +hero | findFirstParagraph | stripTags }) | def (@{ +main | findFirstParagraph | stripTags }) } } ~@>
<article class="ff-card" style="--ff-i: @{ :i }">
	<a class="ff-card__media" href="@{ url }" tabindex="-1" aria-hidden="true">
		<@~ with @{ :ffTeaser } { width: 800, height: 534, crop: true } ~@>
			<img src="@{ :fileResized }" alt="" loading="lazy" width="@{ :widthResized }" height="@{ :heightResized }">
		<@~ else ~@>
			<span class="ff-card__fallback"></span>
		<@~ end ~@>
	</a>
	<div class="ff-card__body">
		<@ if @{ date } @>
			<time class="ff-card__date" datetime="@{ date | dateFormat ('Y-m-d') }">@{ date | dateFormat ('j. F Y', 'de') }</time>
		<@ end @>
		<h3 class="ff-card__title"><a href="@{ url }">@{ title }</a></h3>
		<@ if @{ :ffExcerpt } @>
			<p class="ff-card__text">@{ :ffExcerpt | 160 }</p>
		<@ end @>
		<span class="ff-card__more" aria-hidden="true">Weiterlesen</span>
	</div>
</article>
