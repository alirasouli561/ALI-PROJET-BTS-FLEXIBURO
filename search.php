<?php
session_start();
include 'base.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    
    $typeMapping = [
        'bureaux' => 'bureau',
        'salle' => 'salle',
        'entrepot' => 'entrepot',
    ];

    
    if (!array_key_exists($type, $typeMapping)) {
        die("Invalid type");
    }

    
    $mappedType = $typeMapping[$type];

    
    $stmt = $conn->prepare("SELECT * FROM espace WHERE type_espace = ? AND description LIKE ?");
    $queryParam = "%$query%";
    $stmt->bind_param("ss", $mappedType, $queryParam);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>Search Results</title>';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<link rel="stylesheet" href="./style.css">';
        echo '</head>';
        echo '<body>';

        
        echo '<main>';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<div class="image">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="Image de l\'espace">';
            echo '</div>';
            echo '<div class="caption">';
            echo '<p class="description">' . $row['description'] . '</p>';
            echo '<p class="tarif">' . $row['tarif_par_jour'] . '<b>€ par jour</b></p>';
            echo '<p class="disponibilite">';
            echo $row['disponibilite'] ? '<span class="available">Disponible</span>' : '<span class="unavailable">Indisponible</span>';
            echo '</p>';

            if ($row['disponibilite']) {
                echo '<form action="reservation.php" method="post">';
                echo '<input type="hidden" name="espace_id" value="' . $row['espace_id'] . '">';
                echo '<label for="date_debut">Date de début:</label>';
                echo '<input type="date" id="date_debut" name="date_debut" required>';
                echo '<label for="date_fin">Date de fin:</label>';
                echo '<input type="date" id="date_fin" name="date_fin" required>';
                echo '<button type="submit" class="add">Réserver</button>';
                echo '</form>';
            } else {
                echo '<button class="add unavailable" disabled>Indisponible</button>';
            }

            echo '</div>';
            echo '</div>';
        }
        echo '</main>';

        echo '</body>';
        echo '</html>';

        
        $stmt->close();
    } else {
        

echo '<script>';
echo 'alert("Aucun espace correspondant trouvé pour ' . $type . '");';
echo 'setTimeout(function() { window.location.href = "' . $type . '.php"; }, 100);'; 
echo '</script>';

    }

    
    $conn->close();
    exit(); 
}
?>