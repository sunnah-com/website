<?php

if (!isset($_GET['eurn'])) {echo "An error occurred"; return;}

$eurn = htmlentities($_GET['eurn']);
$hid = htmlentities($_GET['hid']);

if (!is_numeric($eurn) || !is_numeric(substr($hid, 1))) {echo "An error occurred"; return;}

?>
<div class="clear"></div>
<div id="re<?php echo $hid; ?>" class=reporterrorbox>
	<div class="hadith_narrated" style="font-size: 15px;">Report Error</div>
	<form class="reform" action="" id="reform<?php echo $hid; ?>">
	<div class="leftre" style="padding-right: 20px;">

		Type of error: 
		<span style="color: red;"> *</span><br>

			<input type=hidden name=urn value=<?php echo $eurn; ?>>
			<input type="hidden" name=ftype value="er" />
			<input name="type" type=radio value=mismatch /> Mismatched translation<br>
			<input name="type" type=radio value=spelling /> Spelling mistake<br>
			<input name="type" type=radio value=incomplete /> Incomplete text<br>
			<input name="type" type=radio value=translation /> Mistranslation<br>
			<input name="type" type=radio value=other /> Other (please specify)<br>
			<div style="padding-left: 23px;">
				<input name="othererror" type="text" style="width: 150px;" />
			</div>
	</div>
	<div class="leftre" style="padding-right: 20px;">
		Additional details:<br>
		<textarea rows="5" cols="32" name="re_additional" /></textarea><br>
		<input name="emailme" type="checkbox" value=true /> Yes, email me when the error is corrected<br />
		<div style="padding-left: 23px;"><input name="email" type="text" placeholder="Email address" style="padding-left: 5px; width: 200px;"/></div>
	</div>
	
	<div class="leftre" style="padding-right: 0px;">
		<div id="rerec<?php echo $hid; ?>"> </div>
	</div>
	
	<div class="clear" style="padding-top: 0px;"></div>
	<div class="reresp" id="reresp<?php echo $hid; ?>"></div>
	<div align="center"><input type="submit" class="resubmit" value="SUBMIT"></div>
	</form>
	<div class="clear"></div>
</div>


