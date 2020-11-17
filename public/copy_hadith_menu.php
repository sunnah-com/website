<div id="copyContainer">
	<div style="display:flex;">
		<ul style="list-style-type: none; padding: 0px; margin:0 15px 15px 0;">
			<li style="font-size:13pt; color:#666; margin-bottom: 5px;">Hadith Text</li>
			<li><input type="checkbox" id="copyArabic" onchange="updateItemsToCopyInLocalStorage(this);"> Arabic</input></li>
			<li><input type="checkbox" id="copyTranslation" onchange="updateItemsToCopyInLocalStorage(this);"> Translation</input></li>		
		</ul>
		<ul style="list-style-type: none; padding-left: 15px; margin:0 3px 15px 0px; border-left: 1px dashed #aaa;">
			<li style="font-size:13pt; color:#666; margin-bottom: 5px;">Hadith Reference</li>
			<li><input type="radio" name="referenceType" id="copyBasicReference" onchange="updateItemsToCopyInLocalStorage(this);"> Basic</input></li>
			<li><input type="radio" name="referenceType" id="copyDetailedReference" onchange="updateItemsToCopyInLocalStorage(this);"> Detailed</input></li>
			<li><input type="checkbox" id="copyWebReference" onchange="updateItemsToCopyInLocalStorage(this);"> Web</input></li>
		</ul>	
	</div>
	<div style="width:100%; text-align:center; display:flex;">
		<div style="flex:1;"></div>
		<button id="btnCopy" style="min-width:100%; font-size:15px; padding:7px; flex:1; line-height:15px; display:flex;" onclick="copyToClipboard(this);">
			<span style="flex:1; text-align:left;"></span>
			<span id="copyBtnText" style="flex:1;"><i class="icn-docs"></i> Copy</span>
			<span id="copySuccessIndicator" style="flex:1; text-align:right;"></span>
		</button>
		<div style="flex:1;"></div>
	</div>
</div>