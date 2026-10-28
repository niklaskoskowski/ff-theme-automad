<# Fast Forest – Seite ohne Bild-Seitenkopf (z. B. Impressum, Datenschutz) #>
<@~ components/base.php ~@>

<@~ snippet hero ~@>
	<div class="ff-navbar-spacer"></div>
<@~ end ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			<h1 class="am-block ff-page-title">@{ title }</h1>
			@{ +main }
		</div>
	</main>
<@~ end ~@>
