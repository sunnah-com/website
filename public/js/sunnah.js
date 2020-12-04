	jQuery.htmlPrefilter = function( html ) {
		return html;
	};

	function openquran(surah, beginayah, endayah) {
        window.open("https://quran.com/"+(surah+1)+"/"+beginayah+"-"+endayah, "quranWindow", "resizable = 1, fullscreen = 1");
    }

    function reportHadith_old(urn) {
        window.open("/report.php?urn="+urn, "reportWindow", "scrollbars = yes, resizable = 1, fullscreen = 1, location = 0, toolbar = 0, width = 500, height = 700");
	}
	
	var recaptchaLoaded = false;
	var pendingCaptchas = [];
	function onRecaptchaLoad() {
		recaptchaLoaded = true
		addPendingCaptchas();
	}

	function addCaptcha(container) {
		pendingCaptchas.push(container)
		if (recaptchaLoaded) {
			addPendingCaptchas();
		}
	}

	function addPendingCaptchas() {
		while (container = pendingCaptchas.shift()) {
			grecaptcha.render(
				container,
				{
					"sitekey": "6LeSfaEUAAAAAJwX1rGqAy6mN2oo3KCJGolLdOxL",
					"theme": "light"
				}
			)
		}
	}

	var openre = "";
	
    function reportHadith(eurn, divname) {
		// first check if some other RE panel is open.
		// if it is and it's not this one, close it and destroy the captcha.
		// otherwise if it's this one, toggle it off (animated), return
		// 
		// set up this panel and display it

		var reel = $("#re"+divname);
		var openreel = $("#re"+openre);
	
		if (openre.length > 0) {
			if (openre == divname) {
				reel.toggle(400, function() {openreel.remove(); });
				openre = "";
				return;
			}
			else {
				$("#re"+openre).toggle();
				openreel.remove()
				openre = "";
			}
		}

		insertScript('https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit', 'recaptcha-script');

		$.get("/report.php", {eurn: eurn, hid: divname}, function (data) {
			$("#"+divname+" .bottomItems").append(data);
			
			addCaptcha("rerec" + divname);

			openre = divname;
			$("#reform"+divname).submit(function(event) {
				event.preventDefault();
				
				if (!$("#reform"+divname+" input[name=type]:checked").length) {
					$("#reresp"+divname).html("Please choose the type of error.");			
				}
				else if ($("#reform"+divname+" input[name=type]:checked").val() == "other"
						&& $("#reform"+divname+" input[name=othererror]").val().length < 1) {
					$("#reresp"+divname).html("Please specify the type of error.");
				}
				else if ($("#reform"+divname+" input[name=emailme]").is(':checked') 
						&& $("#reform"+divname+" input[name=email]").val().length < 1) {
					$("#reresp"+divname).html("Please enter an email address.");
				}
				else {
					$.ajax({
						type: "POST",
						url: "/processer.php",
						data: $("#reform"+divname).serialize(),
						success: function(data) {
							var dataObj = $.parseJSON(data);
							if (dataObj.status == 0) {
								$("#reresp"+divname).css('color', 'rgb(117, 161, 161');
								$("#reresp"+divname).css('font-weight', 'bold');
								$("#reresp"+divname).css('font-size', '15px');
								//$("#reresp"+divname).css('height', ($("#reresp"+divname).height()+15)+'px');
								$(".resubmit").toggle();
 							}
							$("#reresp"+divname).html(dataObj.message);
						}
					});
				}
			});
			
			$("#re"+divname).toggle(400);

		});
    }


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22385858-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  // (a) put default input focus on the state field
  // (b) jquery ajax autocomplete implementation
  
	function insertScript(uri, id) {
		var js, fjs = document.getElementsByTagName('script')[0];
		if (document.getElementById(id)) return;
		js = document.createElement('script'); js.id = id;
		js.src = uri;
		fjs.parentNode.insertBefore(js, fjs);
	}
  
  function close_box() {
	$('#sharefuzz, .share_mb').animate(
			{'opacity':'0'}, 
			200, 
			'linear', 
			function() {
				$('#sharefuzz, .share_mb').css('display', 'none');
			});
	}
	
	var sharescriptsInserted = false;
	var justloaded = false;

	function share(permalink) {		
		$.get("/share.php", {"link": permalink}, function(data) {
			if (!$(".share_mb").length) $("body").append('<div class="share_mb"></div>');
			$(".share_mb").html(data); 
			
			$(".share_mb").css("left", ($(window).width() - $(".share_mb").width())/2+"px");
			$(".share_mb").css("top", ($(window).height() - $(".share_mb").height())/2.8+"px");
		
			$('#sharefuzz, .share_mb').animate({'opacity':'.25'}, 200, 'linear');
			$('.share_mb').animate({'opacity':'1.00'}, 200, 'linear');
			$('#sharefuzz, .share_mb').css('display', 'block');

			$(".permalink_box").select();			
		});
	}	





	//#region Copy Menu UI Management

	var openedMenu;
	var $hadithContainerInObservance;

	/**
	 * Opens copy menu, fills it from user's preferences from Local Storage
	 * @param {object} $copyMenu jQuery object representing the copy menu container 
	 */	
	function openCopyMenu($copyMenu) {
		if ($copyMenu) {
			if (openedMenu) {
				closeCopyMenu();
			}
			
			$hadithContainerInObservance = $copyMenu.closest('.actualHadithContainer');
			
			// if grade for the Hadith is not available, then do not show the option in the dialog box
			if(!$hadithContainerInObservance.find('.arabic_grade').length) 
				$hadithContainerInObservance.find('.copyGrade')
											.parent()
											.hide();				

			syncAppCopyUserPreferenceWithLocalStorage();

			// Updating the UI with values saved in Local Storage if they were set; 
			// otherwise, with the default values
			for (var className in itemsToCopy)
				$hadithContainerInObservance.find('.' + className)
											.prop('checked', itemsToCopy[className])
			
			$copyMenu.fadeIn('fast');
			openedMenu = $copyMenu;				
		}
	}


	/**
	 * Close the menu that was previously opened, if any. 
	 * Otherwise, do nothing.
	 */
	function closeCopyMenu() {
		if (openedMenu) {
			openedMenu.fadeOut('fast');
			openedMenu = null;					
		}
	}


	/**
	 * Manages the closing and opening of copy menus 
	 * depending on where the user clicks on a page. 
	 */
	$(document).on('click', function(event) {
		$clickedElement = $(event.target);
		if ($clickedElement.attr('class') == 'copyMenuCaret') {
			if ($clickedElement.siblings('.copyContainer').is(':visible')) {
				// user is trying to close a copy menu
				closeCopyMenu();
			} else {
				// user is trying to open a copy menu
				openCopyMenu($clickedElement.siblings('.copyContainer'));
			}
		} else if (openedMenu) {
			if ($clickedElement.closest('.copyContainer').length) {
				// User is clicking within an opened copy menu
				// Don't do anything. Let it remain open.
			} else {
				// User is clicking on the website outside the copy menu
				closeCopyMenu();					
			}
		}
	});

	//#endregion Copy Menu UI Management





	//#region Copy Menu Options Local Storage Management

	/**
	 * Set default copy menu values in this object!
	 */
	var itemsToCopy	= { 
		copyArabic				: true ,
		copyTranslation			: true ,
		copyGrade				: true ,
		copyBasicReference		: true ,
		copyDetailedReference	: false,		
		copyWebReference		: true ,
	};


	/**
	 * Sync App's Copy User Preferences in the UI with Local Storage
	 * @returns {object} An object with boolean properties with keys same as the class name of the UI elements 
	 */
	function syncAppCopyUserPreferenceWithLocalStorage() {
		if (storageAvailable("localStorage")) {
			var localItemsToCopy = localStorage.getItem("ItemsToCopy");

			if (!localItemsToCopy || localItemsToCopy == "null") { 
				// Info not stored in Local Storage as of yet.                
				// Setting default value for first use if 
				// nothing is stored as of yet in Local Storage.
				localStorage.setItem('ItemsToCopy', JSON.stringify(itemsToCopy));
			} else { 
				// Info available in Local Storage.
				// Caching value in memory for app use.  
				itemsToCopy = JSON.parse(localItemsToCopy);				
			}
		}
	}


	var $copySuccessIndicator;

	/**
	 * Checking if Storage is both supported and available in the browser 
	 * in order to persist user preference
	 * @param  {string}  type 'localStorage' or 'sessionStorage'
	 * @returns {boolean} Storage available or not
	 */
	function storageAvailable(type) {
		var storage;
		try {
			storage = window[type];
			var x	= '__storage_test__';
			storage.setItem(x, x);
			storage.removeItem(x);
			return true;
		}
		catch(e) {
			return e instanceof DOMException && (
				// everything except Firefox
				e.code === 22 ||
				// Firefox
				e.code === 1014 ||
				// test name field too, because code might not be present
				// everything except Firefox
				e.name === 'QuotaExceededError' ||
				// Firefox
				e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
				// acknowledge QuotaExceededError only if there's something already stored
				(storage && storage.length !== 0);
		}
	}


	/**
	 * Copy menu item click event handler
	 */
	function updateItemsToCopyInLocalStorage() {
		if (storageAvailable("localStorage")) {
			for(var className in itemsToCopy)
				itemsToCopy[className] = $hadithContainerInObservance
											.find('.' + className)
											.prop('checked');
			localStorage.setItem('ItemsToCopy', JSON.stringify(itemsToCopy));
		}		
	}

	//#endregion Copy Menu Options Local Storage Management





	//#region Copy to Clipboard Operation 

	/**
	 * Copy button in Copy Dialog Box click event handler
	 */
	function copyHadithToClipboard(e) {
		// Get which Hadith to copy and what parts of it to copy
		$hadithContainerInObservance = $(e).closest('.actualHadithContainer');
		syncAppCopyUserPreferenceWithLocalStorage();

		var copyText = extractHadithTextFromPage();
		
		if ("permissions" in navigator && "clipboard" in navigator) 
			navigator.permissions.query({name: "clipboard-write"})
				.then(result => {
					if (result.state == "granted" || result.state == "prompt")								
						copyToClipboard(copyText);
					else
						copyToClipboardFallback(copyText);
				});				
		else			
			copyToClipboardFallback(copyText);
	}
	

	/**
	 * Get Hadith text and references from the webpage, 
	 * and neatly format it into a string according to user specifications
	 * @returns {string} Hadith text and references neatly formatted into a string 
	 */
	function extractHadithTextFromPage() {
		var hadithStr = '';

		if (itemsToCopy.copyArabic) {
			// Adding the Arabic text of Hadith
			var $arabicContainer = $hadithContainerInObservance.find('.arabic_hadith_full');
			if ($arabicContainer.length) {
				var arabicText 	 = $arabicContainer.text().replace(/\n{2,}/g, '\n').trim();
				if (arabicText)
					hadithStr	+= arabicText 
								+  '\n';
			}
		}

		if (itemsToCopy.copyTranslation) {
			// Adding the translation of Hadith that is visible
			var $translationContainer = $hadithContainerInObservance.find('.englishcontainer');
			if ($translationContainer.length) {
				$translationContainer.children().each(function () {
					$this = $(this);
					if ($this.is(':visible')) { // Whichever translation is visible, copy that only.
						var translation = $this.text().replace(/\n{2,}/g, '\n').trim(); // replace potential multiple newlines with a single newline character 
						if (translation)
							hadithStr	+=	'\n'
										+	translation 
										+	'\n';
					} 
				});					
			}
		}

		if (itemsToCopy.copyGrade && $hadithContainerInObservance.find('.gradetable').length) {
			// Adding the grade of the Hadith
			var $englishGrade, $arabicGrade, englishGrade;

			$englishGrade = $hadithContainerInObservance.find('.english_grade:nth-child(2)');			
			if ($englishGrade.length) {
				englishGrade = $englishGrade.text().trim().slice(2);
				if (englishGrade)
					hadithStr += '\nGrade: ' + englishGrade;
			}

			$arabicGrade = $hadithContainerInObservance.find('.arabic_grade:first');
			if ($arabicGrade.length) {
				var arabicGrade = $arabicGrade.text().replace(/\s{2,}/g, ' ').trim();
				if (arabicGrade) {
					if (englishGrade)
						hadithStr += ' | ';
					else
						hadithStr += '\n';

					hadithStr	  += 'حكم: '
								  +	 arabicGrade;
				}
			}
		}

		// Adding a simple reference of Hadith in English
		if ($hadithContainerInObservance.find('.hadith_reference tr:first-child td:nth-child(1)') == "Reference") {
			var $basicRef = $hadithContainerInObservance.find('.hadith_reference tr:first-child td:nth-child(2)');
			if ($basicRef.length){
				var basicRef	 = 	$basicRef.text().trim().slice(2);
				if (basicRef)
					hadithStr	+=	'\nReference: ' + basicRef
								+	'\n';					 
			}	
		} else { // Required reference numbering is not available for this, 
				// including the  Collection name.  
			   // We will have to manually extract this from the breadcrumbs.
			var $crumbs = $('.crumbs');
			if ($crumbs.length) {
				var crumbs = $crumbs.text();
				if (crumbs) {
					var crumbsArray = crumbs.split('»');
					if (crumbsArray.length > 1) {
						var $refNums = $hadithContainerInObservance.find('.hadith_reference tr:first-child td:nth-child(2)');
						if ($refNums.length){
							var refNums	 = 	$refNums.text().trim().slice(2);
							if (refNums)
								hadithStr	+=	'\nReference: ' 
											+ crumbsArray[1].trim() 
											+ ', ' 
											+ refNums
											+	'\n';					 
						}
					}
				}
			}
		}
	
		if (itemsToCopy.copyDetailedReference) {
			// Adding a more complete reference of Hadith in both Arabic and English
			var detailedReferenceStr= '';			
			var $bookInfo			= $('.book_info');
			var $chapterInfo		= $hadithContainerInObservance.prevAll('.chapter:first');
			var $hadithInfo			= $hadithContainerInObservance.find('.hadith_reference tr:nth-child(2)');

			if ($bookInfo.length) {
				// Add a line for book information 
				var $bookNameEnglish= $bookInfo.find('.book_page_english_name');
				var $bookNumber		= $bookInfo.find('.book_page_number');
				var $bookNameArabic	= $bookInfo.find('.book_page_arabic_name');
				var bookNameEnglish, bookNumber, bookNameArabic;

				// check if book name tags (divs/classes) are present on page
				if ($bookNameEnglish.length)
					bookNameEnglish = $bookNameEnglish.text().trim();					
				if ($bookNumber.length)
					bookNumber = $bookNumber.text().trim();					
				if ($bookNameArabic.length)
					bookNameArabic = $bookNameArabic.text().trim();

				if (bookNameEnglish || bookNameArabic) { // only add book info to detailed reference 
														// if a book name is present					
					detailedReferenceStr += ' - '; 
					// check if book names aren't actually empty tags with no content
					if (bookNameEnglish)
						detailedReferenceStr += bookNameEnglish + ' ';
					if (bookNumber)
						detailedReferenceStr += '(' + bookNumber + ') ';
					if (bookNameArabic)
						detailedReferenceStr += bookNameArabic;
					detailedReferenceStr += '\n';
				}
			}	

			if ($chapterInfo.length) {
				// Add a line for chapter information
				var $chapterNameEnglish	= $chapterInfo.find('.englishchapter');
				var $chapterNumber		= $chapterInfo.find('.achapno');
				var $chapterNameArabic	= $chapterInfo.find('.arabicchapter');
				var chapterNameEnglish, chapterNumber, chapterNameArabic;

				if ($chapterNameEnglish.length)
					chapterNameEnglish = $chapterNameEnglish.text().trim();
				if ($chapterNumber.length)
					chapterNumber = $chapterNumber.text().trim();
				if ($chapterNameArabic.length)
					chapterNameArabic = $chapterNameArabic.text().trim();

				if (chapterNameEnglish || chapterNameArabic) {	 // only add chapter info to the detailed reference 
																// if a book name is present					
					detailedReferenceStr += ' - '; 
					if (chapterNameEnglish)
						detailedReferenceStr += chapterNameEnglish + ' ';
					if (chapterNumber)
						detailedReferenceStr += chapterNumber + ' ';
					if (chapterNameArabic)
						detailedReferenceStr += chapterNameArabic;
					detailedReferenceStr += '\n';
				}
			}

			if ($hadithInfo.length) {
				var $hadithNumberType = $hadithInfo.find('td:first');
				if ($hadithNumberType.length) {
					if ($hadithNumberType.text().trim() == "In-book reference") {
						var $hadithNumber = $hadithInfo.find('td:nth-child(2)');
						if ($hadithNumber.length) {
							var hadithNumber = $hadithNumber.text().trim().split(',');
							if (hadithNumber.length > 1)
								detailedReferenceStr += ' - ' + hadithNumber[1].trim() + '\n';			
						}
					}
				}
			}

			if (detailedReferenceStr)
				hadithStr += 'In-book reference:\n' + detailedReferenceStr;
		}
		
		if (itemsToCopy.copyWebReference) {
			// Adding sunnah.com web source reference of Hadith
			$shareLink = $hadithContainerInObservance.find('.sharelink');
			if ($shareLink.length) {
				var pageLink = $shareLink.attr('onclick')
										 .match(/["'](.*?)["']/)[1];				
				if (pageLink)
					hadithStr	+= 'Source: https://' 
								+	window.location.hostname 
								+	pageLink;
			}
		}
		
		return hadithStr.trim();
	}


	/**
	 * Writes text to clipboard and shows success message.
	 * @param {string} text The text that should be copied to clipboard 
	 */
	function copyToClipboard(text) {
		navigator.clipboard.writeText(text)
						   .then(
								() => showCopySuccessIndicator(),    
								() => copyToClipboardFallback(text) // In case of failure, use fallback
        					);		
    }


	/**
	 * Display an indication for copy-to-clipboard operation success
	 */
	function showCopySuccessIndicator() {		
		$hadithContainerInObservance.find('.copySuccessIndicator')
									.finish()
									.animate({'opacity': 0.9}, 'fast')
									.delay(1300)
									.animate({'opacity': 0})									
	}


	/**
	 * Copies to clipboard using a dummy text area and Ctrl+C. 
	 * Use this as a fallback method if clipboard doesn't work. 
	 * @param {string} text The text to copy to clipboard 
	 */
	function copyToClipboardFallback(text) {
		var dummy = document.createElement("textarea");
		// to avoid breaking orgain page when copying more words
		// cant copy when adding below this code
		// dummy.style.display = 'none'
		document.body.appendChild(dummy);
		dummy.value = text;

		// Select the text field
		dummy.select();
		dummy.setSelectionRange(0, 99999); /*For mobile devices*/
		
		// Copy the text inside the text field
		document.execCommand("copy");
		document.body.removeChild(dummy);
		showCopySuccessIndicator();
	}

	//#endregion Copy to Clipboard Operation 




	
   $(document).ready(function () {  

	$(window).scroll(function() {
		if ($(window).scrollTop() > 750) $("#back-to-top").addClass('bttenabled');
		else $("#back-to-top").removeClass('bttenabled');

		if ($(window).scrollTop() > 25) { // this number is height of short banner + breadcrumbs - 40
			$("#banner").removeClass('bannerTop');
			$("#banner").addClass('bannerMiddle');
			$("#header").css('position', 'fixed');
			$("#header").css('top', '0');
			$("#topspace").css('display', 'block');
			$("#toolbar").css('display', 'none');
			$("#search").css('bottom', '31px'); // crumbs height + 12 bottom padding
			$("#sidePanel").css({'position': 'fixed', 'top': '65px', 'left': $(".mainContainer").position().left - $("#sidePanel").width() - 55}); // last number is sidePanelContainer padding
		}
		else {
			$("#banner").removeClass('bannerMiddle');
			$("#banner").addClass('bannerTop');
			$("#header").css('position', 'relative');
			$("#topspace").css('display', 'none');
			$("#toolbar").css('display', 'block');
			$("#search").css('bottom', '45px'); // crumbs height + 20 bottom padding
			$("#sidePanel").css('position', 'static');
		}
	});

	$("body").append('<div id="sharefuzz"></div>');
	$('#sharefuzz').click(function(){ close_box(); });
	
	if ("searchQuery" in window) {
		$(".searchquery").val($('<textarea/>').html(searchQuery).text());
		$(".searchquery").css('color', '#000');
	}

	$(".searchtipslink").click(function() {
		if ($("#searchtips").css('display') == 'none') {
			$("#searchtips").show(400);
		}
		else $("#searchtips").hide(400);
	});

    $(".indexsearchtipslink").click(function() {
        if ($("#indexsearchtips").css('display') == 'none') {
            $("#indexsearchtips").show(400);
        }
        else $("#indexsearchtips").hide(400);
    });


   // tell the autocomplete function to get its data from our php script
  
     var $searchBox = $('#searchBox');

         $searchBox.autocomplete({
        source: "/autocomplete/javaCaller.php",
        minLength: 2,
                //select: {$("searchForm").submit() }
            select: function(e, ui) {
                   $searchBox.val(ui.item.value);
                   $("#searchform").submit();
                },  
        open: function (e, ui) {
                var acData = $(this).data('autocomplete');
                acData
                .menu
                .element
                .find('a')
                .each(function () {
                    var me = $(this);
                    var keywords = acData.term.split(' ').join('|');
                    me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>'));
                });
              } 
    
    });

	
	setLangCBs();
	if ("pageType" in window && spshowing) {
		if (langDisplay != 'english') setLanguageDisplay('english', false);
		setLanguageDisplay(langDisplay, true);
	}

  });

    var langLoaded = new Object();

    function loadLang(lang, collection, bookID) {
        $.getJSON("/ajax/"+lang+"/"+collection+"/"+bookID, function(data) { 
            $.each(data, function(idx, elt) {
				text = "<div class=\""+lang+"_hadith_full "+lang+"\">";
				if (elt["hadithSanad"]) text = text + "<span class=\""+lang+"_sanad\">"+elt["hadithSanad"]+"</span> ";
				text = text + elt["hadithText"]+"</div>"
				$("#t"+elt["matchingArabicURN"]).append(text);
			});
            langLoaded[lang] = true;
        });
    }

    function toggleLanguageDisplay(lang) {
		setLanguageDisplay(langDisplay, false);
        langDisplay = lang;
        setLanguageDisplay(lang, true);
		setLangCookie();
	}

	function setLanguageDisplay(lang, val) {
		if (val) {
			if (!langLoaded[lang]) loadLang(lang, collection, bookID);
			$("."+lang+"_hadith_full").css('display', 'block');
		}
		else $("."+lang+"_hadith_full").css('display', 'none');
	}

	function setLangCookie() {
		$.cookie('langprefs13', JSON.stringify(langDisplay, null, 2), {path: '/'});
	}

	function setLangCBs() {
		$("#ch_"+langDisplay).prop("checked", true);
	}

    langLoaded['english'] = true;
    langLoaded['indonesian'] = false;
    langLoaded['urdu'] = false;

	if ($.cookie('langprefs13') == null) {
		langDisplay = 'english';
		setLangCookie();
	}
	else {
		cookieLang = JSON.parse($.cookie('langprefs13'));
		if ("avbl_languages" in window && $.inArray(cookieLang, avbl_languages) == -1) langDisplay = "english"
		else langDisplay = cookieLang;
	}

	if ($.cookie('recvis') == null) {
		$.cookie('recvis', new Date().toString(), { expires: 30, path: '/' } )
	}