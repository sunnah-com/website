<?php $books = $this->_viewVars->books; $totalHadith = 0; ?>

<div class=about>
The table below shows meta-information related to the books and hadith in <?php echo $this->_collection->englishTitle ?>.
The status of each book appears in the last column. A status of "Verified" means that the hadith boundaries, reference numbers and chapters in that book have been verified to the best of our ability. A blank status means we will verify it soon inshaAllah.
</div>

<div>&nbsp;</div>

<div align=center>
<table style="border:1px solid; font-size: 13px; width: 80%;" cellpadding=4 border=1>
<tr>
	<td>Book Number</td>
	<td>Book Name</td>
	<td>Number of hadith</td>
	<td>First hadith number</td>
	<td>Last hadith number</td>
	<td>Status</td>
</tr>
<?php foreach ($books as $book) {?>
<tr>
	<td><?php echo $book->ourBookID; ?></td>
	<td><?php echo $book->englishBookName; ?></td>
	<td><?php if ($book->totalNumber > 0) echo $book->totalNumber; $totalHadith = $totalHadith + $book->totalNumber;?></td>
	<td><?php if ($book->firstNumber > 0) echo $book->firstNumber; ?></td>
	<td><?php if ($book->lastNumber > 0) echo $book->lastNumber; ?></td>
	<td><?php if ($book->status == "4") echo "Verified"; ?></td>
</tr>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td>Total</td>
	<td><?php echo $totalHadith; ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</table>
</div>
