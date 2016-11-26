<?php

class Search extends CModel
{
	protected $_query;
	protected $_context;
	protected $_username = "ansari";
	protected $_password = "ansari";
	protected $_resultsPerPage;

	public function attributeNames() {}
	
	function __construct() {
		$this->_resultsPerPage = Yii::app()->params['pageSize'];
		$this->_context = stream_context_create(array('http' => array(
			     'header'  => "Authorization: Basic " . base64_encode($this->_username.":".$this->_password)
					   )
				));
	}

	public function searchEnglishHighlighted($query, $pageNumber = 1) {
  		// TODO: Sanity check the query and start variables
		$start = ($pageNumber-1)*$this->_resultsPerPage;
		//$fullquery = "hadithText:".rawurlencode($this->replace_special_chars(stripslashes($query)));
		$fullquery = "hadithText:".rawurlencode(stripslashes($query));
		$resultscode = file_get_contents('http://localhost:7641/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->_resultsPerPage.'&start='.$start.'&hl=true&hl.fl=hadithText&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&spellcheck=true&spellcheck.collate=true&spellcheck.count=10&spellcheck.maxCollations=10&spellcheck.maxCollationEvaluations=10&defType=edismax&mm=3%3C-1%205%3C-2', false, $this->_context);
		if ($resultscode === FALSE) {
			$headers = "From: webmaster@sunnah.com";
            mail("sunnahhadith@gmail.com", "Solr Server may be down", "Solr Server may be down. Query: $query", $headers);
			return array();
		}
		
		eval("\$resultsarray = ".$resultscode.";");
		$results = $resultsarray['response']['docs'];
		$numFound = $resultsarray['response']['numFound'];
		$highlighting = $resultsarray['highlighting'];
		if (array_key_exists('spellcheck', $resultsarray)) $spellcheck = $resultsarray['spellcheck'];
		else $spellcheck = NULL;
		$eurns = NULL; $pairs = NULL; $aurns = NULL;
		foreach ($results as $result) $eurns[] = $result['URN'];

		if (!is_null($eurns)) {
			$aurns = $this->getMatchedArabicURNs($eurns);
		}

		return array($eurns, $aurns, $highlighting, $numFound, $spellcheck);
	}

	public function searchArabicHighlighted($query, $pageNumber = 1) {
  		// TODO: Sanity check the query and start variables
		$start = ($pageNumber-1)*$this->_resultsPerPage;
		$fullquery = rawurlencode($this->replace_special_chars(stripslashes(trim($query))));
		$resultscode = file_get_contents('http://localhost:7641/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->_resultsPerPage.'&start='.$start.'&hl=true&hl.fl=arabichadithText&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&defType=edismax&mm=3%3C-1%205%3C-2&qf=arabichadithText', false, $this->_context);
		if ($resultscode === FALSE) {
			$headers = "From: webmaster@sunnah.com";
            mail("sunnahhadith@gmail.com", "Solr Server may be down", "Solr Server may be down. Query (arabic): $query", $headers);
			return array();
		}
		
		eval("\$resultsarray = ".$resultscode.";");
		$results = $resultsarray['response']['docs'];
		$numFound = $resultsarray['response']['numFound'];
		$highlighting = $resultsarray['highlighting'];
		$aurns = NULL; $eurns = NULL;
		foreach ($results as $result) $aurns[] = $result['URN'];

		if (!is_null($aurns)) {
			$eurns = $this->getMatchedEnglishURNs($aurns);
		}

		return array($eurns, $aurns, $highlighting, $numFound, NULL);
	}

	private function getIP() {
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
      		$IP=$_SERVER['HTTP_CLIENT_IP'];
   		}
    	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
	      	$IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
    	}
    	else $IP=$_SERVER['REMOTE_ADDR'];
    	
		return $IP;
	}	

	public function logQuery($query, $numResults) {
		
		$IP = $this->getIP();
		$sql_query = "INSERT INTO search_queries (query, IP, numResults) values ('".$query."', '".$IP."', ".$numResults.")";
        mysql_select_db("searchdb") or die(mysql_error());
		mysql_query($sql_query) or die(mysql_error().$query);
	}

	public function getMatchedEnglishURNs($aURNs) {
        if (count($aURNs) == 0) return array();
        $eURNs = array_fill(0, count($aURNs), 0);

        $aurns_string = '(';
        foreach ($aURNs as $aURN) $aurns_string = $aurns_string.$aURN.',';
        $aurns_string = substr($aurns_string, 0, -1).')';
        $query = "SELECT * FROM matchtable WHERE arabicURN in ".$aurns_string;
        $urn_query = mysql_query($query) or die(mysql_error().$query);
        while ($row = mysql_fetch_array($urn_query)) {
            $eurn = $row['englishURN'];
            $aurn = $row['arabicURN'];
            $pos = array_search($aurn, $aURNs);
            if (!($pos === FALSE)) $eURNs[$pos] = $eurn;
        }

        return $eURNs;
    }
	
    public function getMatchedArabicURNs($eURNs) {
        if (count($eURNs) == 0) return array();
        $aURNs = array_fill(0, count($eURNs), 0);

        $eurns_string = '(';
        foreach ($eURNs as $eURN) $eurns_string = $eurns_string.$eURN.',';
        $eurns_string = substr($eurns_string, 0, -1).')';
        $query = "SELECT * FROM matchtable WHERE englishURN in ".$eurns_string;
        $urn_query = mysql_query($query) or die(mysql_error().$query);
        while ($row = mysql_fetch_array($urn_query)) {
            $eurn = $row['englishURN'];
            $aurn = $row['arabicURN'];
            $pos = array_search($eurn, $eURNs);
            if (!($pos === FALSE)) $aURNs[$pos] = $aurn;
        }

        return $aURNs;
    }
    
	
	public function php_zip($enumbers, $anumbers) {
        return array_map(NULL, $enumbers, $anumbers);
	}

	private function replace_special_chars($str) {
  		return preg_replace('/([\!\(\)\{\}\[\]\^\'\~\*\?\:\\\\])/', '\\\\${1}', $str);
	}
}

?>
