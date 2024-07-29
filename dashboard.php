<?php
session_start();
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
    header("location: login.php");
    exit;
}

?>

<?php
include 'connect.php';

$grp = isset($_GET['val']) ? $_GET['val'] : '';

$time = time();
$timeFilter = "";

switch ($grp) {
    case 'day':
        $timeFilter = "AND createdAT >= $time - (60*60*24)";
        break;
    case 'week':
        $timeFilter = "AND createdAT >= $time - (60*60*24*7)";
        break;
    case 'month':
        $timeFilter = "AND createdAT >= $time - (60*60*24*30)";
        break;
    default:
        $timeFilter = "";
}

// if ($grp == '1month') {
//     $end_date = $time - (60 * 60 * 24 * 30);
// } else if ($grp == 'lastweek') {
//     $end_date = $time - (60 * 60 * 24 * 7);
// } else if ($grp == 'today') {
//     $end_date = $time - (60 * 60 * 24);
// }




//pie chart
$male = "SELECT * from employees where gender= 'Male' AND isdeleted=0 AND createdAT BETWEEN $time-(60*60*24*30) AND $time $timeFilter";
$result5 = mysqli_query($con, $male);
$m = mysqli_num_rows($result5);

$female = "SELECT * from employees where gender= 'Female' AND isdeleted=0 AND createdAT BETWEEN $time-(60*60*24*30) AND $time $timeFilter";
$result6 = mysqli_query($con, $female);
$f = mysqli_num_rows($result6);

// bar graph
$week1 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*7) AND $time $timeFilter";
$result1 = mysqli_query($con, $week1);
$w1 = mysqli_num_rows($result1);

$day1 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*7) AND $time-(60*60*24*6) $timeFilter";
$res1 = mysqli_query($con, $day1);
$d1 = mysqli_num_rows($res1);

$day2 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*6) AND $time-(60*60*24*5) $timeFilter";
$res2 = mysqli_query($con, $day2);
$d2 = mysqli_num_rows($res2);

$day3 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*5) AND $time-(60*60*24*4) $timeFilter";
$res3 = mysqli_query($con, $day3);
$d3 = mysqli_num_rows($res3);

$day4 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*4) AND $time-(60*60*24*3) $timeFilter";
$res4 = mysqli_query($con, $day4);
$d4 = mysqli_num_rows($res4);

$day5 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*3) AND $time-(60*60*24*2) $timeFilter";
$res5 = mysqli_query($con, $day5);
$d5 = mysqli_num_rows($res5);

$day6 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*2) AND $time-(60*60*24*1) $timeFilter";
$res6 = mysqli_query($con, $day6);
$d6 = mysqli_num_rows($res6);

$day7 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*1) AND $time  $timeFilter";
$res7 = mysqli_query($con, $day7);
$d7 = mysqli_num_rows($res7);

$day_time= strtotime('today midnight');
$time1 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time AND $day_time+(60*60*4) $timeFilter";
$rslt1 = mysqli_query($con, $time1);
$t1 = mysqli_num_rows($rslt1);

$time2 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time+(60*60*4) AND $day_time+(60*60*8) $timeFilter";
$rslt2 = mysqli_query($con, $time2);
$t2 = mysqli_num_rows($rslt2);

$time3 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time+(60*60*8) AND $day_time+(60*60*12) $timeFilter";
$rslt3 = mysqli_query($con, $time3);
$t3 = mysqli_num_rows($rslt3);

$time4 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time+(60*60*12) AND $day_time+(60*60*16) $timeFilter";
$rslt4 = mysqli_query($con, $time4);
$t4 = mysqli_num_rows($rslt4);

$time5 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time+(60*60*16) AND $day_time+(60*60*20) $timeFilter";
$rslt5 = mysqli_query($con, $time5);
$t5 = mysqli_num_rows($rslt5);

$time6 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $day_time+(60*60*20) AND $day_time+(60*60*24) $timeFilter";
$rslt6 = mysqli_query($con, $time6);
$t6 = mysqli_num_rows($rslt6);


$week2 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*14) AND $time-(60*60*24*7) $timeFilter";
$result2 = mysqli_query($con, $week2);
$w2 = mysqli_num_rows($result2);

$week3 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*21) AND $time-(60*60*24*14) $timeFilter";
$result3 = mysqli_query($con, $week3);
$w3 = mysqli_num_rows($result3);


$week4 = "SELECT * FROM employees WHERE isdeleted = 0 AND createdAT BETWEEN $time-(60*60*24*28) AND $time-(60*60*24*21) $timeFilter";
$result4 = mysqli_query($con, $week4);
$w4 = mysqli_num_rows($result4);


// //pie chart
// $male = "SELECT * from employees where gender= 'Male' ";
// $result5 = mysqli_query($con, $male);
// $m = mysqli_num_rows($result5);

// $female = "SELECT * from employees where gender= 'Female'";
// $result6 = mysqli_query($con, $female);
// $f = mysqli_num_rows($result6);


// //for bar graph

// $week1 = "SELECT * FROM `employees` WHERE isdeleted = 0 AND createdAT between $time-(60*60*24*7) AND $time ";
// $result1 = mysqli_query($con, $week1);
// $w1 = mysqli_num_rows($result1);

// $week2 = "SELECT * FROM `employees` WHERE isdeleted = 0 AND createdAt between $time-(60*60*24*7)-(60*60*24*7) AND $time-(60*60*24*7)";
// $result2 = mysqli_query($con, $week2);
// $w2 = mysqli_num_rows($result2);

// $week3 = "SELECT * FROM `employees` WHERE isdeleted = 0 AND createdAt between $time-(60*60*24*7)-(60*60*24*7)-(60*60*24*7) AND $time-(60*60*24*7)-(60*60*24*7)";
// $result3 = mysqli_query($con, $week3);
// $w3 = mysqli_num_rows($result3);

// $week4 = "SELECT * FROM `employees` WHERE isdeleted = 0 AND createdAt between $time-(60*60*24*7)-(60*60*24*7)-(60*60*24*7)-(60*60*24*7) AND $time-(60*60*24*7)-(60*60*24*7)-(60*60*24*7)";
// $result4 = mysqli_query($con, $week4);
// $w4 = mysqli_num_rows($result4);
?>


<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- Bootstrap -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- <script src="https://code.highcharts.com/modules/data.js"></script> -->
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body>
    <?php include "header.php"; ?>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="content">
        <div class="wrapper">
            <div class="left_sidebr">
                <ul>
                    <li><a href="dashboard.php" class="dashboard">Dashboard</a></li>
                    <li><a href="list-users.php" class="user">Users</a>
                        <ul class="submenu">
                            <li><a href="">Manage Users</a></li>

                        </ul>

                    </li>
                    <li><a href="" class="Setting">Setting</a>
                        <ul class="submenu">
                            <li><a href="">Chnage Password</a></li>
                            <li><a href="">Mange Contact Request</a></li>
                            <li><a href="#">Manage Login Page</a></li>

                        </ul>

                    </li>
                    <li><a href="" class="social">Configuration</a>
                        <ul class="submenu">
                            <li><a href="">Payment Settings</a></li>
                            <li><a href="">Manage Email Content</a></li>
                            <li><a href="#">Manage Limits</a></li>
                        </ul>

                    </li>
                </ul>
            </div>
            <div class="right_side_content">
                <h1>Dashboard</h1>
                <!-- <div class="tab">
					<ul>
						<li class="selected"><a href=""><span class="left"><img class="selected-act" src="images/dashboard-hover.png"><img src="images/dashboard.png" class="hidden" /></span><span class="right">Dashboard</span></a></li>
						<li><a href="list-users.php"><span class="left"><img class="selected-act" src="images/user-hover.png"><img class="hidden" src="images/user.png" /></span><span class="right">Users</span></a></li>
						<li><a href=""><span class="left"><img class="selected-act" src="images/setting-hover.png"><img class="hidden" src="images/setting.png" /></span><span class="right">Setting</span></a></li>
						<li><a href=""><span class="left"><img class="selected-act" src="images/configuration-hover.png"><img class="hidden" src="images/configuration.png" /></span><span class="right">Configuration</span></a></li>

					</ul>
				</div> --><span id="selectSpan"><b>Filter:</b></span>
                <select id="selectFilter" onchange="filterData()">
                    <!-- <option value="all" >All</option> -->
                    <option value="month"  <?php echo ($grp == 'month') ? 'selected' : ''; ?>>1 Month</option>
                    <option value="week"  <?php echo ($grp == 'week') ? 'selected' : ''; ?>>Last Week</option>
                    <option value="day"  <?php echo ($grp == 'day') ? 'selected' : ''; ?>>1 Day</option>
                </select>

                <div class="charts">
                    <div class="_pie-chart">
                        <figure class="highcharts-figure">

                            <div id="container"></div>

                            <p class="highcharts-description">

                            </p>
                        </figure>

                    </div>
                    <div class="bar_graph">
                        <figure class="highcharts-figure">

                            <div id="container1"></div>
                            <p class="highcharts-description">

                            </p>

                        </figure>
                    </div>
                </div>
                <!-- <div class="for-line-chart" style="display:flex;justify-content:center;; "> -->
                <div class="line_chart" style="display:flex;justify-content:center;">

                    <figure class="highcharts-figure">

                        <div id="container2"></div>
                        <p class="highcharts-description">

                        </p>
                    </figure>
                </div>

            </div>

        </div>

    </div>

    </div>



    <div class="footer">
        <div class="wrapper">
            <p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
        </div>

    </div>
    <script>
        function pieData() {
            return [{
                    name: "Male",
                    sliced: true,
                    selected: true,
                    y: <?php echo $m ?>

                },
                {
                    name: "Female",
                    sliced: true,
                    selected: true,
                    y: <?php echo $f ?>
                },

            ];
        }

        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Gender Composition'
            },
            tooltip: {
                valueSuffix: ''
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7,
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: pieData(),
                showInLegend: true,
                //     {
                //         name: 'Week1',
                //         y: 40,
                //     },
                //     {
                //         name: 'Week2',
                //         sliced: true,
                //         selected: true,
                //         y: 20,
                //     },
                //     {
                //         name: 'Week3',
                //         y: 16,
                //     },
                //     {
                //         name: 'Week4',
                //         y: 4,
                //     }
                // ]
            }]
        });


        function getData() {

            return [{
                    name: "Week 1",
                    y: <?php echo $w4 ?>
                },
                {
                    name: "Week 2",
                    y: <?php echo $w3 ?>
                },
                {
                    name: "Week 3",
                    y: <?php echo $w2 ?>
                },
                {
                    name: "Week 4",
                    y: <?php echo $w1 ?>
                },



            ];
        }

        function getData_Week() {

return [{
       
    
        name: " Day 1",
        y: <?php echo $d1 ?>
    },
    {   
       name: " Day 2",
       y: <?php echo $d2 ?>
   },
   { 
       name: " Day 3",
       y: <?php echo $d3 ?>
   },
   {    
       name: " Day 4",
       y: <?php echo $d4 ?>
   },
   {
       name: " Day 5",
       y: <?php echo $d5 ?>
   },
   {
       name: " Day 6",
       y: <?php echo $d6 ?>
   },
   {
       name: " Day 7",
       y: <?php echo $d7 ?>
   },




];
}


function getData_Day() {

return [{
       name: "12:00 - 4:00 a.m.",
       y: <?php echo $t1 ?>
   },
   {
       name: "4:00 - 8:00 a.m.",
       y: <?php echo $t2 ?>
   },
   {
       name: "8:00 - 12:00 p.m.",
       y: <?php echo $t3 ?>
   },
   {
       name: "12:00 - 4:00 p.m.",
       y: <?php echo $t4 ?>
   },
   {
       name: "4:00 - 8:00 p.m.",
       y: <?php echo $t5 ?>
   },
   {
       name: "8:00 - 12:00 a.m.",
       y: <?php echo $t6 ?>
   },

];
}


        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'List of Users by Week'
            },
            subtitle: {
                align: 'left',

            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Users'
                }

            },
            legend: {
                enabled: true
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                    '<b>{point.y:.2f}%</b> of total<br/>'
            },



            series: [{

                <?php if($grp=='month'){?>
                    name: 'Weeks'<?php } 

             else if($grp=='week'){?>
                    name: 'Days'<?php } 

            else if($grp=='day'){?>
                    name: 'Hours' <?php } 
                
            else{?>
                    name: 'Weeks'<?php } ?>,
            
               
                colorByPoint: true,
                <?php if($grp=='month'){?>
              data:getData() <?php } 

              else if($grp=='week'){?>
                data:getData_Week() <?php } 

            else if($grp=='day'){?>
                data:getData_Day() <?php } 

            else {?>
                data:getData() <?php } ?>,
            }],

        });


        // line chart

        // function lineChartData() {
        //     const data = [{
        //             Weeks: 1,
        //             y: <?php echo $w4 ?>
        //         },
        //         {
        //             Weeks: 2,
        //             y: <?php echo $w3 ?>
        //         },
        //         {
        //             Weeks: 3,
        //             y: <?php echo $w2 ?>
        //         },
        //         {
        //             Weeks: 4,
        //             y: <?php echo $w1 ?>
        //         },
        //     ]
        //     return data;
        // }

        Highcharts.chart('container2', {
            title: {
                text: 'Growth of Users per Week'
            },

            accessibility: {
                point: {
                    valueDescriptionFormat: '{xDescription}{separator}{value} Users'
                }
            },

            xAxis: {
                title: {
                    text: ''
                },
                categories: ['1', '2', '3', '4','5','6','7']
            },

            yAxis: {
                type: 'logarithmic',
                title: {
                    text: 'Number of Users '
                }
            },

            tooltip: {
                headerFormat: '<b>{series.name}</b><br />',
                pointFormat: '{point.y} Users'
            },

            series: [{
                name: 'Weeks',
                //keys: ['y', 'color'],
                <?php if($grp=='month'){?>
              data:getData() <?php } 

              else if($grp=='week'){?>
                data:getData_Week() <?php } 

            else if($grp=='day'){?>
                data:getData_Day() <?php } 

            else {?>
                data:getData() <?php } ?>,

                // [
                //     [16, '#0000ff'],
                //     [361, '#8d0073'],
                //     [1018, '#ba0046'],
                //     [2025, '#d60028'],
                //     [3192, '#eb0014'],
                //     [4673, '#fb0004'],
                //     [5200, '#ff0000']
                // ],
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 1,
                        y2: 0
                    },
                    stops: [
                        [0, '#0000ff'],
                        [1, '#ff0000']
                    ]
                }
            }]
        });
    </script>
    <script>
        function filterData() {
            const selectFilter = document.getElementById('selectFilter').value;
            window.location.href = "http://localhost/Employee_management/dashboard.php?val=" + selectFilter;
        }
    </script>
</body>

</html>