<?php
session_start();
if(isset($_SESSION['idUser']))
{
    header('location:profile_client.php');
    die;
}else if(isset($_SESSION['idVet']))
{
    header('location:profile_vet.php');
    die;
}

require_once "../configuration/connexion.php";
$error=0;

if(isset($_POST['login']))
{
    if(isset($_POST['email']) && !empty($_POST['email']))
  {
    
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    

  }else
  {
     $error=1;
     $e_email="obligatoire!";
  }

  if(isset($_POST['password']) && !empty($_POST['password']))
  {

      $password =mysqli_real_escape_string($conn,$_POST['password']);

  }else
  {
     $error=1;
      $e_password="Obligatoire!";
  }


  if($error==0)
  {
        $check=mysqli_query($conn,"SELECT email,password,id_user FROM users WHERE email='$email' LIMIT 1");
        if(mysqli_num_rows($check)>0){
            $get_info=mysqli_fetch_assoc($check);

            if(password_verify($password,$get_info['password']))
            {
                $_SESSION['email']=$get_info['email'];
                $_SESSION['idUser']=$get_info['id_user'];

                if(!isset($_GET['p']) || empty($_GET['p']))
                {

                    header('location:profile_client.php');
                    die;
                }else if(isset($_GET['p']) && !empty($_GET['p']))
                        {
                            $page=$_GET['p'];
                            header("location:$page.php");
                            die;
                        }
            }else
            {
                $_SESSION['login'] ="Email or password incorrect !";
            }
        }else
        {
            $_SESSION['login'] ="Email or password incorrect !";

        }
  }

}


?>


<!DOCTYPE html>
<!-- coding by helpme_coder -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Login </title>
    <link rel="stylesheet" href="style.css" />
</head>
<style>
     #d{
                text-decoration: none;
        color: purple;
        
            }
</style>

<body>
<header>
    <div class="nav">
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1> 
    <ul>
        <li style="top:5px"><a href="index.php"> Analyseur de symptomes</a></li>
        <li style="display:flex;"> <a href="">Animaux  <img src="cadenas.png" alt="" width="20px"></a></li>
        <li style="display:flex;"> <a href="">Chercher vétirinaire <img src="cadenas.png" alt="" width="20px"></a></li>
        <li style="top:5px"><a href="aboutus.php">A propos</a></li>
        
        
        </a> </li>
        
    </ul>
    
    <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row"><a href="choixsignup.php">Créé compte</a> </span>
</div></header><center>
  <div class="container">
    <form  method="POST">
        <h2>Connexion</h2>
        <?php if(isset($_SESSION['succes']) && $_SESSION['succes'] !=""): ?>
                              <div class="alert alert-success alert-dismissible">
                                <?php

                                    {

                                     
                                     echo '<p style="color: rgb(105, 167, 11);">'.$_SESSION['succes'].'</p>';
                                    }
                                    unset($_SESSION["succes"]);

                                ?>
                                </div>
                                <?php endif;?>

        <?php if(isset($_SESSION['login']) && $_SESSION['login'] !=""): ?>
                              <div class="alert alert-success alert-dismissible">
                                <?php

                                    {

                                     
                                     echo '<p style="color:red;">'.$_SESSION['login'].'</p>';
                                    }
                                    unset($_SESSION["login"]);

                                ?>
                                </div>
                                <?php endif;?>
        <div class="input-field">
            <input type="email" id="email" name="email" required />
            <label for="email">Entrer l'email</label>
        </div>
        <div class="input-field">
            <input type="password" id="password" name="password" required />
            <label for="password">Entrer le mot de passe</label>
        </div>
        
        <button type="submit" name="login" >Connexion</button>
        <div class="create-account">
            <p>Vous n'avez pas de compte? <a href="choixsignup.php">Créer un compte</a></p>
        </div>
    </form>
</div>

    </div></center>
    
</body>

</html>