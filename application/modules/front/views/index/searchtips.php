<h1 class="abouttitle">Search tips and tricks</h1>
<div class="about">

In order to unleash the true power of our search engine, we&#39;ve provided you
the following tips and tricks to help you narrow down exactly what you are
looking for.<br>

<p>This list has been compiled from the official <a href="http://lucene.apache.org/core/old_versioned_docs/versions/2_9_1/queryparsersyntax.html" target="_blank">Lucene query parser syntax</a> page.

<br><br>

<h2 class="section_header">1. Terms</h2><hr>

A query is broken up into terms and operators. There are two types of terms:
Single Terms and Phrases. A Single Term is a single word such as <code>&quot;pledge&quot;</code> 
or <code>&quot;allegiance&quot;</code>. A Phrase is a group of words surrounded by double quotes such as 
<code>&quot;pledge allegiance&quot;</code>. Multiple terms can be combined together with Boolean operators to form a
more complex query (see below).

<br><br>

<h2 class="section_header">2. Wildcard searches</h2><hr>

Lucene supports single and multiple character wildcard searches within
single terms (not within phrase queries). To perform a single character wildcard search use the
<code>?</code> symbol. To perform a multiple character wildcard search use the
<code>*</code> symbol.

<br><br>
The single character wildcard search looks for terms that match that with
the single character replaced. For example, to search for &quot;near&quot; or &quot;neat&quot; you
can use the search: 

<pre class="textboxlook">nea?</pre><br>

Multiple character wildcard searches looks for 0 or more characters. For
example, to search for test, tests or testers, you can use the search:

<pre class="textboxlook">test*</pre><br>

You can also use the wildcard searches in the middle of a term, such as
<pre class="textboxlook">"te*t"</pre>
<br>
Note: You cannot use a <code>*</code> or <code>?</code> symbol as the first character of a search.

<br><br>

<h2 class="section_header">3. Fuzzy searching</h2><hr>
Lucene supports fuzzy searches based on the Levenshtein Distance, or Edit
Distance algorithm. To do a fuzzy search use the tilde <code>~</code> symbol at the end of a Single word
Term. For example to search for a term similar in spelling to &quot;swore&quot; use the
fuzzy search: 

<pre class="textboxlook">swore~</pre>

This search will find terms like swore, snore, score, etc.
<br><br>

Furthermore, an optional parameter can specify the required similarity. The
value is between 0 and 1, with a value closer to 1 only terms with a higher
similarity will be matched. For example:

<pre class="textboxlook">swore~0.7</pre> 

will yield only results that are close to the original query, such as swore, score, etc.

<br><br>

swore~0.3

will yield results that are slightly similar to the original query, such as
swore, stone, swords, etc.

<br><br>

The default that is used if the parameter is not given is 0.5.

<br><br>

<h2 class="section_header">4. Proximity Searches</h2><hr>

Lucene supports finding words are a within a specific distance away.
To do a proximity search use the tilde, &quot;~&quot;, symbol at the end of a Phrase.
For example to search for a &quot;pledge&quot; and &quot;migration&quot; within 10 words of each
other in a document use the search: 

<pre class="textboxlook">&quot;pledge migration&quot;~10</pre>

This will yield results in which the words pledge and migration are
separated by no more then 10 words. Very helpful if you only know the context
of what you are searching for.

<br><br>

<h2 class="section_header">5. Boosting a term</h2><hr>

<p>Lucene provides the relevance level of matching documents
based on the terms found.
To boost a term use the caret (&quot;^&quot;) symbol with a boost factor (a number) at
the end of the term you are searching. The higher the boost factor, the more
relevant the term will be.
Boosting allows you to control the relevance of a document by boosting its
term. For example, if you are searching for
<br><pre class="textboxlook">pledge hijrah</pre>
and you want the term &quot;pledge&quot; to be more relevant, boost it using the <code>^</code>
symbol along with the boost factor next to the term. You would type:
<br>

<pre class="textboxlook">pledge^4 hijrah</pre>

This will make results with the term pledge appear more relevant. 

<br><br>

You can also boost Phrase Terms as in the example:
<br>
<pre class="textboxlook">&quot;pledge of allegiance&quot;^5 requested</pre><br>

By default, the boost factor is 1. Although the boost factor must be
positive, it can be less than 1 (e.g. 0.2).

<br><br>

<h2 class="section_header">6. Boolean operators </h2><hr>

<p>Boolean operators allow terms to be combined through logic operators. Lucene
supports <code>AND</code>, <code>+</code>, <code>OR</code>, <code>NOT</code> and <code>-</code> as Boolean operators (Note: Boolean operators
must be ALL CAPS).</p>

<h3>The "OR" Operator</h3>
<p>The OR operator is the default conjunction operator. This means that if
there is no Boolean operator between two terms, the OR operator is used. The OR
operator links two terms and finds a matching document if either of the terms
exist in a document. This is equivalent to a union using sets. The symbol <code>||</code>
can be used in place of the word OR.

<p>To search for documents that contain either &quot;pledge allegiance&quot; or just
&quot;pledge&quot; use the query:

<pre class="textboxlook">&quot;pledge allegiance&quot; pledge</pre>

or
<pre class="textboxlook">&quot;pledge allegiance&quot; OR pledge</pre>
<br>

<h3>The "AND" Operator</h3>
<p>The AND operator matches documents where both terms exist anywhere in the
text of a single document. This is equivalent to an intersection using sets.
The symbol <code>&amp;&amp;</code> can be used in place of the word AND.

<p>To search for documents that contain &quot;pledge of Allegiance&quot; and &quot;second
time&quot; use the query:

<pre class="textboxlook">&quot;pledge of Allegiance&quot; AND &quot;second time&quot;</pre>

<br>

<h3>The "+" Operator</h3>
<p>The <code>+</code> or required operator requires that the term after the <code>+</code> symbol
exist somewhere in a the field of a single document.
<p>To search for documents that must contain &quot;pledge&quot; and may contain &quot;allegiance&quot; use the query:

<pre class="textboxlook">+pledge allegiance</pre><br>

<h3>The "NOT" Operator</h3>
<p>The NOT operator excludes documents that contain the term after NOT. This is
equivalent to a difference using sets. The symbol <code>!</code> can be used in place of the
word NOT.

<p>To search for documents that contain &quot;pledge allegiance&quot; but not &quot;second
time&quot; use the query:

<pre class="textboxlook">&quot;pledge of Allegiance&quot; NOT &quot;second time&quot;</pre><br>

<p>Note: The NOT operator cannot be used with just one term. For example, the
following search will return no results:

<pre class="textboxlook">NOT &quot;pledge allegiance&quot;</pre>
<br>

<h3>The "-" Operator</h3>

<p>The <code>-</code> or prohibit operator excludes documents that contain the term after
the <code>-</code> symbol.</p>

<p>To search for documents that contain &quot;pledge allegiance&quot; but not &quot;allegiance
to the Messenger&quot; use the query:
<pre class="textboxlook">&quot;pledge allegiance&quot;-&quot;allegiance to the Messenger&quot;</pre>

<br>

<h2 class="section_header">7. Grouping</h2><hr>

<p>Lucene supports using parentheses to group clauses to form sub queries. This
can be very useful if you want to control the boolean logic for a query.
<p>To search for either &quot;pledge&quot; or &quot;allegiance&quot; and &quot;prayer&quot; use the query:
<pre class="textboxlook">(pledge OR allegiance) AND prayer</pre>

This eliminates any confusion and makes sure you that prayer must exist and
either term pledge or allegiance may exist.

</div>
