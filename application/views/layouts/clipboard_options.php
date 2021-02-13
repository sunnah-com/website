<div  id="cb_flyout" onchange="saveCbSettings()" style="display: none">
	<fieldset>
		<legend>Hadith Text</legend>
			<label title="The Arabic text of the Hadith.">
				<input type="checkbox" name="arabic" value="arabic">Arabic</label>
			<label title="The translation that is displaying on page.">
				<input type="checkbox" name="translation" value="translation">Translation</label>		
			<label title="The authenticity grade of the Hadith, if available.">
				<input type="checkbox" name="grade" value="grade">Grade</label>
	</fieldset>

	<fieldset>
		<legend>Reference</legend>
			<label title="The reference will only contain the collection name and the overall Hadith number.">
				<input type="radio" name="ref" value="concise">Concise</label>
			<label title="The reference will contain more information in English and Arabic, such as the book name/number, chapter name/number, Hadith number within book, etc., whatever is available.">
				<input type="radio" name="ref" value="detailed">Detailed</label>
			<label title="The web link for the Hadith.">
				<input type="checkbox" name="url" value="url">URL</label>
	</fieldset>
</div>