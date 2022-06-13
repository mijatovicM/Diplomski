
<?php
$nonce = bin2hex(random_bytes('32'));
header("Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net cdn.rawgit.com https://code.jquery.com/ https://stackpath.bootstrapcdn.com/ https://use.fontawesome.com/releases/v5.3.1/css/all.css https://www.kurir.rs use.fontawesome.com cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com https://ads.kurir-info.rs; script-src 'nonce-$nonce' 'self' https://cdn.jsdelivr.net cdn.rawgit.com https://code.jquery.com/ https://stackpath.bootstrapcdn.com/ https://use.fontawesome.com/releases/v5.3.1/css/all.css https://www.kurir.rs use.fontawesome.com cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com https://ads.kurir-info.rs; style-src 'self' https://fonts.googleapis.com/ https://cdnjs.cloudflare.com https://use.fontawesome.com/ cdn.jsdelivr.net; ");
include_once("config/dbconfig.php");
include_once("admin/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Izveštavaj - Najnovije vesti iz sveta i regiona</title>


    <!-- Bootstrap -->
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="src/css/main.css"/>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Teko|PT+Sans|Permanent+Marker" rel="stylesheet">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="src/bootstrap/js/jquery-3.3.1.min.js"></script>
    <?php
    require_once 'csrf/csrf_javascript.php'
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js"></script>
    <link href="src/css/comments.css" rel="stylesheet" type="text/css">
</head>
<body>


<div>
    <div class="comments0" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div class="comments1">

        <div class="clearfix comments2" id="firstwrapper">
    <?php
    require "newsheader.php";
    ?>

    <div class="comments3 commentsection">

        <?php

        $id = $_GET['id'];

        $sql="SELECT * FROM comments WHERE approved=1 AND id=? ORDER BY comments_id DESC";
        $result = $pdo->prepare($sql);
        !$result->execute([$id]) ? die($result->errorInfo()) : false;
        if($result->rowCount() > 0){

            while ($row = $result->fetch()){

                $originalDate =  $row['timeofcomment'];
                $newDate = date("d.m.Y H:i", strtotime($originalDate));
                $nickname=$row['nickname'];
                $comments=$row['comments'];
                $approved=$row['approved'];
                echo "<div class='comments4'>";
                echo "<div class='col-lg-6 commentspan comments5'><span class='nickname'>$nickname</span><span class='timeofcomment'> $newDate </span><br/>
 <span class='commentpart' >$comments</span>";

                if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija') {
                    $commid=$row['comments_id'];
                    echo "<hr/><div class=\"comments6\">";
                    echo "<button class='btn btn-danger' onClick='deletecommm($commid )' name='Delete'> <i class=\"fas fa-trash-alt\"></i></button></div>";
                    deletecomm();
                }


                echo "</div> ";
                echo "</div>";
                echo "<br/>";
            }

        }
        else{
            echo "<div class='hashtag comments7'>Nema komentara. Budite prvi i ostavite komentar.</div>";
        }

    ?>




</div>

    <?php
    require "footer2.php";
    ?>
        </div>
    </div>
</div>
</body>
<script>
    $("#user_input").emojioneArea({
        pickerPosition:"bottom"
    });
</script>
</html>