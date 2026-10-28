<# Fast Forest – Pagelist: kompakte Liste mit Datum #>
<ul class="ff-list">
	<@ foreach in pagelist @>
		<li>
			<a href="@{ url }">
				<span class="ff-list__title">@{ title }</span>
				<@ if @{ date } @>
					<time datetime="@{ date | dateFormat ('Y-m-d') }">@{ date | dateFormat ('j. M Y', 'de') }</time>
				<@ end @>
			</a>
		</li>
	<@ end @>
</ul>
