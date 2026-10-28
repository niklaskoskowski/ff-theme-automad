<# Fast Forest – News-Beitrag: Datum im Seitenkopf, Zurück-Link zur Übersicht #>
<@~ components/base.php ~@>

<@~ snippet hero ~@>
	<@ if @{ date } @>
		<@ set { :ffEyebrow: @{ date | dateFormat ('j. F Y', 'de') } } @>
	<@ end @>
	<@ components/banner.php @>
<@~ end ~@>

<@~ snippet content ~@>
	<main class="ff-main ff-main--article" id="inhalt">
		<div class="ff-container">
			@{ +main }
			<p class="am-block ff-back">
				<@ with @{ :parent } @>
					<a href="@{ url }">&larr; Zurück zu @{ title }</a>
				<@ end @>
			</p>
		</div>
	</main>
<@~ end ~@>
