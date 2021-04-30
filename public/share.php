<?php
?>

<h2>Share</h2>
<i class="icn-docs copy_btn" title="Copy Hadith link to clipboard"></i>
<div class=share_buttons>
	<div class="share_button">
		<a href="https://www.facebook.com/sharer.php?u=https://sunnah.com<?php echo $_GET['link']; ?>" target="blank" rel="noopener noreferrer" title="Share Hadith on Facebook" class="icn-fb"></a>
	</div>

	<div class="share_button">
		<a href="https://twitter.com/intent/tweet?url=https://sunnah.com<?php echo $_GET['link']; ?>&text=Hadith via @SunnahCom&hashtags=SunnahCom,hadith" target="blank" rel="noopener noreferrer" title="Share Hadith on Twitter" class="icn-twitter"></a>
	</div>	

	<div class=clear></div>
</div>

<input class=permalink_box type="text" value="https://sunnah.com<?php echo $_GET['link']; ?>" size=36 />

