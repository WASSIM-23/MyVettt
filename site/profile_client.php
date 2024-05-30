<?php
session_start();
    require_once "../configuration/connexion.php";

    if(!isset($_SESSION['idUser']) || !isset($_SESSION['email']) )
    {
        header('location:index.php');
        die;
    }else
    {
        $id=$_SESSION['idUser'];
        $email=$_SESSION['email'];

    }

    $sql=mysqli_query($conn,"SELECT * FROM users WHERE id_user='$id' AND email='$email' LIMIT 1");
    $data=mysqli_fetch_assoc($sql);




    if(isset($_POST['changer']))
    {

        $error=0;

        if(isset($_POST['password']) && !empty($_POST['password']))
        {


            $password =mysqli_real_escape_string($conn,$_POST['password']);

            if(strpos($password, ' ') !== false)
            {
                $error=1;
                $e_password="le Mot de passe ne doit pas contenir des espaces!";


            }else if(strlen($password) < 8)
            {
                $error=1;
                $e_password="Le mot de passe doit contenir au moins 8 caractères!";
            }

        }else
        {
        $error=1;
            $e_password="Obligatoire!";
        }

        if(isset($_POST['new_password']) && !empty($_POST['new_password']))
        {


            $new_password =mysqli_real_escape_string($conn,$_POST['new_password']);
            

            if(strpos($new_password, ' ') !== false)
            {
                $error=1;
                $e_new_password="le Mot de passe ne doit pas contenir des espaces!";


            }elseif(strlen($new_password) < 8)
            {
                $error=1;
                $e_new_password="Le mot de passe doit contenir au moins 8 caractères!";
            }else
            {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);

            }

        }else
        {
        $error=1;
            $e_new_password="Obligatoire!";
        }

        if($error==0)
        {
            $stmt = $conn->prepare("SELECT `password` FROM `users` WHERE `email` = ? AND `id_user`= ? LIMIT 1");
            $stmt->bind_param("ss", $email,$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $old_password = $row['password'];
            if (password_verify($password, $old_password)) {
                if(!password_verify($new_password,$old_password))
                {   
                    $stmt = $conn->prepare("UPDATE `users` SET `password` = ? WHERE `email` = ? AND `password`= ? AND `id_user`=?  LIMIT 1");
                    $stmt->bind_param("ssss", $hash, $email,$old_password,$id);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['creat']= "Votre mot de passe a été modifié avec succès.";
                    header('location:profile_client.php');
                    die;
                }
                else
                {
                    $e_cha="vous etes deja utiliser ce mot de passe!";
                    
                }
            }else
            {
                $e_change="Mot de pass incorect!";
               
            }

            }
        }



    }


    if(isset($_POST['delete_pfp']))
 {
    $image = "SELECT `pfp_profile` FROM `users` WHERE email = ? LIMIT 1";
    $stmt_image = $conn->prepare($image);
    $stmt_image->bind_param("s", $_SESSION['email']);
    $stmt_image->execute();
    $image_info=$stmt_image->get_result();
    $row_image = $image_info->fetch_assoc();
    
    if($row_image['pfp_profile']==NULL)
    {
        $erreu="Nothing to delete";
    }else
    {
        if (!empty($row_image['pfp_profile']) && file_exists("./pfpi_pic/" . $row_image['pfp_profile'])) {
            unlink("./pfpi_pic/" . $row_image['pfp_profile']);
            $image_info->close();
            
            $sql1 = "UPDATE `users` SET `pfp_profile`= NULL WHERE email = ?  LIMIT 1";
            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("s",$_SESSION['email']);
            $stmt->execute();
            if($stmt->affected_rows > 0) {
                $stmt->close();
                $_SESSION['success']="profile mis à jour avec succès";

            }
            
            
        }
        




     }
 }





 if(isset($_POST['save_pfp'])) {
    
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
                    $dir = "./pfpi_pic/".$new_name;

                 
                    $old_image_name_query = "SELECT `pfp_profile` FROM `users` WHERE email = ? LIMIT 1";
                    $stmt_old = $conn->prepare($old_image_name_query);
                    $stmt_old->bind_param("s", $_SESSION['email']);
                    $stmt_old->execute();
                    $stmt_old->bind_result($old_image_name);
                    $stmt_old->fetch();
                    $stmt_old->close();

                   
                    $sql = "UPDATE `users` SET `pfp_profile`=? WHERE email = ?  LIMIT 1";
                    $stmt = $conn->prepare($sql);

                    
                    $stmt->bind_param("ss", $new_name, $_SESSION['email']);

                    
                    $stmt->execute();

                    
                    if($stmt->affected_rows > 0) {
                     
                        if (!empty($old_image_name) && file_exists("./pfpi_pic/" . $old_image_name)) {
                            unlink("./pfpi_pic/" . $old_image_name);
                        }

                        if(move_uploaded_file($_FILES['pic_profile']['tmp_name'], $dir)) {
                            
                            header('location: profile_client.php');
                            die();
                        } else {
                            $erreur = "Erreur lors de l'upload de l'image.";
                        }
                    } else {
                        $erreur = "Erreur lors de la mise à jour de l'image.";
                    }

                    
                    $stmt->close();
                } else {
                    $erreur = "Votre image est trop grande !";
                }
            } else {
                $erreur = "Nous avons une erreur dans votre image !";
            }
        } else {
            $erreur = "Choisissez une image avec le type correct !";
        }
    }else
    {
        $erreur="Obliagatoire!";
    }
}




    if (isset($_POST['delete'])) {
        $error_delete=0;
    
        if(isset($_POST['password_delete']) && !empty($_POST['password_delete']))
        {


            $password_delete =mysqli_real_escape_string($conn,$_POST['password_delete']);

            if(strpos($password_delete, ' ') !== false)
            {
                $error_delete=1;
                $e_password_delete="le Mot de passe ne doit pas contenir des espaces!";


            }else if(strlen($password_delete) < 8)
            {
                $error_delete=1;
                $e_password_delete="Le mot de passe doit contenir au moins 8 caractères!";
            }

        }else
        {
        $error_delete=1;
            $e_password_delete="Obligatoire!";
        }

        if($error_delete==0)
        {   
            if(!empty($password_delete))
            {
    
                $stmt = $conn->prepare("SELECT  `password` FROM `users` WHERE `email` = ? AND `id_user`=? LIMIT 1");
                $stmt->bind_param("ss", $email,$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $row_delete = $result->fetch_assoc();
                $pass=$row_delete['password'];
            if (password_verify($password_delete, $pass)) {
                
                $stmt = $conn->prepare("DELETE FROM `users` WHERE `email` = ? AND `id_user`=? AND `password`=? LIMIT 1");
                $stmt->bind_param("sss", $email,$id,$pass);
                
                
                
    
                $stmt->execute();
                
                
                $stmt->close();
                
                
                header('location:logout.php');
                die;
                
            }else{
                $e_password_delete="Mot de passe  incorrect!";
                

            }
            }else
            {
                $e_password_delete = "Obligatoire!";
                

            }
        }
    }





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
</head>
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
                color: purple;
                padding: 10px 10px;
                border-radius: 10px;
                }
                span :hover{
                    background-color: #837f8696;
                    box-shadow: 0 0 25px    #837f8696;
                }
    body {
    background-color: #f9f9fa
}

.padding {
    padding: 3rem !important
}

.user-card-full {
    overflow: hidden;
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    box-shadow: 0 1px 20px 0 rgba(69,90,100,0.08);
    border: none;
    margin-bottom: 30px;
}

.m-r-0 {
    margin-right: 0px;
}

.m-l-0 {
    margin-left: 0px;
}

.user-card-full .user-profile {
    border-radius: 5px 0 0 5px;
}

.bg-c-lite-green {
    background: linear-gradient(to right, #04B970, #03454C);
}

.user-profile {
    padding: 20px 0;
}

.card-block {
    padding: 1.25rem;
}

.m-b-25 {
    margin-bottom: 25px;
}

.img-radius {
    border-radius: 5px;
}


 
h6 {
    font-size: 14px;
}

.card .card-block p {
    line-height: 25px;
}

@media only screen and (min-width: 1400px){
p {
    font-size: 14px;
}
}

.card-block {
    padding: 1.25rem;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.m-b-20 {
    margin-bottom: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.card .card-block p {
    line-height: 25px;
}

.m-b-10 {
    margin-bottom: 10px;
}

.text-muted {
    color: #919aa3 !important;
}

.b-b-default {
    border-bottom: 1px solid #e0e0e0;
}

.f-w-600 {
    font-weight: 600;
}

.m-b-20 {
    margin-bottom: 20px;
}

.m-t-40 {
    margin-top: 20px;
}

.p-b-5 {
    padding-bottom: 5px !important;
}

.m-b-10 {
    margin-bottom: 10px;
}

.m-t-40 {
    margin-top: 20px;
}

.user-card-full .social-link li {
    display: inline-block;
}

.user-card-full .social-link li a {
    font-size: 20px;
    margin: 0 10px 0 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

   
    .input-field {
  position: relative;
  margin-bottom: 20px;
}

.input-field input {
  width: 350px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  outline: none;
  transition: border-color 0.3s ease;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  background-color: white;
  padding: 0 5px;
  color: #666;
  font-size: 14px;
  transition: top 0.3s ease, font-size 0.3s ease;
}

.input-field input:focus {
  border-color: #007BFF;
}

.input-field input:focus + label,
.input-field input:valid + label {
  top: -10px;
  font-size: 12px;
  color: #007BFF;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  background-color: #007BFF;
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}
#choose_file{
            width:300px;
            background:white;
            border:none;
            outline:none;
            box-shadow: 2px 5px 2px black;
            border-radius:50px;
        }
        ::-webkit-file-upload-button{
            border:none;
            background:#8a1702fa;
            border-radius:50px;
            height:40px;
            color:white;
            width:100px;
            box-shadow: 2px 0px 0px grey;
            
        }
</style>
<body>

<header>
    <div class="nav">
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1> 
    <ul>
        <li><a href="index.php"> Analyseur de symptomes</a></li>
        <li><a href="#">Profile</a></li>
        <li><a href="mes_animaux.php">Mes Animaux</a></li>
        <li><a href="aide_animale.php">Animaux</a></li>
        <li><a href="liste_vet.php">Chercher vétirinaire</a></li>


        <li><a href="aboutus.php">a propos</a></li>
        
    </ul>
    
    <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="logout.php">Déconnecter</a> </span>
</div></header>
    
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
<div class="col-xl-6 col-md-12">
                                                <div class="card user-card-full">
                                                    <div class="row m-l-0 m-r-0">
                                                        <div class="col-sm-4 bg-c-lite-green user-profile">
                                                            <div class="card-bloc text-center text-white">
                                                            <?php
            $get_image = "SELECT `pfp_profile` FROM `users` WHERE email = ? AND id_user= ? LIMIT 1";
                    $stmt_get_image = $conn->prepare($get_image);
                    $stmt_get_image->bind_param("ss", $_SESSION['email'],$id);
                    $stmt_get_image->execute();
                    $unfo_image=$stmt_get_image->get_result();
                     $row_userinfo = $unfo_image->fetch_assoc();



            ?>
                                                         
                                                                <div class="m-b-25">
                                                                <?php
                                                                        if($row_userinfo['pfp_profile']==NULL)
                                                                        {
                                                                           echo' <img id="profileImage" src="https://img.icons8.com/bubbles/100/000000/user.png" class="rounded-circle p-1 bg-primary" style="height:110px;  border-radius: 40%;" width="110">';
                                                                            
                                                                        }else{
                                                                           echo' <img id="profileImage" src="pfpi_pic/'.$row_userinfo['pfp_profile'].'" class="rounded-circle p-1 bg-primary" style="height:110px;  border-radius: 50%;" width="110">';
                                                                        }
                                                                     $stmt_get_image->close();

                                                                    ?>
                                                                    
                                                                   
                                                                </div>
                                                                
                                                                
                                                                <h6 class="f-w-600"><?=$data['nom'].' '.$data['prenom'] ?></h6>
                                                                <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" style="background-color:red; border-color:red; color:white; cursor:pointer;" class="btn btn-danger" name="delete_pfp" value="Supprimer Image" id="">
        <span class="text-danger"><?php if(isset($erreu)) echo $erreu; ?></span>
            
            <br><br>
       
         <input type="file" name="pic_profile" id="choose_file" onchange="previewImage(this)">
         <input style="background-color: #04B970; border-color:#0d6efd; color:white;cursor:pointer;width: 100px;height: 35px; border-radius:5px;" type="submit" class="btn save" name="save_pfp" value="Enregistrer" id="">
        

        <span class="text-danger"><?php if(isset($erreur)) echo $erreur; ?></span>
        </form>

        <script>
    function previewImage(input) {
        var file = input.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('profileImage').src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }
</script>
                                                                
                                                                <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="card-block">
                                                              <div class="info">  <h2 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h2>
                                                                <div class="row">
                                                                <div class="col-sm-6">
                                                                        <h3 class="m-b-10 f-w-600">Nom & Prénom</>
                                                                        <h4 class="text-muted f-w-400"><?=$data['nom'].' '.$data['prenom'] ?></h4>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <h3 class="m-b-10 f-w-600">Email</>
                                                                        <h4 class="text-muted f-w-400"><?=$data['email'] ?></h4>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <h3 class="m-b-10 f-w-600">Numéro de Téléphone</>
                                                                        <h4 class="text-muted f-w-400"><?=$data['telephone'] ?></h4>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <h3 class="m-b-10 f-w-600">Adresse</>
                                                                        <h4 class="text-muted f-w-400"><?=$data['address'] ?></h4>
                                                                    </div>
                                                                </div></div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <p class="m-b-10 f-w-600">Changer Mot de passe</p>
                                                                        <form action="" method="post">
                                                                        <div class="input-field">
                                                                        <input type="password" id="password" name="password" required />
                                                                        <label for="email">Mot de passe</label>
                                                                        <p style="color:red;"><?php if(isset($e_change)) echo $e_change; ?><p>
                                                                    </div>
                                                                    <div class="input-field">
                                                                        <input type="password" id="password" name="new_password" required />
                                                                        <label for="password">Nouveau Mot de passe</label>
                                                                        <p style="color:red;"><?php if(isset($e_cha)) echo $e_cha; ?><p>

                                                                    </div>
                                                                    <button style="background-color: #04B970;" type="submit" name="changer" >Changer</button>
                                                                    </form>




                                                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Supprimer le compte</h6>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <p class="m-b-10 f-w-600">Le compte sera supprimer définitivement</p>
                                                                        <form action="" method="post">
                                                                        <div class="input-field">
                                                                        <input type="password" id="password" name="password_delete" required />
                                                                        <label for="email">Mot de passe</label>
                                                                        <p style="color:red;"><?php if(isset($e_password_delete)) echo $e_password_delete; ?><p>
                                                                    </div>
                                                                    
                                                                    <button style="background-color: red; color:white;"  type="submit" name="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');" >Supprimer</button>
                                                                    </form>
        
                  
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             </div>
                                                </div>
                                            </div>

                                            <style>
    .card-block{
        display: flex;

        justify-content: space-between;
        background-color: transparent;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    }
    .col-sm-6{
        padding-top: 10px;
    }
    .card-bloc{
        margin-left: 20px;
    }
    </style>
</body>
</html>

