<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Insert Drink</title>
    <style type="text/css">
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        h3 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        img {
            transition: transform 0.25s ease;
        }

        img:hover {
            transform: scale(1.5);
        }
    </style>
</head>

<body>
    <?php
    require 'conn.php';

    $sql_select = 'SELECT * FROM menu ORDER BY MenuID';
    $stmt_s = $conn->prepare($sql_select);
    $stmt_s->execute();

    if (isset($_POST['submit'])) {
        if (!empty($_POST['DrinkID']) && !empty($_POST['DrinkName'])) {
            $DrinkID = $_POST['DrinkID'];
            $MenuID = $_POST['MenuID'];
            $DrinkName = $_POST['DrinkName'];
            $price = $_POST['price'];

            $uploadFile = $_FILES['img']['name'];
            $tmpFile = $_FILES['img']['tmp_name'];

            $fullpath = "./img/" . $uploadFile;
            move_uploaded_file($tmpFile, $fullpath);

            $sql = "INSERT INTO drink (DrinkID, MenuID, DrinkName, price, img) VALUES (:DrinkID, :MenuID, :DrinkName, :price, :img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':DrinkID', $DrinkID);
            $stmt->bindParam(':MenuID', $MenuID);
            $stmt->bindParam(':DrinkName', $DrinkName);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':img', $uploadFile);

            try {
                if ($stmt->execute()) {
                    echo '
                    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            swal({
                                title: "Success!",
                                text: "Successfully added new drink",
                                type: "success",
                                timer: 2500,
                                showConfirmButton: false
                            }, function() {
                                window.location.href = "index.php";
                            });
                        });
                    </script>';
                } else {
                    echo 'Fail to add new drink';
                }
            } catch (PDOException $e) {
                echo 'Fail! ' . $e;
            }
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4"> <br>
                <h3>Insert Drink Form</h3>
                <form action="Adddrink.php" method="POST" enctype="multipart/form-data">
                    <input type="text" placeholder="Enter Drink ID" name="DrinkID" required>
                    <br><br>
                    <input type="text" placeholder="Drink Name" name="DrinkName" required>
                    <br><br>
                    <input type="number" placeholder="Price" name="price">
                    <br><br>
                    <label>Select Menu</label>
                    <select name="MenuID">
                        <?php
                        while ($cc = $stmt_s->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $cc['MenuID'] . "'>" . $cc['MenuName'] . "</option>";
                        }
                        ?>
                    </select>
                    <br><br>
                    Attach Image:
                    <input type="file" name="img" required>
                    <br><br>
                    <input type="submit" value="Submit" name="submit" />
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8"