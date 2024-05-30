<?php

require_once "../configuration/connexion.php";
session_start();
if( !isset($_SESSION['email']))
{
    header('location:login_vet.php');
    die;
}else
{
    if(isset($_SESSION['idUser']))
    {

        $id=$_SESSION['idUser'];
    }else if(isset($_SESSION['idVet']))
    {
        $id=$_SESSION['idVet'];

    }
    $email=$_SESSION['email'];

}



if(isset($_POST['get_id']))
{
    $get_id_vet=$_POST['get_id'];
}
if(isset($_POST['send']))
{

    if(isset($_POST['comment_text']) && !empty($_POST['comment_text']))
    {
        $commentaire= mysqli_real_escape_string($conn,$_POST['comment_text']);
        $commented_at=date("Y-m-d H:i:s");

        $insert_comment=$conn->prepare("INSERT INTO  `aide_animale` (`id_veterinaire`, `id_analyse`, `conseils`, `datea`) VALUES (?,?,?,?)");
        $insert_comment->bind_param("ssss",$id,$get_id_vet,$commentaire,$commented_at);
        $insert_comment->execute();

        if($insert_comment->affected_rows > 0)
        {
            $_SESSION['success']="Votre commentaire a bien été envoyé!";
            header('location:aide_animale.php');
            die;
        }

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
<link style="border-radius: 50%; " rel="shortcut icon" href="images/qualam11.png" type="image/x-icon">
	<!--css-->
    <link rel="stylesheet" href="navbar.css">
	<link rel="stylesheet" href="css/bootstrap1.css">
	<link rel="stylesheet" href="css/bootstrap2.css">
	<link rel="stylesheet" href="css/bootstrap3.css">


	<!--script-->

	<script src="js/bootstrap.js"></script>
	<script src="js/j.js"></script>
	<script src="js/fontowsem.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        color: purple;
    }
    .item:hover{
        width: 300px; 
        transition: 2s;}
                span{
                    margin-right: 30px;
                    font-weight: 700;
                    cursor:grab;
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
          <li><a href="aboutus.php">A propos</a></li></ul>
    
    <span><a href="logout.php">Déconecter</a> </span>
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
$stmt_get_pub=$conn->prepare("SELECT a.*,us.* FROM analyse a JOIN users us ON us.id_user=a.id_user");
$stmt_get_pub->execute();
$result=$stmt_get_pub->get_result();

if($result->num_rows > 0)
{
   

    
    
          while ($row = $result->fetch_assoc()) 
          {
              
              $id_pub=$row['id_analyse'];
              echo ' <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post"> <main class="container p-4" >
              <input type="hidden" name="get_id" id="" value="'.$row['id_analyse'].'">
              <section class="row justify-content-center"  >
              <article class="col-sm col-md-6 col-lg"  style="width:550px;  ">
              <div class="row row-cols-1  g-4" >
              <div class="col"  >
              <div class="card" style="box-shadow:0px 1px 20px 1px;">
              <div class="card-body">';

                        if(!empty($row['pfp_animal']))
                        {


                                echo '<h5 class="card-title "><img style="  position: relative;right: 10px; border-radius: 50%;" src="./pfpi_pic/'.$row['pfp_profile'].'" width="60px" height="60px" >'.$row['nom'].' '.$row['prenom'].'</h5>';
                        }else{
                            echo '<h5 class="card-title "><img style="  position: relative;right: 10px; border-radius: 50%;" src="https://bootdey.com/img/Content/avatar/avatar6.png" width="50px" height="50px" >'.$row['nom_animale'].'</h5>';
                        }

                        

                        echo'
						
                       <p class="card-title lead"> <b>Date naissance: </b> '.$row['date_nai'].'</p> 


                       <p class="card-title lead"> <b>Type:</b> '.$row['type'].'</p> 
                        <p class="card-title lead"> <b>Race: </b>'.$row['race'].'</p>
                        <p class="card-title lead"> <b>Symptomes: </b>'.$row['symptomes'].'</p>
                        <p class="card-title lead"> <b>Maladie: </b>'.$row['Maladie_possible'].'</p>

                        
                        <img src="./pfpi_animal/'.$row['pfp_animal'].'" class="card-img-top" alt="photo_publication" height="400px"/>
                        

						
						</div>
                        
						';

                        $get_comments=$conn->prepare("SELECT * FROM aide_animale WHERE id_analyse='$id_pub'");
                        $get_comments->execute();
                        $r=$get_comments->get_result();
                        $get_comments->close();
                        
                        if($r->num_rows < 1)
                        {
                            
                            echo'<details style="padding:20px;"><summary class="text-primary">Commentaires '.$r->num_rows.'</summary>';
                            if(!isset($_SESSION['idUser'])){
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
                            
                            $get_comments_pub=$conn->prepare("SELECT c.*, u.* FROM `aide_animale` c JOIN `veterinaire` u ON c.id_veterinaire = u.id_veterinaire WHERE id_analyse='$id_pub' ORDER BY c.`datea` DESC");
                            $get_comments_pub->execute();
                            $res=$get_comments_pub->get_result();
                            
                            echo'<details style="padding:20px;" ><summary class="text-primary">Commentaires '.$res->num_rows.'</summary>';
                            if(!isset($_SESSION['idUser']))
                            {
                            echo'
                                <div class="form-floating" >
                                <textarea class="form-control" placeholder="Leave a comment here" name="comment_text" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Rédigez un commentaire ...</label>
                                <br>
    
                                <button type="submit" name="send" class="btn btn-success">Commenter</button>
                              </div>
                                ';
                            }
                            while($data=$res->fetch_assoc())
                            {
                                if(!empty($data['pfp_profile']))
                                {

                                    echo'
                                    <div class="text-center p-3">
                                    <li class="list-group-item text-start" ><h5><img style="  position: relative;right: 10px; border-radius: 50%;" src="./pfpi_picture/'.$data['pfp_profile'].'" width="30px" height="30px" >'.$data['nom'].' '.$data['prenom'].' : '.$data['conseils'].'</h5></li>
                                    </div>
                                    
                                    ';
                                }else
                                {
                                    echo'
                                    <div class="text-center p-3">
                                    <li class="list-group-item text-start" ><h6><img style="  position: relative;right: 10px; border-radius: 50%;" src="https://bootdey.com/img/Content/avatar/avatar6.png" width="30px" height="30px" >'.$data['nom'].' '.$data['prenom'].' : '.$data['conseils'].'</h6></li>
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

    Aucune Animal trouvée !

</div>';

}
	?>



            

</body>

</html>