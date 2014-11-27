<header class="kentBlueBackground">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 no-right-padding">
                <a href="dashboard.php"><h4 class="inline-heading smallerMobileHeading whiteText"> Kent Projects </h4></a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 login-position no-left-padding alignRight">
                <a href="profile.php"><span class="fui-user smallerMobileHeading whiteText"></span></a>
                <a href="settings.php"><span class="fui-gear marginLeft10 smallerMobileHeading whiteText"></span></a>
                <span class="fui-exit hoverHand marginLeft10 smallerMobileHeading whiteText" onclick="logoutUser()"></span>
            </div>
        </div>
    </div>
</header>

<script>
    /**
     * Confirm the user wants to log out, if so logs the user out of the system.
     */
    function logoutUser() {
        if (confirm("Are you sure you want to log out?")) {
            //TODO: Implement logout.
            alert("Hah, you thought you were logged in to begin with... Here's the landing page.")
            window.location.href = ("/");
        }
    }
</script>