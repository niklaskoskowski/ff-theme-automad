<# Fast Forest – News-Übersicht: listet Unterseiten (Beiträge) mit Paginierung #>
<@~ components/base.php ~@>

<@~ snippet content ~@>
	<main class="ff-main" id="inhalt">
		<div class="ff-container">
			@{ +main }
			<@ newPagelist {
				type: 'children',
				sort: 'date desc',
				limit: @{ numberPostsPerPage | def (9) },
				page: @{ ?page | def (1) }
			} @>
			<@ if @{ :pagelistCount } @>
				<div class="ff-cards am-block">
					<@ foreach in pagelist @>
						<@ components/card.php @>
					<@ end @>
				</div>
				<@ components/pagination.php @>
			<@ else @>
				<p class="am-block">Noch keine Beiträge.</p>
			<@ end @>
		</div>
	</main>
<@~ end ~@>
