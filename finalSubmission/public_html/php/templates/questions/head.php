<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!---------------------- stylesheets ---------------------->
    <!-- From CanvasJS-->
    <!--<link href="/public_html/assets/bootstrap.min.css" rel="stylesheet">-->
    <link href="../../../assets/style.css" rel="stylesheet">
    <link href="../../../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- From Bootstrap -->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <!--<link href="/public_html/assets/css/bootstrap.rtl.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-grid.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-grid.rtl.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-reboot.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-reboot.rtl.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-utilities.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-utilities.rtl.css" rel="stylesheet">-->
    <!---------------------- End stylesheets ---------------------->

    <!---------------------- scripts ---------------------->
    <!--[if lt IE 9 ]>
    <script src="../../../assets/js/html5shiv.min.js"></script>
    <script src="../../../assets/js/respond.min.js"></script>
    <![endif]-->
    <!--script src="/assets/js/	"></script-->
    <script src="../../../assets/js/jquery-1.12.4.min.js"></script>
    <script src="../../../assets/js/bootstrap.min.js"></script>

    <script>
        $(function () {
            // #sidebar-toggle-button
            $('#sidebar-toggle-button').on('click', function () {
                $('#sidebar').toggleClass('sidebar-toggle');
                $('#page-content-wrapper').toggleClass('page-content-toggle');
                fireResize();
            });

            // sidebar collapse behavior
            $('#sidebar').on('show.bs.collapse', function () {
                $('#sidebar').find('.collapse.in').collapse('hide');
            });

            // To make current link active
            var pageURL = $(location).attr('href');
            var URLSplits = pageURL.split('/');

            //console.log(pageURL + "; " + URLSplits.length);
            //$(".sub-menu .collapse .in").removeClass("in");

            if (URLSplits.length === 5) {
                var routeURL = '/' + URLSplits[URLSplits.length - 2] + '/' + URLSplits[URLSplits.length - 1];
                var activeNestedList = $('.sub-menu > li > a[href="' + routeURL + '"]').parent();

                if (activeNestedList.length !== 0 && !activeNestedList.hasClass('active')) {
                    $('.sub-menu > li').removeClass('active');
                    activeNestedList.addClass('active');
                    activeNestedList.parent().addClass("in");
                }
            }

            function fireResize() {
                if (document.createEvent) { // W3C
                    var ev = document.createEvent('Event');
                    ev.initEvent('resize', true, true);
                    window.dispatchEvent(ev);
                }
                else { // IE
                    element = document.documentElement;
                    var event = document.createEventObject();
                    element.fireEvent("onresize", event);
                }
            }
        })
    </script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!---------------------- End Scripts ---------------------->

    <!---------------------- Basic page styling ---------------------->
    <style>
        body {
            padding: 25px;
            background-color: white;
            color: black;
            font-size: 15px;
        }
        /*.dark-mode {
        background-color: #262a2b;
        color: white;
      }
      .light-mode {
        background-color: white;
        color: black;
      }*/
    </style>
    <!---------------------- End Basic page styling ---------------------->

    <!-- Tab Icon -->
    <link rel="icon" href="../../../assets/seal.png">

    <!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
    <!-- Tab Title -->
    <!-- MUST BE SET IN DOCUMENT THAT CALLS THIS FILE. -->

