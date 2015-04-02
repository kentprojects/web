<!--
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */-->
<!--Show details and buttons for the intent.-->
<h3 id="intentTitle"></h3>

<p id="intentDescription"></p>
<!--Buttons to accept or declide the intent.-->
<div class="btn-group intentResponseButtons">
	<button class="btn btn-primary intentAccept" onclick="intentAccept();" value="accept">
		Accept
	</button>
	<button class="btn btn-info intentDecline" onclick="intentDecline();" value="decline">
		Decline
	</button>
</div>
