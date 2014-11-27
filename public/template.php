<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Template </title>
        <link rel="shortcut icon" href="/includes/img/kp.ico">
        <link href="/includes/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="/includes/css/style.css" rel="stylesheet">
        <script src="/includes/js/konami.js">
            var easter_egg = new Konami(function() { alert('Konami code!')});
            easter_egg.load();
        </script>
    </head>
    <body>

        <?php include 'includes/php/header.php'; ?>
        <div class="container">
            <div class="row">
                <h1> Page content </h1>
                <p> This be your page content... </p>
            </div>
        </div>
        <?php include 'includes/php/footer.php'; ?>
    </body>
</html>