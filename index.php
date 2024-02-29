<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>project</title>
    <style>
        /* Additional CSS for styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        h3 {
            margin-bottom: 20px;
        }

        th {
            text-align: center;
        }

        img {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12"> <br>
                <h3>DRINK <a href="Adddrink.php" class="btn btn-info float-end">+เพิ่มข้อมูลเครื่องดื่ม</a>
                </h3> <br />
                <table id="drinkTable" class="display table table-striped  table-hover table-responsive table-bordered ">

                    <thead align="center">
                        <tr>
                            <th width="10%">รหัสเครื่องดื่ม</th>
                            <th width="10%">ชื่อเมนู</th>
                            <th width="10%">ชื่อเครื่องดื่ม</th>
                            <th width="10%">ราคา</th>
                            <th width="20%">รูปภาพ</th>
                            <th width="5%">แก้ไข</th>
                            <th width="5%">ลบ</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        require 'conn.php';
                        $query = "SELECT menu.MenuName, drink.DrinkName,drink.DrinkID,drink.price,drink.img
                        FROM menu,drink
                        WHERE menu.MenuID=drink.menuID ";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        foreach ($result as $r) { ?>
                            <tr>
                                <td>
                                    <?= $r['DrinkID'] ?>
                                </td>
                                <td>
                                    <?= $r['MenuName'] ?>
                                </td>
                                <td>
                                    <?= $r['DrinkName'] ?>
                                </td>
                                <td align="right"><?= $r['price'] ?></td>

                                <td><img src="./img/<?= $r['img']; ?>" width="50px" height="50" alt="img" onclick="enlargeImg()" id="img"></td>

                                <td><a href="UpdateFrom.php?DrinkID=<?= $r['DrinkID'] ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                                <td><a href="Delete.php?DrinkID=<?= $r['DrinkID'] ?> " class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ลบ</a></td>

                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#drinkTable').DataTable();
        });
    </script>
</body>

</html>