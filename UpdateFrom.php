<?php
require 'conn.php';

$sql_select = 'SELECT * FROM menu ORDER BY MenuID';
$stmt_s = $conn->prepare($sql_select);
$stmt_s->execute();

if (isset($_GET['DrinkID'])) {
    $query_select = 'SELECT * FROM drink WHERE DrinkID=?';
    $stmt = $conn->prepare($query_select);
    $params = array($_GET['DrinkID']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $query_update = 'UPDATE drink SET MenuID=?,DrinkName=?,price=? where DrinkID=?';
        $stmt = $conn->prepare($query_update);


        $MenuID = $_POST['MenuID'];
        $DrinkName = $_POST['DrinkName'];
        $price = $_POST['price'];
        $DrinkID = $_POST['DrinkID'];

        $stmt->bindParam(1, $MenuID, PDO::PARAM_STR);
        $stmt->bindParam(2, $DrinkName, PDO::PARAM_STR);
        $stmt->bindParam(3, $DrinkID, PDO::PARAM_INT);
        $stmt->bindParam(4, $price, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                <script type="text/javascript">        
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "Successfully updated  information",
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
            echo 'Failed to update  information';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Update Drink</title>
    <style>
        .container {
            margin-top: 50px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .row {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="Update.php?DrinkID=<?php echo $result['DrinkID']; ?>" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label for="DrinkID">รหัสเครื่องดื่ม:</label>
                    <input type="text" name="DrinkID" class="form-control" required value="<?php echo $result['DrinkID']; ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label for="DrinkName">ชื่อเครื่องดื่ม:</label>
                    <input type="text" name="DrinkName" class="form-control" required value="<?php echo $result['DrinkName']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="MenuID">เมนู:</label>
                    <select name="MenuID" class="form-select">
                        <?php
                        while ($cc = $stmt_s->fetch(PDO::FETCH_ASSOC)) :
                        ?>
                            <option value="<?php echo $cc["MenuID"];  ?>">
                                <?php echo $cc["MenuName"]; ?>
                            </option>
                        <?php
                        endwhile;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price">ราคา:</label>
                    <input type="number" name="price" class="form-control" required value="<?php echo $result['price']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="submit" name="submit" value="แก้ไขข้อมูล" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>