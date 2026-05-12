<?php
/**
 * "Go to Hadith Number" widget.
 *
 * Renders a small form that lets the user jump directly to a hadith by its
 * number within the current collection. The URL pattern matches the
 * `<collectionName>:<hadithNumber>` route defined in application/config/main.php.
 *
 * @var string $collectionName  The collection slug (e.g. "bukhari", "muslim").
 */

$inputId = 'goToHadithInput_' . uniqid();
$formId  = 'goToHadithForm_' . uniqid();
$collectionNameJs = json_encode($collectionName, JSON_UNESCAPED_SLASHES);
?>
<div class="go_to_hadith">
    <form id="<?= $formId ?>" class="go_to_hadith_form" role="search" aria-label="Go to hadith number">
        <label class="go_to_hadith_label" for="<?= $inputId ?>">Go to hadith #</label>
        <input
            type="number"
            inputmode="numeric"
            pattern="[0-9]*"
            min="1"
            step="1"
            id="<?= $inputId ?>"
            class="go_to_hadith_input"
            placeholder="e.g. 1"
            aria-label="Hadith number" />
        <button type="submit" class="go_to_hadith_button">Go</button>
    </form>
</div>

<script>
(function () {
    var form = document.getElementById(<?= json_encode($formId) ?>);
    if (!form) return;
    var input = document.getElementById(<?= json_encode($inputId) ?>);
    var collectionName = <?= $collectionNameJs ?>;

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        var raw = (input.value || '').trim();
        if (!raw) {
            input.focus();
            return;
        }
        // Strip leading zeros but allow plain "0" through to the server, which
        // already 301-redirects /<col>:0N -> /<col>:N (CollectionController).
        var num = raw.replace(/^0+(?=\d)/, '');
        if (!/^\d+$/.test(num)) {
            input.focus();
            return;
        }
        window.location.href = '/' + encodeURIComponent(collectionName) + ':' + num;
    });
})();
</script>

<style>
.go_to_hadith {
    margin: 10px 0;
    text-align: center;
}

.go_to_hadith_form {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: center;
}

.go_to_hadith_label {
    font-size: 14px;
    color: var(--secondary-text-color, inherit);
}

.go_to_hadith_input {
    width: 90px;
    height: 30px;
    padding: 4px 8px;
    box-sizing: border-box;
    border: 1px solid var(--border-color, rgba(0, 0, 0, 0.2));
    border-radius: 4px;
    background-color: var(--input-bg, #fff);
    color: var(--primary-text-color, inherit);
    font-size: 14px;
}

.go_to_hadith_input::-webkit-outer-spin-button,
.go_to_hadith_input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.go_to_hadith_input[type="number"] {
    -moz-appearance: textfield;
}

.go_to_hadith_button {
    height: 30px;
    padding: 0 14px;
    box-sizing: border-box;
    border: none;
    border-radius: 4px;
    background-color: var(--chip-selected-bg, #3ba08f);
    color: #fff;
    font-size: 14px;
    cursor: pointer;
}

.go_to_hadith_button:hover {
    background-color: #1c625d;
}
</style>
