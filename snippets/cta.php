<# Fast Forest – CTA-Band (Texte in den globalen Einstellungen, z. B. Recruiting) #>
<div class="ff-cta am-block">
	<div class="ff-cta__text">
		<h2 class="ff-cta__title">@{ textCtaTitle | def ('Werde Teil des Teams') }</h2>
		<@ if @{ textCtaText } @>
			<p>@{ textCtaText }</p>
		<@ end @>
	</div>
	<@ if @{ urlCta } @>
		<a class="ff-btn ff-btn--dark" href="@{ urlCta }">@{ textCtaButton | def ('Jetzt bewerben') }</a>
	<@ end @>
</div>
