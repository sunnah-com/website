<?php
$num_collections = count($collections);
$splitSize = round($num_collections / 2, 0, PHP_ROUND_HALF_UP);
?>

<div align=center id="indextag">
    The Hadith of the Prophet Muhammad (صلى الله عليه و سلم) at your fingertips
</div>

<div class="indexsearchcontainer">
    <div id="indexsearch">
        <form name="searchform" action="/search/" method="get" id="searchform">
            <input type="text" class="indexsearchquery" name="q" placeholder="Search &#8230;" value="" />

            <!-- This hidden field will store the user’s selected collections as a comma-separated list -->
            <input type="hidden" name="selected_collections" id="selected_collections" value="" />

            <input type="submit" class="indexsearchsubmit" value="l" />
        </form>
    </div>

    <button id="openCollectionsModal" type="button">
        Select Collections
    </button>

    <a class="indexsearchtipslink">Search Tips</a>
    <div id="indexsearchtips">
        <b>Quotes</b> e.g. "pledge allegiance"<br>
        Searches for the whole phrase instead of individual words
        <p>
            <b>Wildcards</b> e.g. test*<br>
            Matches any set of one or more characters. For example test* would result in test, tester, testers, etc.
        <p>
            <b>Fuzzy Search</b> e.g. swore~<br>
            Finds terms that are similar in spelling. For example swore~ would result in swore, snore, score, etc.
        <p>
            <b>Term Boosting</b> e.g. pledge^4 hijrah<br>
            Boosts words with higher relevance. Here, the word <i>pledge</i> will have higher weight than <i>hijrah</i>
        <p>
            <b>Boolean Operators</b> e.g. ("pledge allegiance" OR "shelter) AND prayer<br>
            Create complex phrase and word queries by using Boolean logic.
        <p>
            <a href="/searchtips">More ...</a>
    </div>
    <div class="clear"></div>
</div>


<div class=collections>
    <div class="collection_titles" style="padding-right: 6px;">
        <?php
        for ($i = 0; $i < $splitSize; $i++) {
            $collection = $collections[$i];
            ?>
            <div class=collection_title>
                <a href="/<?php echo $collection['name']; ?>" style="display: inline;">
                    <div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
                    <div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
                </a>
                <div class="clear"></div>
            </div>
            <?php if ($i < $splitSize - 1)
                echo '<div class="collection_sep"></div>';
        } ?>
    </div><!-- end collection titles 1 -->
    <div class="collection_titles" style="float: right;">
        <?php
        for ($i = $splitSize; $i < $num_collections; $i++) {
            $collection = $collections[$i];
            ?>
            <div class=collection_title>
                <a href="/<?php echo $collection['name']; ?>" style="display: inline;">
                    <div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
                    <div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
                </a>
                <div class="clear"></div>
            </div>
            <?php if ($i < $num_collections - 1)
                echo '<div class="collection_sep"></div>';
        } ?>
    </div><!-- end collection titles 2 -->
    <div class="clear"></div>
</div> <!-- end collections div -->
<div id="collectionsModal" class="modal">
    <div class="modal-content">
        <span class="closeModal">&times;</span>
        <h2>Select Collections</h2>

        <form id="collectionForm" onsubmit="return false;">
            <?php foreach ($collections as $collection): ?>
                <label style="display:block; margin: 5px 0;">
                    <input type="checkbox" class="collectionCheckbox" value="<?php echo $collection['name']; ?>" />
                    <?php echo $collection['englishTitle']; ?>
                </label>
            <?php endforeach; ?>

            <br />
            <button type="button" id="saveCollections">Save</button>
        </form>
    </div>
</div>
<br>
<div align=center style="color: #75A1A1;">Supported languages: English, Arabic, Urdu, Bangla</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('collectionsModal');
        var openBtn = document.getElementById('openCollectionsModal');
        var closeSpan = document.querySelector('.closeModal');
        var saveBtn = document.getElementById('saveCollections');
        var hiddenInput = document.getElementById('selected_collections');

        // Open the modal
        openBtn.addEventListener('click', function () {
            modal.style.display = 'block';
        });

        // Close when clicking the 'x'
        closeSpan.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close when clicking outside the modal content
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Save button logic
        saveBtn.addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('.collectionCheckbox');
            var selectedValues = [];

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    selectedValues.push(checkbox.value);
                }
            });

            // Put the comma-separated list of selected collection names into the hidden input
            hiddenInput.value = selectedValues.join(',');

            // Close the modal
            modal.style.display = 'none';
        });
    });
</script>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(31, 33, 37, 0.7);
    }

    .modal-content {
        background-color: var(--secondry_block_bg);
        color: var(--primary-text-color);

        margin: 100px auto;
        padding: 20px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;

        width: 400px;
        max-width: 90%;

        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        position: relative;
        text-align: left;
    }

    .closeModal {
        color: var(--primary-text-color);
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        margin-top: -8px;
        margin-right: -8px;
    }

    .closeModal:hover,
    .closeModal:focus {
        color: #fff;
        text-decoration: none;
    }

    .modal-content form label {
        display: block;
        margin: 8px 0;
        cursor: pointer;
        color: var(--primary-text-color);
    }

    .modal-content input[type="checkbox"] {
        vertical-align: middle;
        margin-right: 6px;
    }

    #saveCollections {
        background: var(--secondry_block_bg);
        color: var(--primary-text-color);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        padding: 8px 16px;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        transition: background 0.2s ease, color 0.2s ease;
    }

    #saveCollections:hover {
        background: var(--highlight-color);
        color: #fff;
    }

    #openCollectionsModal {
        background: var(--secondry_block_bg);
        color: var(--primary-text-color);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        padding: 8px 16px;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        transition: background 0.2s ease, color 0.2s ease;
        margin-left: 10px;
    }

    #openCollectionsModal:hover {
        background: var(--highlight-color);
        color: #fff;
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 90%;
            margin: 60px auto;
        }
    }
</style>