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
		<a href="https://api.whatsapp.com/send?url=https://sunnah.com<?php echo $_POST['link']; ?>" 
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
					const hadithText = <?php echo json_encode($_POST['hadithText']); ?>;
					const href = $(this).attr('href');

					console.log('doing the stuff for a share button');
					console.log('HREF: '+href);

					const url = new URL(href);
					url.searchParams.set('text', hadithText);
					console.log(url);
					$(this).attr('href', url.toString());
				});
			});
		});
	</script>

</div>

