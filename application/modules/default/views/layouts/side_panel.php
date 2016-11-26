
<div id="languagePanel">

Language:

<div style="padding-top: 10px;">
	<input type="radio" name="sidelang" value="english" id="ch_english" onclick="toggleLanguageDisplay('english');" checked="checked"  />
    <label for="ch_english">English</label>
</div>             
<!--
<div>
	<input type="checkbox" name="arabic" id="ch_arabic" onclick="" checked="checked" disabled />
    <label for="ch_arabic">Arabic العربية</label>
</div>            
--> 
<?php if (in_array("urdu", $langarray)) { ?>
<div>
	<input type="radio" name="sidelang" value="urdu" id="ch_urdu" onclick="toggleLanguageDisplay('urdu')"  />
    <label for="ch_urdu">Urdu &nbsp;<span style="font-family: Jameel Noori Nastaleeq; font-size: 16px;">اردو</span></label>
</div>             
<?php } ?>
<?php if (in_array("indonesian", $langarray)) { ?>
<div>
	<input type="radio" name="sidelang" value="indonesian" id="ch_indonesian" onclick="toggleLanguageDisplay('indonesian')"  />
    <label for="ch_indonesian">Bahasa Indonesia</label>
</div>             
<?php } ?>
</div>
