{**
 * plugins/blocks/dainstNav/block.tpl
 *
 *
 *
 *}
<div class="pkp_block block_browse">
	<nav class="content" role="navigation" aria-label="{translate|escape key="plugins.dainstNav.browse.newReleases"}">
		<ul>


			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="catalog" op="newReleases"}">
					{translate key="navigation.newReleases"}
				</a>
			</li>


			{if $browseCategoryFactory && $browseCategoryFactory->getCount()}
				<li class="has_submenu">
					{translate key="plugins.block.dainstNav.category"}
					<ul>
						{iterate from=browseCategoryFactory item=browseCategory}
							<li class="category_{$browseCategory->getId()}{if $browseCategory->getParentId()} is_sub{/if}{if $browseBlockSelectedCategory == $browseCategory->getPath()} current{/if}">
								<a href="{url router=$smarty.const.ROUTE_PAGE page="catalog" op="category" path=$browseCategory->getPath()|escape}">
									{$browseCategory->getLocalizedTitle()|escape}
								</a>
							</li>
						{/iterate}
					</ul>
				</li>
			{/if}

			{if $browseSeriesFactory && $browseSeriesFactory->getCount()}
				<li class="has_submenu">
					{translate key="plugins.block.dainstNav.series"}
					<ul>
						{iterate from=browseSeriesFactory item=browseSeriesItem}
							<li class="series_{$browseSeriesItem->getId()}{if $browseBlockSelectedSeries == $browseSeriesItem->getPath() && $browseBlockSelectedSeries != ''} current{/if}">
								<a href="{url router=$smarty.const.ROUTE_PAGE page="catalog" op="series" path=$browseSeriesItem->getPath()|escape}">
									{$browseSeriesItem->getLocalizedTitle()|escape}
								</a>
							</li>
						{/iterate}
					</ul>
				</li>
			{/if}

			<li class="has_submenu">
				{translate key="plugins.block.dainstNav.external"}
				<ul>
					{foreach from=$contentLinks item=contentLink}
						<li class="idai-block"><a href="{$contentLink.href}">{$contentLink.label}</a></li>
					{/foreach}
				</ul>
			</li>

		</ul>
	</nav>
</div><!-- .block_browse -->
