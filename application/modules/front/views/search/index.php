<?php

use yii\widgets\LinkPager;

if (isset($errorMsg)) {
    echo $errorMsg;
} else {

    // "Did you mean" section
    if (!is_null($spellcheck)) {
        $suggestions = $spellcheck['suggestions'];
        if (!empty($suggestions)) {
            $collation = $suggestions['collation'];
            $suggest_string = htmlentities(stripslashes(substr(strstr($collation, ":"), 1)));
            $atag = "<a href=\"javascript:void(0);\" onclick=\"location.href='/search?q=".rawurlencode($suggest_string)."&didyoumean=true";
            $atag = $atag."&old=".rawurlencode($this->params['_searchQuery'])."';\">";
            echo "<span class=breadcrumbs_search>Did you mean to search for ".$atag.$suggest_string."</a></span> ?
            <br><span class=breadcrumbs_search>We are still working on this feature. Please bear with us if the suggestion doesn't sound right.</span><br>";
        }
    }

    if ($numFound == 0) {
        echo "<p align=center>Sorry, there were no results found.";
        $googlequery = "http://www.google.com/#q=".preg_replace("/ /", "+", htmlentities($this->params['_searchQuery']))."+site:sunnah.com";
        echo "<br><a href=\"".$googlequery."\">Click here</a> to use Google's site search feature for your query instead.<br><br></p>";
    } elseif ($numFound > 0) {
        $beginResult = ($pageNumber-1)*$resultsPerPage+1;
        $endResult = min($pageNumber*$resultsPerPage, $numFound);
        echo "<div class=\"AllHadith\">\n";
        echo "<span style=\"color: #75A1A1;\">&nbsp;Showing $beginResult-$endResult of ".$numFound."</span>";
        //echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
        echo "<div align=right style=\"float: right;\">";
        echo LinkPager::widget(array(
            'pagination' => $pages,
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

        foreach ($searchResults as $result) {
            if ($language === 'english') {
                $hadith = $result['en'];
                $eurn = $hadith['englishURN'];
                $aurn = $hadith['matchingArabicURN'];
            } elseif ($language === 'arabic') {
                $hadith = $result['ar'];
                $aurn = $hadith['arabicURN'];
                $eurn = $hadith['matchingEnglishURN'];
            }

            $collection = $hadith['collection'];
            $book = $result['book'];
            $ourBookID = $book->ourBookID;

            if ($hadith['ourHadithNumber'] > 0) {
                $hasbooks = $collectionsInfo[$collection]['hasbooks'];
                if ($hasbooks === 'yes') {
                    $booklink = $ourBookID;
                    if ($ourBookID === -1) {
                        $booklink = 'introduction';
                    } elseif ($ourBookID === -35) {
                        $booklink = '35b';
                    } elseif ($ourBookID === -8) {
                        $booklink = '8b';
                    }
                    $permalink = '/'.$collection.'/'.$booklink.'/'.$hadith['ourHadithNumber'];
                } else {
                    $permalink = '/'.$collection.'/'.$hadith['ourHadithNumber'];
                }
            } else {
                $permalink = '/urn/';
                $permalink .= $language === 'english' ? $eurn : $aurn;
            }

            $truncation = false;

            if ($language === 'english') {
                if ($hadith['highlighted'] !== null) {
                    $englishText = $hadith['highlighted'];
                    $englishText = str_replace('<em>', '<b><i>', $englishText);
                    $englishText = str_replace('</em>', '</i></b>', $englishText);
                } else {
                    $englishText = "Preview not available. Please click on the link to view the hadith.";
                }

                $arabicText = '';
                if ($result['ar'] !== null) {
                    $arabicText = $result['ar']['hadithText'];
                    if (strlen($arabicText) <= 2500) {
                        $arabicText = $arabicText;
                    } else {
                        $pos = strpos($arabicText, ' ', 2500);
                        if ($pos === false) {
                            $arabicText = $arabicText;
                        } else {
                            $arabicText = substr($arabicText, 0, $pos)." ...";
                            $truncation = true;
                        }
                    }
                }
            } elseif ($language === 'arabic') {
                if ($hadith['highlighted'] !== null) {
                    $arabicText = $hadith['highlighted'];
                    $arabicText = str_replace('<em>', '<b>', $arabicText);
                    $arabicText = str_replace('</em>', '</b>', $arabicText);
                } else {
                    $arabicText = "<div style='text-align: left; direction: ltr;'>Preview not available. Please click on the link to view the hadith.</div>";
                }

                $englishText = '';
                if ($result['en'] !== null) {
                    $englishText = $result['en']['hadithText'];
                    if (strlen($englishText) <= 2500) {
                        $englishText = $englishText;
                    } else {
                        $pos = strpos($englishText, ' ', 2500);
                        if ($pos === false) {
                            $englishText = $englishText;
                        } else {
                            $englishText = substr($englishText, 0, $pos)." ...";
                            $truncation = true;
                        }
                    }
                }
            }

            echo "<div class=\"boh\" style=\"margin-bottom: 10px;\">\n";
            echo "<!-- URN $eurn -->";

            // Print the path of the hadith
            echo "<div class=\"bc_search\">\n";
            echo "<a class=nounderline href=\"/".$collection."\">".$collectionsInfo[$collection]['englishTitle']."</a> » ";
            echo "<a class=nounderline href=\"/".$collection."/".$ourBookID."\">".$book->englishBookName." - ".$book->arabicBookName."</a>";
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
                    'otherlangs' => null
                )
            );
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
            'pagination' => $pages,
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


