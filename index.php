<?php include('autoload.php'); ?>

<html>
<head>
    <title>E. TEST</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/test.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/test.css">

</head>
    <body>
        <div id="loader"></div>
        <table id="resultTable">
            <?php echo $view->output(); ?>
        </table>
    </body>
</html>
