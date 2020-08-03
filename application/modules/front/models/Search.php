<?php

namespace app\modules\front\models;

use yii\base\Model;
use Yii;
use yii\db\Query;

class Search extends Model
{
    protected $_query;
    protected $_context;
    protected $_username = "ansari";
    protected $_password = "ansari";
    protected $_resultsPerPage;

    public function attributeNames()
    {
    }

    public function __construct()
    {
        $this->_resultsPerPage = Yii::$app->params['pageSize'];
        $this->_context = stream_context_create(array('http' => array(
                 'header'  => "Authorization: Basic " . base64_encode($this->_username.":".$this->_password)
                       )
                ));
    }

    public function searchEnglishHighlighted($query, $pageNumber = 1)
    {
        // TODO: Sanity check the query and start variables
        $start = ($pageNumber-1)*$this->_resultsPerPage;
        //$fullquery = "hadithText:".rawurlencode($this->replace_special_chars(stripslashes($query)));
        $fullquery = "hadithText:".rawurlencode(stripslashes($query));
        $resultscode = file_get_contents('http://localhost:7641/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->_resultsPerPage.'&start='.$start.'&hl=true&hl.fl=hadithText&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&spellcheck=true&spellcheck.collate=true&spellcheck.count=10&spellcheck.maxCollations=10&spellcheck.maxCollationEvaluations=10&defType=edismax&mm=3%3C-1%205%3C-2', false, $this->_context);
        if ($resultscode === false) {
            $headers = "From: webmaster@sunnah.com";
            mail("sunnahhadith@gmail.com", "Solr Server may be down", "Solr Server may be down. Query: $query", $headers);
            return array();
        }

        eval("\$resultsarray = ".$resultscode.";");
        $results = $resultsarray['response']['docs'];
        $numFound = $resultsarray['response']['numFound'];
        $highlighting = $resultsarray['highlighting'];
        if (array_key_exists('spellcheck', $resultsarray)) {
            $spellcheck = $resultsarray['spellcheck'];
        } else {
            $spellcheck = null;
        }
        $eurns = null;
        $pairs = null;
        $aurns = null;
        foreach ($results as $result) {
            $eurns[] = $result['URN'];
        }

        if (!is_null($eurns)) {
            $aurns = $this->getMatchedArabicURNs($eurns);
        }

        return array($eurns, $aurns, $highlighting, $numFound, $spellcheck);
    }

    public function searchArabicHighlighted($query, $pageNumber = 1)
    {
        // TODO: Sanity check the query and start variables
        $start = ($pageNumber-1)*$this->_resultsPerPage;
        $fullquery = rawurlencode($this->replace_special_chars(stripslashes(trim($query))));
        $resultscode = file_get_contents('http://localhost:7641/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->_resultsPerPage.'&start='.$start.'&hl=true&hl.fl=arabichadithText&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&defType=edismax&mm=3%3C-1%205%3C-2&qf=arabichadithText', false, $this->_context);
        if ($resultscode === false) {
            $headers = "From: webmaster@sunnah.com";
            mail("sunnahhadith@gmail.com", "Solr Server may be down", "Solr Server may be down. Query (arabic): $query", $headers);
            return array();
        }

        eval("\$resultsarray = ".$resultscode.";");
        $results = $resultsarray['response']['docs'];
        $numFound = $resultsarray['response']['numFound'];
        $highlighting = $resultsarray['highlighting'];
        $aurns = null;
        $eurns = null;
        foreach ($results as $result) {
            $aurns[] = $result['URN'];
        }

        if (!is_null($aurns)) {
            $eurns = $this->getMatchedEnglishURNs($aurns);
        }

        return array($eurns, $aurns, $highlighting, $numFound, null);
    }

    private function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
            $IP=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
            $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $IP=$_SERVER['REMOTE_ADDR'];
        }

        return $IP;
    }

    public function logQuery($query, $numResults)
    {
        $searchdb = Yii::$app->searchdb;
        $searchdb->createCommand(
            'INSERT INTO `search_queries` (query, IP, numResults) VALUES (:query, :IP, :numResults)',
            [
                ':query' => $query,
                ':IP' => $this->getIP(),
                ':numResults' => $numResults
            ]
        )->execute();
    }

    public function getMatchedEnglishURNs($aURNs)
    {
        if (count($aURNs) == 0) {
            return array();
        }
        $eURNs = array_fill(0, count($aURNs), 0);

        $query = new Query();
        $query = $query->select('*')
            ->from('matchtable')
            ->where(array('in', 'arabicURN', $aURNs));
        $results = $query->all();
        foreach ($results as $row) {
            $eurn = $row['englishURN'];
            $aurn = $row['arabicURN'];
            $pos = array_search($aurn, $aURNs);
            if (!($pos === false)) {
                $eURNs[$pos] = $eurn;
            }
        }

        return $eURNs;
    }

    public function getMatchedArabicURNs($eURNs)
    {
        if (count($eURNs) == 0) {
            return array();
        }
        $aURNs = array_fill(0, count($eURNs), 0);

        $query = new Query();
        $query = $query->select('*')
            ->from('matchtable')
            ->where(array('in', 'englishURN', $eURNs));
        $results = $query->all();
        foreach ($results as $row) {
            $eurn = $row['englishURN'];
            $aurn = $row['arabicURN'];
            $pos = array_search($eurn, $eURNs);
            if (!($pos === false)) {
                $aURNs[$pos] = $aurn;
            }
        }

        return $aURNs;
    }


    public function php_zip($enumbers, $anumbers)
    {
        return array_map(null, $enumbers, $anumbers);
    }

    private function replace_special_chars($str)
    {
        return preg_replace('/([\!\(\)\{\}\[\]\^\'\~\*\?\:\\\\])/', '\\\\${1}', $str);
    }
}
