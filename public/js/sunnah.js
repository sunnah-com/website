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
			
			$(".share_mb").css("left", ($(window).width() - $(".share_mb").outerWidth())/2+"px");
			$(".share_mb").css("top", ($(window).height() - $(".share_mb").outerHeight())/2+"px");
		
			$('#sharefuzz, .share_mb').animate({'opacity':'.25'}, 200, 'linear');
			$('.share_mb').animate({'opacity':'1.00'}, 200, 'linear');
			$('#sharefuzz, .share_mb').css('display', 'block');

			$(".permalink_box").select();			
		});
	}	


	/**
	 * Checks if Storage is supported and available in the browser 
	 * @param  {string}  type 'localStorage' or 'sessionStorage'
	 * @returns {boolean} Is Storage available
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
	 * Save Clipboard Settings to localStorage
	 */
	function saveCbSettings() {
		if (storageAvailable("localStorage")) {
			var $flyout = $("#cb_flyout"),
				cbSettings = {};

			$flyout.find("input[type=checkbox]").each( function() {
				cbSettings[ $(this).attr("name") ] = $(this).is(":checked");
			});

			$flyout.find("input[type=radio]:checked").each( function() {
				cbSettings[ $(this).attr("name") ] = $(this).val();
			});

			localStorage.setItem('cbSettings', JSON.stringify(cbSettings));
		}		
	}


	function getCbSettings() {
		var cbSettings = $.parseJSON(localStorage.getItem('cbSettings'));
		
		if ( cbSettings === null ) {
			// Defaults
			cbSettings = {
				arabic: true,
				translation: true,
				ref: "concise",
				url: true,
				grade: false
			}
		}

		return cbSettings;
	}


	/**
	 * Handles Copy button
	 * 
	 * @listens document#click
	 */
	function cbCopy() {
		var $hadithContainer = $(this).closest('.actualHadithContainer'),
			$copyLink = $hadithContainer.find(".copylink"),
			copyText = getCopyText($hadithContainer);
		
		copyTextToClipboard(copyText);

		$copyLink.addClass("success");
		setTimeout(() => {
			$copyLink.removeClass("success");
		}, 2500);
	}


	function copyTextToClipboard(copyText) {
		if ("permissions" in navigator && "clipboard" in navigator)
			navigator.permissions.query({ name: "clipboard-write" })
				.then(result => {
					if (result.state === "granted" || result.state === "prompt")
						navigator.clipboard.writeText(copyText)
										   .then(null, () => copyToClipboardFallback(copyText)); // In case of failure		
					else
						copyToClipboardFallback(copyText);
				});

		else
			copyToClipboardFallback(copyText);
	}


	function shareLinkCopyBtnClickHandler() {
		copyTextToClipboard($('.share_mb .permalink_box').val());

		var $copyBtn = $('.share_mb .copy_btn');
		$copyBtn.addClass("success");
		setTimeout(() => {
			$copyBtn.removeClass("success");
		}, 2500);
	}
	

	/**
	 * Get Hadith text and references from the page
	 * 
	 * @returns {string} Formatted hadith text
	 */
	function getCopyText($hadithContainer) {
		var hadithStr = '', arabic, translation, grade, ref='', hadithUrl;
		var itemsToCopy = getCbSettings();

		if (itemsToCopy.arabic) {
			var $arabicContainer = $hadithContainer.find('.arabic_hadith_full');
			if ($arabicContainer.length) {
				arabic = cleanText(preserveNewLines($arabicContainer));
			}
		}

		if (itemsToCopy.translation) {
			var $translationContainer = $hadithContainer.find('.englishcontainer');
			if ($translationContainer.length) {
				$translationContainer.children().each(function () {
					$this = $(this);
					if ($this.is(':visible')) { // Copy visible translation
						translation = cleanText($this.text())
											.replace(/(\S)\[/g, '$1 ['); // Adding a space between a character and opening bracket, which can contain Reference. Needed in Riyadus Saliheen for now.
					} 
				});					
			}
		}

		if (itemsToCopy.grade && $hadithContainer.find('.gradetable').length) {
			var $englishGrade, $arabicGrade, englishGrade='';

			$englishGrade = $hadithContainer.find('.english_grade:nth-child(2)');
			if ($englishGrade.length) {
				englishGrade = cleanText($englishGrade.text());
				if (englishGrade)
					grade = englishGrade;
			}

			if (!englishGrade) {
				$arabicGrade = $hadithContainer.find('.arabic_grade:first');
				if ($arabicGrade.length) {
					var arabicGrade = cleanText($arabicGrade.text());
					if (arabicGrade)
						grade = arabicGrade;
				}
			}
		}
		// Concise reference
		var conciseRef = '';
		var $refStandard = $hadithContainer.find('.hadith_reference tr:first-child td:nth-child(1)');
		if ($refStandard.length) {
			if (cleanText($refStandard.text()) == "Reference") {
				var $conciseRef = $hadithContainer.find('.hadith_reference tr:first-child td:nth-child(2)');
				if ($conciseRef.length)	{
					conciseRef = cleanText($conciseRef.text()).slice(2);
					if (conciseRef)
						ref = conciseRef;
				}
			}
		} 

		if (!conciseRef) {
			// Extract from the breadcrumbs
			var $crumbs = $('.crumbs');
			if ($crumbs.length) {
				var aEls = $crumbs.children('a');
				if (aEls.length > 1) {
					ref = aEls[1].innerText.trim();
				}
			}
		}
	
		if (itemsToCopy.ref === "detailed") {
				$chap = $hadithContainer.prevAll('.chapter:first');

			if ($chap.length) {
				var chapEn	= $chap.find('.englishchapter').text(),
					chapNo	= $chap.find('.echapno').text();

				if (chapEn) {
					chapEn = cleanText(chapEn);
					if (chapEn.substring(0, 9) == "Chapter: ")
						chapEn = chapEn.substr(9);
				}

				if (chapNo) {
					chapNo = cleanText(chapNo);
					if (chapNo[0] == '(')
						chapNo = chapNo.substring(1, chapNo.length - 1)
				}

				if (chapNo || chapEn) {
					ref += "\nChapter";
					ref += chapNo ? " " + chapNo : "";
					ref += chapEn ? ": " + chapEn : "";
				}
			}

			// Getting Book number and name for complete reference
			var $bookInfo = $('.book_info');
			if ($bookInfo.length) {
				var bookEn	= $bookInfo.find('.book_page_english_name').text();
				var bookNo	= $bookInfo.find('.book_page_number').text();

				bookEn = bookEn !== "" ? cleanText(bookEn) : "";
				bookNo = bookNo !== "" ? cleanText(bookNo) : "";

				if (bookNo || bookEn) {
					if (chapNo || chapEn)
						ref += ", ";
					else
						ref += "\n";

					ref += "Book";
					ref += bookNo ? " " + bookNo : "";
					ref += bookEn ? ": " + bookEn : "";
				}
			}	
		}
		
		if (itemsToCopy.url) {
			var $shareLink = $hadithContainer.find('.sharelink');
			if ($shareLink.length) {
				var uri = $shareLink.attr('onclick')
										 .match(/["'](.*?)["']/)[1];
				hadithUrl = 'https://' + window.location.hostname + uri;
			}
		}

		if (arabic && translation) {
			// Add an extra line-break between text and translation
			arabic += "\n";
		}

		hadithStr += !arabic	?	"" :  arabic +  '\n';
		hadithStr += !translation?	"" :  translation + '\n';
		hadithStr += !ref		?	"" :  '\n' + ref;
		hadithStr += !grade		?	"" :  '\n' + 'Grade: ' + grade;
		hadithStr += !hadithUrl	?	"" :  '\n' + hadithUrl;

		return hadithStr.trim();
	}


	function cleanText(text) {
		text = text
			.replace(/<br *\/?>/g, '\n\n')
			.replace(/(\S)( *)(\r\n|\r|\n){1}( *)(\S)/g, '$1 $5') // convert single newline to space
			.replace(/( *)(\r\n|\r|\n){2,}( *)/g, '\n') // make >=2 \n to a single \n
			.replace(/( *: *)/g, ': ') // Fix colon spacing
			.replace(/( |\u00a0)+/g, ' ') // Convert multiple spaces or &nbsp; chars into a single space
			.trim();

		return text;
	}


	/**
	 * Converting <br> element to newline character so that we don't lose paragraph information
	 */
	function preserveNewLines($obj) {
		var temp = 	$obj.html()
						.trim()
						.replace(/<br *\/?>/g, '\n\n');
		return $.parseHTML("<div>" + temp + "</div>")[0].innerText;
	}


	/**
	 * Fallback when clipboard not available 
	 * @param {string} text 
	 */
	function copyToClipboardFallback(text) {
		var dummy = document.createElement("textarea");
		document.body.appendChild(dummy);
		dummy.value = text;
		dummy.select();
		dummy.setSelectionRange(0, 99999); /*For mobile devices*/		
		document.execCommand("copy");
		document.body.removeChild(dummy);
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
			$("#search").css('top', '2px');
			if (window.innerWidth > 992)
				$("#sidePanel").css({'position': 'fixed', 'top': '65px'});
			else
				$("#sidePanel").css({'position': 'static'});
		}
		else {
			$("#banner").removeClass('bannerMiddle');
			$("#banner").addClass('bannerTop');
			$("#header").css('position', 'relative');
			$("#topspace").css('display', 'none');
			$("#toolbar").css('display', 'block');
			$("#search").css('top', '46px');
			if (window.innerWidth > 992)
				$("#sidePanel").css({'position': 'fixed', 'top': '122px'});
			else
				$("#sidePanel").css({'position': 'static'});
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
			$("#searchtips").fadeIn('fast');

			// Avoid immediate trigger
			setTimeout( function() {
				$("body").one("click", function(e) {
					$("#searchtips").fadeOut('fast')
				});
			}, 500);
		}
		else $("#searchtips").fadeOut('fast');
	});

    $(".indexsearchtipslink").click(function() {
        if ($("#indexsearchtips").css('display') == 'none') {
            $("#indexsearchtips").fadeIn('fast');

			// Avoid immediate trigger
			setTimeout( function() {
				$("body").one("click", function(e) {
					$("#indexsearchtips").fadeOut('fast');
				});
			}, 500);
        }
        else $("#indexsearchtips").fadeOut('fast');
    });

	$('.scrolling_link').click(function(e) {
		var anchor = $("#" + e.target.dataset.scrollTo);
		var scrollMargin = e.target.dataset.scrollMargin;
		var headerHeight = $('#header').height();
		if (scrollMargin)
			$('html,body').animate({scrollTop: anchor.offset().top - headerHeight - scrollMargin}, 'fast', 'linear', function() {
				var newHeaderHeight = $('#header').height();
				if (headerHeight != newHeaderHeight)
					$('html,body').animate({scrollTop: anchor.offset().top - newHeaderHeight - scrollMargin}, 'fast', 'linear');
			}); 
		else
			$('html,body').animate({scrollTop: anchor.offset().top - headerHeight}, 'fast', 'linear', function() {
				var newHeaderHeight = $('#header').height();
				if (headerHeight != newHeaderHeight)
				$('html,body').animate({scrollTop: anchor.offset().top - newHeaderHeight}, 'fast', 'linear');
			}); 
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

	// Listeners for Copy feature
	$(document).on("click", ".copylink", cbCopy);
	$(document).on("click", ".share_mb .copy_btn", shareLinkCopyBtnClickHandler);
	
	$("#cb_flyout").on("click", function(e) { e.stopPropagation() });
	$("#indexsearchtips").on("click", function(e) { e.stopPropagation() });
	$("#searchtips").on("click", function(e) { e.stopPropagation() });

	$(".copycbcaret").on("click", function(e) {
		var $cbFlyout = jQuery("#cb_flyout");
		if ($cbFlyout.is(':hidden')) {
			var offset	= $(e.currentTarget).offset(),
			settings 	= getCbSettings();

			for (option in settings) {
				$cbFlyout.find("[type=checkbox][name="+option+"]").prop("checked", settings[option])
				$cbFlyout.find("[type=radio][value="+settings[option]+"]").prop("checked", true)
			}

			$("#cb_flyout")
				.css("top", offset.top)
				.css("left", offset.left)
				.fadeIn('fast');
		
			// Avoid immediate trigger
			setTimeout( function() {
				$("body").one("click.flyout", function(e) {
					$("#cb_flyout").fadeOut('fast')
				});
			}, 500);
		}
	});
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