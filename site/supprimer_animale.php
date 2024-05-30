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





    if(isset($_GET['s']) && !empty($_GET['s']))
    {
        $id_animale=$_GET['s'];
        $delete_animale=mysqli_query($conn,"DELETE FROM analyse WHERE id_analyse='$id_animale' LIMIT 1");

        if($delete_animale)
        {
            header('location:mes_animaux.php');
            die;
        }
    }




?>