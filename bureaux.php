
<?php
session_start(); 
include 'base.php';
  $sql = "SELECT * FROM espace WHERE type_espace='bureau'";
  $result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
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
    position: relative;
}

section {
  text-align: center;
  margin: 125px 0; 
}

.search-form {
  display: block;
}

.search-form label,
.search-form select,
.search-form input,
.search-form button {
  font-size: medium;
  margin: 5px;
}

.search-form select,
.search-form input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.search-form button {
  background-color: #005f73; 
  color: white; 
  padding: 8px 12px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}


@media (max-width: 768px) {
  .search-form select,
  .search-form input {
    width: 100%;
  }
}


</style>
</head>
<body>
  <nav class="mask">
  <a href="index.php"><h2>FlexiBuro</h2></a>
    <ul class="list">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="bureaux.php">Bureaux</a></li>
      <li><a href="salle.php">Salles</a></li>
      <li><a href="Entrepot.php">Entrepôt</a></li>
      <?php if (isset($_SESSION['login'])): ?>
        <li><a href="list.php">Réservation</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    <?php else: ?>
        <li><a href="connecter.php">Se connecter</a></li>
    <?php endif; ?>
  </ul>
</nav>

<section>
  <form class="search-form" action="search.php" method="get" onsubmit="return validateForm()">
    <label for="type_office">Type:</label>
    <select id="type_office" name="type">
      <option value="bureaux">Bureaux</option>
      <option value="salle">Salles</option>
      <option value="entrepot">Entrepôt</option>
    </select>
    <label for="search_office">Search:</label>
    <input type="text" id="search_office" name="query" placeholder="Entrez les critères de recherche">
    <button type="submit">Search</button>
  </form>
</section>

<script>
  function validateForm() {
    
    var selectedType = document.getElementById("type_office").value;

    
    var validTypes = ['bureaux', 'salle', 'entrepot'];
    if (!validTypes.includes(selectedType)) {
      alert("Invalid type");
      return false; 
    }

    return true; 
  }
</script>

<main>
  <?php
  while ($row = $result->fetch_assoc()) {
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
    
    <?php if ($row["disponibilite"]): ?>
  <form action="reservation.php" method="post">
    <input type="hidden" name="espace_id" value="<?php echo $row["espace_id"]; ?>">
    
    <label for="date_debut">Date de début:</label>
    <input type="date" id="date_debut" name="date_debut" required>
    
    <label for="date_fin">Date de fin:</label>
    <input type="date" id="date_fin" name="date_fin" required>
    
    <button type="submit" class="add">Réserver</button>
  </form>
<?php else: ?>
  <button class="add unavailable" disabled>Indisponible</button>
<?php endif; ?>


  </div>
  <?php
  }
  ?>
</main>

</body>
</html>
