<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: connecter.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'base.php';
    
    
    $espace_id = $_POST['espace_id'];
    $user_id = $_SESSION['user_id']; 
    $date_debut = $_POST['date_debut']; 
    $date_fin = $_POST['date_fin']; 
    
    $conn->begin_transaction();
    
    
    $sql = "INSERT INTO reservation (date_debut, date_fin, statut_de_la_reservation, espace_id, user_id) VALUES (?, ?, 1, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssii", $date_debut, $date_fin, $espace_id, $user_id);
        
        
        if ($stmt->execute()) {
            $update_sql = "UPDATE espace SET disponibilite = 0 WHERE espace_id = ?";
            if ($update_stmt = $conn->prepare($update_sql)) {
                $update_stmt->bind_param("i", $espace_id);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                echo "Error: Could not prepare the update query: " . $conn->error;
               
                $conn->rollback();
                exit();
            }
            
           
            $conn->commit();

            header("Location: list.php"); 
            exit();
        } else {
            echo "Error: Could not execute the reservation query: " . $stmt->error;
            $conn->rollback();
        }
        
        $stmt->close();
    } else {
        echo "Error: Could not prepare the reservation query: " . $conn->error;
        $conn->rollback();
    }
    
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
