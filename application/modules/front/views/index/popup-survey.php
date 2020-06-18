<?php
$ip = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');

// Test 123.455.212.232 for 0
$trigger_popup = (substr( hash("crc32", $ip ), -1) === "0") ? "true" : "false";

?>
<div id="popup_survey" class="popup_wrapper" style="display: none;">
	<div class="popup_content">
		<p>Will you help us by answering a few questions on how you use <b>sunnah.com?</b><br>
		Your thoughtful answers will shape the direction of our efforts.</p>
		<p>
		<a class="button button_sec" id="popup_close">No thanks</a>
		<a class="button button_pri" id="popup_success" href="/survey" target="_blank">I'd love to!</a>
		</p>
	</div>
</div>

<script>
$(".popup_wrapper").on("click", function(e) {
	if(e.target != this) return;

	$.cookie("popup_close", 1, { expires : 7 });
	$("#popup_survey").fadeOut();
});

$("#popup_close, #popup_success").on("click", function(e) {
	var btn = e.target.id;

	if (btn == "popup_success") {
		$.cookie("popup_success", 1, { expires : 7 });
		$(".footer .survey").fadeOut();
	}

	$.cookie("popup_close", 1, { expires : 7 });
	$("#popup_survey").fadeOut();
});

if ( $.cookie("popup_success") === null ) {
	$(".footer a:last").after(" | <a class=\"survey\" onclick=\"$(\'#popup_survey\').fadeIn();\">Take our survey</a>");
}

if ( <?php echo $trigger_popup; ?> && $.cookie("popup_close") === null) {
	$("#popup_survey").fadeIn();
}
</script>
