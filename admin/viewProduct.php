<?php
if(!isset($_SESSION))
{
    session_start();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
<!-- header   -->
        <div class="row">
            <?php require_once "navbarcopy.php"; ?>
        </div>

        <div class="row"><!-- content   -->
            <div class="col-md-3">
                filters are here

            </div>
            <div class="col-md-9"><!-- table view   -->
                <?php 
                if(isset($_SESSION['message']))
                {   
                    echo "<p class='alert alert-success'>$_SESSION[message] </p>";
                } 
                 ?>

            </div>
        </div>
    </div>



</body>

</html>