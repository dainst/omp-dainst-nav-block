<?php


import('lib.pkp.classes.plugins.BlockPlugin');
import('plugins.blocks.omp-dainst-nav-block.seriesCountDAO');

class DainstNavBlockPlugin extends BlockPlugin {

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.block.dainstNav.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return __('plugins.block.dainstNav.description');
	}


	/**
	 * Get the HTML contents of the browse block.
	 * @param $templateMgr PKPTemplateManager
	 * @return string
	 */
	function getContents($templateMgr, $request = null) {

		$contents = array(
			array(
				"href"	=>	"https://publications.dainst.org/journals",
				"label"	=>	"journals"
			),
			array(
				"href"	=>	"https://arachne.dainst.org/category/?c=buch",
				"label"	=>	"arachne"
			)
		);

		foreach ($contents as $i => $content) {
			$contents[$i]["label"] = AppLocale::translate("plugins.block.dainstNav." . $contents[$i]["label"]);
		}

		$press = $request->getPress();
		$seriesDisplay = true; //$this->getSetting($press->getId(), 'browseSeries');
		if ($seriesDisplay) {
			// Provide a list of series to browse
			$seriesCountDao = new SeriesCountDAO();
			$seriesDao = DAORegistry::getDAO('SeriesDAO');
			$series = $seriesDao->getByPressId($press->getId());
			$seriesCount = $seriesCountDao->getSeriesCount();
			$templateMgr->assign('browseSeriesFactory', $series);
			$templateMgr->assign('seriesCount', $seriesCount);
			/*$templateMgr->register_function('get_series_count', function($params, &$smarty) {
				return $seriesCount[$params["id"]];
			});*/
		}

		$categoriesDisplay = true; //$this->getSetting($press->getId(), 'browseCategories');
		if ($categoriesDisplay) {
			// Provide a list of categories to browse
			$categoryDao = DAORegistry::getDAO('CategoryDAO');
			$categories = $categoryDao->getByContextId($press->getId());
			$templateMgr->assign('browseCategoryFactory', $categories);
		}

		// If we're currently viewing a series or catalog, detect it
		// so that we can highlight the current selection in the
		// dropdown.
		$router = $request->getRouter();
		switch ($router->getRequestedOp($request)) {
			case 'category':
				$args = $router->getRequestedArgs($request);
				$templateMgr->assign('browseBlockSelectedCategory', reset($args));
				break;
			case 'series':
				$args = $router->getRequestedArgs($request);
				$templateMgr->assign('browseBlockSelectedSeries', reset($args));
				break;
		}


		$templateMgr->assign('contentLinks', $contents);


		return parent::getContents($templateMgr);
	}
}

?>
