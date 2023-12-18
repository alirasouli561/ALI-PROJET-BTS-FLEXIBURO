<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: connecter.php");
    exit();
}


include 'base.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    
    $reservation_id = $_POST['reservation_id'];

    
    $sql = "DELETE FROM reservation WHERE reservation_id = ? AND user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);
        
        
        if ($stmt->execute()) {
            echo "Reservation cancelled successfully.";
        } else {
            echo "Error: Could not execute the cancellation query: " . $stmt->error;
        }
        
        
        $stmt->close();
    } else {
        echo "Error: Could not prepare the cancellation query: " . $conn->error;
    }
    
    
    $conn->close();
}


header("Location: list.php");
exit();
?>
