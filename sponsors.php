<# Fast Forest – Sponsoren: Einleitung (+main), dann je Stufe ein eigenes Blockfeld.
Jeder Block in einem Stufen-Feld wird eine Kachel im Raster: ein Bild-Block
(Logo, optional mit Link) oder ein Abschnitt mit Logo + Text. Leere Stufen
werden ausgeblendet, Überschriften sind in den Seiteneinstellungen änderbar.
#>
<@~ components/base.php ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			@{ +main }
			<@ if @{ +platin } @>
				<section class="ff-sponsor-tier">
					<h2 class="ff-sponsor-tier__title">@{ textTierPlatin | def ('Platin Partner') }</h2>
					<div class="ff-sponsors ff-sponsors--platin">@{ +platin }</div>
				</section>
			<@ end @>
			<@ if @{ +gold } @>
				<section class="ff-sponsor-tier">
					<h2 class="ff-sponsor-tier__title">@{ textTierGold | def ('Gold Partner') }</h2>
					<div class="ff-sponsors ff-sponsors--gold">@{ +gold }</div>
				</section>
			<@ end @>
			<@ if @{ +silber } @>
				<section class="ff-sponsor-tier">
					<h2 class="ff-sponsor-tier__title">@{ textTierSilber | def ('Silber Partner') }</h2>
					<div class="ff-sponsors ff-sponsors--silber">@{ +silber }</div>
				</section>
			<@ end @>
			<@ if @{ +bronze } @>
				<section class="ff-sponsor-tier">
					<h2 class="ff-sponsor-tier__title">@{ textTierBronze | def ('Bronze Partner') }</h2>
					<div class="ff-sponsors ff-sponsors--bronze">@{ +bronze }</div>
				</section>
			<@ end @>
			<@ if @{ +partner } @>
				<section class="ff-sponsor-tier">
					<h2 class="ff-sponsor-tier__title">@{ textTierPartner | def ('Partner') }</h2>
					<div class="ff-sponsors ff-sponsors--partner">@{ +partner }</div>
				</section>
			<@ end @>
			@{ +outro }
		</div>
	</main>
<@~ end ~@>
