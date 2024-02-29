<?php
echo 'hello ' . $_POST['DrinkID'];
if (isset($_POST['DrinkID'])) {


    require 'conn.php';
    $sql =  "UPDATE drink 
            SET MenuID = :MenuID,
            price = :price,
            DrinkName = :DrinkName
            WHERE DrinkID = :DrinkID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':DrinkName', $_POST['DrinkName']);
    $stmt->bindParam(':price', $_POST['price']);
    $stmt->bindParam(':MenuID', $_POST['MenuID']);
    $stmt->bindParam(':DrinkID', $_POST['DrinkID']);


    echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    try {
        if ($stmt->execute()) {
            echo '
                <script type="text/javascript">

                    $(document).ready(function(){
                    
                        swal({
                            title: "Success!",
                            text: "Successfully update customer information",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        }, function(){
                            window.location.href = "index.php";
                        });
                    });
                    
                </script>
                ';
        } else {
            echo 'Failed to execute the update statement.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
