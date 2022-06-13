<?php
$nonce = bin2hex(random_bytes('32'));
header("Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net cdn.rawgit.com https://code.jquery.com/ https://stackpath.bootstrapcdn.com/ https://use.fontawesome.com/releases/v5.3.1/css/all.css https://www.kurir.rs use.fontawesome.com cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com https://ads.kurir-info.rs; script-src 'nonce-$nonce' 'self' https://cdn.jsdelivr.net cdn.rawgit.com https://code.jquery.com/ https://stackpath.bootstrapcdn.com/ https://use.fontawesome.com/releases/v5.3.1/css/all.css https://www.kurir.rs use.fontawesome.com cdnjs.cloudflare.com fonts.googleapis.com fonts.gstatic.com https://ads.kurir-info.rs; style-src 'self' https://fonts.googleapis.com/ https://cdnjs.cloudflare.com https://use.fontawesome.com/ cdn.jsdelivr.net; ");

include_once("config/dbconfig.php");
include_once("admin/functions.php");
require_once 'csrf/csrf.php';
startSession();
$id = $_GET['id'];
    include_once("config/dbconfig.php");
    $sql = "SELECT * FROM news WHERE id=? ";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);

    if ($result->rowCount() > 0) {
        while($row = $result->fetch()) {
            if(!isset($_COOKIE['count'.$id])){
                $content = $row["cookie_count"];
                $val = $content + 1;
                $sql = "UPDATE news SET cookie_count=? WHERE id=?";
                $result = $pdo->prepare($sql);
                $result->execute([$val, $id]);
                setcookie("count" . $id, $val, time() + 600);
            }
        }
    }



if(isset($_POST['notloggedin'])) {
if(!isset($_SESSION['userId'])) {
    header("Location: news.php?like=notlogged&id=" . $id . '&csrfToken='.generateCsrfToken());
}
}
if(isset($_POST['komentarisi']) && !isset($_SESSION['userId'])){
    header("Location: news.php?comment=notlogged&id=" . $id . '&csrfToken='.generateCsrfToken());
}
if(isset($_POST['komentarisi']) ) {
    if (isset($_SESSION['userId'])) {
        header("Location: news.php?comment=success&id=" . $id . '&csrfToken='.generateCsrfToken());
    }
}

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
    <link href="src/css/news.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="src/css/main.css" />
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
    <script src="src/js/news.js"></script>


</head>
<body>
<div>
    <div class="news0" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div class="news1">

        <div class="clearfix news2" id="firstwrapper">

    <?php
    require "newsheader.php";


    if(isset($_GET['like'])) {
        if ($_GET['like'] == "notlogged") {
            echo '<div class="errordiv">Morate biti prijavljeni da biste lajkovali vest!</div>';
        }
    }
    if(isset($_GET['comment'])) {
        if ($_GET['comment'] == "notlogged") {
            echo '<div class="errordiv">Morate biti prijavljeni da biste poslali komentar!</div>';
        }
        if ($_GET['comment'] == 'html_detected') {
            echo '<div class="errordiv">Komentar ne sme sadržati html!</div>';
        }
        if ($_GET['comment'] == 'prfanity_detected') {
            echo '<div class="errordiv">Komentar ne sme sadržati ružne reči!</div>';
        }
    }


    if(isset($_GET['comment'])) {
        if ($_GET['comment'] == "success") {
            $messagecomment = "Uspešno ste poslali komentar.";
            echo "<div class='successdiv'>$messagecomment</div>";
        }
    }


    ?>





            <?php

            $id = $_GET['id'];
            $sql = "SELECT * FROM news WHERE id=?";
            $result = $pdo->prepare($sql);
            $result->execute([$id]);

            while($row = $result->fetch()) {
                echo "<br>";
                echo "<div class='news'>";
                echo $row['content'];

                $originalDate =  $row['timeofinsert'];
                $newDate = date("d/M/Y H:i", strtotime($originalDate));
                echo "<div class=\"news3\">$newDate";
                echo "<br/>";
                echo "<p>Urednik: ".$row['creatorname']."</p> ";
                echo "<p class=\"news4\">".$row['cookie_count']."&nbsp<i class=\"far fa-eye\" class=\"news5\"></i>&nbsp&nbsp&nbsp";
            }

            $sql = "SELECT * FROM liked_news WHERE id=?;";
            $result = $pdo->prepare($sql);
            $result->execute([$id]);

            if($row = $result->fetch()) {
                $num_rows = $result->rowCount();
                echo $num_rows."&nbsp<i class=\"far fa-thumbs-up\" class=\"news6\"></i></p> ";
            }
            else{
                echo "0"."&nbsp<i class=\"far fa-thumbs-up\" class=\"news6\"></i></p> ";
            }

            //SELECT news.id, news.title, news.caption, news.images, news.alt, news.newstype
           // FROM news INNER JOIN hashtags ON news.id=hashtags.id WHERE hashtags.hashtags='$hashtag'
            $sql = "SELECT * FROM hashtags h INNER JOIN hashtags_middle_table m  ON h.hashtags_id = m.hashtags_id INNER JOIN news n ON m.id = n.id ";
            $result = $pdo->query($sql);
            while($row = $result->fetch()) {
                if($row['id']==$id) {

                    $hashtags = $row['hashtags'];
                    $trimmedhashtags = trim($hashtags, '#');
                    echo '<a href="search.php?search=%23' . $trimmedhashtags . '">' . $hashtags . '</a>';
                }
            }


            echo "</div>";


            if(!isset($_SESSION['userId']) ){
                echo '<div class="news8">';
                echo "<form action='' method='post'><button class='btn btn-info' type='submit' name='notloggedin'>Sviđa mi se <i class=\"fas fa-thumbs-up\"></i></button></form> &nbsp;";
                echo '</div>';

            }

            elseif(isset($_SESSION['userId'])) {
                $userid=$_SESSION['userId'];
                echo '<div class="news8"/>';
                $sql = "SELECT * FROM liked_news WHERE id=? AND users_id=?";
                $result = $pdo->prepare($sql);
                $result->execute([$id, $userid]);
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {

                        echo "<button class='btn btn-info' id='like-button' name='like' style='display: none;'>Sviđa mi se <i class=\"far fa-thumbs-up\"></i></button> &nbsp;";
                        like();
                    }
                }
                else{
                    echo "<button class='btn btn-info' id='like-button' name='like'>Sviđa mi se <i class=\"fas fa-thumbs-up\"'></i></button> &nbsp;";
                    like();
                }

                echo "</div>";
            }





            if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija') {
                echo '<div class="news8"/>';

                echo "<button class='btn btn-danger' id='deletenewsme' onClick='deletenewsme($id)' name='Delete'>Izbrišite <i class=\"fas fa-trash-alt\"></i></button> &nbsp;";
                deletenews();

                echo "</div>";
                $sql = "SELECT * FROM news WHERE id=?";
                $result = $pdo->prepare($sql);
                $result->execute([$id]);
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        if ($row['important_news'] == 1) {
                            echo "<div class='important'>Bitna vest</div>";
                        } elseif ($row['important_news'] == 0) {
                            echo "<div class='important'> Obična vest</div>";
                        }
                    }
                }
            }



            function save(){?>
                <!-- Javascript function for deleting news -->

            <?php }

            function like(){
                global $nonce;
                ?>
                <!-- Javascript function for deleting news -->
                <script language="javascript" nonce="<?=$nonce?>">
                    document.getElementById('like-button').addEventListener('click', () => {
                        console.log('asdf')
                        if(confirm("Da li želite da lajkujete ovu vest?")){
                            let likenewsid = <?=$_GET['id'] ?? ''?>;
                            window.location.href='likenews.php?likenews_id=' +likenewsid+'&csrfToken='+'<?=generateCsrfToken()?>'

                            alert('Lajkovali ste ovu vest');
                            return true;
                        }
                    })

                </script>
            <?php }


            function deletenews(){
                global $nonce
                ?>
                <!-- Javascript function for deleting news -->
                <script language="javascript" nonce="<?=$nonce?>">
                    function deletenewsme(delnewsid)
                    {
                        if(confirm("Da li sigurno želite da obrišete ovu vest?")){
                            window.location.href='deletenews.php?delnews_id=' +delnewsid+'&csrfToken='+'<?=generateCsrfToken()?>';
                            alert('Uspešno ste izbrisali vest');
                            return true;
                        }
                    }



                </script>
            <?php }

            echo "</div>";
            ?>


        <!-- SIDE BAR-->
        <div class="vertical-menu2">


            <p>Najnovije</p>
            <?php
                $sql = "SELECT * FROM news WHERE approved=1 ORDER BY id DESC LIMIT 0,12";
                $result = $pdo->query($sql);

                if ($result->rowCount() > 0) {
                    // output data of each row
                    while($row = $result->fetch()) {
                        $id=$row["id"];
                        echo '<a href="news.php?id='.$id.'">'.$row["title"].'</a>';
                    }
                } else {
                    echo "0 results";
                }
                ?>

        <!--END OF SIDE BAR-->

    </div>






    <div class="commentsection" >
        <h3>Postavite komentar</h3>

        <form action="post_comment.php" method="post">
            <?php
            $news_id = $_GET['id'] ?? '';
            ?>
            <div class="news12">
                <textarea name="user_input" id="user_input"  cols="30" rows="3" placeholder="Upišite komentar..." required maxlength="500" class="commentsinput" ></textarea>
            </div>
            <?=simplePostCsrf()?>
            <input type="hidden" name="news_id" value="<?=$news_id?>">
            <br/>
            <p>Max. 500 karaktera</p>
            <input type="submit"  name="komentarisi" value="Postavite komentar" class="responsive-width btn btn-primary">
        </form>


        <hr class="news13"/>
        <?php

        $id = $_GET['id'];

        $sql="SELECT * FROM comments WHERE approved=1 AND id=? ORDER BY comments_id DESC LIMIT 0,5";
        $result=$pdo->prepare($sql);
        $result->execute([$id]);
        if($result->rowCount() > 0){

            while ($row=$result->fetch()){

                $originalDate =  $row['timeofcomment'];
                $newDate = date("d.m.Y H:i", strtotime($originalDate));
                $nickname=$row['nickname'];
                $comments=$row['comments'];
                $approved=$row['approved'];

                echo "<div class=\"news14\">";
                echo "<div class='col-lg-6 commentspan news15'><span class='nickname'>$nickname</span><span class='timeofcomment'> $newDate </span><br/>
 <span class='commentpart' >$comments</span>";

                if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija') {
                    $commid=$row['comments_id'];
                    echo "<hr/><div class=\"news16\">";
                    echo "<button class='btn btn-danger' id='deletecommm' onClick='deletecommm($commid )' name='Delete'> <i class=\"fas fa-trash-alt\"></i></button></div>";
                    deletecomm();
                }


                echo "</div> ";
                echo "</div>";
                echo "<br/>";

            }

        }

        echo '<div class="news17"/>';
        echo '<a class="allcommentslink" href="comments.php?id='.$id.getCsrf().'">Pročitajte sve komentare</a><br/>';
        echo '</div>';

     ?>

        <br>
        <br>
        <br>
    </div>
            <div>
                </br>
                </br>
    <?php
    require "footer2.php";
    ?>
            </div>
</div>
    </div>
</div>
<script src="src/images.js"></script>
</body>
<script nonce="<?=$nonce?>">
    $("#user_input").emojioneArea({
        pickerPosition:"bottom"
    });
</script>
<script src="src/images.js"></script>
</html>
