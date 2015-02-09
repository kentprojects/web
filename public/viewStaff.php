<?php
    // Get header
    require_once __DIR__."/../private/bootstrap.php";
    $title = "Staff List";
    require PUBLIC_DIR . "/includes/php/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8">
            <h1 class="reduceHeading"> View Staff </h1>
        </div>
        <div class="col-xs-4 col-md-4 alignRight">
            <button style="margin-top:40px;"> Edit staff </button>
        </div>
        <script type="text/javascript">
            function generateList() {
                var listItems = [["Fred Barnes", "Concurrent and parallel computing, compilers for concurrent languages;"],["Eerke Boiten", "Logic, formal methods, cryptography"],["John Bovey", "Not specified"],["Janet Carter", "Not specified"],["David Chadwick", "Not specified"],["Dominique Chu", "My main research interest is Bio-inspired computing and Systems Biology. Specifically, I am working on computational systems that evolve cell signaling networks that have pre-specified properties. I am currently also collaborating with various people from the Biosciences department on modelling biological systems"],["Olaf Chitil", "Not specified"],["John Crawford", "Not specified"],["Rogerio de Lemos", "Not specified"],["Bob Eager", "Not specified"],["Sally Fincher", "Not specified"],["Yang He", "Not specified"],["Julio Hernandez-Castro", "Not specified"],["Tim Hopkins", "Not specified"],["Colin Johnson", "Not specified"],["Richard Jones", "Not specified"]];
                var output = "<table class='table table-striped'><thead><tr><th>Name</th><th class='mobileHide'>Interests</th></tr></thead><tbody>";
                listItems.forEach(function(item){
                    output += "<tr><td>" + item[0] + "</td><td class='mobileHide'>" + item[1] + "</td></tr>";
                });
                output += "</tbody></table>"; document.write(output);
            }
            generateList();

            function showHideEdit() {

            }
        </script>
    </div>
</div>
<?php
    require PUBLIC_DIR.'/includes/php/footer.php';
?>