<div class="about">

<div class=section>Donate to Support Sunnah.com</div><br>
<div class=content>
Sunnah.com has been an entirely volunteer-supported effort from its inception in 2011. Through the effort of dozens of volunteers all over the world we have put up over 50,000 ahadith and their translations, manually checked them, numbered them according to the most rigorous systems, and added multiple languages. 
<p>
In order to continue adding more ahadith, languages, and features at a faster pace, we are moving to a hybrid model with volunteers and paid employees. We are excited to partner with the <a href="https://quran.foundation">Qur'an Foundation</a> to help with this and are launching a fundraising campaign to support it. Your donations help us continue our mission of making authentic hadith accessible to everyone around the world. By supporting Sunnah.com, you contribute to:

<ul>
<li><b>Adding data</b>: Adding more hadith books, languages, and hadith-related information such as explanations and narrator biographies.</li>
<li><b>Adding features</b>: Adding learning journeys, bookmarks, and more platform features for a richer user experience.</li>
<li><b>Operations</b>: Keeping our servers running and a design refresh.</li>
<li><b>Commissioning translations</b>: Some of our translations are archaic and we are exploring projects to commission modern translations from qualified scholars.</li>
</ul>

We highly encourage <b>recurring donations</b> if you are able, as that allows us to plan further out. Please contact us separately if you wish to donate a larger amount directly or through a donor-advised fund.
<p>

<div id="classy-donation-widget" style="margin: auto;">
    <!-- Classy donation widget will be loaded here -->
</div>

<p>
Every contribution, no matter how small, helps us continue our work. May Allah reward you for your generosity.
</p>

</div>

</div>

<!-- Classy Donation Widget Embed Code -->
<script>
    (function (win) {
      win.egProps = {
        campaigns: [
          {
            campaignId:   <?php echo Yii::$app->params['classyCampaignId']; ?>,
            customDomain: 'give.quran.foundation',
            donation: {
              inline: {
                urlParams: { },
                elementSelector: '#classy-donation-widget'
              }
            }
          }
        ]
      }
      win.document.body.appendChild(makeEGScript())

      /** Create the embed script */
      function makeEGScript() {
        var egScript = win.document.createElement('script')
        egScript.setAttribute('type', 'text/javascript')
        egScript.setAttribute('async', 'true')
        egScript.setAttribute('src', 'https://sdk.classy.org/embedded-giving.js')
        return egScript
      }

      /* Read URL Params from your website. This could potentially
        * be included in the embed snippet */
      function readURLParams() {
        const searchParams = new URLSearchParams(location.search)
        const validUrlParams = ['c_src', 'c_src2']
        return validUrlParams.reduce(function toURLParamsMap(urlParamsSoFar, validKey) {
          const value = searchParams.get(validKey)
          return value === null ? urlParamsSoFar : { ...urlParamsSoFar, [validKey]: value }
        }, {})
      }
    })(window)
  </script>
