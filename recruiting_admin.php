<?php
// Fast Forest – Bewerbungen verwalten. Logic: lib/recruiting.php
require_once __DIR__ . '/lib/recruiting.php';
ff_rec_admin_handle($Automad);
?>
<# Fast Forest – Bewerbungsverwaltung
Diese Seite als "Privat" anlegen: dann ist sie nur für eingeloggte Nutzer erreichbar.
Liste mit Suche, Filtern, Status und CSV-Export, Detailansicht mit Notiz und Löschen.
#>
<@~ components/base.php ~@>

<@~ snippet hero ~@>
	<div class="ff-navbar-spacer"></div>
<@~ end ~@>

<@~ snippet content ~@>
	<main class="ff-main ff-main--wide" id="inhalt">
		<div class="ff-container">
			<h1 class="am-block ff-page-title">@{ title }</h1>
			@{ +main }
			<?php echo ff_rec_render_admin_page($Automad); ?>
		</div>
	</main>
<@~ end ~@>
