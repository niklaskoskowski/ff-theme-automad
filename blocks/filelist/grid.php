<# Fast Forest – Filelist: Bildraster (quadratisch beschnitten, Bildunterschrift als Overlay) #>
<ul class="ff-photo-grid">
	<@ foreach in filelist @>
		<li>
			<@~ with @{ :file } { width: 700, height: 700, crop: true } ~@>
				<img src="@{ :fileResized }" alt="@{ :caption | stripTags }" loading="lazy" width="@{ :widthResized }" height="@{ :heightResized }">
			<@~ end ~@>
			<@ if @{ :caption } @>
				<span class="ff-photo-grid__caption">@{ :caption }</span>
			<@ end @>
		</li>
	<@ end @>
</ul>
