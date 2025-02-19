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

	function share(button, permalink) {
		const $hadithContainer = $(button).closest('.actualHadithContainer');
		
		if ($hadithContainer.length === 0) {
			console.error("Error: .actualHadithContainer not found.");
			return;
		}
		
		const hadithText = getCopyText($hadithContainer);		
	
		$.post("/share.php", {link: permalink, hadithText: hadithText }, function(data) {
			if (!$(".share_mb").length) $("body").append('<div class="share_mb"></div>');
			$(".share_mb").html(data); 
			
			$(".share_mb").css("left", ($(window).width() - $(".share_mb").width()) / 2 + "px");
			$(".share_mb").css("top", ($(window).height() - $(".share_mb").height()) / 2.8 + "px");
	
			$('#sharefuzz, .share_mb').animate({'opacity': '.25'}, 200, 'linear');
			$('.share_mb').animate({'opacity': '1.00'}, 200, 'linear');
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
		
		if ("permissions" in navigator && "clipboard" in navigator) 
			navigator.permissions.query({name: "clipboard-write"})
				.then(result => {
					if (result.state === "granted" || result.state === "prompt")
						copyToClipboard(copyText);
					else
						copyToClipboardFallback(copyText);
				})
				.catch(() => copyToClipboardFallback(copyText));				
		else			
			copyToClipboardFallback(copyText);

		$copyLink.addClass("success");
		setTimeout(() => {
			$copyLink.removeClass("success");
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
				var crumbs = cleanText($crumbs.text());
				if (crumbs !== "") {
					var crumbsArray = crumbs.split('»');
					if (crumbsArray.length > 1) {
						ref = crumbsArray[1].trim();
					}
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
				var bookNo		= $bookInfo.find('.book_page_number').text();

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
	 * Writes text to clipboard
	 * 
	 * @param {string} text
	 */
	function copyToClipboard(text) {
		navigator.clipboard.writeText(text)
						   .then(
								() => copyToClipboardFallback(text) // In case of failure, use fallback
        					);		
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

	// Listeners for Copy feature
	$(document).on("click", ".copylink", cbCopy);
	
	$("#cb_flyout").on("click", function(e) { e.stopPropagation() });

	$(".copycbcaret").on("click", function(e) {
		var $cbFlyout = jQuery("#cb_flyout");
		if ($cbFlyout.is(':hidden')) {
			var offset 	 = $(e.currentTarget).offset(),
			settings = getCbSettings();

			for (option in settings) {
				$cbFlyout.find("[type=checkbox][name="+option+"]").prop("checked", settings[option])
				$cbFlyout.find("[type=radio][value="+settings[option]+"]").prop("checked", true)
			}

			$("#cb_flyout")
				.css("top", offset.top)
				.css("left", offset.left)
				.show(400);
		
			// Avoid immediate trigger
			setTimeout( function() {
				$("body").one("click.flyout", function(e) {
					$("#cb_flyout").hide(400)
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
    langLoaded['bangla'] = false;

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
