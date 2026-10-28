# Fast Forest – Automad 2 Theme

Hochladen nach `packages/fastforest/fast-forest/`, dann Dashboard → Einstellungen → Theme „Fast Forest“.

## Templates
- **home** – Vollbild-Hero, Inhalt, neueste News (Unterseiten von /news), Kontaktbereich
- **page** – Seitenkopf mit Bild (Standardbild in globalen Einstellungen → „Seitenkopf: Hintergrundbild“)
- **page_no_header** – ohne Bildkopf (Impressum, Datenschutz)
- **news** – Übersicht der Unterseiten mit Paginierung
- **post** – News-Beitrag mit Datum und Zurück-Link
- **recruiting_form** – Bewerbungsformular (Felder wie das alte WP-Formular). Bewerbungen werden gespeichert (bevorzugt außerhalb des Web-Ordners in `../ff-recruiting-data`, sonst `config/ff-recruiting`), per Mail an den Empfänger geschickt (Seiteneinstellung, Standard niklas.koskowski@fast-forest.de) und mit Bestätigung an Bewerber. Eingeloggte Nutzer sehen auf der Seite Übersicht, Details, Löschen und CSV-Export. Mailversand über Dashboard → System → E-Mail. Spam-Schutz: Lockfeld, Mindestzeit, Rechenaufgabe, max. 5 Bewerbungen/Stunde pro IP.
- **sponsors** – Einleitung + je Stufe ein Blockfeld (`+platin`, `+gold`, `+silber`, `+bronze`, `+partner`). Jeder Block (Bild oder Abschnitt mit Logo + Text) wird eine Kachel im Raster; leere Stufen werden ausgeblendet.

## Blöcke
- Pagelist: `cards` (News), `tiles` (Fahrzeuge/Departments/Teams), `list`
- Filelist: `logos` (Sponsoren, grau → farbig), `grid` (Fotoraster)
- Snippet: `cta` (Recruiting-Band, Texte in globalen Einstellungen)

## Navigation
Bis zu 3 Ebenen. Seiten mit Template `news` oder „Unterseiten nicht im Menü aufklappen“ zeigen kein Dropdown.
Footer-Links: Seite → „Im Footer verlinken“.

Schrift Saira ist lokal eingebunden (SIL OFL, `assets/fonts/OFL.txt`) – keine Anfrage an Google.
