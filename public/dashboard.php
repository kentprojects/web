<?php
    // Get authentication
    $prerequisites = array("authentication");
    require_once __DIR__."/../private/bootstrap.php";

    $user = Auth::getUser();
    $year = !empty($_GET["year"]) ? $_GET["year"] : date("Y");

    $yearData = API::Request(API::GET, "/year/$year");

    if ($yearData->status !== 200)
    {
        echo "Year not created.";
        exit(1);
    }

    // Get header
    $title = "Dashboard";
    require PUBLIC_DIR . "/includes/php/header.php";
?>

<!-- Layout -->

<div class="container">
    <div class="row Header">
        <div class="col-xs-12">
            <h1> Dashboard - <?php echo $year;?></h1>
            <p>Welcome to your dashboard. Here you can look at graphs and stuff.</p>
        </div>
    </div>
    <div class="row Meters">
        <h3>This year at a glance:</h3>
        <div class="col-sm-6 col-md-3 gauge">
            <div class="tile"><div id="power-levels"></div></div>
        </div>
        <div class="col-sm-6 col-md-3 gauge">
            <div class="tile"><div id="julio-awesome"></div></div>
        </div>
        <div class="col-sm-6 col-md-3 gauge">
            <div class="tile"><div id="project-complete"></div></div>
        </div>
        <div class="col-sm-6 col-md-3 gauge">
            <div class="tile"><div id="half-of-100"></div></div>
        </div>
    </div>
    <div class="Projects">
        <div class="row">
            <div class="col-sm-6 rowTitle"><h3>Projects</h3></div>
            <div class="col-sm-6 sideScrollerSearchBox"><input type="text" value="" placeholder="Search Projects" class="form-control"></div>
        </div>
        <div class="row">
        <div class="col-sm-12">

            <div class="sideScroller" id="project-scroller">
                <ul class="list-inline noBottomMargin" >
                    <!-- Projects appear here -->
                </ul>
            </div>
            </div>
        </div>
    </div>
    <div class="Students">
        <div class="row">
        <div class="col-sm-6 rowTitle"><h3>Students</h3></div>
            <div class="col-sm-6 sideScrollerSearchBox"><input type="text" value="" placeholder="Search Students" class="form-control"></div>
           </div>
        <div class="row">
        <div class="col-sm-12">
            <div class="sideScroller" id="student-scroller">
                <ul class="list-inline noBottomMargin">
                    <!-- Students appear here -->
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="row Supervisors">
        <h3>Supervisors</h3>
        <div class="col-sm-12">
        </div>
    </div>
</div>

<!-- *** App code goes here *** -->

<!-- For Raphael -->
<script src="/includes/js/raphael.js"></script>
<!-- For JustGage -->
<script src="/includes/js/justgage.js"></script>

<!-- Set the gauges -->
<script>
    function setGauges() {
        var powerLevel = 9001;
        var projectCompleteness = 10;
        var julioAwesomeness = 101;
        var fifty = 50;
        var powerLevelsGauge = new JustGage({
            id: "power-levels",
            value: powerLevel,
            min: 0,
            max: 10000,
            title: "Power Levels:",
            label: "Power",
            relativeGaugeSize: true
        });
        var projectCompleteGauge = new JustGage({
            id: "project-complete",
            value: projectCompleteness,
            min: 0,
            max: 100,
            title: "Project completeness:",
            label: "%",
            relativeGaugeSize: true
        });
        var julioAwesomenessGauge = new JustGage({
            id: "julio-awesome",
            value: julioAwesomeness,
            min: 0,
            max: 100,
            title: "How awesome Julio is:",
            label: "Awesome",
            relativeGaugeSize: true
        })
        var halfOfOneHundred = new JustGage({
            id: "half-of-100",
            value: fifty,
            min: 0,
            max: 100,
            title: "100 divided by 2 is:",
            relativeGaugeSize: true
        })
    }
    setGauges();
</script>

<script src="/includes/js/ajax.js" type="text/javascript"></script>
<script src="/includes/js/includes.php" type="text/javascript"></script>
<script>
    function scrollerHTML(data) {
        if (data.body.length > 0) {
            var item, HTML = [];
            for (var i = 0; i < data.body.length; i++) {
                item = data.body[i];
                HTML.push(
                        '<li class="sideScrollerItem noBottomMargin">',
                        '<div class="tile scrollerTile noBottomMargin">',
                        '<div class="tile-title">' + item.name + '</div>',
                        '</div>',
                        '</li>'
                );
            }
            return HTML.join("");
        }
        else {
            return '<div class="scrollerPlaceholder noBottomMargin"><div class="tile-title"> There\'s nothing here yet! </div></div>';
        }
    };

    // List the projects
    API.GET(
        "/projects", { "year": <?php echo $year;?> },
        function (data) {
            document.querySelector(".Projects ul").innerHTML = scrollerHTML(data);
            document.querySelector(".Projects h3").innerText = 'Projects ('+data.body.length+')';
        },
        function (data)	{console.error(data);}
    );

    // List the students
    API.GET(
            "/students", { "year": <?php echo $year;?> },
    function (data) {
        document.querySelector(".Students ul").innerHTML = scrollerHTML(data);
        document.querySelector(".Students h3").innerText = 'Students ('+data.body.length+')';
    },
    function (data)	{console.error(data);}
    );
</script>


<?php require PUBLIC_DIR.'/includes/php/footer.php'; ?>