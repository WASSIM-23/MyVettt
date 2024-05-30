

<?php
session_start();
    require_once "../configuration/connexion.php";

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vétérinare</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <style>
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
            #d{
                text-decoration: none;
        color: purple;
        
            }
                
    </style>
    <header>
        <div class="nav">
        <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1> 
    <ul>
        <?php
        if( isset($_SESSION['idUser']) )
        {

        
    echo '<li><a href="index.php"> Analyseur de symptomes</a></li>
        
        <li><a href="profile_client.php">Profile</a></li>
        <li><a href="mes_animaux.php">Mes Animaux</a></li>
        <li><a href="aide_animale.php">Animaux</a></li>

        <li><a href="liste_vet.php">Chercher vétirinaire</a></li>
        <li><a href="aboutus.php">A propos</a></li>';
    
    } else{
        echo '
        
           
        <li style="top:3px"><a href="index.php"> Analyseur de symptomes</a></li>
        <li style="display:flex;"><a href=""><b>Animaux </b> <img src="cadenas.png" alt="" width="20px"></a></li>
        <li style="display:flex;"><a href=""><b>Chercher vétirinaire </b> <img src="cadenas.png" alt="" width="20px"></a></li>
        <li style="top:3px;"><a href="aboutus.php">A propos</a></li>';
        }
     ?>
    </ul>
            <?php if(isset($_SESSION['idUser']))
            {
              echo'  <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout.php">Déonnecter</a> </span>';

            } else
            {
              echo'  <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="choiconnecter.php">Se Connecter</a> </span>';

            } ?>
</div>
</header>
<div class="introduction">
    <div class="pargraphe"><div class="textheader"><h1>Vous cherchez des conseils avisés sur la santé et le bien-être
         de votre animal de compagnie ?</h1><p> En tant qu'expert vétérinaire, je suis là pour vous
          aider à prendre les meilleures décisions pour assurer le bonheur et la santé de 
          votre fidèle compagnon. Avec mes conseils, vous pourrez préserver le bien-être de
         votre animal en toute tranquillité d'esprit.</p></div>
         <div class="choisir">
         <div class="question1 question"><center>
            <img src="chien-removebg-preview.png" alt=""><br>
            <a href="filtrer.php">Commencer le questionnaire pour mon chien</a></center></div>
         <div class="question2 question"><center>
            <img src="chat-removebg-preview.png" alt=""><br>
            <a href="chat.php">Commencer le questionnaire pour mon chat</a></center></div>
         <div class="question3 question"><center>
            <img src="oiseau-removebg-preview.png" alt=""><br>
            <a href="oiseau.php">Commencer le questionnaire pour mon oiseau</a></center></div></div>
    </div>

</div>
<div class="infocomplet">
    <h1>Le conseil vétérinaire en ligne !</h1>
    <div class="inf">
        <div class="rectangle"><img src="smartphone.png" alt="">
        <p>Questions adaptées aux symptomes de l'animal</p>
    </div>
    <div class="rectangle"><img src="chien.png" alt="">
        <p>Conseils sur la conduite à tenir</p>
    </div>
        <div class="rectangle"><img src="patient.png" alt="">
        <p>Facilite l'orientation médicale</p>
    </div></div>
    
</div>
</body>
</html>