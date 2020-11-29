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


	// BEGIN REGION Copy Menu Management
	var openedMenu;

	function openCopyMenu($copyMenu) {
		if ($copyMenu) {
			if (openedMenu) {
				closeCopyMenu(openedMenu);
			}	
			$copyMenu.find('.downCaret').show();		
			$copyMenu.find('.rightCaret').hide();		
			$copyMenu.find('.copyContainer').fadeIn('fast');
			openedMenu = $copyMenu;	
		}
	}

	function closeCopyMenu($copyMenu) {
		if ($copyMenu) {
			$copyMenu.find('.downCaret').hide();		
			$copyMenu.find('.rightCaret').show();		
			$copyMenu.find('.copyContainer').fadeOut('fast');
			openedMenu = null;				
		}
	}


	$(document).on('click', function(event) {
		$clickedElement = $(event.target);
		var elementClass = $clickedElement.attr('class');
		if (elementClass == 'rightCaret') {
			// user is trying to open a copy menu
			openCopyMenu($clickedElement.closest('.menuCaretBtn'));
		} else if (elementClass == 'downCaret') {
			// user is trying to close a copy menu
			closeCopyMenu($clickedElement.closest('.menuCaretBtn'));
		} else {
			if ($clickedElement.closest('.copyContainer').length) {
				// user is clicking within an opened copy menu
				// Don't do anything. Let it remain open.
			} else {
				// user is clicking on the website outside the copy menu
				closeCopyMenu(openedMenu);					
			}
		}
	});
	// END REGION Copy Menu Management


	
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