<div style="display:flex;">
	<ul style="list-style-type: none; padding: 0px; margin:0 15px 15px 0;">
		<li style="font-size:13pt; color:#666;">Hadith Text</li>
		<li><input type="checkbox" id="copyArabic" onchange="updateItemsToCopyInLocalStorage(this);"> Arabic</input></li>
		<li><input type="checkbox" id="copyTranslation" onchange="updateItemsToCopyInLocalStorage(this);"> Translation</input></li>		
	</ul>
	<ul style="list-style-type: none; padding: 0px; margin:0 3px 15px 15px;">
		<li style="font-size:13pt; color:#666;">Hadith Reference</li>
		<li><input type="radio" name="referenceType" id="copyBasicReference" onchange="updateItemsToCopyInLocalStorage(this);"> Basic</input></li>
		<li><input type="radio" name="referenceType" id="copyDetailedReference" onchange="updateItemsToCopyInLocalStorage(this);"> Detailed</input></li>
		<li><input type="checkbox" id="copyWebReference" onchange="updateItemsToCopyInLocalStorage(this);"> Web</input></li>
	</ul>	
</div>
<div style="width:100%; text-align:center">
	<button style="font-size:14px; padding:5px 25px;">Copy</button>
</div>