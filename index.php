<?php
session_start(); 
include 'base.php';

$sql = "(SELECT * FROM espace WHERE type_espace='bureau' ORDER BY RAND() LIMIT 1) 
        UNION
        (SELECT * FROM espace WHERE type_espace='salle' ORDER BY RAND() LIMIT 1)
        UNION
        (SELECT * FROM espace WHERE type_espace='entrepot' ORDER BY RAND() LIMIT 1)";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Flexiburo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
  <style>
    body {
    height: 100%;
    width: 100%;
    background-image: linear-gradient(#313030,#333), url(image.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    position: relative;}

    .welcome-banner {
  text-align: center;
  color: white;
  padding: 3rem 1rem;
  background: rgba(0, 0, 0, 0.6);
  margin-top: 100px; 
}

.introduction {
    background: #100b0bb8;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 80px;
    margin: 152px auto;
    width: 1400px;
    color: #333333;
}

.introduction h2 {
  color: white; 
  font-size: 2.5rem; 
  margin-bottom: 20px; 
  text-transform: uppercase; 
  font-weight: 700; 
}

.introduction p {
  font-size: 1rem; 
  line-height: 1.6; 
  margin-bottom: 20px; 
  color: white; 
  text-align: justify; 
}


@media (min-width: 1500px) {
.introduction {
    padding: 60px;
    margin: 199px auto;
}
  .introduction h2 {
    font-size: 3rem; 
  }

  .introduction p {
    font-size: 1.125rem; 
  }
}


@media (min-width: 640px) {
  .welcome-banner h1 {
    font-size: 5rem; 
  }

  .welcome-banner p,
  .introduction h2,
  .introduction p {
    font-size: 2.4rem; 
  }
}
.welcome-image {
  height: 25px; 
  width: auto;
}

.offices-display {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-top: 20px;
    flex-wrap: wrap;
    align-content: stretch;
    justify-content: space-around;
}

.card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width: 30%;
    overflow: hidden;
    height: min-content;
}

.image img {
  width: 100%;
  height: auto;
  display: block;
}

.caption {
  padding: 15px;
  text-align: center;
}

.description, .tarif, .disponibilite {
  margin-bottom: 10px;
}

.add {
    display: block;
    background-color: #4CAF50;
    margin-bottom: 50px;
    color: white;
    padding: 18px 30px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    width: 150px;
}

.add.unavailable {
  background-color: #ccc;
}

@media (max-width: 768px) {
  .card {
    width: 95%; 
  }
}


</style>
</head>
<body>


<nav class="mask">
  
  <a href="index.php" class="brand"><h2>FlexiBuro</h2></a>
  
  <ul class="list">
    <li><a href="index.php">Accueil</a></li>
    <li><a href="bureaux.php">Bureaux</a></li>
    <li><a href="salle.php">Salles</a></li>
    <li><a href="Entrepot.php">Entrepôt</a></li>
  </ul>

  <div class="navbar-right">
    <?php if (isset($_SESSION['login'])): ?>
      <br><img src="login.png" class="welcome-image">&nbsp;<?php echo htmlspecialchars($_SESSION['login']); ?></span>
        <a href="list.php">Réservation</a>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="connecter.php">Se connecter</a>
    <?php endif; ?>
  </div>
</nav>
<br><br>
<div class="container">
<div class="christmas">
  <div class="tree">
    <div class="chain"></div>
  </div>
  <div class="lights">
    <div class="light1"></div>
    <div class="light2"></div>
    <div class="light3"></div>
    <div class="light4"></div>
    <div class="light5"></div>
    <div class="light6"></div>
    <div class="light7"></div>
    <div class="light8"></div>
    <div class="light9"></div>
    <div class="light10"></div>
  </div>
  <div class="balls">
    <div class="ball1"></div>  
  </div>
  <div class="star"></div>
  <div class="gift"></div>
  <div class="ribbon"></div>
  <div class="gift2"></div>
  <div class="ribbon2"></div>
  <div class="gift3"></div>
  <div class="ribbon3"></div>
  <div class="shadow"></div>
</div>
    </div>

<section class="introduction">
  <h2>Découvrez nos offres</h2>
  <p>Que vous recherchiez un bureau commercial pour démarrer votre activité, une salle de réunion pour vos conférences, ou un entrepôt spacieux pour votre stock, FlexiBuro vous offre des solutions sur mesure adaptées à vos besoins.
  Parcourez notre site pour en savoir plus sur nos espaces disponibles et trouvez l'environnement de travail idéal pour faire prospérer votre entreprise.
  </p>
</section>
<section class="offices-display">
<?php
while ($row = $result->fetch_assoc()) {

  $targetPage = '';
    switch ($row["type_espace"]) {
        case 'bureau':
            $targetPage = 'bureaux.php';
            break;
        case 'salle':
            $targetPage = 'salle.php';
            break;
        case 'entrepot':
            $targetPage = 'entrepot.php';
            break;
    }
?>
    <div class="card">
        <div class="image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" alt="Image de l'espace">
        </div>
        <div class="caption">
            <p class="description"><?php echo $row["description"]; ?></p>
            <p class="tarif"><?php echo $row["tarif_par_jour"]; ?><b>€ par jour</b></p>
            <p class="disponibilite">
                <?php echo $row["disponibilite"] ? '<span class="available">Disponible</span>' : '<span class="unavailable">Indisponible</span>'; ?>
            </p>
        </div>
        
        <a href="<?php echo $targetPage; ?>?espace_id=<?php echo $row["espace_id"]; ?>" class="add">Découvrir</a>
    </div>
<?php
}
?>

</section>
</body>
</html>

<style>

.container {
  display: flex;
    align-items: center;
    justify-content: center;
    height: 8vh;
    margin-right: 1064px;
    margin-top: 127px;
    }

.christmas {
  position: relative;
}

.tree {
  position: relative;
  background-color: #685044;
  width: 30px;
  height:80px;
  top:100px;
  transform-style: preserve-3d;
}

.tree:before {
  content:"";
  position: relative;
  width: 0;
  height: 0;
  border-left: 90px solid transparent;
  border-right: 90px solid transparent;
  border-bottom: 270px solid #127475;
  border-radius: 30px;
  top:-250px;
  left:-75px;
}

.tree:after {
  content:"";
  position: relative;
  width: 0;
  height: 0;
  border-right: 90px solid transparent;
  border-bottom: 270px solid #0e9594;
  border-bottom-right-radius: 30px;
  top:-250px;
  left:-165px;
}

.chain {
  width: 85px;
  height: 85px;
  border: solid 3px #333;
  border-radius: 50%;
  top: -185px; 
  left: -35px; 
  position: absolute;
  transform: rotate3d(8, 0.1, -5, 75deg); 
  box-sizing: border-box;
  backface-visibility: visible !important;
  z-index:5;
}

.chain2 {
  width: 145px;
  height: 135px;
  border: solid 3px #333;
  border-radius: 50%;
  top: -115px; 
  left: -65px; 
  position: absolute;
  transform: rotate3d(8, 0.1, -5, 75deg); 
  box-sizing: border-box;
  backface-visibility: visible !important;
  z-index:5;
  
}

.shadow {
  background-color: rgba(0,0,0,0.07);
  position: absolute;
  width: 250px;
  height: 30px;
  border-radius:50%;
  top:170px;
  left:-115px;
  z-index:-1;
}

.star {
  margin: 50px 0;
  position: absolute;
  display: block;
  width: 0px;
  height: 0px;
  border-right: 25px solid transparent;
  border-bottom: 17.5px solid #f9dc5c;
  border-left: 25px solid transparent;
  transform: rotate(35deg);
  top:-190px;
  left:-9px;
    }

.star:before {
      border-bottom: 20px solid #f9dc5c;
      border-left: 7.5px solid transparent;
      border-right: 7.5px solid transparent;
      position: absolute;
      height: 0;
      width: 0;
      top: -12.5px;
      left: -17.5px;
      display: block;
      content: '';
      transform: rotate(-35deg);
    }

.star:after {
      position: absolute;
      display: block;
      top: 0.75px;
      left: -26.25px;
      width: 0px;
      height: 0px;
      border-right: 25px solid transparent;
      border-bottom: 17.5px solid #f9dc5c;
      border-left: 25px solid transparent;
      transform: rotate(-70deg);
      content: '';
    }

.lights {
  position: absolute;
  
}

.light1 {
   position: absolute;
   width: 15px; 
   height: 15px;
   border-radius: 10px 150px 30px 150px;
}

.light1 {
  background-color: #ff595e;
  top:-100px;
  left:-35px;
  transform: rotate(40deg);
  box-shadow: 1px 1px 15px #faf3dd;
}

.light2 {
  position: absolute;
  background-color: #ffca3a;
  top:-95px;
  left:-10px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light3 {
  position: absolute;
  background-color: #6a4c93;
  top:-105px;
  left:15px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light4 {
  position: absolute;
  background-color: #1982c4;
  top:-118px;
  left:35px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light5 {
  position: absolute;
  background-color: #1982c4;
  top:12px;
  left:-55px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light6 {
  position: absolute;
  background-color: #8ac926;
  top:15px;
  left:-25px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light7 {
  position: absolute;
  background-color: #ff595e;
  top:10px;
  left:2px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light8 {
  position: absolute;
  background-color: #ffca3a;
  top:-2px;
  left:27px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light9 {
  position: absolute;
  background-color: #9e0059;
  top:-17px;
  left:50px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.light10 {
  position: absolute;
  background-color: #4361ee;
  top:-40px;
  left:68px;
  box-shadow: 1px 1px 15px #faf3dd;
  width: 15px; 
  height: 15px;
  border-radius: 10px 150px 30px 150px;
  transform: rotate(40deg);
}

.gift {
  position: absolute;
  width: 60px;
  height: 50px;
  background-color: #ffc857;
  top:130px;
  left:30px;
  box-shadow: inset -8px 0 0 rgba(0,0,0,0.07);
  
}

.gift:before {
  content:"";
  position: absolute;
  width:70px;
  height:15px;
  background-color: #ffc857;
  left:-5px;
  box-shadow: inset -8px -4px 0 rgba(0,0,0,0.07);
  
}

.gift:after {
  content:"";
  background-color: #db3a34;
  width: 10px;
  height:50px;
  position: absolute;
  left:25px;
}

.ribbon {
  position: absolute;
  width: 20px;
  height: 10px;
  border: 3px solid #db3a34;
  border-radius:50%;
  transform: skew(15deg, 15deg);
  top:116px;
  left:35px;
}

.ribbon:before {
  content:"";
  position: absolute;
  width: 20px;
  height: 10px;
  border: 3px solid #db3a34;
  border-radius:50%;
  transform: skew(-15deg, -20deg);
  left:22px;
  top:-8px;
}

.gift2 {
  position: absolute;
  width: 50px;
  height: 40px;
  background-color: #08bdbd;
  top:140px;
  left:-65px;
  box-shadow: inset -8px 0 0 rgba(0,0,0,0.07);
  
}

.gift2:before {
  content:"";
  position: absolute;
  width:60px;
  height:15px;
  background-color: #08bdbd;
  left:-5px;
  box-shadow: inset -8px -4px 0 rgba(0,0,0,0.07);
  
}

.gift2:after {
  content:"";
  background-color: #abff4f;
  width: 10px;
  height:40px;
  position: absolute;
  left:15px;
}

.gift3 {
  position: absolute;
  width: 40px;
  height: 30px;
  background-color: #7678ed;
  top:150px;
  left:-85px;
  box-shadow: inset -8px 0 0 rgba(0,0,0,0.07);
  
}

.gift3:before {
  content:"";
  position: absolute;
  width:50px;
  height:10px;
  background-color: #7678ed;
  left:-5px;
  box-shadow: inset -8px -4px 0 rgba(0,0,0,0.07);
  
}

.gift3:after {
  content:"";
  background-color: #f7b801;
  width: 7px;
  height:30px;
  position: absolute;
  left:15px;
}

.ribbon2 {
  position: absolute;
  width: 15px;
  height: 7px;
  border: 3px solid #abff4f;
  border-radius:50%;
  transform: skew(15deg, 15deg);
  top:129px;
  left:-65px;
}

.ribbon2:before {
  content:"";
  position: absolute;
  width: 15px;
  height: 7px;
  border: 3px solid #abff4f;
  border-radius:50%;
  transform: skew(-15deg, -20deg);
  left:15px;
  top:-8px;
}

.ribbon3 {
  position: absolute;
  width: 12px;
  height: 5px;
  border: 3px solid #f7b801;
  border-radius:50%;
  transform: skew(15deg, 15deg);
  top:142px;
  left:-85px;
}

.ribbon3:before {
  content:"";
  position: absolute;
  width: 12px;
  height: 5px;
  border: 3px solid #f7b801;
  border-radius:50%;
  transform: skew(-15deg, -20deg);
  left:15px;
  top:-8px;
}

.balls {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #db3a34;
  top:15px;
  left: -15px;
}

.balls:before {
  content:"";
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #ffc857;
  top:35px;
  left: -15px;
}

.balls:after {
  content:"";
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #f07167;
  top:20px;
  left: 45px;
}

.ball1 {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #fae588;
  top:-90px;
  left:20px;
  
}

.ball1:before {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #fae588;
  content:"";
  top:170px;
  left:50px
}

.light1, .light2, .light3, .light4, .light5, .light6, .light7, .light8, .light9, .light10 {
  -webkit-animation: flash 6s infinite;
}

@-webkit-keyframes flash {
  20%, 24%, 55% {box-shadow: none;}
 0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
 box-shadow: 0 0 5px #f5de93, 0 0 15px #f5de93, 0 0 20px #f5de93, 0 0 40px #f5de93, 0 0 60px #decea4, 0 0 10px #d6c0a5, 0 0 98px #ff0000;
  }
}

</style>