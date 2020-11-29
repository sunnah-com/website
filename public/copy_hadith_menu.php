<div class="copyContainer">
	<div style="display:flex;">
		<fieldset style="margin:0 15px 0 0; min-width:100px;">
			<legend>Hadith Text</legend>
			<ul>
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

		<fieldset style="margin:0; min-width:120px;">
			<legend>Hadith Reference</legend>
			<ul>
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
</div>