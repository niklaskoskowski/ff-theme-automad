<# Fast Forest – Filelist: Sponsoren-Logos im Raster (Bildunterschrift = Name) #>
<ul class="ff-logos">
	<@ foreach in filelist @>
		<li class="ff-logo">
			<@~ with @{ :file } { width: 480, height: 240 } ~@>
				<img src="@{ :fileResized }" alt="@{ :caption | def (@{ :basename }) }" loading="lazy" width="@{ :widthResized }" height="@{ :heightResized }">
			<@~ end ~@>
		</li>
	<@ end @>
</ul>
