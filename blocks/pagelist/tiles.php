<# Fast Forest – Pagelist: Bildkacheln mit Titel-Overlay (Fahrzeuge, Departments, Teams) #>
<div class="ff-tiles">
	<@ foreach in pagelist @>
		<@ set { :ffTeaser: false } @>
		<@ set { :ffTeaser: @{ imageTeaser | def (@{ +hero | findFirstImage }) | def (@{ +main | findFirstImage }) | def (@{ imageHeader }) } } @>
		<a class="ff-tile" href="@{ url }" style="--ff-i: @{ :i }">
			<@~ with @{ :ffTeaser } { width: 800, height: 534, crop: true } ~@>
				<img src="@{ :fileResized }" alt="" loading="lazy" width="@{ :widthResized }" height="@{ :heightResized }">
			<@~ end ~@>
			<span class="ff-tile__title">@{ title }</span>
		</a>
	<@ end @>
</div>
