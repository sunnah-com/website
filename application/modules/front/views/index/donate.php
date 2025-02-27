<div class="about">

<div class=section>Donate to Support Sunnah.com</div><br>
<div class=content>
Your generous donations help us continue our mission of making authentic hadith accessible to everyone around the world. By supporting Sunnah.com, you contribute to:

<ul>
<li><b>Expanding our collections</b>: Adding more hadith collections and translations</li>
<li><b>Improving our platform</b>: Enhancing search capabilities and user experience</li>
<li><b>Ensuring sustainability</b>: Maintaining servers and infrastructure</li>
</ul>

<div id="classy-donation-widget" style="margin: 30px 0;">
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
// Load Classy donation widget
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://cdn.classy.org/classy-embed.js";
    js.onload = function() {
        Classy.EmbeddedForm({
            campaignId: '123456', // Replace with actual Classy campaign ID
            target: '#classy-donation-widget',
            theme: 'light',
            width: '100%',
            showTitle: false,
            donateText: 'Support Sunnah.com',
            onLoad: function() {
                console.log('Classy donation form loaded');
            },
            onSuccess: function(donation) {
                console.log('Donation successful', donation);
            }
        });
    };
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'classy-widget-script'));
</script>
