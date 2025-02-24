<?php
function removeURLs($text) {
    return preg_replace('/https?\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $text);
}

function separateArabicAndEnglish($text) {
    $paragraphs = explode("\n", $text);
    $result = [];
    $lastWasArabic = false;

    foreach ($paragraphs as $paragraph) {
        if (preg_match('/[\x{0600}-\x{06FF}]/u', $paragraph)) {
            if (!$lastWasArabic && !empty($result)) {
                $result[] = "\n";
            }
            $result[] = $paragraph;
            $lastWasArabic = true;
        } else {
            if ($lastWasArabic) {
                $result[] = "\n";
            }
            $result[] = $paragraph;
            $lastWasArabic = false;
        }
    }

    $resultText = implode("\n", $result);
    $resultText = preg_replace("/\n+/", "\n\n", $resultText);  // Clean up multiple newlines
    
    return $resultText;
}

$hadithText = $_POST['hadithText'];
$hadithText = removeURLs($hadithText);
$hadithText = separateArabicAndEnglish($hadithText);

?>


<h1> SHARE THIS HADITH</h1>
<!-- hadith preview -->
<div class="hadith-preview">
	<p>
		<?php echo nl2br(htmlspecialchars($hadithText)); ?>
	</p>
</div>

<!-- link display -->
<input class=permalink_box type="text" value="https://sunnah.com<?php echo $_POST['link']; ?>" size=36 />

<!-- Share buttons -->
<div class=share_buttons>
	<div class="share_button">
		<a href="https://www.facebook.com/sharer.php?u=https://sunnah.com<?php echo $_POST['link']; ?>"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Facebook"
			class="icn-fb">
		</a>
	</div>

	<div class="share_button">
		<a href="https://twitter.com/intent/tweet?url=https://sunnah.com<?php echo $_POST['link']; ?>&hashtags=SunnahCom,hadith"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Twitter"
			class="icn-twitter">
		</a>
	</div>

    <!-- WhatsApp -->
	<div class="share_button">
		<a href="https://api.whatsapp.com/send" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on WhatsApp"
			class="icn-whatsapp"
			>
		</a>
	</div>

	<!-- Telegram -->
	<div class="share_button">
		<a href="https://t.me/share/url?url=https://sunnah.com<?php echo $_POST['link']; ?>" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on Telegram"
			class="icn-telegram"
			>
		</a>
	</div>

	<div class=clear></div>
	<!-- share button script -->
	<script defer>
		$(document).ready(function(){
			const iconClasses = [ 'twitter', 'whatsapp', 'telegram', 'fb' ];

			$('.share_button').each(function(){
				const a = $(this).find('a').first();
				a.each(function(){
					const href = $(this).attr('href');
					const url = new URL(href);
					const textParam = a.hasClass('icn-fb')? 'quote' : 'text';

					let hadithText = <?php echo json_encode($_POST['hadithText']); ?>;

					// if telegram button, handle 4000 character URL limit
					if(a.hasClass('icn-telegram')){
						let hadithTextLength = encodeURIComponent(hadithText).length;
						const urlLength = url.toString().length;
						const characterLimit = 4000;

						const needsTruncating = hadithTextLength + urlLength > characterLimit;
						// if truncating is needed, continue shortening hadithText + '...' until it is within the limit
						if(needsTruncating){
							while(hadithTextLength + urlLength > characterLimit){
								hadithText = hadithText.substring(0, hadithText.length-1);
								hadithTextLength = encodeURIComponent(hadithText+'...').length;
							}
							hadithText += '...';
						}
					}
					url.searchParams.set(textParam, hadithText);

					$(this).attr('href', url.toString());
				});
			});
		});
	</script>

	<!-- styling -->
	 <style>
		.share_mb {
			display: none;
			flex-direction: column;
			height: fit-content;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			max-width: 90vmin;
			max-height: 75vh;
			overflow: auto;
			gap: 0.25rem;
			opacity: 0;
			transition: opacity 0.25s ease;
			padding: 1rem;
		}

		.share_mb.open {
			opacity: 1;
		}

		.share_mb h1 {
			text-align: center;
			margin: 0;
			padding: 0;
			font-size: 1.5rem;
		}

		#sharefuzz {
			opacity: 0;
			display: none;
			transition: opacity 0.25s ease;
		}

		#sharefuzz.open {
			opacity: 0.3; 
		}


		.hadith-preview {
			box-sizing: border-box;
			max-height: 30vh;
			overflow: auto;
			background: rgba(125, 125, 125, 0.1);
			border-radius: inherit;
			padding:  0 0.5rem;
		}

		.share_mb .share_buttons {
			display: flex;
			padding-top: 0.5rem;
		}

		.share_mb .share_button {
			padding-top: 0;
		}
	 </style>
</div>

