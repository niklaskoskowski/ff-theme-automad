<?php
/*
 * Fast Forest – recruiting form backend (used by recruiting_form.php)
 *
 * Automad caches rendered pages for visitors, so nothing personal is ever rendered
 * into the page. The form talks to the same URL via fetch:
 *   POST ff_action=challenge  -> math question + signed token (JSON)
 *   POST ff_action=submit     -> validate, store, send mails (JSON)
 * Logged-in Automad users additionally get the entry list (?bewerbungen),
 * a detail view (?bewerbungen=<id>), CSV export (?bewerbungen=csv) and delete.
 *
 * Entries are stored as PHP files with an exit guard, preferably outside the
 * document root, otherwise in /config/ff-recruiting with a deny-all .htaccess.
 */

defined('AUTOMAD') or die('Direct access not permitted!');

if (!function_exists('ff_rec_fields')) {
	function ff_rec_fields(): array {
		$yesNo = array('Ja // Yes', 'Nein // No');

		return array(
			array('section' => 'Über dich // About you'),
			array('name' => 'vorname', 'type' => 'text', 'label' => 'Vorname // First name', 'required' => true, 'autocomplete' => 'given-name', 'half' => true),
			array('name' => 'nachname', 'type' => 'text', 'label' => 'Nachname // Last name', 'required' => true, 'autocomplete' => 'family-name', 'half' => true),
			array('name' => 'gender', 'type' => 'radio', 'label' => 'Gender', 'options' => array('male', 'female', 'diverse')),
			array('name' => 'email', 'type' => 'email', 'label' => 'E-Mail', 'required' => true, 'autocomplete' => 'email', 'half' => true),
			array('name' => 'telefon', 'type' => 'tel', 'label' => 'Handynummer // Phone number', 'required' => true, 'autocomplete' => 'tel', 'half' => true),

			array('section' => 'Studium // Studies'),
			array('name' => 'studiengang', 'type' => 'text', 'label' => 'Studiengang // Field of studies', 'required' => true),
			array('name' => 'abschluss', 'type' => 'radio', 'label' => 'Momentan angestrebter akademischer Grad? // Academic degree', 'required' => true, 'options' => array('Bachelor', 'Master')),
			array('name' => 'semester', 'type' => 'number', 'label' => 'Semester', 'required' => true, 'min' => 1, 'max' => 20, 'half' => true),
			array('name' => 'dual', 'type' => 'radio', 'label' => 'Bist du Dualer- oder Verbundstudent? // Are you a working student?', 'required' => true, 'options' => $yesNo),

			array('section' => 'Fast Forest'),
			array('name' => 'aufmerksam', 'type' => 'textarea', 'label' => 'Ich wurde auf Fast Forest aufmerksam durch? // I got aware of Fast Forest through', 'required' => true, 'rows' => 2),
			array(
				'name' => 'bereiche',
				'type' => 'checkbox',
				'label' => 'Ich interessiere mich bei Fast Forest für folgende Bereiche: // I am interested in the following fields of Fast Forest',
				'help' => 'Bitte nur die gewünschten Departments wählen, nicht alles. // Please only select your desired departments and not everything.',
				'required' => true,
				'options' => array(
					'Chassis (Carbonfiber Parts)',
					'Vehicle Dynamics (Aero & Suspension)',
					'Manufacturing',
					'Powertrain Mechanical',
					'Powertrain Electrical',
					'On-Board Electronics',
					'Software Engineering',
					'IT',
					'Marketing',
					'Business & Finance',
					'Organisation'
				)
			),
			array('name' => 'semester_vor_ort', 'type' => 'select', 'label' => 'Ich bin in den nächsten ... Semestern durchgehend an der THD und in Deggendorf (keine Praktika o. Ä.) // I will be at the THD and in Deggendorf throughout the next ... semesters (no internship or similar plans)', 'required' => true, 'options' => array('1', '2', '3', '4', '5', '6', '7')),
			array('name' => 'geplant', 'type' => 'textarea', 'label' => 'Nein, ich habe Folgendes geplant: // No, I have planned the following', 'rows' => 2),

			array('section' => 'Skills'),
			array('name' => 'skills', 'type' => 'text', 'label' => 'Ich besitze folgende Technical Skills // I have the following technical skills', 'help' => 'Z. B. Schweißen, Drehen, Fräsen, Lackieren, Umgang mit Steuergeräten // e.g. welding, turning, milling, painting, handling ECUs'),
			array('name' => 'deutsch', 'type' => 'scale', 'label' => 'Deutschkenntnisse // German skills', 'required' => true, 'max' => 10),
			array('name' => 'englisch', 'type' => 'scale', 'label' => 'Englischkenntnisse // English skills', 'required' => true, 'max' => 10),
			array('name' => 'programme', 'type' => 'textarea', 'label' => 'Sonstige Programme inkl. Kenntnisstand // Other skills or experience with software', 'help' => 'Office, Programmiersprachen, Media-Software etc. // Office, programming languages, media software, etc.', 'rows' => 3),

			array('section' => 'Motivation'),
			array('name' => 'motorsport', 'type' => 'textarea', 'label' => 'Hast du Erfahrungen im Motorsport? Erzähl uns davon: // Do you have experience in motorsport? Tell us about it:', 'rows' => 3),
			array('name' => 'motivation', 'type' => 'textarea', 'label' => 'Was motiviert dich, bei Fast Forest mitzumachen? // What is your motivation to join Fast Forest?', 'required' => true, 'rows' => 4),
			array(
				'name' => 'zeit',
				'type' => 'checkbox',
				'label' => 'Wann hast du Zeit? // When do you have time?',
				'required' => true,
				'options' => array(
					'Unter der Woche im Semester // During the week in the semester',
					'Unter der Woche in den Semesterferien // During the week in the semester holidays',
					'Am Wochenende im Semester // At the weekend during the semester',
					'Am Wochenende in den Semesterferien // At the weekend during the semester holidays'
				)
			),
			array(
				'name' => 'anhaenger',
				'type' => 'checkbox',
				'label' => 'Anhänger // Trailer',
				'help' => 'Um unsere Jennys im Hänger zu transportieren, brauchen wir Hängerfahrer, am besten mit passendem Fahrzeug mit Anhängerkupplung. // To transport our Jennys in the trailer we need trailer drivers, ideally with a suitable vehicle with a tow bar.',
				'required' => true,
				'options' => array('Hängerführerschein // Trailer license', 'Passendes Zugfahrzeug // Matching towing vehicle', 'Keines // None')
			),
			array('name' => 'fragen', 'type' => 'textarea', 'label' => 'Hast du noch Fragen zum Projekt oder uns etwas Wichtiges mitzuteilen? // Do you have any questions about the project?', 'rows' => 3),
			array('name' => 'lied', 'type' => 'text', 'label' => 'Dein Lied für Bärbl // Your song for our playlist „Bärbl“', 'required' => true, 'help' => 'Bärbl ist unsere Playlist für Nachtschichten: komplett schwachsinnige Lieder, bayerische Volksmusik, krasser Schranz oder Helene Fischer. Ziel: Keinem gefällt sie, also gibt es keine Diskussion über die Musik. // Bärbl is our playlist for long nights in the workshop: completely crazy songs, Bavarian folk music and the like. Nobody is supposed to like it, so nobody fights about the music.'),

			array('section' => 'Einverständniserklärung // Consent'),
			array(
				'name' => 'einwilligung',
				'type' => 'checkbox',
				'label' => 'Einverständniserklärung / Datenschutz // Consent form',
				'help' => 'Deine Daten werden streng vertraulich behandelt und nicht an Dritte weitergegeben. Ich bin ausdrücklich damit einverstanden, dass meine Angaben im Rahmen der Bewerberauswahl durch Fast Forest e.V. verwendet werden. // All data will be treated confidentially and not handed over to third parties. I expressly agree that the data can be used by Fast Forest e.V. for the recruiting process.',
				'required' => true,
				'options' => array('Ja, ich habe die Einverständniserklärung gelesen und stimme zu. // Yes, I have read the consent form and agree.')
			)
		);
	}

	function ff_rec_inputs(): array {
		return array_values(array_filter(ff_rec_fields(), fn ($f) => isset($f['name'])));
	}

	function ff_rec_h(?string $s): string {
		return htmlspecialchars(strval($s), ENT_QUOTES, 'UTF-8');
	}

	/* ---------- Storage ---------- */

	function ff_rec_dir(): string {
		static $dir = null;

		if ($dir !== null) {
			return $dir;
		}

		$outside = dirname(AM_BASE_DIR) . '/ff-recruiting-data';
		$inside = AM_BASE_DIR . '/config/ff-recruiting';

		foreach (array($outside, $inside) as $candidate) {
			if (!@is_dir($candidate)) {
				@mkdir($candidate, 0750, true);
			}

			if (@is_dir($candidate) && @is_writable($candidate)) {
				$dir = $candidate;
				break;
			}
		}

		if ($dir === null) {
			throw new RuntimeException('No writable storage directory for recruiting entries.');
		}

		if (!file_exists("$dir/.htaccess")) {
			@file_put_contents("$dir/.htaccess", "Require all denied\nDeny from all\n");
		}

		if (!file_exists("$dir/index.html")) {
			@file_put_contents("$dir/index.html", '');
		}

		return $dir;
	}

	function ff_rec_write(string $file, $data): void {
		$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		file_put_contents($file, "<?php exit; ?>\n" . $json, LOCK_EX);
	}

	function ff_rec_read(string $file) {
		$raw = @file_get_contents($file);

		if ($raw === false) {
			return null;
		}

		return json_decode(preg_replace('/^<\?php exit; \?>\n/', '', $raw), true);
	}

	function ff_rec_secret(): string {
		$file = ff_rec_dir() . '/secret.php';
		$data = ff_rec_read($file);

		if (empty($data['key'])) {
			$data = array('key' => bin2hex(random_bytes(32)));
			ff_rec_write($file, $data);
		}

		return $data['key'];
	}

	function ff_rec_entries(): array {
		$entries = array();

		foreach (glob(ff_rec_dir() . '/entry-*.php') ?: array() as $file) {
			$entry = ff_rec_read($file);

			if (is_array($entry)) {
				$entries[] = $entry;
			}
		}

		usort($entries, fn ($a, $b) => strcmp($b['created'] ?? '', $a['created'] ?? ''));

		return $entries;
	}

	function ff_rec_entry_file(string $id): ?string {
		if (!preg_match('/^[0-9]{8}-[0-9]{6}-[a-f0-9]{8}$/', $id)) {
			return null;
		}

		return ff_rec_dir() . "/entry-$id.php";
	}

	/* ---------- Spam protection ---------- */

	function ff_rec_challenge(): array {
		$a = random_int(2, 9);
		$b = random_int(1, 9);
		$ts = time();
		$sig = hash_hmac('sha256', ($a + $b) . '|' . $ts, ff_rec_secret());

		return array(
			'question' => "Was ist $a + $b? // What is $a + $b?",
			'token' => "$ts.$sig"
		);
	}

	function ff_rec_check_challenge(string $token, string $answer): ?string {
		if (!preg_match('/^(\d+)\.([a-f0-9]{64})$/', $token, $m)) {
			return 'Bitte lade die Seite neu. // Please reload the page.';
		}

		$age = time() - intval($m[1]);

		if ($age < 8) {
			return 'Das ging etwas zu schnell. Bitte versuche es gleich noch einmal. // That was a bit too fast, please try again.';
		}

		if ($age > 6 * 3600) {
			return 'Die Sitzung ist abgelaufen, bitte lade die Seite neu. // The session expired, please reload the page.';
		}

		$expected = hash_hmac('sha256', intval(trim($answer)) . '|' . $m[1], ff_rec_secret());

		if (!hash_equals($expected, $m[2])) {
			return 'Die Rechenaufgabe ist nicht richtig gelöst. // The math answer is wrong.';
		}

		return null;
	}

	function ff_rec_rate_limited(): bool {
		$file = ff_rec_dir() . '/ratelimit.php';
		$ip = hash_hmac('sha256', $_SERVER['REMOTE_ADDR'] ?? '', ff_rec_secret());
		$data = ff_rec_read($file) ?: array();
		$now = time();

		foreach ($data as $key => $times) {
			$data[$key] = array_values(array_filter($times, fn ($t) => $t > $now - 3600));

			if (!$data[$key]) {
				unset($data[$key]);
			}
		}

		$limited = count($data[$ip] ?? array()) >= 5;

		if (!$limited) {
			$data[$ip][] = $now;
		}

		ff_rec_write($file, $data);

		return $limited;
	}

	/* ---------- Validation ---------- */

	function ff_rec_validate(array $post): array {
		$values = array();
		$errors = array();

		foreach (ff_rec_inputs() as $f) {
			$name = $f['name'];
			$raw = $post[$name] ?? null;

			if ($f['type'] === 'checkbox') {
				$raw = is_array($raw) ? $raw : array();
				$value = array_values(array_intersect($f['options'], array_map('strval', $raw)));
				$empty = !$value;
			} else {
				$value = is_string($raw) ? trim(mb_substr($raw, 0, 5000)) : '';

				if (in_array($f['type'], array('radio', 'select'), true) && $value !== '' && !in_array($value, $f['options'], true)) {
					$value = '';
				}

				if ($f['type'] === 'scale' && $value !== '' && (!ctype_digit($value) || $value < 1 || $value > $f['max'])) {
					$value = '';
				}

				if ($f['type'] === 'number' && $value !== '' && !ctype_digit($value)) {
					$value = '';
				}

				if ($f['type'] === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$errors[$name] = 'Bitte gib eine gültige E-Mail-Adresse an. // Please enter a valid email address.';
				}

				$empty = $value === '';
			}

			if (!empty($f['required']) && $empty && !isset($errors[$name])) {
				$errors[$name] = 'Pflichtfeld // Required';
			}

			$values[$name] = $value;
		}

		return array($values, $errors);
	}

	/* ---------- Output helpers ---------- */

	function ff_rec_value_text($value): string {
		return is_array($value) ? implode("\n", $value) : strval($value);
	}

	function ff_rec_label_short(string $label): string {
		return trim(explode(' // ', $label)[0]);
	}

	function ff_rec_mail_table(array $values): string {
		$rows = '';

		foreach (ff_rec_inputs() as $f) {
			$v = ff_rec_value_text($values[$f['name']] ?? '');

			if ($v === '') {
				continue;
			}

			$rows .= '<tr><th style="text-align:left;vertical-align:top;padding:6px 12px 6px 0;color:#555;font-weight:600;width:40%">'
				. ff_rec_h(ff_rec_label_short($f['label'])) . '</th><td style="padding:6px 0;vertical-align:top">'
				. nl2br(ff_rec_h($v)) . '</td></tr>';
		}

		return '<table style="border-collapse:collapse;font:14px/1.5 Arial,sans-serif;width:100%">' . $rows . '</table>';
	}

	function ff_rec_send(string $to, string $subject, string $body, ?string $replyTo): bool {
		if (!class_exists('\Automad\System\Mail')) {
			return false;
		}

		$html = '<div style="font:15px/1.6 Arial,sans-serif;color:#111;max-width:640px">' . $body . '</div>';

		try {
			return \Automad\System\Mail::send($to, $subject, $html, $replyTo);
		} catch (\Throwable $e) {
			return false;
		}
	}

	function ff_rec_json(array $data, int $code = 200): void {
		http_response_code($code);
		header('Content-Type: application/json; charset=utf-8');
		header('Cache-Control: no-store');
		exit(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	function ff_rec_is_admin(): bool {
		return class_exists('\Automad\Auth\Session\Session') && \Automad\Auth\Session\Session::getUsername() !== '';
	}

	function ff_rec_same_origin(): bool {
		$origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
		$host = $_SERVER['HTTP_HOST'] ?? '';

		return $origin !== '' && parse_url($origin, PHP_URL_HOST) === parse_url('//' . $host, PHP_URL_HOST);
	}

	/* ---------- Rendering ---------- */

	// Escape for output inside an Automad template: the template is parsed after PHP ran,
	// so "@" must never reach the parser from user input.
	function ff_rec_t($s): string {
		return str_replace(array('@', '{', '}'), array('&#64;', '&#123;', '&#125;'), ff_rec_h(strval($s)));
	}

	function ff_rec_label_html(string $label, string $suffix = ''): string {
		$parts = explode(' // ', $label, 2);
		$html = ff_rec_t($parts[0]) . $suffix;

		if (isset($parts[1])) {
			$html .= ' <span class="ff-form__en">' . ff_rec_t($parts[1]) . '</span>';
		}

		return $html;
	}

	function ff_rec_render_form(): string {
		$html = '<form class="ff-form" data-ff-recruiting novalidate>';
		$open = false;

		foreach (ff_rec_fields() as $f) {
			if (isset($f['section'])) {
				$html .= ($open ? '</div></fieldset>' : '') . '<fieldset class="ff-form__section"><legend class="ff-form__legend">' . ff_rec_label_html($f['section']) . '</legend><div class="ff-form__grid">';
				$open = true;
				continue;
			}

			$name = $f['name'];
			$id = 'ff-' . $name;
			$req = !empty($f['required']);
			$reqAttr = $req ? ' required' : '';
			$star = $req ? ' <span class="ff-form__req" aria-hidden="true">*</span>' : '';
			$help = !empty($f['help']) ? '<p class="ff-form__help" id="' . $id . '-help">' . ff_rec_label_html($f['help']) . '</p>' : '';
			$describe = !empty($f['help']) ? ' aria-describedby="' . $id . '-help"' : '';
			$cls = 'ff-form__field ff-form__field--' . $f['type'] . (!empty($f['half']) ? ' ff-form__field--half' : '');
			$err = '<p class="ff-form__error" data-ff-error="' . $name . '"></p>';

			if (in_array($f['type'], array('radio', 'checkbox', 'scale'), true)) {
				$options = $f['type'] === 'scale' ? array_map('strval', range(1, $f['max'])) : $f['options'];
				$type = $f['type'] === 'checkbox' ? 'checkbox' : 'radio';
				$inputName = $f['type'] === 'checkbox' ? $name . '[]' : $name;
				$items = '';

				foreach ($options as $i => $opt) {
					$oid = "$id-$i";
					$items .= '<label class="ff-form__choice" for="' . $oid . '"><input type="' . $type . '" id="' . $oid . '" name="' . $inputName . '" value="' . ff_rec_t($opt) . '"'
						. ($type === 'radio' && $i === 0 ? $reqAttr : '') . '><span>' . ff_rec_label_html($opt) . '</span></label>';
				}

				$extra = $f['type'] === 'scale' ? '<div class="ff-form__scale-legend" aria-hidden="true"><span>1 = keine // none</span><span>' . $f['max'] . ' = Muttersprache // native</span></div>' : '';
				$html .= '<fieldset class="' . $cls . '"' . ($req && $type === 'checkbox' ? ' data-ff-required-group' : '') . $describe . '><legend class="ff-form__label">' . ff_rec_label_html($f['label'], $star) . '</legend>'
					. $help . '<div class="ff-form__choices">' . $items . '</div>' . $extra . $err . '</fieldset>';
				continue;
			}

			$label = '<label class="ff-form__label" for="' . $id . '">' . ff_rec_label_html($f['label'], $star) . '</label>';

			if ($f['type'] === 'textarea') {
				$control = '<textarea class="ff-form__input" id="' . $id . '" name="' . $name . '" rows="' . ($f['rows'] ?? 4) . '" maxlength="5000"' . $reqAttr . $describe . '></textarea>';
			} elseif ($f['type'] === 'select') {
				$opts = '<option value="">– bitte wählen // please choose –</option>';

				foreach ($f['options'] as $opt) {
					$opts .= '<option value="' . ff_rec_t($opt) . '">' . ff_rec_t($opt) . '</option>';
				}

				$control = '<select class="ff-form__input" id="' . $id . '" name="' . $name . '"' . $reqAttr . $describe . '>' . $opts . '</select>';
			} else {
				$attrs = '';

				foreach (array('min', 'max', 'autocomplete') as $a) {
					if (isset($f[$a])) {
						$attrs .= " $a=\"" . ff_rec_t($f[$a]) . '"';
					}
				}

				$control = '<input class="ff-form__input" type="' . $f['type'] . '" id="' . $id . '" name="' . $name . '" maxlength="300"' . $attrs . $reqAttr . $describe . '>';
			}

			$html .= '<div class="' . $cls . '">' . $label . $help . $control . $err . '</div>';
		}

		$html .= ($open ? '</div></fieldset>' : '')
			. '<div class="ff-form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>'
			. '<input type="hidden" name="ff_token" value="">'
			. '<div class="ff-form__submit">'
			. '<div class="ff-form__field ff-form__field--captcha"><label class="ff-form__label" for="ff-answer"><span data-ff-question>Rechenaufgabe wird geladen … // Loading question …</span> <span class="ff-form__req" aria-hidden="true">*</span></label>'
			. '<input class="ff-form__input" type="text" inputmode="numeric" id="ff-answer" name="ff_answer" required autocomplete="off"><p class="ff-form__error" data-ff-error="ff_answer"></p></div>'
			. '<button class="ff-btn" type="submit">Absenden // Submit</button>'
			. '</div>'
			. '<p class="ff-form__status" role="status" aria-live="polite" data-ff-status></p>'
			. '<noscript><p class="ff-form__status is-error">Bitte aktiviere JavaScript, um das Formular abzusenden. // Please enable JavaScript to submit the form.</p></noscript>'
			. '</form>';

		return $html;
	}

	function ff_rec_render_admin($Automad): string {
		if (!ff_rec_is_admin()) {
			return '';
		}

		$url = ff_rec_t(AM_BASE_INDEX . $Automad->Context->get()->get('url'));
		$view = strval($_GET['bewerbungen'] ?? '');

		try {
			$entries = ff_rec_entries();
		} catch (\Throwable $e) {
			return '<div class="ff-admin"><p><strong>Bewerbungen:</strong> Speicherordner nicht beschreibbar – ' . ff_rec_t($e->getMessage()) . '</p></div>';
		}

		$bar = '<div class="ff-admin__bar"><strong>Bewerbungen (' . count($entries) . ')</strong>'
			. '<span>Nur für eingeloggte Nutzer sichtbar</span>'
			. '<a href="' . $url . '?bewerbungen">Übersicht</a>'
			. '<a href="' . $url . '?bewerbungen=csv">CSV-Export</a>'
			. ($view !== '' ? '<a href="' . $url . '">Formular</a>' : '')
			. '</div>';

		if ($view === '') {
			return '<div class="ff-admin">' . $bar . '</div>';
		}

		if ($view !== 'csv' && $file = ff_rec_entry_file($view)) {
			$e = ff_rec_read($file);

			if (!$e) {
				return '<div class="ff-admin">' . $bar . '<p>Eintrag nicht gefunden.</p></div>';
			}

			$rows = '';

			foreach (ff_rec_inputs() as $f) {
				$v = ff_rec_value_text($e['values'][$f['name']] ?? '');
				$v = $f['type'] === 'email' && $v !== ''
					? '<a href="mailto:' . ff_rec_t($v) . '">' . ff_rec_t($v) . '</a>'
					: nl2br(ff_rec_t($v));
				$rows .= '<tr><th>' . ff_rec_t(ff_rec_label_short($f['label'])) . '</th><td>' . ($v !== '' ? $v : '–') . '</td></tr>';
			}

			return '<div class="ff-admin">' . $bar
				. '<h2>' . ff_rec_t(($e['values']['vorname'] ?? '') . ' ' . ($e['values']['nachname'] ?? '')) . '</h2>'
				. '<p class="ff-admin__meta">Eingegangen am ' . ff_rec_t(date('d.m.Y, H:i', strtotime($e['created']))) . ' Uhr</p>'
				. '<table class="ff-admin__table ff-admin__table--detail">' . $rows . '</table>'
				. '<p><button class="ff-btn ff-btn--small ff-btn--danger" type="button" data-ff-delete="' . ff_rec_t($e['id']) . '" data-ff-back="' . $url . '?bewerbungen">Bewerbung löschen</button></p>'
				. '</div>';
		}

		$rows = '';

		foreach ($entries as $e) {
			$v = $e['values'];
			$rows .= '<tr><td>' . ff_rec_t(date('d.m.Y', strtotime($e['created']))) . '</td>'
				. '<td><a href="' . $url . '?bewerbungen=' . ff_rec_t($e['id']) . '">' . ff_rec_t(($v['vorname'] ?? '') . ' ' . ($v['nachname'] ?? '')) . '</a></td>'
				. '<td>' . ff_rec_t(($v['studiengang'] ?? '') . (isset($v['semester']) && $v['semester'] !== '' ? ' (' . $v['semester'] . '.)' : '')) . '</td>'
				. '<td>' . ff_rec_t(implode(', ', $v['bereiche'] ?? array())) . '</td></tr>';
		}

		return '<div class="ff-admin">' . $bar
			. ($rows ? '<div class="ff-admin__scroll"><table class="ff-admin__table"><thead><tr><th>Datum</th><th>Name</th><th>Studium</th><th>Bereiche</th></tr></thead><tbody>' . $rows . '</tbody></table></div>' : '<p>Noch keine Bewerbungen.</p>')
			. '</div>';
	}

	/* ---------- Request handling ---------- */

	function ff_rec_handle($Automad): void {
		$Page = $Automad->Context->get();
		$get = fn (string $key, string $default) => trim(strip_tags(strval($Page->get($key)))) ?: $default;

		// Admin: CSV export.
		if (isset($_GET['bewerbungen']) && $_GET['bewerbungen'] === 'csv' && ff_rec_is_admin()) {
			$fields = ff_rec_inputs();
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename="bewerbungen-' . date('Y-m-d') . '.csv"');
			header('Cache-Control: no-store');
			$out = fopen('php://output', 'w');
			fwrite($out, "\xEF\xBB\xBF");
			fputcsv($out, array_merge(array('Datum'), array_map(fn ($f) => ff_rec_label_short($f['label']), $fields)), ';');

			foreach (ff_rec_entries() as $e) {
				$row = array(date('d.m.Y H:i', strtotime($e['created'])));

				foreach ($fields as $f) {
					$row[] = str_replace("\n", ', ', ff_rec_value_text($e['values'][$f['name']] ?? ''));
				}

				fputcsv($out, $row, ';');
			}

			fclose($out);
			exit;
		}

		$action = $_POST['ff_action'] ?? '';

		if ($action === '') {
			return;
		}

		try {
			if ($action === 'challenge') {
				ff_rec_json(ff_rec_challenge());
			}

			if ($action === 'delete') {
				if (!ff_rec_is_admin() || !ff_rec_same_origin()) {
					ff_rec_json(array('error' => 'Forbidden'), 403);
				}

				$file = ff_rec_entry_file(strval($_POST['id'] ?? ''));

				if ($file && is_file($file)) {
					unlink($file);
				}

				ff_rec_json(array('ok' => true));
			}

			if ($action !== 'submit') {
				ff_rec_json(array('error' => 'Unknown action'), 400);
			}

			// Honeypot: pretend success.
			if (!empty($_POST['website'])) {
				ff_rec_json(array('ok' => true, 'message' => ''));
			}

			if ($error = ff_rec_check_challenge(strval($_POST['ff_token'] ?? ''), strval($_POST['ff_answer'] ?? ''))) {
				ff_rec_json(array('error' => $error, 'field' => 'ff_answer'), 422);
			}

			list($values, $errors) = ff_rec_validate($_POST);

			if ($errors) {
				ff_rec_json(array('error' => 'Bitte prüfe die markierten Felder. // Please check the marked fields.', 'fields' => $errors), 422);
			}

			if (ff_rec_rate_limited()) {
				ff_rec_json(array('error' => 'Zu viele Versuche, bitte später erneut versuchen. // Too many attempts, please try again later.'), 429);
			}

			$id = date('Ymd-His') . '-' . bin2hex(random_bytes(4));
			$entry = array('id' => $id, 'created' => date('c'), 'values' => $values);
			ff_rec_write(ff_rec_dir() . "/entry-$id.php", $entry);

			$name = trim($values['vorname'] . ' ' . $values['nachname']);
			$to = $get('textRecruitingTo', 'info@fast-forest.de');
			$adminUrl = AM_SERVER . AM_BASE_INDEX . $Page->get('url') . '?bewerbungen=' . $id;

			$sentTeam = ff_rec_send(
				$to,
				"Neue Bewerbung: $name",
				'<p><strong>Neue Bewerbung über die Website</strong> – ' . ff_rec_h(date('d.m.Y H:i')) . '</p>'
				. ff_rec_mail_table($values)
				. '<p style="margin-top:20px"><a href="' . ff_rec_h($adminUrl) . '">Im CMS ansehen (Login erforderlich)</a></p>',
				$values['email']
			);

			ff_rec_send(
				$values['email'],
				$get('textRecruitingConfirmSubject', 'Deine Bewerbung bei Fast Forest // Your application at Fast Forest'),
				'<p>Hallo ' . ff_rec_h($values['vorname']) . ',</p>'
				. '<p>vielen Dank für deine Bewerbung bei Fast Forest e.V.! Wir haben deine Angaben erhalten und melden uns bald bei dir.</p>'
				. '<p><em>Thank you for your application at Fast Forest e.V.! We have received your details and will get back to you soon.</em></p>'
				. '<p>Deine Angaben // Your details:</p>'
				. ff_rec_mail_table($values)
				. '<p>Viele Grüße // Best regards<br>Fast Forest e.V.</p>',
				$to
			);

			if (!$sentTeam) {
				error_log('Fast Forest recruiting: notification mail could not be sent, entry ' . $id . ' was stored.');
			}

			ff_rec_json(array('ok' => true, 'message' => $get('textRecruitingSuccess', 'Danke für deine Bewerbung! Du bekommst gleich eine Bestätigung per E-Mail. // Thank you for your application! You will receive a confirmation by email shortly.')));
		} catch (\Throwable $e) {
			error_log('Fast Forest recruiting: ' . $e->getMessage());
			ff_rec_json(array('error' => 'Technischer Fehler, bitte versuche es später erneut oder schreib an info@fast-forest.de. // Technical error, please try again later or write to info@fast-forest.de.'), 500);
		}
	}
}
