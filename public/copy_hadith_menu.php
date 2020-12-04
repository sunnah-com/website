<div class="copyContainer">
	<div style="display:flex;">
		<fieldset style="margin:0 15px 0 0; min-width:100px;">
			<legend>Hadith Text</legend>
			<ul>
				<li title="The Arabic text of the Hadith."><label>
					<input type="checkbox" class="copyArabic" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Arabic</label>
				</li>
				<li title="The translation that is displaying on page."><label>
					<input type="checkbox" class="copyTranslation" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Translation</label>	
				</li>		
				<li title="The authenticity grade of the Hadith, if available."><label>
					<input type="checkbox" class="copyGrade" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Grade</label>
				</li>
			</ul>
		</fieldset>

		<fieldset style="margin:0; min-width:120px;">
			<legend>Hadith Reference</legend>
			<ul>
				<li title="The reference will only contain the collection name and the overall Hadith number."><label>
					<input type="radio" name="referenceType" class="copyBasicReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Basic</label>
				</li>
				<li title="The reference will contain more information in English and Arabic, such as the book name/number, chapter name/number, Hadith number within book, etc., whatever is available."><label>
					<input type="radio" name="referenceType" class="copyDetailedReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Detailed</label>
				</li>
				<li title="The web link for the Hadith."><label>
					<input type="checkbox" class="copyWebReference" 
						onchange="updateItemsToCopyInLocalStorage(this);">
					</input>Web</label>
				</li>
			</ul>	
		</fieldset>		
	</div>
</div>