<?php
?>
<script type="text/javascript">
$(document).ready(function () {
//	$("#dialog").dialog({
//		autoOpen: true, modal: false, width: 400, //height: 300,
//		buttons: [{text: "Закрыть", click: function () { $(this).dialog("close"); }}],
//		show: {effect: "clip", duration: 500},
//		hide: {effect: "clip", duration: 500}
//	});
//	$(".ui-dialog").resizable();
	$("#div_window").resizable();
	$("#div_window").draggable();
	$("#div_window1").resizable();
});
</script>
<!--<span class="glyphicon glyphicon-search"></span>-->

<div id="div_window1" class="ui-dialog0 ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable floatL w400 h300 border1" style="position: relative;">
</div>
<!--<div id="div_window" class="container ui-corner-all p0 w400 h300 border1">
	<div class="ui-dialog ui-widget ui-widget-content ui-front ui-dialog-buttons ui-draggable ui-resizable w100p border0" 
		 style="position: relative;vertical-align: top;">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle bc2">
		<span id="ui-id-1" class="ui-dialog-title">Test&nbsp;</span>
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть">
			<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
		</button>
	</div>
</div>
</div>-->

<div id="div_window" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable w400 h300"
	 style="position: relative;vertical-align: top;">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle bc2">
		<span id="ui-id-1" class="ui-dialog-title">&nbsp;</span>
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть">
			<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
		</button>
	</div>
</div>
<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;"></div>

<div id="dialog" title="Авторизация в системе компании <?php echo $_SESSION['company']; ?>">
	<p id='text'></p>
</div>
