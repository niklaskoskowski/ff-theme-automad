<?php
// Fast Forest – Bewerbungsformular. Logic, fields and storage: lib/recruiting.php
require_once __DIR__ . '/lib/recruiting.php';
ff_rec_handle($Automad);
?>
<# Fast Forest – Bewerbungsformular
Einleitung im Feld "Inhalt" (+main), darunter das Formular, danach "+outro".
Eingeloggte Nutzer sehen oben die Bewerbungen (Übersicht, Details, CSV-Export).
Empfänger, Betreff der Bestätigung und Erfolgsmeldung in den Seiteneinstellungen.
Mailversand nutzt die Mail-Einstellungen des Dashboards (System → E-Mail).
#>
<@~ components/base.php ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			<?php echo ff_rec_render_admin($Automad); ?>
			@{ +main }
			<div class="am-block ff-form-wrap">
				<?php echo ff_rec_render_form(); ?>
			</div>
			@{ +outro }
		</div>
	</main>
<@~ end ~@>
<# @{ textRecruitingTo } @{ textRecruitingConfirmSubject } @{ textRecruitingSuccess } #>
