<?php
    // Get header
    require_once __DIR__."/../../private/bootstrap.php";
    $title = "Staff List";
    require PUBLIC_DIR . "/includes/php/header.php";
?>
<div class="container">
    <div class="row">
        <h1> Staff List </h1>
        <script type="text/javascript">
            function generateList() {
                var listItems = [["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"],["Name", "Interests"]];
                var output = "<table class='table table-striped'><thead><tr><th>Name</th><th class='mobileHide'>Interests</th></tr></thead><tbody>";
                listItems.forEach(function(item){
                    output += "<tr><td>" + item[0] + "</td><td class='mobileHide'>" + item[1] + "</td></tr>";
                });
                output += "</tbody></table>";
                document.write(output);
            }
            generateList();
        </script>
    </div>
</div>
<?php require PUBLIC_DIR.'/includes/php/footer.php'; ?>