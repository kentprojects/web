<header class="kentBlueBackground">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 no-right-padding">
                <!-- TODO: Change link to actual dashboard link. -->
                <a href="#dashboard"><h4 class="inline-heading smallerMobileHeading whiteText"> Kent Projects </h4></a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 login-position no-left-padding alignRight">
                <span class="fui-user iconSize whiteText" onclick="viewProfile()"></span>
                <span class="fui-gear iconSize whiteText" onclick="viewSettings()"></span>
                <span class="fui-exit iconSize whiteText" onclick="logoutUser()"></span>
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
            alert("Nah, we can't do that yet, we'll just redirect you...")
            window.location.href = ("/");
        }
    }

    /**
     * Opens the users profile page.
     */
    function viewProfile() {
        alert("Profile.");
    }

    /**
     * Opens the users settings page.
     */
    function viewSettings() {
        alert("Settings");
    }
</script>