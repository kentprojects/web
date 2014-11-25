<header class="kentBlueBackground">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 no-right-padding">
                <!-- TODO: Change link to actual dashboard link. -->
                <a href="#dashboard"><h4 class="inline-heading whiteText"> Kent Projects </h4></a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 login-position no-left-padding alignRight">
                <span class="fui-gear iconSize whiteText" onclick="clickSettings()"></span>
                <span class="fui-exit iconSize whiteText" onclick="clickLogOut()"></span>
            </div>
        </div>
        <div class="row">
            <div class="hideOnLoad" id="settingsMenu">
                <ul class="noBullets whiteText" id="settingsList">
                    <!-- TODO: Replace with proper links and options text. -->
                    <li class="settingsMenuOption slightLeftPadding topBlueBorder"><a class="kentBlueText listLink" href="#option1">Option 1</a></li>
                    <li class="settingsMenuOption slightLeftPadding topBlueBorder"><a class="kentBlueText listLink" href="#option2">Option 2</a></li>
                    <li class="settingsMenuOption slightLeftPadding topBlueBorder"><a class="kentBlueText listLink" href="#option3">Option 3</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
    function clickLogOut() {
        if (confirm("Are you sure you want to log out?")) {
            //TODO: Implement logout.
            alert("Nah, we can't do that yet, we'll just redirect you...")
            window.location.href = ("/");
        }
    }

    function clickSettings() {
        if (document.getElementById("settingsMenu").style.display == "none") {
            document.getElementById("settingsMenu").style.display = "block";
        }
        else {
            document.getElementById("settingsMenu").style.display = "none";
        }
    }
</script>