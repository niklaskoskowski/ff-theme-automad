<#

Fast Forest – Automad theme
Base layout. Templates include this file first and then override
the snippets "hero", "content" and "afterContent" (last definition wins).

Fields that are only used inside pagelists or by other templates are
listed here so the dashboard shows them on every page:
@{ +hero } @{ imageTeaser } @{ textTeaser } @{ selectFooterLink } @{ textSubtitle } @{ imageHeader }

#>
<@~ set { :ffEyebrow: false } ~@>

<@~ snippet hero ~@>
	<@ banner.php @>
<@~ end ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			@{ +main }
		</div>
	</main>
<@~ end ~@>

<@~ snippet afterContent ~@><@~ end ~@>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#020202">
	<link rel="preload" href="/packages/@{ theme }/assets/fonts/saira-latin-standard-normal.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="stylesheet" href="/packages/@{ theme }/assets/fast-forest.css?v=1.4.2">
	<style>
		:root {
			--ff-accent: @{ colorAccent | def ('#9bc31c') };
		}
	</style>
	<script src="/packages/@{ theme }/assets/fast-forest.js?v=1.4.2" defer></script>
</head>
<body class="ff ff--@{ template | sanitize }">
	<a class="ff-skip" href="#inhalt">Zum Inhalt springen</a>
	<@ navbar.php @>
	<@ hero @>
	<@ content @>
	<@ afterContent @>
	<@ footer.php @>
</body>
</html>
