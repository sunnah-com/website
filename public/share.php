<?php
?>

<div style="font-size: 16px; padding-top: 0px; padding-bottom: 16px; text-align: center;"> SHARE THIS HADITH</div>

<input class=permalink_box type="text" value="https://sunnah.com<?php echo $_POST['link']; ?>" size=36 /><br>

<div class=share_buttons>
	<div class="share_button" style="float: right; padding-top: 13px;">
		<a href="https://www.facebook.com/sharer.php?u=https://sunnah.com<?php echo $_POST['link']; ?>"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Facebook"
			class="icn-fb">
		</a>
	</div>

	<div class="share_button" style="float: right; padding-top: 13px;">
		<a href="https://twitter.com/intent/tweet?url=https://sunnah.com<?php echo $_POST['link']; ?>&hashtags=SunnahCom,hadith"
			target="blank"
			rel="noopener noreferrer"
			title="Share Hadith on Twitter"
			class="icn-twitter">
		</a>
	</div>

    <!-- WhatsApp -->
	<div class="share_button" style="float: right; padding-top: 13px;">
		<a href="https://api.whatsapp.com/send" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on WhatsApp"
			class="icn-whatsapp"
			>
		</a>
	</div>

	<!-- Telegram -->
	<div class="share_button" style="float: right; padding-top: 13px;">
		<a href="https://t.me/share/url?url=https://sunnah.com<?php echo $_POST['link']; ?>" 
			target="_blank"
			rel="noopener noreferrer"
			title="Share Hadith on Telegram"
			class="icn-telegram"
			>
		</a>
	</div>

	<div class=clear></div>
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

</div>

