<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>

  <link href="/css/header.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/banner.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/toolbar.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/index.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/common.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/collection.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/hadith.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/search.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/css/footer.css" media="screen" rel="stylesheet" type="text/css" />

  <title>Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)</title>  <link rel="shortcut icon" href="/favicon.ico" >
  <script type="text/javascript">
  	function openquran(surah, beginayah, endayah) {
    	window.open("http://quran.com/"+(surah+1)+"/"+beginayah+"-"+endayah, "quranWindow", "resizable = 1, fullscreen = 1");
  	}
  	function reportHadith(urn) {
    	window.open("/report.php?urn="+urn, "reportWindow", "scrollbars = yes, resizable = 1, fullscreen = 1, location = 0, toolbar = 0, width = 500, height = 700");
  	}
  </script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22385858-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>
<div id="site">
	<div id="toolbar"> 
		<div id="toolbarRight"> 
			<a href="http://quran.com">Qur'an</a> |
			<a href="http://corpus.quran.com/wordbyword.jsp">Word by Word</a> | 
			<a href="http://quranicaudio.com">Audio</a> | 
			<span>New: sunnah.com</span> | 
			<a href="http://salah.com">Prayer Times</a> |
			<a href="http://android.quran.com">Android</a> |
			<a href="http://beta.quran.com"><b style="font-weight: normal; padding-right: 18px; position: relative;"><strong>New&nbsp;:</strong>&nbsp;beta.quran.com
				<!-- <img style="position: absolute; top: -6px; right: -12px;" src="http://c222770.r70.cf1.rackcdn.com/labs.png"> -->
				<img style="position: absolute; top: -6px; right: 0px;" src="/images/labs.png">
			</b></a>
		</div>
	</div> 

	
	<a href="http://sunnah.com/"><div id="header"></div></a>
    <div style="width:100%; height:5px; background-color:#867044"></div>

	<link href="/css/nav_menu.css" media="screen" rel="stylesheet" type="text/css" />
<div class="menu">
  <ul>
	<li><a href="/">Home</a></li>
<li><a href="/" target="_self" >Collections</a>
      <ul>
        <li><a href="/bukhari" target="_self">Ṣaḥīḥ al-Bukhārī</a></li>
        <li><a href="/muslim" target="_self">Ṣaḥīḥ Muslim</a></li>
        <li><a href="/nasai" target="_self">Sunan an-Nasā'ī</a></li>
        <li><a href="/tirmidhi" target="_self">Jāmi` at-Tirmidhī</a></li>
        <li><a href="/malik" target="_self">Muwaṭṭa Imām Mālik</a></li>
        <li><a href="/nawawi40" target="_self">Imam Nawawi's 40 Hadith</a></li>
        <li><a href="/riyadussaliheen" target="_self">Riyāḍ as-Ṣālihīn</a></li>
        <li><a href="/qudsi" target="_self">Hadith Qudsi</a></li>
        <li><a href="/shamail" target="_self">Shamāil Muḥammadiyah</a></li>
      </ul></li>
	<li><a href="/about">About</a></li>
<li><a href="/news">News</a></li>
<li><span class="selectedMenuItem"><a href="/contact">Contact</a></span></li>
<li><a href="/support">Support</a></li>

				<div style="float: right; display: inline; padding-right: 10px; padding-top: 2px; vertical-align: center; height: 100%;">
			<form name="searchform" action="/search_redirect.php" method=get style="height: 100%;">
                <input type="text" size="25" class="input_search" name=query value="" />
            	<input type="submit" class="search_button" value="Search" />
           	</form>	
		</div>
		        <div class="clear"></div>
	</ul>
</div>

    <div id="wrapper">
        <div class="breadcrumbs">
    <a href="/">Home</a>&nbsp;&gt;&nbsp;Developer</div>
</div>

		
<p class="p1">Interested in integrating various ahadith into your website or a mobile app?<br>
<br>
Sunnah.com now offers developer APIs so you can seamlessly query the most recent up to date hadith including both Arabic and English texts. Our data is constantly changing due to a variety of reasons, and the API provides the freshest most verified hadith for your use.<br>
<br>
In order to consume our services, please contact us so we can provide you an authorization token to provide in the header to your requests.<br>
<br>
The sunnah.com web services work similar to many other popular web services, such as twitter. We have a RESTful service that accepts JSON request bodies and then provides JSON response bodies based on properly formatted URL requests.</p>
<p class="p2"><br></p>
<p class="p3"><b>Heirarchy Based Hadith Retrieval</b></p>
<p class="p1">In order to query hadith in a gradual and logical progression, there is a heirarchy of calls that must be made. This allows clients to methodically travel down our data tree to the leaf level by deciding exactly what data they want to obtain at each level of our data classification.</p>
<p class="p1">The API order is as follows:<br>
</p>
<p class="p1">1. This first step is optional, but its recommended for those who want to obtain hadith in languages other then Arabic and English. This step involves making a query to recieve the available languages we have to offer. Here is an example call:<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '' https://sunnah.com/languageList</p>
<p class="p1"><br>
Note how there is no POST body necessary in the call. Here is a sample response from the server:</p>
<p class="p1">{<br>
   "languages":[<br>
      "english",<br>
      "arabic",<br>
      "indonesian"<br>
   ]<br>
}</p>
<p class="p1">These are our supported languages at the time this API call was made. This data will be needed when you start progressing through the call heirarchy which is described below.</p>
<p class="p1"><br>
<br>
2. The next in the call heirarchy requires you to query the collections sunnah.com has to offer. For example: Bukhari, Muslim, etc...The call looks like this:<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"languages":["english", "arabic"]}' https://sunnah.com/collectionList<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"languages":["english"]}' https://sunnah.com/collectionList<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '' https://sunnah.com/collectionList<br>
<br>
This returns a JSON formatted collection list of all collections we host. It takes an optional POST body which describes the 'languages' you are intersted in. You must specify the word 'languages' as the key in the JSON payload. Valid language values can be obtained from step 1 listed above.</p>
<p class="p1">The absense of this optional 'languages' payload will lead to the default language selection returned which is Arabic and English.</p>
<p class="p1">Example response:<br>
<br>
{<br>
   "collectionList":{<br>
      "bukhari":{<br>
         "arabic":"<span class="s1">صحيح</span> <span class="s1">البخاري</span>",<br>
         "english":"Sahih al-Bukhari"<br>
      },<br>
      "muslim":{<br>
         "arabic":"<span class="s1">صحيح</span> <span class="s1">مسلم</span>",<br>
         "english":"Sahih Muslim"<br>
      },<br>
      "malik":{<br>
         "arabic":" <span class="s1">موطأ</span> <span class="s1">مالك</span>",<br>
         "english":"Muwatta Malik"<br>
      },<br>
  }<br>
}</p>
<p class="p1"><br>
<br>
3. The next step would be to query the books which exist within certain collections. The call looks like this:<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"collections":["bukhari", "muslim"],"languages":["english", "arabic"]}' https://sunnah.com/booksInCollectionList<br>
<br>
For this particular request, there is a required request payload which must have 'collections' defined as a JSON array of collection names (retrieved from the call above in step 2). Once again, the languages portion of this request is optional. The absense of the languages portion of the request payload will notify the server to default to Arabic and English.<br>
<br>
The response body looks similar to this:</p>
<p class="p1">{<br>
   "booksInCollectionList":{<br>
      "bukhari":{<br>
         "1":{<br>
            "english":"Revelation",<br>
            "arabic":"<span class="s1">كتاب</span> <span class="s1">بدء</span> <span class="s1">الوحى</span> "<br>
         },<br>
         "2":{<br>
            "english":"Belief",<br>
            "arabic":"<span class="s1">كتاب</span> <span class="s1">الإيمان</span> "<br>
         },<br>
         "3":{<br>
            "english":"Knowledge",<br>
            "arabic":"<span class="s1">كتاب</span> <span class="s1">العلم</span> "<br>
         },<br>
         "4":{<br>
            "english":"Ablutions (Wudu')",<br>
            "arabic":"<span class="s1">كتاب</span> <span class="s1">الوضوء</span>"<br>
         }<br>
      },<br>
      "muslim":{<br>
         "1":{<br>
            "english":"The Book of Faith (Kitab Al-Iman)",<br>
            "arabic":"<span class="s1">كتاب</span> <span class="s1">الإيمان</span>"<br>
         },<br>
         "2":{<br>
            "english":"The Book of Purification (Kitab Al-Taharah)",<br>
            "arabic":" <span class="s1">كتاب</span> <span class="s1">الطهارة</span>"<br>
         },<br>
         "3":{<br>
            "english":"The Book of Menstruation (Kitab Al-Haid)",<br>
            "arabic":" <span class="s1">كتاب</span> <span class="s1">الحيض</span>"<br>
         }<br>
      }<br>
   }<br>
}</p>
<p class="p1">You can see the server has provided book number for each book followed by the English and Arabic book names for each of these books. This is because we requested English and Arabic in our request. If we had specified another language, such as Indonesian, there could be the possibility of certain books missing the 'indonesian' key. This is because the Indonesian version of the hadith in that particular book are not available yet. Well behaved clients must understand that the absence of a language from a certain book means that the server cannot possibly return hadith in that language later on.<br>
<br>
<br>
<br>
4. The next step would be to identify the book numbers from the books you are interested in from the set of books listed in the response above. From this list of books, you get a list of the hadith inside each book. For example if you are interested in the books with numbers 4, 5 in bukhari and books with numbers 2, 6 in muslim, then you would make the following call. <br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"hadithInBookList":{"bukhari":[4,5],"muslim":[2,6]}}' https://sunnah.com/hadithInBookList</p>
<p class="p1">An example response would like something like this:</p>
<p class="p1">{<br>
    "hadithInBookList": {<br>
        "muslim": {<br>
            "2": [<br>
                "305560",<br>
                "307040"<br>
            ],<br>
            "6": [<br>
                "316030",<br>
                "316040",<br>
                "316050",<br>
                "316060",<br>
                "316070",<br>
                "319880"<br>
            ]<br>
        },<br>
        "bukhari": {<br>
            "4": [<br>
                "101350",<br>
                "101360",<br>
                "101370",<br>
                "102470",<br>
                "102480"<br>
            ],<br>
            "5": [<br>
                "102490",<br>
                "102500",<br>
                "102510",<br>
                "102520",<br>
                "102940"<br>
            ]<br>
        }<br>
    }<br>
}<br>
<br>
Note that this request does NOT accept 'languages' in the payload. It only provides individual hadithIDs which can be used to query the actual hadith (and its meta data) in subsequent requests. If a client has correctly followed the call heirarchy until this point, they will be aware of which books to query for their languages of interest. This means that logical progression will not allow a well behaved client to expect hadith in languages for which we currently don't have support for.</p>
<p class="p1"><br>
<br>
5. The last call is to actually fetch the hadith text itself. The body of the request is a list of hadithIDs that you fetched from the call above. The call looks a little something like this:<br>
<br>
curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"hadithIDs":["305700", "305600"]}' https://sunnah.com/hadithByID<br>
<br>
An example response would look something like this:<br>
<br>
{<br>
   "hadithText":[<br>
      {<br>
         "hadithID":"305600",<br>
         "chapterNumber":"3",<br>
         "hadithNumber":"226a",<br>
         "arabicChapterName":" <span class="s1">باب</span> <span class="s1">صِفَةِ</span> <span class="s1">الْوُضُوءِ</span> <span class="s1">وَكَمَالِهِ</span> \u200F\u200F ",<br>
         "arabicText":" <span class="s1">حَدَّثَنِي</span> <span class="s1">أَبُو</span> <span class="s1">الطَّاهِرِ،</span> <span class="s1">أَحْمَدُ</span> <span class="s1">بْنُ</span> <span class="s1">عَمْرِو</span> <span class="s1">بْنِ</span> <span class="s1">عَبْدِ</span> <span class="s1">اللَّهِ</span> <span class="s1">بْنِ</span> <span class="s1">عَمْرِو</span> <span class="s1">بْنِ</span> <span class="s1">سَرْحٍ</span> <span class="s1">وَحَرْمَلَةُ</span> <span class="s1">بْنُ</span> <span class="s1">يَحْيَى</span> <span class="s1">التُّجِيبِيُّ</span> <span class="s1">قَالاَ</span> <span class="s1">أَخْبَرَنَا</span> <span class="s1">ابْنُ</span> <span class="s1">وَهْبٍ،</span> <span class="s1">عَنْ</span> <span class="s1">يُونُسَ،</span> <span class="s1">عَنِ</span> <span class="s1">ابْنِ</span> <span class="s1">شِهَابٍ،</span> <span class="s1">أَنَّ</span> <span class="s1">عَطَاءَ</span> <span class="s1">بْنَ</span> <span class="s1">يَزِيدَ</span> <span class="s1">اللَّيْثِيَّ،</span> <span class="s1">أَخْبَرَهُ</span> <span class="s1">أَنَّ</span> <span class="s1">حُمْرَانَ</span> <span class="s1">مَوْلَى</span> <span class="s1">عُثْمَانَ</span> <span class="s1">أَخْبَرَهُ</span> <span class="s1">أَنَّ</span> <span class="s1">عُثْمَانَ</span> <span class="s1">بْنَ</span> <span class="s1">عَفَّانَ</span> - <span class="s1">رضى</span> <span class="s1">الله</span> <span class="s1">عنه</span> - <span class="s1">دَعَا</span> <span class="s1">بِوَضُوءٍ</span> <span class="s1">فَتَوَضَّأَ</span> <span class="s1">فَغَسَلَ</span> <span class="s1">كَفَّيْهِ</span> <span class="s1">ثَلاَثَ</span> <span class="s1">مَرَّاتٍ</span> <span class="s1">ثُمَّ</span> <span class="s1">مَضْمَضَ</span> <span class="s1">وَاسْتَنْثَرَ</span> <span class="s1">ثُمَّ</span> <span class="s1">غَسَلَ</span> <span class="s1">وَجْهَهُ</span> <span class="s1">ثَلاَثَ</span> <span class="s1">مَرَّاتٍ</span> <span class="s1">ثُمَّ</span> <span class="s1">غَسَلَ</span> <span class="s1">يَدَهُ</span> <span class="s1">الْيُمْنَى</span> <span class="s1">إِلَى</span> <span class="s1">الْمِرْفَقِ</span> <span class="s1">ثَلاَثَ</span> <span class="s1">مَرَّاتٍ</span> <span class="s1">ثُمَّ</span> <span class="s1">غَسَلَ</span> <span class="s1">يَدَهُ</span> <span class="s1">الْيُسْرَى</span> <span class="s1">مِثْلَ</span> <span class="s1">ذَلِكَ</span> <span class="s1">ثُمَّ</span> <span class="s1">مَسَحَ</span> <span class="s1">رَأْسَهُ</span> <span class="s1">ثُمَّ</span> <span class="s1">غَسَلَ</span> <span class="s1">رِجْلَهُ</span> <span class="s1">الْيُمْنَى</span> <span class="s1">إِلَى</span> <span class="s1">الْكَعْبَيْنِ</span> <span class="s1">ثَلاَثَ</span> <span class="s1">مَرَّاتٍ</span> <span class="s1">ثُمَّ</span> <span class="s1">غَسَلَ</span> <span class="s1">الْيُسْرَى</span> <span class="s1">مِثْلَ</span> <span class="s1">ذَلِكَ</span> <span class="s1">ثُمَّ</span> <span class="s1">قَالَ</span> <span class="s1">رَأَيْتُ</span> <span class="s1">رَسُولَ</span> <span class="s1">اللَّهِ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">تَوَضَّأَ</span> <span class="s1">نَحْوَ</span> <span class="s1">وُضُوئِي</span> <span class="s1">هَذَا</span> <span class="s1">ثُمَّ</span> <span class="s1">قَالَ</span> <span class="s1">رَسُولُ</span> <span class="s1">اللَّهِ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">مَنْ</span> <span class="s1">تَوَضَّأَ</span> <span class="s1">نَحْوَ</span> <span class="s1">وُضُوئِي</span> <span class="s1">هَذَا</span> <span class="s1">ثُمَّ</span> <span class="s1">قَامَ</span> <span class="s1">فَرَكَعَ</span> <span class="s1">رَكْعَتَيْنِ</span> <span class="s1">لاَ</span> <span class="s1">يُحَدِّثُ</span> <span class="s1">فِيهِمَا</span> <span class="s1">نَفْسَهُ</span> <span class="s1">غُفِرَ</span> <span class="s1">لَهُ</span> <span class="s1">مَا</span> <span class="s1">تَقَدَّمَ</span> <span class="s1">مِنْ</span> <span class="s1">ذَنْبِهِ</span>  <span class="s1">قَالَ</span> <span class="s1">ابْنُ</span> <span class="s1">شِهَابٍ</span> <span class="s1">وَكَانَ</span> <span class="s1">عُلَمَاؤُنَا</span> <span class="s1">يَقُولُونَ</span> <span class="s1">هَذَا</span> <span class="s1">الْوُضُوءُ</span> <span class="s1">أَسْبَغُ</span> <span class="s1">مَا</span> <span class="s1">يَتَوَضَّأُ</span> <span class="s1">بِهِ</span> <span class="s1">أَحَدٌ</span> <span class="s1">لِلصَّلاَةِ</span>",<br>
         "englishChapterName":" HOW TO PERFORM ABLUTION",<br>
         "englishText":"&lt;p&gt;\nHumran, the freed slave of 'Uthman, said: Uthman b. 'Affan called for ablution water and this is how he performed the ablution. He washed his hands thrice. He then rinsed his mouth and cleaned his nose with water (three times). He then washed his face three times, then washed his right arm up to the elbow three times, then washed his left arm like that, then wiped his head; then washed his right foot up to the ankle three times, then washed his left foot like that, and then said: I saw the Messenger of Allah (may peace be upon him) perform ablution like this ablution of mine. Then the Messenger of Allah (may peace be upon him) said: He who performs ablution like this ablution of mine and then stood up (for prayer) and offered two rak'ahs of prayer without allowing his thoughts to be distracted, all his previous sins are expiated. Ibn Shihab said: Our scholars remarked: This is the most complete of the ablutions performed for prayer."<br>
      },<br>
      {<br>
         "hadithID":"305710",<br>
         "chapterNumber":"4",<br>
         "hadithNumber":"232b",<br>
         "arabicChapterName":" <span class="s1">باب</span> <span class="s1">فَضْلِ</span> <span class="s1">الْوُضُوءِ</span> <span class="s1">وَالصَّلاَةِ</span> <span class="s1">عَقِبَهُ</span>",<br>
         "arabicText":" <span class="s1">وَحَدَّثَنِي</span> <span class="s1">أَبُو</span> <span class="s1">الطَّاهِرِ،</span> <span class="s1">وَيُونُسُ</span> <span class="s1">بْنُ</span> <span class="s1">عَبْدِ</span> <span class="s1">الأَعْلَى،</span> <span class="s1">قَالاَ</span> <span class="s1">أَخْبَرَنَا</span> <span class="s1">عَبْدُ</span> <span class="s1">اللَّهِ</span> <span class="s1">بْنُ</span> <span class="s1">وَهْبٍ،</span> <span class="s1">عَنْ</span> <span class="s1">عَمْرِو</span> <span class="s1">بْنِ</span> <span class="s1">الْحَارِثِ،</span> <span class="s1">أَنَّ</span> <span class="s1">الْحُكَيْمَ</span> <span class="s1">بْنَ</span> <span class="s1">عَبْدِ</span> <span class="s1">اللَّهِ</span> <span class="s1">الْقُرَشِيَّ،</span> <span class="s1">حَدَّثَهُ</span> <span class="s1">أَنَّ</span> <span class="s1">نَافِعَ</span> <span class="s1">بْنَ</span> <span class="s1">جُبَيْرٍ</span> <span class="s1">وَعَبْدَ</span> <span class="s1">اللَّهِ</span> <span class="s1">بْنَ</span> <span class="s1">أَبِي</span> <span class="s1">سَلَمَةَ</span> <span class="s1">حَدَّثَاهُ</span> <span class="s1">أَنَّ</span> <span class="s1">مُعَاذَ</span> <span class="s1">بْنَ</span> <span class="s1">عَبْدِ</span> <span class="s1">الرَّحْمَنِ</span> <span class="s1">حَدَّثَهُمَا</span> <span class="s1">عَنْ</span> <span class="s1">حُمْرَانَ،</span> <span class="s1">مَوْلَى</span> <span class="s1">عُثْمَانَ</span> <span class="s1">بْنِ</span> <span class="s1">عَفَّانَ</span> <span class="s1">عَنْ</span> <span class="s1">عُثْمَانَ</span> <span class="s1">بْنِ</span> <span class="s1">عَفَّانَ،</span> <span class="s1">قَالَ</span> <span class="s1">سَمِعْتُ</span> <span class="s1">رَسُولَ</span> <span class="s1">اللَّهِ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">يَقُولُ</span>  <span class="s1">مَنْ</span> <span class="s1">تَوَضَّأَ</span> <span class="s1">لِلصَّلاَةِ</span> <span class="s1">فَأَسْبَغَ</span> <span class="s1">الْوُضُوءَ</span> <span class="s1">ثُمَّ</span> <span class="s1">مَشَى</span> <span class="s1">إِلَى</span> <span class="s1">الصَّلاَةِ</span> <span class="s1">الْمَكْتُوبَةِ</span> <span class="s1">فَصَلاَّهَا</span> <span class="s1">مَعَ</span> <span class="s1">النَّاسِ</span> <span class="s1">أَوْ</span> <span class="s1">مَعَ</span> <span class="s1">الْجَمَاعَةِ</span> <span class="s1">أَوْ</span> <span class="s1">فِي</span> <span class="s1">الْمَسْجِدِ</span> <span class="s1">غَفَرَ</span> <span class="s1">اللَّهُ</span> <span class="s1">لَهُ</span> <span class="s1">ذُنُوبَهُ</span>",<br>
         "englishChapterName":" THE MERIT OF WUDU AND THAT OF PRAYER AFTER IT",<br>
         "englishText":"&lt;p&gt;\nHumran, the freed slave of 'Uthman b. 'Affan, reported on the authority of 'Uthman b. 'Affan that he heard Allah's Messenger (may peace be upon him) say: He who performed ablution for prayer and performed it properly and then went (to observe) obligatory prayer and offered it along with people or with the congregation or in the mosque, Allah would pardon his sins."<br>
      }<br>
   ]<br>
}</p>
<p class="p1">You can see that the user must specify 'hadithIDs' as the key in the payload. As with other API calls, the 'languages' portion of the payload is optional, with the default being Arabic and English. And, as described above, it is known that the user will not ask for hadith in languages for books that we won't have that language in. Furthermore, since this particular call can get quite large, we limit the response provided by the server for up to 100 hadith in the response payload.</p>
<p class="p2"><br></p>
<p class="p3"><b>Search</b></p>
<p class="p1">We also provide an API to be able to perform search using the same search engine we use on sunnah.com. This allows clients to be able to leverage our powerful search capabilities without having to recreate their own. Example call is as follows:</p>
<p class="p1">curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"parameters" : {"start":"0","rows":"50","query":"cat"}}' https://sunnah.com/search</p>
<p class="p1">This call requires the 'parameters' map to define 'start', 'rows' and 'query'. All of these are required. This particular API implements pagination by allowing clients to specify at what offset they want the results by using 'start'. The 'rows' value defines how many results they want in the response. There is a maximum response size of 200, so values over 200 will be reset back down to 200. The 'query' portion of the API represents the term that is being searched for.<span class="Apple-converted-space"> </span></p>
<p class="p1">Currently the search API does only supports Arabic and English search queries. We plan on offering other languages in the future insh'Allah.</p>
<p class="p1">Example output is as follows:</p>
<p class="p1">{<br>
    "hadithText": [<br>
        {<br>
            "hadithID": "934820",<br>
            "collection": "abudawud",<br>
            "bookID": "24",<br>
            "chapterNumber": "28",<br>
            "hadithNumber": "3479",<br>
            "arabicChapterName": " <span class="s1">باب</span> <span class="s1">فِي</span> <span class="s1">ثَمَنِ</span> <span class="s1">السِّنَّوْرِ</span> ",<br>
            "arabicText": " <span class="s1">حَدَّثَنَا</span> <span class="s1">إِبْرَاهِيمُ</span> <span class="s1">بْنُ</span> <span class="s1">مُوسَى</span> <span class="s1">الرَّازِيُّ،</span> <span class="s1">ح</span> <span class="s1">وَحَدَّثَنَا</span> <span class="s1">الرَّبِيعُ</span> <span class="s1">بْنُ</span> <span class="s1">نَافِعٍ</span> <span class="s1">أَبُو</span> <span class="s1">تَوْبَةَ،</span> <span class="s1">وَعَلِيُّ</span> <span class="s1">بْنُ</span> <span class="s1">بَحْرٍ،</span> <span class="s1">قَالاَ</span> <span class="s1">حَدَّثَنَا</span> <span class="s1">عِيسَى،</span> <span class="s1">وَقَالَ،</span> <span class="s1">إِبْرَاهِيمُ</span> <span class="s1">أَخْبَرَنَا</span> <span class="s1">عَنِ</span> <span class="s1">الأَعْمَشِ،</span> <span class="s1">عَنْ</span> <span class="s1">أَبِي</span> <span class="s1">سُفْيَانَ،</span> <span class="s1">عَنْ</span> <span class="s1">جَابِرِ</span> <span class="s1">بْنِ</span> <span class="s1">عَبْدِ</span> <span class="s1">اللَّهِ،</span> <span class="s1">أَنَّ</span> <span class="s1">النَّبِيَّ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">نَهَى</span> <span class="s1">عَنْ</span> <span class="s1">ثَمَنِ</span> <span class="s1">الْكَلْبِ</span> <span class="s1">وَالسِّنَّوْرِ</span> ‏.‏ \n",<br>
            "englishChapterName": "Regarding The Price Of Cats",<br>
            "englishText": "\n&lt;p&gt;\n\nNarrated Jabir ibn Abdullah:\n&lt;/p&gt;\n\n\n\n&lt;p&gt;\n\nThe Prophet (peace_be_upon_him) forbade payment for dog and cat.\n&lt;/p&gt;\n\n\n"<br>
        },<br>
        {<br>
            "hadithID": "934830",<br>
            "collection": "abudawud",<br>
            "bookID": "24",<br>
            "chapterNumber": "28",<br>
            "hadithNumber": "3480",<br>
            "arabicChapterName": " <span class="s1">باب</span> <span class="s1">فِي</span> <span class="s1">ثَمَنِ</span> <span class="s1">السِّنَّوْرِ</span> ",<br>
            "arabicText": " <span class="s1">حَدَّثَنَا</span> <span class="s1">أَحْمَدُ</span> <span class="s1">بْنُ</span> <span class="s1">حَنْبَلٍ،</span> <span class="s1">حَدَّثَنَا</span> <span class="s1">عَبْدُ</span> <span class="s1">الرَّزَّاقِ،</span> <span class="s1">حَدَّثَنَا</span> <span class="s1">عُمَرُ</span> <span class="s1">بْنُ</span> <span class="s1">زَيْدٍ</span> <span class="s1">الصَّنْعَانِيُّ،</span> <span class="s1">أَنَّهُ</span> <span class="s1">سَمِعَ</span> <span class="s1">أَبَا</span> <span class="s1">الزُّبَيْرِ،</span> <span class="s1">عَنْ</span> <span class="s1">جَابِرٍ،</span> <span class="s1">أَنَّ</span> <span class="s1">النَّبِيَّ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">نَهَى</span> <span class="s1">عَنْ</span> <span class="s1">ثَمَنِ</span> <span class="s1">الْهِرَّةِ</span> ‏.‏ \n",<br>
            "englishChapterName": "Regarding The Price Of Cats",<br>
            "englishText": "Narrated Jabir:\nThe Prophet (saws) forbade payment for cat."<br>
        }<br>
    ]<br>
}</p>
<p class="p2"><br></p>
<p class="p3"><b>Single Hadith Retrieval</b></p>
<p class="p1">We also offer clients the ability to directly retrieve hadith by specifying the collection and hadith number they are interested in. This is for clients who have previously followed the steps above and have cached relevant hadith meta data. It can also apply to clients who aready know the collection they are interested in and are also aware of the hadith numbers within these aforementioned collections. These calls do not take hadithIDs, but rather they take the hadith number itself.<span class="Apple-converted-space"> </span></p>
<p class="p1">Clients may do either of the following:<br>
1. Fetch hadith by specifying a hadith number on the collection level (i.e collection: bukhari &amp; hadith number:3648).</p>
<p class="p1">2. Fetch hadith by specifying a hadith number on the collection level and offset within a book (i.e collection: bukhari &amp; book number: 55 &amp; hadith number:12).</p>
<p class="p1">The first call here allows the user to fetch hadith using a global hadith number within the collection. The second one allows the user to fetch hadith on a certain offset within a specified book. For futher information on where to obtain either of these numbers, you can visit any of the hadith on our site and observe the hadith numbering informatin located right below the hadith itself.</p>
<p class="p1">Sample API call would look like this:</p>
<p class="p1">curl -v -H "Content-Type: application/json" -H "xauth-sunnah: &lt;your auth token&gt;" -X POST -d '{"collection":"bukhari","hadithNumber":"13"}' https://sunnah.com/hadithByNumber</p>
<p class="p1">Sample response would look similar to this:</p>
<p class="p1">{<br>
    "hadithText": [<br>
        {<br>
            "hadithID": "100130",<br>
            "collection": "bukhari",<br>
            "bookID": "2",<br>
            "chapterNumber": "7",<br>
            "hadithNumber": "13",<br>
            "arabicChapterName": "<span class="s1">باب</span> <span class="s1">مِنَ</span> <span class="s1">الإِيمَانِ</span> <span class="s1">أَنْ</span> <span class="s1">يُحِبَّ</span> <span class="s1">لأَخِيهِ</span> <span class="s1">مَا</span> <span class="s1">يُحِبُّ</span> <span class="s1">لِنَفْسِهِ</span> ",<br>
            "arabicText": "<span class="s1">حَدَّثَنَا</span> <span class="s1">مُسَدَّدٌ،</span> <span class="s1">قَالَ</span> <span class="s1">حَدَّثَنَا</span> <span class="s1">يَحْيَى،</span> <span class="s1">عَنْ</span> <span class="s1">شُعْبَةَ،</span> <span class="s1">عَنْ</span> <span class="s1">قَتَادَةَ،</span> <span class="s1">عَنْ</span> <span class="s1">أَنَسٍ</span> <span class="s1">ـ</span> <span class="s1">رضى</span> <span class="s1">الله</span> <span class="s1">عنه</span> <span class="s1">ـ</span> <span class="s1">عَنِ</span> <span class="s1">النَّبِيِّ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span>‏.‏\n\n<span class="s1">وَعَنْ</span> <span class="s1">حُسَيْنٍ</span> <span class="s1">الْمُعَلِّمِ،</span> <span class="s1">قَالَ</span> <span class="s1">حَدَّثَنَا</span> <span class="s1">قَتَادَةُ،</span> <span class="s1">عَنْ</span> <span class="s1">أَنَسٍ،</span> <span class="s1">عَنِ</span> <span class="s1">النَّبِيِّ</span> <span class="s1">صلى</span> <span class="s1">الله</span> <span class="s1">عليه</span> <span class="s1">وسلم</span> <span class="s1">قَالَ</span> ‏\"‏ <span class="s1">لا</span> <span class="s1">يُؤْمِنُ</span> <span class="s1">أَحَدُكُمْ</span> <span class="s1">حَتَّى</span> <span class="s1">يُحِبَّ</span> <span class="s1">لأَخِيهِ</span> <span class="s1">مَا</span> <span class="s1">يُحِبُّ</span> <span class="s1">لِنَفْسِهِ</span> ‏\"‏‏.‏   \n",<br>
            "englishChapterName": "To like for one's (Muslim's) brother what one likes for himself is a part of faith",<br>
            "englishText": "\n&lt;p&gt;\n\n     Narrated Anas:\n&lt;p&gt;\n\n     The Prophet said, \"None of you will have faith till he wishes for his \n     (Muslim) brother what he likes for himself.\"\n&lt;p&gt;\n\n\n"<br>
        }<br>
    ]<br>
}</p>
<p class="p1"><br>
That's a quick summary of the new sunnah.com web services. If you are interested in using these services, or have any questions, please feel free to <a href="http://sunnah.com/contact"><span class="s2">contact us.</span></a></p>

	
<br />
<div style="display: none; width:100%; height:2px; background-color:#867044; margin-top: 30px;"></div>
<div class=footer>
<div class=footer_left>Sunnah.com &copy; 2011</div>
<div class=footer_right>
	<a href="/about">About</a> |
	<a href="/contact">Contact</a> |
	<a href="/support">Support</a>
</div>
<div class=footer_center>Sunnah.com supports <a href="http://www.islamic-relief.com/">Islamic Relief</a></div>
<div class=clear />
</div>
<div style="width:100%; height:4px; background-color:#867044; margin-top: 0px; margin-bottom: 0px;"></div>




<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://sunnah.com/piwik/" : "http://sunnah.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://sunnah.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

<script type="text/javascript">
var sc_project=7148282; 
var sc_invisible=1; 
var sc_security="63a57073"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
class="statcounter"><a title="drupal statistics"
href="http://statcounter.com/drupal/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/7148282/0/63a57073/1/"
alt="drupal statistics" ></a></div></noscript>

</body>
</html>

