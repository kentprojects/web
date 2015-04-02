<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-->
<!--Placeholders for the intent details..-->
<h3 id="intentTitle"></h3>

<p id="intentDescription"></p>
<!--Buttons to accept or decline the intent.-->
<div class="btn-group intentResponseButtons">
	<button class="btn btn-primary intentAccept" onclick="confirmRequest();" value="Confirm">
		Confirm
	</button>
	<button class="btn btn-info intentDecline" onclick="cancelRequest();" value="Cancel">
		Cancel
	</button>
</div>