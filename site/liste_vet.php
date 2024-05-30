<?php
require_once "../configuration/connexion.php";
session_start();

// Vérification de la session
if(!isset($_SESSION['email'])) {
    header('location:login_vet.php');
    exit; // Utilisez exit() au lieu de die() pour plus de clarté
} else {
    // Récupération de l'ID utilisateur ou vétérinaire
    $id = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : (isset($_SESSION['idVet']) ? $_SESSION['idVet'] : null);
    $email = $_SESSION['email'];
}

// Traitement du formulaire de commentaire
if(isset($_POST['send'])) {
    if(isset($_POST['comment_text']) && !empty($_POST['comment_text'])) {
        $commentaire = mysqli_real_escape_string($conn, $_POST['comment_text']);
        $commented_at = date("Y-m-d H:i:s");

        $insert_comment = $conn->prepare("INSERT INTO `comments` (`id_user`, `id_veterinaire`, `comment`, `date`) VALUES (?, ?, ?, ?)");
        $insert_comment->bind_param("ssss", $id, $_POST['get_id'], $commentaire, $commented_at);
        $insert_comment->execute();

        if($insert_comment->affected_rows > 0) {
            $_SESSION['success'] = "Votre commentaire a bien été envoyé!";
            header('location:liste_vet.php');
            exit;
        }
    }
}

// Traitement de l'évaluation
if(isset($_POST['save'])) {
    $uID = $_SESSION['idUser'];
    $ratedIndex = $conn->real_escape_string($_POST['ratedIndex']);
    $vetID = $conn->real_escape_string($_POST['vetID']);
    $ratedIndex++;

    $test = mysqli_query($conn, "SELECT * FROM stars WHERE id_user='$uID' AND id_veterinaire='$vetID' LIMIT 1");
    if(mysqli_num_rows($test) > 0) {
        mysqli_query($conn, "UPDATE stars SET `rateIndex`='$ratedIndex' WHERE `id_user`='$uID' AND `id_veterinaire`='$vetID' LIMIT 1");
    } else {
        mysqli_query($conn, "INSERT INTO stars (rateIndex,id_user,id_veterinaire) VALUES ('$ratedIndex','$uID','$vetID')");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- titre de la page -->
<title></title>


<!-- logo de site web -->
	<!--css-->
    <link style="border-radius: 50%;" rel="shortcut icon" href="images/qualam11.png" type="image/x-icon">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="css/bootstrap1.css">
    <link rel="stylesheet" href="css/bootstrap2.css">
    <link rel="stylesheet" href="css/bootstrap3.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/j.js"></script>
    <script src="js/fontowsem.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>


	<style>
*{
    padding: 0;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body{
    background-image:url("homebg.jpg");
    margin:auto ;    
    align-items: center;  
    background-repeat:repeat ;
    width: 100%;
    height: 100vh;
}
.nav{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: auto;
    background-color: #c4c2c25e;
    color: #3b023b;
  }
  header h1{
    margin-left: 30px;
   
  }
  
  
  .nav ul {
    display: flex;
    margin: 20px;
    
    
  }
  .nav ul li{
    list-style: none;
    justify-content: center;
    margin: 0 10px;
    position: relative;
    padding: 10px 10px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;     
    transition: 0.5s;
  }
  .nav ul li:hover{
    background-color: #837f8696;
    box-shadow: 0 0 25px    #837f8696;}
  .nav ul li a {
        text-decoration: none;
        color: purple ;
    }
    .item:hover{
        width: 300px; 
        transition: 2s;}
                span{
                    margin-right: 30px;
                    font-weight: 700;
                    cursor:grab;
                    width: auto;
                }
                span a {
                text-decoration: none;
                padding: 10px 10px;
                border-radius: 10px;
                color: purple;
                }
                span :hover{
                    background-color: #837f8696;
                    box-shadow: 0 0 25px    #837f8696;
                }

	</style>


<header>
    <div class="nav">
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1> 
    <ul>
        <?php
    if( isset($_SESSION['idUser']) )
        {

        
    echo '
    <li><a href="index.php"> Analyseur de symptomes</a></li>
        
        <li><a href="profile_client.php">Profile</a></li>
        <li><a href="mes_animaux.php">Mes Animaux</a></li>
        <li><a href="aide_animale.php">Animaux</a></li>
        <li><a href="liste_vet.php">Chercher vétirinaire</a></li>';}else
        {
            echo '
        
            <li><a href="profile_vet.php">Profile</a></li>
            <li><a href="aide_animale.php">Animaux</a></li>
            <li><a href="liste_vet.php">Chercher vétirinaire</a></li>';
        }
     ?>
        <li><a href="aboutus.php">a propos</a></li>
        
    </ul>
    
    <span><a href="logout.php">Déconnecter</a> </span>
</div></header>

<?php if(isset($_SESSION['success']) && $_SESSION['success']!=""):?>
            <div class=" text-center alert alert-success" role="alert">
            <?php
             {
                 echo $_SESSION['success'];
             }
                unset($_SESSION['success']);
            ?>
                 
            </div>
            <?php endif; ?>
    <!-- fin navbar -->
    
    <br>
    <?php
    // Modified query to get average ratings and sort by rating
    $stmt_get_pub = $conn->prepare("
        SELECT v.*, ROUND(AVG(s.rateIndex), 1) AS average_rating 
        FROM veterinaire v 
        LEFT JOIN stars s ON v.id_veterinaire = s.id_veterinaire 
        GROUP BY v.id_veterinaire 
        ORDER BY average_rating DESC
    ");
    $stmt_get_pub->execute();
    $result = $stmt_get_pub->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_pub = $row['id_veterinaire'];
            $average_rating = $row['average_rating'];

            echo ' <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post"> <main class="container p-4" >
              <input type="hidden" name="get_id" id="" value="' . $row['id_veterinaire'] . '">
              <section class="row justify-content-center"  >
              <article class="col-sm col-md-6 col-lg" style="width:550px;">
              <div class="row row-cols-1 g-4">
              <div class="col">
                <div class="card" style="box-shadow:0px 1px 20px 1px;">
                  <div class="card-body">';

            if (!empty($row['pfp_profile'])) {
                echo ' <h5 class="card-title"><img style="position: relative; right: 10px; border-radius: 50%;" src="./pfpi_picture/' . $row['pfp_profile'] . '" width="60px" height="60px"> ' . $row['nom'] . ' ' . $row['prenom'] . ' </h5>';
                if (!isset($_SESSION['idVet'])) {
                    echo '<div style="background: #000; padding:5px;color:white;">
                        <i class="fa fa-star fa-2x" data-index="0" data-vet-id="' . $id_pub . '"></i>
                        <i class="fa fa-star fa-2x" data-index="1" data-vet-id="' . $id_pub . '"></i>
                        <i class="fa fa-star fa-2x" data-index="2" data-vet-id="' . $id_pub . '"></i>
                        <i class="fa fa-star fa-2x" data-index="3" data-vet-id="' . $id_pub . '"></i>
                        <i class="fa fa-star fa-2x" data-index="4" data-vet-id="' . $id_pub . '"></i>
                        <br><br>
                      </div>';
                }
            } else {
                echo '<h5 class="card-title"><img style="position: relative; right: 10px; border-radius: 50%;" src="https://bootdey.com/img/Content/avatar/avatar6.png" width="50px" height="50px"> ' . $row['nom'] . ' ' . $row['prenom'] . '</h5>';
                if (!isset($_SESSION['idVet'])) {
                    echo '<div style="background: #000; padding:5px;color:white;">
                        <i style="cursor:pointer;" class="fa fa-star fa-2x" data-index="0" data-vet-id="' . $id_pub . '"></i>
                        <i style="cursor:pointer;" class="fa fa-star fa-2x" data-index="1" data-vet-id="' . $id_pub . '"></i>
                        <i style="cursor:pointer;" class="fa fa-star fa-2x" data-index="2" data-vet-id="' . $id_pub . '"></i>
                        <i style="cursor:pointer;" class="fa fa-star fa-2x" data-index="3" data-vet-id="' . $id_pub . '"></i>
                        <i style="cursor:pointer;" class="fa fa-star fa-2x" data-index="4" data-vet-id="' . $id_pub . '"></i>
                        <br><br>
                      </div>';
                }
            }

            echo'
           <h5> '. ($average_rating ? "Notes: $average_rating / 5" : "0/5") .' </h5>
                       <p class="card-title lead"> <b>Type:</b> '.$row['type'].'</p>
                        <p class="card-title lead"> <b>Spécialité:</b>'.$row['specialite'].'</p>
                        <p class="card-title lead"><b>Téléphone:</b> '.$row['telephone'].'</p>
                        <p class="card-title lead"><b>Jour de travail: </b> ' .$row['jour_d'].'->'.$row['jour_f'].'</p>
                        <p class="card-title lead"><b>Heurs de travail: </b> '.$row['heur_d'].'->'.$row['heur_f'].'</p>
                        

						<p style="card-title lead"> <b>Address:  </b>'.$row['address'].'</p>
						<p style="card-title lead"> <b>Email:  </b>'.$row['email'].'</p>
						</div>
                        
						';

                        $get_comments=$conn->prepare("SELECT * FROM comments WHERE id_veterinaire='$id_pub'");
                        $get_comments->execute();
                        $r=$get_comments->get_result();
                        $get_comments->close();
                        
                        if($r->num_rows < 1)
                        {
                            
                            echo'<details style="padding:20px;"><summary class="text-primary">Commentaires '.$r->num_rows.'</summary>';
                            if(!isset($_SESSION['idVet']))
                            {
                                echo'
                            
                            <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" name="comment_text" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Rédigez un commentaire ...</label>
                            <br>

                            <button type="submit" name="send" class="btn btn-success">Commenter</button>
                          </div>';
                            }
                            echo'
                            <div class="text-center p-3">
                            </details>
                            </div>
                            </div>
                            </div>
                            </div>
                            </article>
                            </section>
                            </main></form>';
                        }else
                        {
                            $get_comments_pub=$conn->prepare("SELECT c.*, u.* FROM `comments` c JOIN `users` u ON c.id_user = u.id_user WHERE id_veterinaire='$id_pub' ORDER BY c.`date` DESC");
                            $get_comments_pub->execute();
                            $res=$get_comments_pub->get_result();
                            
                            echo'<details style="padding:20px;" ><summary class="text-primary">Commentaires '.$res->num_rows.'</summary>';
                            if(!isset($_SESSION['idVet'])){
                                echo '
                                <div class="form-floating" >
                                <textarea class="form-control" placeholder="Leave a comment here" name="comment_text" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Rédigez un commentaire ...</label>
                                <br>
                                
                                <button type="submit" name="send" class="btn btn-success">Commenter</button>
                                </div>';
                            }
                            while($data=$res->fetch_assoc())
                            {
                                if(!empty($data['pfp_profile']))
                                {

                                    echo'
                                    <div class="text-center p-3">
                                    <li class="list-group-item text-start" ><h5><img style="  position: relative;right: 10px; border-radius: 50%;" src="./pfpi_pic/'.$data['pfp_profile'].'" width="30px" height="30px" >'.$data['nom'].' '.$data['prenom'].' : '.$data['comment'].'</h5></li>
                                    </div>
                                    
                                    ';
                                }else
                                {
                                    echo'
                                    <div class="text-center p-3">
                                    <li class="list-group-item text-start" ><h6><img style="  position: relative;right: 10px; border-radius: 50%;" src="https://bootdey.com/img/Content/avatar/avatar6.png" width="30px" height="30px" >'.$data['nom'].' '.$data['prenom'].' : '.$data['comment'].'</h6></li>
                                    </div>
                                    
                                    ';
                                }
                           
                            }
                        
                        echo'
                        </details>
                        </div>
                        </div>
                            </div>
                            </article>
                            </section>
                            </main></form>'; 
                             

                        }
                        

                        
	}
    
}else
{
    echo'<div class="alert alert-success text-center" role="alert">

    Aucune Vétérinaire trouvée !

</div>';

}
	?>



<script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script>
       var ratedIndex = -1, uID = 0;
var vetID;

$(document).ready(function () {
    resetStarColors();

    // Récupérer les évaluations stockées pour chaque vétérinaire
    $('i.fa-star').each(function () {
        var vetId = $(this).data('vet-id');
        if (localStorage.getItem('ratedIndex_' + vetId) != null) {
            setStars(vetId, parseInt(localStorage.getItem('ratedIndex_' + vetId)));
        }
    });

    $('.fa-star').on('click', function () {
        ratedIndex = parseInt($(this).data('index'));
        vetID = $(this).data('vet-id');
        localStorage.setItem('ratedIndex_' + vetID, ratedIndex);
        saveToTheDB();
    });

    $('.fa-star').mouseover(function () {
        resetStarColors();
        var currentIndex = parseInt($(this).data('index'));
        var vetId = $(this).data('vet-id');
        setStars(vetId, currentIndex);
    });

    $('.fa-star').mouseleave(function () {
        resetStarColors();

        $('i.fa-star').each(function () {
            var vetId = $(this).data('vet-id');
            if (localStorage.getItem('ratedIndex_' + vetId) != null) {
                setStars(vetId, parseInt(localStorage.getItem('ratedIndex_' + vetId)));
            }
        });
    });
});

function saveToTheDB() {
    $.ajax({
        url: "liste_vet.php",
        method: "POST",
        dataType: 'json',
        data: {
            save: 1,
            ratedIndex: ratedIndex,
            vetID: vetID
        },
        success: function (r) {
            uID = r.id;
            localStorage.setItem('uID', uID);
        }
    });
}

function setStars(vetId, max) {
    for (var i = 0; i <= max; i++) {
        $('.fa-star[data-vet-id="' + vetId + '"][data-index="' + i + '"]').css('color', 'yellow');
    }
}

function resetStarColors() {
    $('.fa-star').css('color', 'white');
}

    </script>


            

</body>

</html>