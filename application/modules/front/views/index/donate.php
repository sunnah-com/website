<div class="about">

<div class=section>Donate to Support Sunnah.com</div><br>
<div class=content>
Your generous donations help us continue our mission of making authentic hadith accessible to everyone around the world. By supporting Sunnah.com, you contribute to:

<ul>
<li><b>Expanding our collections</b>: Adding more hadith collections and translations</li>
<li><b>Improving our platform</b>: Enhancing search capabilities and user experience</li>
<li><b>Ensuring sustainability</b>: Maintaining servers and infrastructure</li>
</ul>

<div id="classy-donation-widget">
    <!-- Classy donation widget will be loaded here -->
</div>

<p>
Every contribution, no matter how small, helps us continue our work. May Allah reward you for your generosity.
</p>

<p>
<i>"The likeness of those who spend their wealth in the way of Allah is as the likeness of a grain that grows seven ears, in every ear a hundred grains. Allah gives manifold increase to whom He wills. And Allah is All-Sufficient, All-Knowing." (Quran 2:261)</i>
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
