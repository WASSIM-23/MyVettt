<?php
session_start();
    require_once "../configuration/connexion.php";

    if(!isset($_SESSION['idUser']) || !isset($_SESSION['email']) )
    {
        header('location:login.php?p=filtrer');
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


            if(!isset($_POST['Fiévre']) && !isset($_POST['Pneumonie']) && !isset($_POST['gingivostomatite']) && !isset($_POST['Ecoulements_nasaux_et_oculaires']) && !isset($_POST['toux']) && !isset($_POST['éternuements']) && !isset($_POST['Perte_d_appétie']) && !isset($_POST['Difficult']))
            {
                $er=1;
            }

            if($er==0)
            {
                
                if(isset($_POST['Fiévre']) && isset($_POST['Pneumonie']) && isset($_POST['gingivostomatite']) && !isset($_POST['Ecoulements_nasaux_et_oculaires']) && !isset($_POST['toux']) && !isset($_POST['éternuements']) && !isset($_POST['Perte_d_appétie']) && !isset($_POST['Difficult']))
                {
                    $fievre=$_POST['Fiévre'];
                    $Pneumonie=$_POST['Pneumonie'];
                    $gingivostomatite=$_POST['gingivostomatite'];
                    $malade="Caliciviorse";
                }
                
                
                if(isset($_POST['Ecoulements_nasaux_et_oculaires']) && isset($_POST['toux']) && isset($_POST['éternuements']) && isset($_POST['Perte_d_appétie']) && !isset($_POST['Difficult']) && !isset($_POST['Fiévre']) && !isset($_POST['Pneumonie']) && !isset($_POST['gingivostomatite']))
                {   
                    $perte=$_POST['Perte_d_appétie'];
                    $Ecoulements=$_POST['Ecoulements_nasaux_et_oculaires'];
                    $toux=$_POST['toux'];
                    $éternuements=$_POST['éternuements'];
                    $malade="Coryza";
                }

                if(isset($_POST['Difficult']) && isset($_POST['toux']) && isset($_POST['éternuements']) && isset($_POST['Ecoulements_nasaux_et_oculaires']) && !isset($_POST['Perte_d_appétie']) && !isset($_POST['Fiévre']) && !isset($_POST['Pneumonie']) && !isset($_POST['gingivostomatite']))
                {
                    $Ecoulements=$_POST['Ecoulements_nasaux_et_oculaires'];
                    $toux=$_POST['toux'];
                    $éternuements=$_POST['éternuements'];
                    $respirer=$_POST['Difficult'];
                    $malade="Rhinotrachéite infectieuse";
                }
                
                $type="chien";

                if(isset($malade) && !empty($malade))
                {

                    if($malade=="Caliciviorse")
                    {
                        $symptomes=$fievre.'-'.$Pneumonie.'-'.$gingivostomatite;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }else if($malade=="Coryza")
                    {
                        $symptomes=$toux.'-'.$éternuements.'-'.$Ecoulements.'-'.$perte;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }else if($malade=="Rhinotrachéite infectieuse")
                    {
                        $symptomes=$toux.'-'.$éternuements.'-'.$Ecoulements.'-'.$respirer;
                        $date=date("Y-m-d H:i:s");
                        $inser=mysqli_query($conn,"INSERT INTO `analyse`(`id_user`, `nom_animale`, `pfp_animal`, `date_nai`, `race`, `sexe`, `corpulence`, `symptomes`, `Maladie_possible`, `date`, `type`) VALUES
                        ('$id','$animalName','$new_name','$animalDob','$race','$gender','$corpulence','$symptomes','$malade','$date','$type')");

                    }
                }else
                {
                    $array=[];
                    if(isset($_POST['Fiévre']))
                    {
                        $array[]=$_POST['Fiévre'];
                    }

                    if(isset($_POST['Pneumonie']))
                    {
                        $array[]=$_POST['Pneumonie'];
                    }
                    
                    if(isset($_POST['gingivostomatite']))
                    {
                        $array[]=$_POST['gingivostomatite'];
                    } 
                    
                    if(isset($_POST['Ecoulements_nasaux_et_oculaires']))
                    {
                        $array[]=$_POST['Ecoulements_nasaux_et_oculaires'];
                    } 
                    
                    if(isset($_POST['toux']))
                    {
                        $array[]=$_POST['toux'];
                    }

                    if(isset($_POST['éternuements']))
                    {
                        $array[]=$_POST['éternuements'];
                    }

                    if(isset($_POST['Perte_d_appétie']))
                    {
                        $array[]=$_POST['Perte_d_appétie'];
                    }

                    if(isset($_POST['Difficult']))
                    {
                        $array[]=$_POST['Difficult'];
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

        <li><a href="aboutus.php">a propos</a> </li>
        
    </ul>
    
    <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout.php">Déconnecter</a> </span>
</div>
</header>
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
<div class="container">
    <form  method="post" id="infoForm" enctype="multipart/form-data">
    <div class="input-field">
            <label for="animalName">Photo de votre Chien ?</label>
            <input type="file" id="choose_file" name="pic_profile" required>
        </div>

        <div class="input-field">
            <label for="animalName">Quel est le nom de votre Chien ?</label>
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
                <option value="Berger">Berger</option>
                <option value="Bouledogue">Bouledogue </option>
                <option value="Caniche">Caniche</option>
                <option value="Husky">Husky</option>
                <option value="Doberman">Doberman</option>
                <option value="Malinois">Malinois</option>
                <option value="pitbull">pitbull</option>

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

            Fiévre <input type="checkbox" id="symptom" value="Fiévre" name="Fiévre"><br>
            Pneumonie <input type="checkbox" id="symptom" value="Pneumonie" name="Pneumonie"><br>
            gingivostomatite <input type="checkbox" id="symptom" value="gingivostomatite" name="gingivostomatite"><br>
            Ecoulements nasaux et oculaires <input type="checkbox" id="symptom" value="Ecoulements nasaux et oculaires" name="Ecoulements_nasaux_et_oculaires"><br>
            toux <input type="checkbox" id="symptom" value="toux" name="toux" ><br>
            éternuements <input type="checkbox" id="symptom" value="éternuements" name="éternuements"><br>
            Perte d'appétie <input type="checkbox" id="symptom" value="Perte d appétie" name="Perte_d_appétie"><br>
            Difficultés à respirer <input type="checkbox" id="symptom" value="Difficultés à respirer" name="Difficult">
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
  