<?php

if (!isset($_GET['eurn'])) {echo "An error occurred"; return;}

$eurn = htmlentities($_GET['eurn']);
$hid = htmlentities($_GET['hid']);

if (!is_numeric($eurn) || !is_numeric(substr($hid, 1))) {echo "An error occurred"; return;}

?>
<div class="clear"></div>
<div id="re<?php echo $hid; ?>" class=reporterrorbox>
	<h1>Report Error</h1>
	<form class="reform" action="" id="reform<?php echo $hid; ?>">
	<div class="report_left_column">
		<fieldset>
			<legend>Type of error <span class="red_asterisk">*</span></legend>	
			<input type=hidden name=urn value=<?php echo $eurn; ?>>
			<input type="hidden" name=ftype value="er" />
			<label><input name="type" type=radio value=mismatch />Mismatched translation</label>
			<label><input name="type" type=radio value=spelling />Spelling mistake</label>
			<label><input name="type" type=radio value=incomplete />Incomplete text</label>
			<label><input name="type" type=radio value=translation />Mistranslation</label>
			<label><input name="type" type=radio value=other />Other (please specify)</label>			
			<input class="othererror" name="othererror" type="text"/>
		</fieldset>
	</div>
	<div class="report_right_column">
		Additional details<br>
		<textarea rows="5" cols="32" name="re_additional" /></textarea><br>
		<label class="cbemail"><input name="emailme" type="checkbox" value=true />Yes, email me when the error is corrected</label>
		<div><input name="email" type="text" placeholder="Email address"/></div>
		<div id="rerec<?php echo $hid; ?>"> </div>
	</div>
	
	<div class="clear"></div>
	<div style="text-align:center;"><input type="submit" class="resubmit" value="Submit"></div>
	<div class="reresp" id="reresp<?php echo $hid; ?>"></div>
	</form>
	<div class="clear"></div>
</div>


