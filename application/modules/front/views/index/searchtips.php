
<div class="about">

<a name="SearchTips"><div class=section>Search tips and tricks</div></a>
<div class=content>


<p>In order to unleash the true power of our search engine, we&#39;ve provided you
the following tips and tricks to help you narrow down exactly what you are
looking for.</p>

<p>This list has been compiled from the official <a href="http://lucene.apache.org/core/old_versioned_docs/versions/2_9_1/queryparsersyntax.html" target="_blank">Lucene query parser syntax</a> page.

<p><strong>1. Terms</strong></p>

<p>A query is broken up into terms and operators. There are two types of terms:
Single Terms and Phrases. A Single Term is a single word such as &quot;pledge&quot; 
or &quot;allegiance&quot;. A Phrase is a group of words surrounded by double quotes such as &quot;pledge
allegiance&quot;. Multiple terms can be combined together with Boolean operators to form a
more complex query (see below).

<p><strong>2. Wildcard searches</strong></p>

Lucene supports single and multiple character wildcard searches within
single terms (not within phrase queries).To perform a single character wildcard search use the &quot;?&quot;
symbol. To perform a multiple character wildcard search use the &quot;*&quot; symbol.
<br>
The single character wildcard search looks for terms that match that with
the single character replaced. For example, to search for &quot;near&quot; or &quot;neat&quot; you
can use the search "nea?" (without quotes).
<br>
Multiple character wildcard searches looks for 0 or more characters. For
example, to search for test, tests or testers, you can use the search "test*" (without quotes)

You can also use the wildcard searches in the middle of a term, such as in "te*t".
<br>
Note: You cannot use a * or ? symbol as the first character of a search.


<p><strong>3. Fuzzy searching</strong></p>
Lucene supports fuzzy searches based on the Levenshtein Distance, or Edit
Distance algorithm. To do a fuzzy search use the tilde, &quot;~&quot;, symbol at the end of a Single word
Term. For example to search for a term similar in spelling to &quot;swore&quot; use the
fuzzy search: "swore~". This search will find terms like swore, snore, score, etc.
<br>
Furthermore, an optional parameter can specify the required similarity. The
value is between 0 and 1, with a value closer to 1 only terms with a higher
similarity will be matched. For example:"swore~0.7" will 
yield only results that are close to the original query, such as swore, score, etc.

<br>
A search query "swore~0.3" will yield results that are slightly similar to the original query, such as
swore, stone, swords, etc.
<br>
The default that is used if the parameter is not given is 0.5.

<br>

<p><strong>4. Proximity Searches</strong></p>

Lucene supports finding words are a within a specific distance away.
To do a proximity search use the tilde, &quot;~&quot;, symbol at the end of a Phrase.
For example to search for a &quot;pledge&quot; and &quot;migration&quot; within 10 words of each
other in a document use the search: &quot;pledge migration&quot;~10. 
This will yield results in which the words pledge and migration are
separated by no more then 10 words. Very helpful if you only know the context
of what you are searching for.

<br>

<p><strong>5. Boosting a term</strong></p>

<p>Lucene provides the relevance level of matching documents
based on the terms found.
To boost a term use the caret (&quot;^&quot;) symbol with a boost factor (a number) at
the end of the term you are searching. The higher the boost factor, the more
relevant the term will be.
Boosting allows you to control the relevance of a document by boosting its
term. For example, if you are searching for
<br><pre>    pledge hijrah</pre>
and you want the term &quot;pledge&quot; to be more relevant, boost it using the ^
symbol along with the boost factor next to the term. You would type:
<br>
<pre>    pledge^4 hijrah</pre>
This will make results with the term pledge appear more relevant. You can
also boost Phrase Terms as in the example:
<br>
<pre>    &quot;pledge of allegiance&quot;^5 requested</pre>
By default, the boost factor is 1. Although the boost factor must be
positive, it can be less than 1 (e.g. 0.2)

<br>

<p><strong>6. Boolean operators </strong></p>

<p>Boolean operators allow terms to be combined through logic operators. Lucene
supports AND, &quot;+&quot;, OR, NOT and &quot;-&quot; as Boolean operators (Note: Boolean operators
must be ALL CAPS).</p>
<br>
<strong>The "OR" Operator</strong>
<p>The OR operator is the default conjunction operator. This means that if
there is no Boolean operator between two terms, the OR operator is used. The OR
operator links two terms and finds a matching document if either of the terms
exist in a document. This is equivalent to a union using sets. The symbol ||
can be used in place of the word OR.

<p>To search for documents that contain either &quot;pledge allegiance&quot; or just
&quot;pledge&quot; use the query:

<pre>    &quot;pledge allegiance&quot; pledge</pre>

or
<pre>    &quot;pledge allegiance&quot; OR pledge</pre>
<br>
<p><strong>The "AND" Operator</strong></p>
<p>The AND operator matches documents where both terms exist anywhere in the
text of a single document. This is equivalent to an intersection using sets.
The symbol &amp;&amp; can be used in place of the word AND.

<p>To search for documents that contain &quot;pledge of Allegiance&quot; and &quot;second
time&quot; use the query:

<pre>    &quot;pledge of Allegiance&quot; AND &quot;second time&quot;</pre>

<br>
<p><strong>The "+" Operator</strong></p>
<p>The &quot;+&quot; or required operator requires that the term after the &quot;+&quot; symbol
exist somewhere in a the field of a single document.
<p>To search for documents that must contain &quot;pledge&quot; and may contain &quot;allegiance&quot; use the query:
<pre>    +pledge allegiance</pre>
<br>
<p><strong>The "NOT" Operator</strong></p>
<p>The NOT operator excludes documents that contain the term after NOT. This is
equivalent to a difference using sets. The symbol ! can be used in place of the
word NOT.

<p>To search for documents that contain &quot;pledge allegiance&quot; but not &quot;second
time&quot; use the query:

<pre>    &quot;pledge of Allegiance&quot; NOT &quot;second time&quot;</pre>

<p>Note: The NOT operator cannot be used with just one term. For example, the
following search will return no results:

<pre>    NOT &quot;pledge allegiance&quot;</pre>
<br>
<p><strong>The "-" Operator</strong></p>

<p>The &quot;-&quot; or prohibit operator excludes documents that contain the term after
the &quot;-&quot; symbol.</p>
<br>
<p>To search for documents that contain &quot;pledge allegiance&quot; but not &quot;allegiance
to the Messenger&quot; use the query:
<pre>    &quot;pledge allegiance&quot;-&quot;allegiance to the Messenger&quot;</pre>

<p><strong>7. Grouping</strong></p>

<p>Lucene supports using parentheses to group clauses to form sub queries. This
can be very useful if you want to control the boolean logic for a query.
<p>To search for either &quot;pledge&quot; or &quot;allegiance&quot; and &quot;prayer&quot; use the query:
<pre>    (pledge OR allegiance) AND prayer</pre>

This eliminates any confusion and makes sure you that prayer must exist and
either term pledge or allegiance may exist.

<br>
</div>
<br>

</div>
