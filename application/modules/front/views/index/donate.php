<div class="about">

<div class=section style="text-align: center;">Donate to support <a href="https://sunnah.com">Sunnah.com</a></div><br>
<div class=content>
We are excited to partner with the <a href="https://quran.foundation">Qur'an Foundation</a> to help us fundraise and advance our mission of making authentic hadith knowledge accessible. 
<p>

</div> <!-- Content class -->
</div> <!-- About class -->

<div id="classy-donation-widget">
    <!-- Classy donation widget will be loaded here -->
</div>

<div class="about">
<div class=content>
<div class=section><u>What do your donations support?</u></div>
May Allah SWT reward you for your generosity. Every contribution, no matter how small, helps us continue our work:

<ul>
<li><b>Building a mobile app</b>: A mobile app is our most requested feature; we have not had the resources to embark on this project until now.</li>
<li><b>Adding data</b>: Adding more hadith books, languages, and hadith-related information such as explanations and narrator biographies.</li>
<li><b>Adding features</b>: Adding learning journeys, bookmarks, and more platform features for a richer user experience.</li>
<li><b>Operations</b>: Keeping our servers running and a design refresh.</li>
<li><b>Commissioning translations</b>: Some of our translations are archaic and we are exploring projects to commission modern translations from qualified scholars.</li>
</ul>

<p>
We highly encourage <b>recurring donations</b> if you are able, as that allows us to plan further out. Please contact us separately if you wish to donate a larger amount directly or through a donor-advised fund.
</p>

<div class=section><u>Why are we fundraising?</u></div>
<a href="https://sunnah.com">Sunnah.com</a> has been an entirely volunteer-supported effort from its inception in 2011. Through the effort of dozens of volunteers all over the world we have put up over 50,000 ahadith and their translations, manually checked them, numbered them according to the most rigorous systems, and added multiple languages. We are moving to a hybrid model with volunteers and paid employees in order to continue adding more ahadith, languages, and features at a faster pace.
<p>

<div class=section>Frequently Asked Questions</div><br>
<b><u>1. Is my donation tax-deductible?</u></b><br>
<a href="https://sunnah.com/">Sunnah.com</a> is fiscally sponsored by the <a href="https://quran.foundation">Qur'an Foundation</a>, a registered 501(c)(3) non-profit organization in the USA. Donations are tax-deductible in the USA (EIN: 82-4203288).
<p>
<b><u>2. Why does my donation receipt say "Qur'an Foundation, Inc." when I donated to sunnah.com?</u></b><br>
We are partnering with the <a href="https://quran.foundation">Qur'an Foundation</a> for fiscal sponsorship, which allows us to raise funds.
<p>
<b><u>3. Can I donate through PayPal?</u></b><br>
Yes, you can donate using PayPal. However, PayPal is only supported for donations in USD. To see and select the PayPal button, please ensure that you have chosen USD as the selected currency.


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
