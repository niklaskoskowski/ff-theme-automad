<# Fast Forest – pagination for the current pagelist #>
<@ if @{ :paginationCount } > 1 @>
	<@ set { :ffPage: @{ ?page | def (1) } } @>
	<nav class="ff-pagination am-block" aria-label="Seiten">
		<@ if @{ :ffPage } > 1 @>
			<a href="?<@ queryStringMerge { page: @{ :ffPage | -1 } } @>" aria-label="Vorherige Seite">&larr;</a>
		<@ end @>
		<@ for 1 to @{ :paginationCount } @>
			<@ if @{ :i } = @{ :ffPage } @>
				<span aria-current="page">@{ :i }</span>
			<@ else @>
				<a href="?<@ queryStringMerge { page: @{ :i } } @>">@{ :i }</a>
			<@ end @>
		<@ end @>
		<@ if @{ :ffPage } < @{ :paginationCount } @>
			<a href="?<@ queryStringMerge { page: @{ :ffPage | +1 } } @>" aria-label="Nächste Seite">&rarr;</a>
		<@ end @>
	</nav>
<@ end @>
