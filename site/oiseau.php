<?php
session_start();
    require_once "../configuration/connexion.php";

    if(!isset($_SESSION['idUser']) || !isset($_SESSION['email']) )
    {
        header('location:login.php?p=oiseau');
        die;
    }else
    {
        $id=$_SESSION['idUser'];
        $email=$_SESSION['email'];

    }

    $sql=mysqli_query($conn,"SELECT * FROM users WHERE id_user='$id' AND email='$email' LIMIT 1");
    $data=mysqli_fetch_assoc($sql);

    $er=0;
    if(isset($_POST['suivant']))
    {


        if(isset($_FILES['pic_profile'])) {

            $image_name = $_FILES['pic_profile']['name'];
            $image_size = $_FILES['pic_profile']['size'];
            $image_error = $_FILES['pic_profile']['error'];
            
            $ex = explode('.', $image_name);   
            $end_name = strtolower(end($ex));  
            $allowed = array('png', 'jpg', 'jpeg', 'svg', 'gif'); 
    
            if(in_array($end_name, $allowed)) {
                if($image_error === 0) {
                    if($image_size < 4000000) { 
                        $new_name = uniqid('',true) . '_' . $image_name;
                        $dir = "./pfpi_animal/".$new_name;
    
                     
                        

                         
                            
    
                            if(move_uploaded_file($_FILES['pic_profile']['tmp_name'], $dir)) {
                                
                                
                            } else {
                                $erreur = "Erreur lors de l'upload de l'image.";
                                $er=1;
                            }
                       
                        
                        
                    } else {
                        $erreur = "Votre image est trop grande !";
                        $er=1;

                    }
                } else {
                    $erreur = "Nous avons une erreur dans votre image !";
                    $er=1;

                }
            } else {
                $erreur = "Choisissez une image avec le type correct !";
                $er=1;

            }
        }else
        {
            $erreur="Obliagatoire!";
            $er=1;

        }

            if(isset($_POST['animalName']) && !empty(trim($_POST['animalName'])) )
            {
                $animalName=mysqli_real_escape_string($conn,$_POST['animalName']);
            }else
            {
                
                $er=1;
            }

            if(isset($_POST['animalDob']) && !empty($_POST['animalDob']) )
            {
                $animalDob=mysqli_real_escape_string($conn,$_POST['animalDob']);
            }else
            {
                
                $er=1;
            }
            


            if(isset($_POST['gender']) && !empty($_POST['gender']) )
            {
                $gender=mysqli_real_escape_string($conn,$_POST['gender']);
            }else
            {
                $er=1;
            }

            if(isset($_POST['race']) && !empty($_POST['race']) )
            {
                $race=mysqli_real_escape_string($conn,$_POST['race']);
            }else
            {
                $er=1;
            }

            if(isset($_POST['corpulence']) && !empty($_POST['corpulence']) )
            {
                $corpulence=mysqli_real_escape_string($conn,$_POST['corpulence']);
            }else
            {
                $er=1;
            }

            

            if(isset($_POST['particulars']) && !empty($_POST['particulars']) )
            {
                $particulars=mysqli_real_escape_string($conn,$_POST['particulars']);
            }else
            {
                $er=1;
            }


            if(!isset($_POST['Diarrhée_avec_présence_de_sang']) && !isset($_POST['perte_de_poids']) && !isset($_POST['bave_au_coin_du_bec']) && !isset($_POST['Respiration_irrégulière']) && !isset($_POST['tremblements']) && !isset($_POST['perte_d_appétit']) && !isset($_POST['Lésoins_cutanées_dues_au_froid']) && !isset($_POST['Nécrose_des_tissus']))
            {
                $er=1;
            }

            if($er==0)
            {
                
                if(isset($_POST['Diarrhée_avec_présence_de_sang']) && isset($_POST['perte_de_poids']) && isset($_POST['bave_au_coin_du_bec']) && !isset($_POST['Respiration_irrégulière']) && !isset($_POST['tremblements']) && !isset($_POST['perte_d_appétit']) && !isset($_POST['Lésoins_cutanées_dues_au_froid']) && !isset($_POST['Nécrose_des_tissus']))
                {
                    $Diarrhée_avec_présence_de_sang=$_POST['Diarrhée_avec_présence_de_sang'];
                    $perte_de_poids=$_POST['perte_de_poids'];
                    $bave_au_coin_du_bec=$_POST['bave_au_coin_du_bec'];
                    $malade="Coccidiose";
                }
                
                
                if(isset($_POST['Respiration_irrégulière']) && isset($_POST['tremblements']) && isset($_POST['perte_d_appétit']) && !isset($_POST['Diarrhée_avec_présence_de_sang']) && !isset($_POST['perte_de_poids']) && !isset($_POST['bave_au_coin_du_bec']) && !isset($_POST['Lésoins_cutanées_dues_au_froid']) && !isset($_POST['Nécrose_des_tissus']))
                {   
                    $Respiration_irrégulière=$_POST['Respiration_irrégulière'];
                    $tremblements=$_POST['tremblements'];
                    $perte_d_appétit=$_POST['perte_d_appétit'];
                    $malade="Psittacose";
                }

                if(isset($_POST['Lésoins_cutanées_dues_au_froid']) && isset($_POST['Nécrose_des_tissus']) && !isset($_POST['Diarrhée_avec_présence_de_sang']) && !isset($_POST['perte_de_poids']) && !isset($_POST['bave_au_coin_du_bec']) && !isset($_POST['Respiration_irrégulière']) && !isset($_POST['tremblements']) && !isset($_POST['perte_d_appétit']))
                {
                    $Lésoins_cutanées_dues_au_froid=$_POST['Lésoins_cutanées_dues_au_froid'];
                    $Nécrose_des_tissus=$_POST['Nécrose_des_tissus'];
                    
                    $malade="Engelures";
                }
                
                $type="oiseau";

                if(isset($malade) && !empty($malade))
                {

                    if($malade=="Coccidiose")
                    {
                        $symptomes=$Diarrhée_avec_présence_de_sang.'-'.$perte_de_poids.'-'.$bave_au_coin_du_bec;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }else if($malade=="Psittacose")
                    {
                        $symptomes=$Respiration_irrégulière.'-'.$tremblements.'-'.$perte_d_appétit;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }else if($malade=="Engelures")
                    {
                        $symptomes=$Lésoins_cutanées_dues_au_froid.'-'.$Nécrose_des_tissus;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }
                }else
                {
                    $array=[];
                    if(isset($_POST['Diarrhée_avec_présence_de_sang']))
                    {
                        $array[]=$_POST['Diarrhée_avec_présence_de_sang'];
                    }

                    if(isset($_POST['perte_de_poids']))
                    {
                        $array[]=$_POST['perte_de_poids'];
                    }
                    
                    if(isset($_POST['bave_au_coin_du_bec']))
                    {
                        $array[]=$_POST['bave_au_coin_du_bec'];
                    } 
                    
                    if(isset($_POST['Respiration_irrégulière']))
                    {
                        $array[]=$_POST['Respiration_irrégulière'];
                    } 
                    
                    if(isset($_POST['tremblements']))
                    {
                        $array[]=$_POST['tremblements'];
                    }

                    if(isset($_POST['perte_d_appétit']))
                    {
                        $array[]=$_POST['perte_d_appétit'];
                    }

                    if(isset($_POST['Lésoins_cutanées_dues_au_froid']))
                    {
                        $array[]=$_POST['Lésoins_cutanées_dues_au_froid'];
                    }

                    if(isset($_POST['Nécrose_des_tissus']))
                    {
                        $array[]=$_POST['Nécrose_des_tissus'];
                    }

                    $symptome="";
                    foreach($array as $item)
                    {
                        $symptome=$symptome.'-'.$item;

                    }

                    $malade="Cas compliquer";
                    $date=date("Y-m-d H:i:s");
                    $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                    ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptome','$malade','$date','$type')");

                }

                
                $_SESSION['success']="La maladie potentielle de votre animal pourrait être erronée. Nous vous conseillons de trouver un vétérinaire pour soigner votre animal via cette page <a href='liste_vet.php'>Trouver vétérinaire<a>";
                header('location:mes_animaux.php');
                die;
            }



            

            
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Dogs</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="filter.css">
</head>
<body>
<header>
    <div class="nav">
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1>  
    <ul>
        <li><a href="index.php"> Analyseur de symptomes</a></li>
        <li><a href="profile_client.php">Profile</a></li>
        <li><a href="mes_animaux.php">Mes Animaux</a></li>
        <li><a href="aide_animale.php">Animaux</a></li>

        <li><a href="liste_vet.php">Chercher vétirinaire</a></li>


        <li><a href="aboutus.php">a propos
        
        </a> </li>
        
    </ul>
    
    <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout.php">Déconnecter</a> </span>
</div></header>
<div class="container">
<form  method="post" id="infoForm" enctype="multipart/form-data">
    <div class="input-field">
            <label for="animalName">Photo de votre Oiseau ?</label>
            <input type="file" id="choose_file" name="pic_profile" required>
        </div>

        <div class="input-field">
            <label for="animalName">Quel est le nom de votre Oiseau ?</label>
            <input type="text" id="animalName" name="animalName" required>
        </div>
        <div class="input-field">
            <label for="animalDob">Quelle est sa date de naissance ? (même approximative)</label>
            <input type="date" id="animalDob" name="animalDob" required>
        </div>
        <div class="input-field">
            <label for="gender">Quel est son sexe ?</label>
            <select id="gender" name="gender" required>
                <option value="">Choisissez <?php if($er==1) echo $er; ?></option>
                <option value="male">Mâle</option>
                <option value="female">Femelle</option>
            </select>
        </div>
        <div class="input-field">
            <label for="race">Quelle est sa race ?</label>
            <select name="race" id="">
                <option value="" selected disabled > </option>
                <option value="perroquet">Perroquet</option>
                <option value="canari">Canari</option>
                <option value="perruche">Perruche</option>
                <option value="calopsitte">Calopsitte</option>
                <option value="inséparable">Inséparable</option>
                <option value="cockatiel">Cockatiel</option>
                <option value="ara">Ara</option>
                <option value="gris_du_gabon">Gris du Gabon</option>
                <option value="tourterelle">Tourterelle</option>
                <option value="pigeon">Pigeon</option>

            </select>
        </div>
        <div class="input-field">
            <label for="corpulence">Quelle est sa corpulence ?</label>
            <select id="corpulence" name="corpulence" required>
                <option value="">Choisissez</option>
                <option value="Maigre">Maigre</option>
                <option value="Un peu maigre">Un peu maigre</option>
                <option value="Normale">Normale</option>
                <option value="Léger surpoids">Léger surpoids</option>
                <option value="Surpoids">Surpoids</option>
            </select>
        </div>
        <div class="input-field">
            <label for="particulars">Cas particulier :</label>
            <select id="particulars" name="particulars" required>
                <option value="">Choisissez</option>
                <option value="Aucun">Aucun</option>
                <option value="Stérilisée">Stérilisée</option>
            </select>
        </div>
        
        
            <label for="symptom">Quels sont les symptômes?</label>

            Diarrhée avec présence de sang <input type="checkbox" id="symptom" value="Diarrhée avec présence de sang" name="Diarrhée_avec_présence_de_sang"><br>
            perte de poids <input type="checkbox" id="symptom" value="perte de poids" name="perte_de_poids"><br>
            bave au coin du bec <input type="checkbox" id="symptom" value="bave au coin du bec" name="bave_au_coin_du_bec"><br>
            Respiration irrégulière <input type="checkbox" id="symptom" value="Respiration irrégulière" name="Respiration_irrégulière"><br>
            Tremblements <input type="checkbox" id="symptom" value="tremblements" name="tremblements" ><br>
            perte d'appétit <input type="checkbox" id="symptom" value="perte d appétit" name="perte_d_appétit"><br>
            Lésoins cutanées dues au froid <input type="checkbox" id="symptom" value="Lésoins cutanées dues au froid" name="Lésoins_cutanées_dues_au_froid"><br>
            Nécrose des tissus<input type="checkbox" id="symptom" value="Nécrose des tissus" name="Nécrose_des_tissus">
            <div id="suggestions-list"></div>
        
        <div class="button">
            <button type="submit" name="suivant">Suivant</button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="filter.js"></script>


</body>
</html>
  