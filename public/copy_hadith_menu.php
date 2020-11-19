<div id="copyContainer">
	<div style="display:flex;">
		<fieldset style="margin:0 15px 15px 0; border:1px dashed #aaa; border-radius:3px; min-width:100px;">
			<legend>Hadith Text</legend>
			<ul style="list-style-type: none; padding: 0px;">
				<li title="The Arabic text of the Hadith.">
					<input type="checkbox" id="copyArabic" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyArabic">Arabic</label>
				</li>
				<li title="The translation that is displaying on page.">
					<input type="checkbox" id="copyTranslation" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyTranslation">Translation</label>	
				</li>		
				<li title="The authenticity grade of the Hadith, if available.">
					<input type="checkbox" id="copyGrade" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyGrade">Grade</label>
				</li>
			</ul>
		</fieldset>

		<fieldset style="margin:0 0 15px 0px; border:1px dashed #aaa; border-radius:3px; min-width:130px;">
			<legend>Hadith Reference</legend>
			<ul style="list-style-type: none; padding:0px;">
				<li title="The reference will only contain the collection name and the overall Hadith number.">
					<input type="radio" name="referenceType" id="copyBasicReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyBasicReference">Basic</label>
				</li>
				<li title="The reference will contain more information in English and Arabic, such as the book name/number, chapter name/number, Hadith number within book, etc., whatever is available.">
					<input type="radio" name="referenceType" id="copyDetailedReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyDetailedReference">Detailed</label>
				</li>
				<li title="The web link for the Hadith.">
					<input type="checkbox" id="copyWebReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>
					<label for="copyWebReference">Web</label>
				</li>
			</ul>	
		</fieldset>		
	</div>
	<div style="width:100%; text-align:center; display:flex;">
		<div style="flex:1;"></div>
		<button id="btnCopy" 
			style="min-width:100%; font-size:15px; padding:7px; flex:1; line-height:15px; display:flex;" 
			onclick="copyToClipboard(this);">
				<span style="flex:1; text-align:left;"></span>
				<span id="copyBtnText" style="flex:1;"><i class="icn-docs"></i> Copy</span>
				<span id="copySuccessIndicator" style="flex:1; text-align:right;"></span>
		</button>
		<div style="flex:1;"></div>
	</div>
</div>