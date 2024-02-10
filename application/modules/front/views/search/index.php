<?php

use yii\widgets\LinkPager;
use app\modules\front\models\Util;
use app\modules\front\models\ArabicHadith;
use app\modules\front\models\EnglishHadith;

function formatHighlightIfExists($text, $highlight){
    if ($highlight == null) return $text;
    $highlightedText = str_replace('<em>', '<em><b><i>', $highlight);
    $highlightedText = str_replace('</em>', '</i></b></em>',$highlightedText);
    return $highlightedText;
}

function truncateHadithText($hadith)
{
    $truncation = false;
    if ($hadith === null) {
        return array('', $truncation);
    }

    $text = $hadith['hadithText'];
    if (strlen($text) > 2500) {
        $pos = strpos($text, ' ', 2500);
        if ($pos !== false) {
            $text = substr($text, 0, $pos)." ...";
            $truncation = true;
        }
    }
    return array($text, $truncation);
}

if (isset($errorMsg)) {
    echo $errorMsg;
} else {

    // "Did you mean" section
    if ($spellcheck !== null) {
        $suggest_string = htmlentities(stripslashes($spellcheck));
        $atag = "<a href=\"javascript:void(0);\" onclick=\"location.href='/search?q=".rawurlencode($suggest_string)."&didyoumean=true";
        $atag = $atag."&old=".rawurlencode($searchQuery)."';\">";
        echo "<span class=breadcrumbs_search>Did you mean to search for ".$atag.$suggest_string."</a></span> ?
        <br><span class=breadcrumbs_search>We are still working on this feature. Please bear with us if the suggestion doesn't sound right.</span><br>";
    }

    if ($resultset->getCount() === 0) {
        echo "<p align=center>Sorry, there were no results found.";
        $googlequery = "https://www.google.com/search?q=".preg_replace("/ /", "+", htmlentities($searchQuery))."+site:sunnah.com";
        echo "<br><a href=\"".$googlequery."\">Click here</a> to use Google's site search feature for your query instead.<br><br></p>";
    } else {
        $beginResult = ($pageNumber-1)*$resultsPerPage+1;
        $endResult = min($pageNumber*$resultsPerPage, $resultset->getCount());
        echo "<div class=\"AllHadith\">\n";
        echo "<span style=\"color: #75A1A1;\">&nbsp;Showing $beginResult-$endResult of ".$resultset->getCount()."</span>";
        //echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
        echo "<div align=right style=\"float: right;\">";
        echo LinkPager::widget(array(
            'pagination' => $pagination,
            'options' => ['class' => 'yiiPager'],
            'prevPageLabel' => '&#x25C0;',
            'nextPageLabel' => '&#x25B6;',
            'pageCssClass' => 'page',
            'activePageCssClass' => 'selected',
            'prevPageCssClass' => 'previous',
            'nextPageCssClass' => 'next',
            'firstPageCssClass' => 'first',
            'lastPageCssClass' => 'last',
            'disabledPageCssClass' => 'hidden',
            //'header' => '',
        ));
        echo "</div>";

        echo "<div style=\"height: 20px;\"></div>";

        $util = new Util();
        foreach ($resultset->getResults() as $result) {
            $highlights = $result['highlighted'];
            $data = $result['data'];
            $hadith = $data[$result['language']];
            $collection = $data['collection'];
                               
            $book = $data['book'];
            $ourBookID = $book->ourBookID;

            $arabicEntry = $data['ar'];
            $englishEntry = $data['en'];

            if ((bool)$arabicEntry) $permalink = $arabicEntry->permalink;
            else $permalink = $englishEntry->permalink;

            [$arabicText, $arabicTruncation] = truncateHadithText($data['ar']);
            [$englishText, $englishTruncation] = truncateHadithText($data['en']);

            $truncation = $englishTruncation || $arabicTruncation;

            if ($result['language'] === 'en') {
                $urn_language = "english";
            } elseif ($result['language'] === 'ar') {
                $urn_language = "arabic";
            }
            
            if (property_exists($highlights, "hadithText")) {
                $englishText = formatHighlightIfExists($englishText, $highlights->hadithText[0]);
            }
            if (property_exists($highlights, "arabicText")) {
                $arabicText = formatHighlightIfExists($arabicText, $highlights->arabicText[0]);;
            }

            $th = new ArabicHadith();
            $th->hadithText = $arabicText;
            $th->process_text();
            $arabicText = $th->hadithText;


            if (property_exists($highlights, "collection") and $highlights->collection[0] !== null){
                $collection['englishTitle'] = "<em>".$collection['englishTitle']."</em>";
            }

            echo "<div class=\"boh\">\n";
            echo "<!-- URN [{$result['language']}] {$result['urn']} -->";

            // Print the path of the hadith
            echo "<div class=\"bc_search\">\n";
            echo "<a class=nounderline href=\"/".$collection['name']."\">".$collection['englishTitle']."</a> » ";
            echo "<a class=nounderline href=\"/".$collection['name']."/".$ourBookID."\">".$book->englishBookName." - ".$book->arabicBookName."</a>";
            echo "</div>";

            echo "<div class=collection_sep style=\"width: 98%;\"></div>";

            echo "<div class=\"actualHadithContainer\" style=\"position: relative; border-radius: 0 0 10px 10px; margin-bottom: 0px; padding-bottom: 10px; background-color: rgba(255, 255, 255, 0);\">";
            echo "<a style=\"display: block;\" href=\"$permalink\"><span class=searchlink></span></a>";
            echo $this->render(
                '/collection/printhadith',
                array(
                    'arabicEntry' => null,
                    'englishText' => $englishText,
                    'arabicText' => $arabicText,
                    'ourHadithNumber' => null,
                    'counter' => null,
                    'otherlangs' => null,
					'hadithNumber' => is_null($data['ar']) ? "" : $data['ar']['hadithNumber'],
                    'book' => $book,
                    'collection' => $collection,
                )
            );

            echo $this->render('/collection/hadith_reference', array(
                'englishExists' => (bool)$englishEntry,
                'arabicExists' => (bool)$arabicEntry,
                'englishEntry' => $englishEntry ?? new EnglishHadith(),
                'arabicEntry' => $arabicEntry ?? new ArabicHadith(),
                'collection' => $collection,
                'book' => $book,
                'urn' => $result['urn'],
                'ourHadithNumber' => $hadith['ourHadithNumber'],
                'ourBookID' => $ourBookID,
                'hideReportError' => true,
                'divName' => "h".(is_null($data['ar']) ? "" : $data['ar']['arabicURN']),
                'hideShare' => true,
                'urn_language' => $urn_language,
            ));

            echo "</div>"; // end actualHadithContainer

            if ($truncation) {
                echo "<div class=searchmore><a href=\"$permalink\">Read more &hellip;</a></div>";
            }
            echo "<div class=clear></div>";
            echo "</div>"; // end boh

            echo "<div class=clear></div>";
            echo "<div class=hline></div>";
        }

        //echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
        echo "<div align=center>";
        echo LinkPager::widget(array(
            'pagination' => $pagination,
            'options' => ['class' => 'yiiPager'],
            'nextPageLabel' => ' Next >',
            'prevPageLabel' => '< Previous&nbsp;',
            'pageCssClass' => 'page',
            'activePageCssClass' => 'selected',
            'prevPageCssClass' => 'previous',
            'nextPageCssClass' => 'next',
            'firstPageCssClass' => 'first',
            'lastPageCssClass' => 'last',
            'disabledPageCssClass' => 'hidden',
        ));
        echo "</div>";
        echo "</div>";
    }
} // ending no error if
?>

