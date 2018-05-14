<?php
import ('classes.press.Series');
import ('classes.press.SeriesDAO');

class SeriesCountDAO extends SeriesDAO {

	function __construct() {
		parent::__construct();
	}

	function _fromRow($row) {
		return $row;
	}

	function getSeriesCount() {
		$sql = "select 
						series_id, count(*) as pulications_count
					from published_submissions 
						left join submissions on published_submissions.submission_id=submissions.submission_id
				  	where status = 3 
					group by series_id;";

		$categoryCount = new DAOResultFactory($this->retrieve($sql), $this, '_fromRow');
		$categoryCount = $categoryCount->toArray();
		$countPerSeries = array();
		foreach ($categoryCount as $item) {
			$countPerSeries[$item["series_id"]] = $item["pulications_count"];
		}
		return $countPerSeries;
	}

}
?>
