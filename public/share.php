<?php
	function truncateHadithText($hadithText, $url) {
		// URL-encode both the hadithText and the URL
		$encodedHadithText = rawurlencode($hadithText);
		$encodedUrl = rawurlencode($url);

		// Calculate the lengths
		$hadithTextLength = strlen($encodedHadithText);
		$urlLength = strlen($encodedUrl);
		$characterLimit = 4000;

		// Check if truncating is necessary
		$totalLength = $hadithTextLength + $urlLength;

		if ($totalLength > $characterLimit) {
			// If truncating is needed, shorten the hadithText and add "..." until within the limit
			while ($totalLength > $characterLimit) {
				$hadithText = substr($hadithText, 0, strlen($hadithText) - 1);
				$encodedHadithText = rawurlencode($hadithText);
				$hadithTextLength = strlen($encodedHadithText);
				$totalLength = $hadithTextLength + $urlLength;
			}
			$hadithText .= '...';
		}

		return $hadithText;
	}

	$hadithText = $_POST['hadithText'];
	$hadithPreviewText = nl2br(htmlspecialchars($hadithText));
?>

<h1> SHARE THIS HADITH </h1>

<!-- hadith preview -->
<div class="hadith-preview">
	<p>
		<?php echo $hadithPreviewText; ?>
	</p>
</div>

<!-- Share buttons -->
<div class="share_buttons">
	<div class="share_button">
		<a href="https://www.facebook.com/sharer.php?u=https://sunnah.com<?php echo $_POST['link']; ?>"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Facebook"
			class="icn-fb">
		</a>
	</div>

	<div class="share_button">
		<a href="https://twitter.com/intent/tweet?url=https://sunnah.com<?php echo $_POST['link']; ?>&text=<?php echo urlencode($_POST['hadithText']); ?>&hashtags=SunnahCom,hadith"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Twitter"
			class="icn-twitter">
		</a>
	</div>

    <!-- WhatsApp -->
	<div class="share_button">
		<a href="https://api.whatsapp.com/send?url=https://sunnah.com<?php echo $_POST['link']; ?>&text=<?php echo urlencode($_POST['hadithText']); ?>" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on WhatsApp"
			class="icn-whatsapp"
			>
		</a>
	</div>

	<!-- Telegram -->
	<div class="share_button">
		<a href="https://t.me/share/url?url=https://sunnah.com<?php echo $_POST['link']; ?>&text=<?php echo truncateHadithText($_POST['hadithText'], "https://t.me/share/url?url=https://sunnah.com" . $_POST['link']); ?>" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on Telegram"
			class="icn-telegram"
			>
		</a>
	</div>

	<div class=clear></div>
</div>

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
		max-height: 75vh;
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