<# Fast Forest – 404 #>
<@~ components/base.php ~@>

<@~ snippet hero ~@>
	<section class="ff-banner ff-banner--plain">
		<div class="ff-banner__content">
			<p class="ff-eyebrow">Fehler 404</p>
			<h1 class="ff-banner__title">Falsche Abzweigung</h1>
			<p class="ff-banner__lead">Diese Seite gibt es nicht (mehr).</p>
		</div>
	</section>
<@~ end ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			<p class="am-block">
				<@ with '/' @>
					<a class="ff-btn" href="@{ url }">Zur Startseite</a>
				<@ end @>
			</p>
		</div>
	</main>
<@~ end ~@>
