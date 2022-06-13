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
    <script nonce=<?=$nonce?> src="src/bootstrap/js/bootstrap.min.js"></script>
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Teko|PT+Sans|Permanent+Marker" rel="stylesheet">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script nonce=<?=$nonce?> src="src/bootstrap/js/jquery-3.3.1.min.js"></script>
    <?php
    require_once 'csrf/csrf_javascript.php'
    ?>

    <script nonce=<?=$nonce?> src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script nonce=<?=$nonce?> src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script nonce=<?=$nonce?>>
        let perfEntries = performance.getEntriesByType("navigation");
        let p = perfEntries[perfEntries.length - 1];

        if (p.type === 'reload' || p.type === 'back_forward'){
            let url = new URL(window.location.href);
            url.searchParams.set('csrfToken', '<?=generateCsrfToken()?>');
            window.location.href = url.toString();
        }
    </script>

</head>
<body>
<div>
    <div class="bannerstyle" >
        <a href="http://www.vts.su.ac.rs" ><img src="src/images/banner.jpg" /></a></div>
    <div class="bannerinnerstyle">

        <div class="clearfix" id="firstwrapper" >
            <?php
            require "newsheader.php";
            ?>
            <script nonce=<?=$nonce?>>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            </script>
            <?php
            //defining how many results we want per page
            global $pdo;
            $results_per_page=6;
            require_once 'csrf/csrf.php';
            if (isset($_SESSION['userId']) and checkCsrf(true)) {
                $nickname = $_SESSION['userUid'];
                echo '<div class="commentsection">';
                $sql = "SELECT * FROM comments WHERE nickname=? ORDER BY comments_id DESC";
                $result = $pdo->prepare($sql);
                !$result->execute([$nickname]) ? die($result->errorInfo()): false;
                if ($result->rowCount() > 0) {

                    while ($row = $result->fetch()) {

                        $originalDate = $row['timeofcomment'];
                        $newDate = date("d.m.Y H:i", strtotime($originalDate));
                        $nickname = $row['nickname'];
                        $comments = $row['comments'];
                        $approved = $row['approved'];
                        $id = $row['id'];
                        $commid=$row['comments_id'];
                        if($approved==1) {
                            echo "<h1 class='commentedh1'>Odobren komentar</h1>";
                        }
                        elseif($approved==0) {
                            echo "<h1 class='commentedh1''>Neodobren komentar</h1>";
                        }
                        echo "<div class='col-lg-6 commentspan'><span class='nickname'>$nickname</span><span class='timeofcomment'> $newDate </span><br/>
<span class='commentpart' >$comments</span>  </div> ";

                        echo "<div class='commenteddiv1'>";
                        echo '<a class="btn btn-secondary" href="news.php?id=' . $id . '">Pročitajte vest</a>&nbsp;';
                        echo "<button class='btn btn-danger deletecommm' id=$commid name='Delete'> <i class=\"fas fa-trash-alt\"></i></button>";
                        ?>
                        <script nonce="<?=$nonce?>">
                            elements = [...document.getElementsByClassName('deletecommm')];
                            console.log(document.getElementsByClassName('deletecommm'))
                            elements.forEach((element) => {
                                console.log(element)
                                element.addEventListener('click', e => {
                                    console.log(element.id)
                                    if(confirm("Da li sigurno želite da obrišete ovaj komentar?")){
                                        window.location.href='deletecomm.php?delcommm_id=' +e.target.id+'&csrfToken='+'<?=generateCsrfToken()?>';
                                        alert('Uspešno ste izbrisali komentar');
                                        return true;
                                    }
                                    e.stopPropagation();
                                })
                            });

                        </script>
            <?php
                        echo "<br/>";
                        echo "</div>";

                        echo "<hr class='commentedhr1'/>";
                    }

                }
                else{
                    echo "<div class='commenteddiv2'>";
                    echo "<div class='commentedh2' >Niste ništa komentarisali</div>";
                    echo "</div>";
                }
            }
            ?>

        </div>


        <?php
        require "footer2.php";
        ?>

    </div>
</div>


</body>

</html>