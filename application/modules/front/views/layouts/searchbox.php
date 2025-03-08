<?php
// Optional logic for $stextval
if (strcmp($this->params['_pageType'], "home")) {
    $searchQuery = null;
    if (strcmp($this->params['_pageType'], "search") == 0) {
        $searchQuery = $this->params['_searchQuery'];
    }
    if (isset($searchQuery)) {
        $stextval = $searchQuery;
    } else {
        $stextval = "";
    }
}

// Get collections directly from a new Util instance
use app\modules\front\models\Util;
$util = new Util();
$collections = $util->getCollectionsInfo('none', true);
?>

<div id="search">
    <div class="search-container">
        <div id="searchbar">
            <form name="searchform" action="/search/" method="get" id="searchform">
                <input type="text" class="searchquery" name="q" placeholder="Search …" />
                <input type="submit" class="searchsubmit search-btn" value="l" />
            </form>
        </div>
        <button type="button" id="filterBtn" class="custom-btn">
            <span class="custom-btn-content filter-icn">
                <i class="fa-solid fa-sliders"></i>
            </span>
        </button>
        <button type="button" id="tipsBtn" class="custom-btn searchtipslink">
            <span class="custom-btn-content tips-icn">
                <i class="fa-solid fa-lightbulb"></i>
            </span>
        </button>
    </div>

    <!-- Modal for selecting collections -->
    <div id="filterModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="header">Select Collections</h2>

            <div id="collectionChips">
                <?php
                if (isset($collections) && is_array($collections)) {
                    $totalCollections = count($collections);
                    $showLimit = 6;

                    foreach ($collections as $index => $collection) {
                        if (isset($collection['name']) && isset($collection['englishTitle'])) {
                            $toggleClass = ($index >= $showLimit) ? 'toggleable-chip hidden' : '';
                            echo '<div class="chip ' . $toggleClass . '" data-value="' . $collection['name'] . '">' . $collection['englishTitle'] . '</div>';
                        }
                    }

                    if ($totalCollections > $showLimit) {
                        echo '<div id="showMoreLessBtn" class="show-more-btn">Show More Collections</div>';
                    }
                }
                ?>
            </div>

            <button id="applyFilterBtn" class="apply-btn">Apply</button>
        </div>
    </div>

    <div id="searchtips">
        <div class="clear"></div>
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
        <div class="clear"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtn = document.getElementById("filterBtn");
        const filterModal = document.getElementById("filterModal");
        const closeModal = document.querySelector("#filterModal .close");
        const applyFilterBtn = document.getElementById("applyFilterBtn");
        const chipElements = document.querySelectorAll("#collectionChips .chip");
        const searchForm = document.getElementById("searchform");
        const filterIcon = document.getElementById("filterIcon");

        // Parse URL parameters for collections (PHP style array params)
        const urlParams = new URLSearchParams(window.location.search);
        let selectedCollections = [];
        let index = 0;
        while (urlParams.has(`collection[${index}]`)) {
            selectedCollections.push(urlParams.get(`collection[${index}]`));
            index++;
        }

        // Initialize chip selection based on URL parameters
        chipElements.forEach(chip => {
            if (selectedCollections.includes(chip.dataset.value)) {
                chip.classList.add("selected");
            }
        });

        // Open modal
        filterBtn.addEventListener("click", function () {
            filterModal.style.display = "block";
        });

        // Close modal (x)
        closeModal.addEventListener("click", function () {
            filterModal.style.display = "none";
        });

        // Close modal if clicking outside
        window.addEventListener("click", function (event) {
            if (event.target === filterModal) {
                filterModal.style.display = "none";
            }
        });

        // Toggle chip selection
        chipElements.forEach(chip => {
            chip.addEventListener("click", function () {
                const value = chip.dataset.value;
                chip.classList.toggle("selected");

                if (chip.classList.contains("selected")) {
                    selectedCollections.push(value);
                } else {
                    selectedCollections = selectedCollections.filter(col => col !== value);
                }
            });
        });

        function submit() {
            const queryInput = document.querySelector(".searchquery").value;
            let actionUrl = "/search/?q=" + encodeURIComponent(queryInput);

            selectedCollections.forEach((col, index) => {
                actionUrl += `&collection[${index}]=${encodeURIComponent(col)}`;
            });

            window.location.href = actionUrl;
        }
        // "Apply" button
        applyFilterBtn.addEventListener("click", function (event) {
            filterModal.style.display = "none";
            submit()
            event.preventDefault()
        });

        // Intercept search form to include selected collections
        searchForm.addEventListener("submit", function (event) {
            submit()
            event.preventDefault();
        });

        const showMoreLessBtn = document.getElementById("showMoreLessBtn");
        let isHidden = true;
        if (showMoreLessBtn) {
            showMoreLessBtn.addEventListener("click", function () {
                $(".toggleable-chip").toggleClass("hidden");
                isHidden = !isHidden
                this.textContent = isHidden ?  "Show More Collections" : "Show Less" ;
            });
        }
    });
</script>

<style>
    [data-theme="light"] {
        --secondary-block-bg: #ebebeb;
        --chip-bg: rgba(0, 0, 0, 0.075);
        --chip-hover-bg: #dedede;
        --chip-selected-bg: #3ba08f;
        --border-color: rgba(0, 0, 0, 0.2);
        --button-highlight-color: rgba(251, 250, 248, 0.2);
        --search-icon-color: var(--chip-selected-bg);
    }

    [data-theme="dark"] {
        --secondary-block-bg: #343A40;
        --chip-bg: rgba(44, 48, 52, .7);
        --chip-hover-bg: #3d4648;
        --chip-selected-bg: #3ba08f;
        --border-color: rgba(255, 255, 255, 0.2);
        --button-highlight-color: #1c625d;
        --search-icon-color: #ffffff;
    }

    [data-theme="light"] .header {
        color: #3d9393;
    }

    .clear {
        clear: both;
    }

    /* Search Container Layout */
    .search-container {
        display: flex;
        gap: 10px;
        align-items: stretch;
    }

    /* Left Column Layout */
    .left-column {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }

    /* Searchbar Layout */
    #searchbar {
        flex: 1;
        display: flex;
        align-items: center;
    }

    #searchform {
        display: flex;
        gap: 10px;
        width: 100%;
    }

    .searchquery {
        flex: 1;
        height: 32px;
    }

    .searchsubmit {
        width: 40px;
        flex-shrink: 0;
    }

    .filter-icn::after {
        content: "Filter";
        padding-left: 5px;
    }

    .tips-icn::after {
        content: "Tips";
        padding-left: 5px;
    }

    .search-btn {
        background-color: var(--highlight-color);
        color: var(--search-icon-color);
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .custom-btn {
        padding: 6px 12px;
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0);
        color: white;
        border: none;
        border-radius: 10px;
        font-family: "Akzidenz Roman", Arial, sans-serif;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .custom-btn:hover {
        background-color: var(--button-highlight-color);
        ;
    }

    .custom-btn-content {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .apply-btn {
        padding: 1rem 2rem;
        cursor: pointer;
        background-color: var(--chip-selected-bg);
        color: white;
        border: none;
        border-radius: 10px;
        font-family: "Akzidenz Roman", Arial, sans-serif;
        white-space: nowrap;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .apply-btn:hover {
        background-color: #1c625d;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        display: flex;
        flex-direction: column;
        background-color: var(--secondary-block-bg);
        color: var(--primary-text-color);
        margin: 100px auto;
        padding: 20px;
        border: 1px solid var(--border-color);
        width: 400px;
        position: relative;
        border-radius: 8px;
    }

    .modal-content .header {
        padding: 0;
        margin: 0;
    }

    .modal-content .close {
        position: absolute;
        top: 10px;
        right: 10px;
        color: var(--secondary-text-color);
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-content .close:hover {
        color: var(--primary-text-color);
    }

    #collectionChips {
        margin: 20px 0;
        flex: 1;
    }

    .chip {
        display: inline-block;
        padding: 8px 12px;
        margin: 4px;
        background-color: var(--chip-bg);
        color: var(--primary-text-color);
        border-radius: 16px;
        cursor: pointer;
        user-select: none;
        font-size: 13px;
        transition: background-color 0.2s ease;
    }

    .chip:hover {
        background-color: var(--chip-hover-bg);
        color: var(--primary-text-color);
    }

    .chip.selected {
        background-color: var(--chip-selected-bg);
        color: #fff;
        display: inline-block !important;
    }

    /* Show More/Less Button */
    .show-more-btn {
        display: block;
        padding: 4px 12px;
        margin: 10px auto;
        background-color: transparent;
        color: var(--chip-selected-bg);
        border: 1px solid var(--chip-selected-bg);
        border-radius: 10px;
        cursor: pointer;
        user-select: none;
        font-size: 13px;
        transition: all 0.2s ease;
        text-align: center;
        width: fit-content;
    }

    .show-more-btn:hover {
        background-color: rgba(59, 160, 143, 0.1);
    }

    .toggleable-chip {
        display: inline-block;
    }

    .hidden {
        display: none
    }

    /* Responsive Design */
    @media screen and (max-width: 760px) {
        .modal-content {
            box-sizing: border-box;
            width: 90vw;
            margin: 80px auto;
        }

        .custom-btn {
            padding: 6px 8px;
        }

        .filter-icn::after {
            content: "";
        }

        .tips-icn::after {
            content: "";
        }
    }
</style>