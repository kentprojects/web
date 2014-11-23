<header class="kentBlueBackground">
	<div class="container">
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 no-right-padding">
				<h4 class="inline-heading whiteText"> Kent Projects </h4>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 login-position no-left-padding alignRight">
				<span class="fui-gear iconSize whiteText" onclick="clickSettings()"></span>
				<span class="fui-exit iconSize whiteText" onclick="clickLogOut()"></span>
			</div>
			<div class="" id="settingsMenu">
				<ul id="settingsList">
					<li class="settingsMenuOption">Option 1</li>
					<li class="settingsMenuOption">Option 2</li>
					<li class="settingsMenuOption">Option 3</li>
				</ul>
			</div>
		</div>
	</div>
</header>

<script>
	function clickLogOut() {
		if (confirm("Are you sure you want to log out?")) {
			//TODO: Implement logout.
			alert("You selected log out...")
		}
	}

	function clickSettings() {
		
	}
</script>