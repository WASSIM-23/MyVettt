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
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;"></h1> 
    <ul>
        <?php
        if (isset($_SESSION['idUser'])) {
            echo '<li><a href="index.php">Analyseur de symptomes</a></li>
                  <li><a href="profile_client.php">Profile</a></li>
                  <li><a href="mes_animaux.php">Mes Animaux</a></li>
                  <li><a href="aide_animale.php">Animaux</a></li>
                  <li><a href="liste_vet.php">Chercher vétérinaire</a></li>';
        } elseif (isset($_SESSION['idVet'])) {
            echo '
                  <li><a href="profile_vet.php">Profile</a></li>
                  <li><a href="aide_animale.php">Animaux</a></li>
                  <li><a href="liste_vet.php">Chercher vétérinaire</a></li>
                  ';
        } else {
            echo '<li><a href="index.php">Analyseur de symptomes</a></li>
                  <li style="display:flex;"><option id="d" disabled><a href=""><b>Animaux</b></a></option><img src="cadenas.png" alt="" width="20px"></li>
                  <li style="display:flex;"><option id="d" disabled><a href=""><b>Chercher vétérinaire</b></a></option><img src="cadenas.png" alt="" width="20px"></li>';
        }
        ?>
        <li><a href="#">A propos</a></li>
    </ul>
    <?php
    if (isset($_SESSION['idUser'])) {
        echo '<span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout.php">Déonnecter</a> </span>';
    }
    elseif(isset($_SESSION['idVet'])){
        echo '<span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout_vet.php">Déonnecter</a> </span>';
    } else {
        echo '<span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="login.php">Se Connecter</a> </span>';
    }
    
    ?>
    
</div>

</div>
</header>
<main>
        <div class="container">
            <section class="about-us">
              <h1>À propos de nous</h1>
              <p>Bienvenue sur MyVet, votre plateforme en ligne de soins vétérinaires.</p>
              <h3>Notre Mission</h3>
                <p>Chez MyVet, notre mission est de révolutionner l'accès aux soins vétérinaires en offrant des solutions pratiques, fiables et innovantes pour la santé de vos animaux de compagnie. Nous nous engageons à fournir des services de qualité qui combinent le meilleur de la technologie et de l'expertise vétérinaire pour garantir le bien-être de vos compagnons.</p>
              <h3>Qui Sommes-Nous?</h3>
                <p>MyVet est né de la constatation que de nombreux propriétaires d'animaux rencontrent des difficultés à accéder facilement aux soins vétérinaires. Que ce soit en raison des contraintes de temps, des obstacles géographiques ou des problèmes de mobilité, il est souvent compliqué de s'assurer que nos animaux reçoivent les soins dont ils ont besoin. Pour répondre à ce besoin croissant, nous avons créé une plateforme en ligne qui offre une gamme complète de services vétérinaires, allant des consultations virtuelles aux visites à domicile, en passant par des conseils personnalisés.</p>
                <h3>Nos Services</h3>
                <p>Nos services comprennent :</p>
                <ul>
                    <li><h5> Consultations Virtuelles :</h5> Nos vétérinaires qualifiés sont disponibles pour des consultations en ligne, vous offrant des conseils et des diagnostics rapides depuis le confort de votre domicile.</li>
                    <li><h5>Visites à Domicile :</h5> Si une intervention physique est nécessaire, nos vétérinaires peuvent se déplacer chez vous pour prodiguer les soins nécessaires à votre animal.</li>
                    <li><h5>Questionnaire de Diagnostic :</h5> Un outil interactif qui vous aide à identifier les problèmes de santé potentiels de votre animal en fonction des symptômes que vous décrivez.</li>
                    <li><H5>Gestion des Dossiers Médicaux :</H5> Un système sécurisé pour gérer les dossiers médicaux de vos animaux, incluant les historiques de consultations et les traitements.</li>
                    <li><h5>Conseils Personnalisés :</h5> Des recommandations adaptées aux besoins spécifiques de chaque animal, basées sur les dernières recherches et pratiques en médecine vétérinaire.</li>
                    
                </ul>
                <h3>Nos Valeurs</h3>
                <ul>
                    <li><h5>Accessibilité :</h5> Rendre les soins vétérinaires accessibles à tous, quel que soit l'endroit où vous vivez.</li>
                    <li><h5>Innovation :</h5> Utiliser les dernières technologies pour améliorer la qualité et l'efficacité des soins vétérinaires. </li>
                    <li><h5> Compassion :</h5> Traiter chaque animal avec le soin et l'attention qu'il mérite, comme s'il faisait partie de notre propre famille.</li>
                    <li><h5>Transparence :</h5> Offrir des services transparents et des conseils honnêtes pour aider les propriétaires à prendre des décisions éclairées concernant la santé de leurs animaux.</li>
                </ul>
                <h3>Notre Équipe</h3>
                    <p>Notre équipe est composée de vétérinaires expérimentés, de spécialistes en technologie de la santé et de passionnés d'animaux. Ensemble, nous travaillons pour créer une expérience utilisateur exceptionnelle et garantir que vos animaux reçoivent les meilleurs soins possibles.</p>

                <h3>Pourquoi Choisir MyVet?</h3>
                    <p>En choisissant MyVet, vous optez pour une solution de soins vétérinaires moderne, flexible et fiable. Nous comprenons l'importance de vos animaux dans votre vie et nous nous engageons à vous offrir des services qui simplifient la gestion de leur santé, tout en assurant leur bien-être à long terme.</p>

                <h3>Contactez-Nous</h3>
                    <p>Si vous avez des questions ou souhaitez en savoir plus sur nos services, n'hésitez pas à nous contacter. Nous sommes là pour vous aider et répondre à toutes vos préoccupations.</p>
                <ul>
                    <li><H5>Email : myvet@gmail.com</H5></li>
                    <li><h5> Téléphone : +213 671 205 377</h5></li>
                    <li><H5>Adresse : 123 Rue Annaba , Annaba, Algérie</H5></li><br>
                    <li style="display: flex; align-items:center;" ><img src="téléchargement 1.jpg"  style=" width: 24px;height: 24px;"><h5>@MyVet</h5></li>
                    <li style="display: flex; align-items:center;"><img src="téléchargement 2.png" style=" width: 24px;height: 24px;"><h5>@MyVet</h5></li>
                    <li style="display: flex; align-items:center"><img src="téléchargement3.jpg"  style=" width: 24px;height: 24px;"><h5>@MyVet</h5></li>
                </ul>
                <p>Merci de faire confiance à MyVet pour les soins de vos animaux de compagnie. Ensemble, nous veillons à leur santé et à leur bonheur.</p>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 My Vet. Tous droits réservés.</p>
        </div>
    </footer>
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
            background-color: #c4c2c25e;
            height: 90px;
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
            }
            .item:hover{
                width: 300px; 
                transition: 2s;}
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 10px;
            align-items: center;
            display: flex;
            justify-content: center;
            
           
        }
        .about-us{
            padding: 20px 20px;
            width: 100%;
            background-color: transparent;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 10px;
            margin-bottom: 100px;
        }
        
        .container .about-us h1 {
            background:#04B970 ;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
             margin-top: -10px;
	        letter-spacing: 0.0015em;
        }
        
        .about-us h3 {
            color: #1e7525;
        }
        
        ul {
            padding: 20px 20px;
        }
        
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        
        footer .container {
            padding: 0 20px;
        }
        p {
            font-size: 17px;
            font-weight: 500;
        }
        
    </style>
</body>
</html>
