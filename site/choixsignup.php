<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="signin.css" />
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
    background-repeat:repeat ;
    width: 100%;
    height: 100%;
}
.nav{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 97PX;
    background-color: #c4c2c25e;
  }
  header h1{
    margin-left: 30px;
   
  }
  
  
  .nav ul {
    display: flex;
    align-items: center;
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
                width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                
                }
                span :hover{
                    background-color: #837f8696;
                    box-shadow: 0 0 25px    #837f8696;
                }
                .client a{
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .vétérinaire a{
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }</style>
                <body>
                    

<header>
    <div class="nav">
    <h1><img src="logo.jpg" alt="logo" height="80px" width="80px" style="border-radius:50%;" ></h1> 
    <ul>
    <li style="top:2px"><a href="index.php"> Analyseur de symptomes</a></li>
        <li style="display:flex;"> <a href="">Animaux<img src="cadenas.png" alt="" width="20px"> </a></li>
        <li style="display:flex;"> <a href="">Chercher vétirinaire <img src="cadenas.png" alt="" width="20px"> </a></li>
        
    </ul>
    
    <span><a href="choiconnecter.php">Se Connecter </a> </span>
</div></header>
    </div><center>
        <h1>Vous etes</h1>
    <div class="clientordoctor">
        <div class="client  choisse">
            <a href="inscription.php">Un particulier</a>
          
        </div>
        <div class="vétérinaire choisse">
            <a href="signin2.php">Un établissement</a>
            
        </div>
    </div></center>
</body>
</html>