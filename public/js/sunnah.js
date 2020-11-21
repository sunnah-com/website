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

	/**
	 * 
	 * @param {HTML} data HTML to insert into created dialog box
	 */
	function createCenteredDialogBox(data) {
		if (!$(".share_mb").length)
			$("body").append('<div class="share_mb"></div>');
		$(".share_mb").html(data);

		$(".share_mb").css("left", ($(window).width() - $(".share_mb").width()) / 2 + "px");
		$(".share_mb").css("top", ($(window).height() - $(".share_mb").height()) / 2.8 + "px");

		$('#sharefuzz, .share_mb').animate({ 'opacity': '.25' }, 200, 'linear');
		$('.share_mb').animate({ 'opacity': '1.00' }, 200, 'linear');
		$('#sharefuzz, .share_mb').css('display', 'block');
	}

	function share(permalink) {		
		$.get("/share.php", {"link": permalink}, function(data) {
			createCenteredDialogBox(data);	
			$(".permalink_box").select();		
		});
	}


	/**
	 * default copy menu values
	 */
	let itemsToCopy = { 
		copyArabic: true,
		copyTranslation: true,
		copyGrade: true,
		copyBasicReference: false,
		copyDetailedReference: true,		
		copyWebReference: true,
	};

	let $copySuccessIndicator;
	let $hadithContainerInObservance;

	
	/**
	 * This dialog box provides Hadith copy options
	 */
	function showCopyDialogBox(e) {
		$.get('/copy_hadith_menu.php', function(data) {
			createCenteredDialogBox(data);
			$copySuccessIndicator = $('#copyContainer #copySuccessIndicator');
			$hadithContainerInObservance = $(e).parents('.actualHadithContainer');
			
			// if grade for the Hadith is not available, then do not show the option in the dialog box
			if (!$('.arabic_grade').length) 
				$('#copyContainer #copyGrade').parent().hide();				

			if (storageAvailable("localStorage")) {
				let localItemsToCopy = localStorage.getItem("ItemsToCopy");
				if (!localItemsToCopy) {    //Info not stored in Local Storage as of yey                
					localItemsToCopy = itemsToCopy;  //setting default value for first use if 
													//nothing is stored as of yet in Local Storage
					localStorage.setItem('ItemsToCopy', JSON.stringify(localItemsToCopy));
                } else {	//Info available in Local Storage  
					localItemsToCopy = JSON.parse(localItemsToCopy);
					itemsToCopy = localItemsToCopy;	//caching value in memory as well for later use				
				}
				for(var name in localItemsToCopy) {
					document.getElementById(name).checked = localItemsToCopy[name];
				}
            }
		});
	}


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
			var x = '__storage_test__';
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
			for(var name in itemsToCopy) {
				itemsToCopy[name] = document.getElementById(name).checked;
			}
			localStorage.setItem('ItemsToCopy', JSON.stringify(itemsToCopy));
		}		
	}


	/**
	 * Copy button in Copy Dialog Box click event handler
	 */
	function copyToClipboard(e) {
		navigator.permissions.query({name: "clipboard-write"}).then(result => {
			if (result.state == "granted" || result.state == "prompt") {
				let copyText = '';
				
				if (itemsToCopy.copyArabic)
					copyText += `${getTextFromDOM('.arabic_hadith_full', $hadithContainerInObservance)}\n`;

				if (itemsToCopy.copyTranslation)
					copyText += `\n${getTextFromDOM('.english_hadith_full', $hadithContainerInObservance).replace('\n','')}\n`;
				
				let arabicGrade = getTextFromDOM('.arabic_grade', $hadithContainerInObservance);
				if (itemsToCopy.copyGrade && arabicGrade) { 
					// Grade checkbox is selected and arabic grade for the Hadith exists
					arabicGrade = arabicGrade.split(' ');
					arabicGrade = `حكم: ${arabicGrade[0].trim()} ${arabicGrade[1].trim()}` 										
					copyText += `Grade: ${getTextFromDOM('.english_grade:nth-child(2)', $hadithContainerInObservance).slice(2)} | ${arabicGrade}`;	
				}					

				if (itemsToCopy.copyBasicReference)
					copyText += `\nReference: ${getTextFromDOM('.hadith_reference tr:first-child td:nth-child(2)', $hadithContainerInObservance).slice(2)}\n`;				
				else if (itemsToCopy.copyDetailedReference) {
					let $bookInfo = $('.book_info');
					let $chapterInfo = $hadithContainerInObservance.prevAll('.chapter:first');
					
					copyText += '\n' +
					`Reference: ${getTextFromDOM('.hadith_reference tr:first-child td:nth-child(2)', $hadithContainerInObservance).slice(2)}\n` +
					`In-book reference:\n` +
					` - ${getTextFromDOM('.book_page_english_name', $bookInfo)} (${getTextFromDOM('.book_page_number', $bookInfo)}) ${getTextFromDOM('.book_page_arabic_name', $bookInfo)}\n` +
					` - ${getTextFromDOM('.englishchapter', $chapterInfo)} ${getTextFromDOM('.echapno', $chapterInfo)} ${getTextFromDOM('.arabicchapter', $chapterInfo)}\n` +
					` - ${getTextFromDOM('.hadith_reference tr:nth-child(2) td:nth-child(2)', $hadithContainerInObservance).split(',')[1].trim()}\n`;
				}
				
				if (itemsToCopy.copyWebReference)
					copyText += `Source: ${window.location.hostname}${$hadithContainerInObservance.find('.sharelink')[0].onclick.toString().match(/["'](.*?)["']/)[1]}`;

				// REMOVE AFTER DEBUGGING!
				console.log(copyText.trim());
				
				updateClipboardWithPlainText(copyText.trim());
			} else {
				showCopySuccessIndicator('✗', '#640000');
			}
		});
	}
	

	/**
	 * Find an element using a CSS selector within a parent element and then return its text
	 * @param  {string} cssSelector cssSelector string to extract text from DOM elements on page
	 * @returns {string} If text is found, returns it; otherwise, returns an empty string 
	 */
	function getTextFromDOM(cssSelector, $element) {
		let textNode = $element.find(cssSelector);
		if (textNode.length)
			return textNode.text().trim();
		else 
			return '';
	}


	/**
	 * Writes plain text to clipboard and shows success or error message.
	 * @param {string} text The text that should be copied to clipboard 
	 */
	function updateClipboardWithPlainText(text) {
        navigator.clipboard.writeText(text).then(
			() => showCopySuccessIndicator('✓', '#006400'),
			() => showCopySuccessIndicator('✗', '#640000')
        );		
    }


	/**
	 * Display indication of copy-to-clipboard operation success or failure
	 * @param {string} text What characters to display on screen, such as ✓ or ✗
	 * @param {string} color The color code
	 */
	function showCopySuccessIndicator(text, color) {		
		$copySuccessIndicator.finish();
		$copySuccessIndicator.css('opacity', '0');
		$copySuccessIndicator.text(text);
		$copySuccessIndicator.css('color', color);
		$copySuccessIndicator.animate({ opacity: 1 }, 300).delay(600).animate({ opacity: 0 }, 300);
	}


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