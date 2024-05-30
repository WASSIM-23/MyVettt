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




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Animaux</title>
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

    #myInput {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
 
}

#myTable {
  border-collapse: collapse; /* Collapse borders */
  width: 100%; /* Full-width */
  border: 1px solid #ddd; /* Add a grey border */
  font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
  text-align: left; /* Left-align text */
  padding: 12px; /* Add padding */
}

#myTable tr {
  /* Add a bottom border to all table rows */
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  /* Add a grey background color to the table header and on hover */
  background-color: #f1f1f1;
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
        color: purple;
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
    
    <span ><a href="logout.php">Déconecter</a> </span>
</div></header><?php if(isset($_SESSION['success']) && $_SESSION['success']!=""):?>
            <div class=" text-center alert alert-success" style="color: red;
    font-size: 20px;" role="alert">
            <?php
             {
                 echo $_SESSION['success'];
             }
                unset($_SESSION['success']);
            ?>
                 
            </div>
            <?php endif; ?><center>
<br>
  <center><h1 >Mes Animaux</h1></center>
<div class="container">
<input type="text" id="myInput" onkeyup="animale()" placeholder="Chercher des animaux..">
<br><br>
    <div style="overflow-x:auto;">
        <table class="table bg-white rounded shadow-sm  table-hover" id="myTable">
            <thead>
              <tr>
              <th>Numero</th>
                <th>Nom animale</th>
                <th>Date naissance</th>
                <th>Race</th>
                <th>Type</th>
                <th>Sexe</th>
                <th>Corpulence</th>
                <th>symptomes</th>
                <th>Maladie possible</th>
                <th>Detail</th>
                <th>Supprimer</th>
              </tr>
            </thead>
            <tbody>
                
            <?php 
                $i=1;

                 $get_locale=mysqli_query($conn,"SELECT * FROM `analyse` WHERE id_user='$id'");
                 if(mysqli_num_rows($get_locale) > 0)
                 {
     
                     while($data=mysqli_fetch_assoc($get_locale))
                     {
                         echo '
                         
                         
     
                         <tr>
                         <td>'.$i.'</td>
                             <td>'.$data["nom_animale"].'</td>
                             <td>'.$data['date_nai'].'</td>
                             <td>'.$data['race'].'</td>
                             <td>'.$data['type'].'</td>
                             <td>'.$data['sexe'].'</td>
                             <td>'.$data['corpulence'].'</td>
                             <td>'.$data['symptomes'].'</td>
                             <td>'.$data['Maladie_possible'].'</td>
                            
                            
                             <div class="text-center p-3">
                             <!-- Button trigger modal -->
                             <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop' . $data["id_analyse"] . '">
                                Detail
                             </button></td>
                             <td><a href="supprimer_animale.php?s='.$data['id_analyse'].'" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette animale ?\');" class="btn btn-danger">Supprimer</a></td>

                             
                             <!-- Modal -->
                             <div class="modal fade" id="staticBackdrop'.$data["id_analyse"].'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <form method="post">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                   <div class="modal-header">
                                     <h1 class="modal-title fs-5" id="staticBackdropLabel">informations</h1>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>
                                   <div class="modal-body  justify-content-center">
                                     <input type="hidden" value="'.$data["id_analyse"].'" name="bs" id="">
                                     <div class="mb-1">
                                     <p for="inputPrenom" class="col-sm text-start col-form-label">Nom animale</p>
                                       <div class="col-sm">
                                         <input type="text" name="prenom" value="'.$data["nom_animale"].'" class="form-control" id="inputPrenom" disabled>
                                       </div>
                                     </div>

                                         <div class="mb-1 text-center">
                                             <p for="inputNom" class="col-sm text-start col-form-label">Date naissance</p>
                                             <div class="col-sm">
                                               <input type="text" name="nom" value="'.$data['date_nai'].'" class="form-control" id="inputNom" disabled>
                                             </div>
                                       </div>
                                       <div class="mb-1">
                                       <p for="inputPrenom" class="col-sm text-start col-form-label">Race</p>
                                         <div class="col-sm">
                                           <input type="text" name="prenom" value="'.$data['race'].'" class="form-control" id="inputPrenom" disabled>
                                         </div>
                                       </div>
                                       <div class="mb-1">
                                     <p for="inputPrenom" class="col-sm text-start col-form-label">Type</p>
                                       <div class="col-sm">
                                         <input type="text" name="Date" value="'.$data["type"].'" class="form-control" id="inputDateDeNaissance" disabled>
                                       </div>
                                     </div>

                                       <div class="mb-1">
                                       <p for="inputPrenom" class="col-sm text-start col-form-label">Sexe</p>
                                         <div class="col-sm">
                                           <input type="text" name="" value="'.$data['sexe'].'" class="form-control" id="inputPrenom" disabled>
                                         </div>
                                       </div>
                                      

                                       <div class="mb-1">
                                       <p for="in" class="col-sm text-start col-form-label">Corpulence</p>
                                         <div class="col-sm">
                                         <select name="groupage" class="form-select" disabled>
                                         <option value="groupage" selected disabled>'.$data['corpulence'].'</option>
                                         
                                       </select>
                                         </div>
                                       </div>
                                       <div class="mb-1">
                                       <p for="inputPrenom" class="col-sm text-start col-form-label">Symptomes</p>
                                         <div class="col-sm">
                                           <input type="text" name="Mairie" value="'.$data["symptomes"].'" class="form-control" id="inputMairie" disabled>
                                         </div>
                                       </div>

                                       <div class="mb-1">
                                       <p for="inputNumber" class="col-sm text-start col-form-label">Maladie_possible</p>
                                         <div class="col-sm">
                                         <select name="jour" id="" class="form-select" disabled>
                                         <option value="jour" selected disabled>'.$data['Maladie_possible'].'</option>
                                         
                                             </select>
                                          

                                         </div>
                                       </div>
                                      
                                   </div>
                                   <div class="modal-footer">
                                      
                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                   </div>
                                   

                                 </div>
                               </div>
                               <form>
                             </div>
                             
                         </tr>';
                         $i++;
                         
                     }
                     
                     
                 }
     
            ?>
            </tbody>
          </table>
          </div>


<script>
function animale() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break; // Si une correspondance est trouvée dans une colonne, afficher la ligne
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

</script>           
        
            



</body>
</html>