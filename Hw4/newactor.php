<?php
session_start();

if (!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะเพิ่ม
if ($_POST){
    $doc_num = $_POST['doc_num'];
    $doc_title = $_POST['doc_title'];
    $doc_start_date = $_POST['doc_start_date'];
    $doc_to_date = $_POST['doc_to_date'];
    $doc_status = $_POST['doc_status'];
    $doc_file_name = $_POST['doc_file_name'];
    

    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB

    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง actor
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql = "INSERT 
            INTO documents (doc_num, doc_title,doc_start_date,doc_to_date,doc_status,doc_file_name) 
            VALUES (?, ?, ?,?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $doc_num, $doc_title,$doc_start_date, $doc_to_date,$doc_status,$doc_file_name);
    $stmt->execute();

    header("location: documents.php");
}
else{
    echo "<div align = center><h1><span class='glyphicon glyphicon-heart-empty'> Welcome ".$_SESSION['stf_name'] . "</span></h1></div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>php db demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#B3DBD8">
    <div class="container">
        <h1>Add Order</h1>
        <form action="newactor.php" method="post">
            <div class="form-group">
                <label for="doc_num">Order</label>
                <input type="text" class="form-control" name="doc_num" id="doc_num" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_title">Order Name</label>
                <input type="text" class="form-control" name="doc_title" id="doc_title" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_start_date">Start Date</label>
                <input type="text" class="form-control" name="doc_start_date" id="doc_start_date" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_to_date">To Date</label>
                <input type="text" class="form-control" name="doc_to_date" id="doc_to_date" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_status">Status</label>
                <input type="radio"  name="doc_status" id="doc_status" value="Active"> Active
                <br>&emsp;&emsp;&nbsp;&nbsp;
               <input type="radio"  name="doc_status" id="doc_status" value="Expire">Expire
            </div>
            <div class="form-group">
                <label for="doc_file_name">File Name</label>
                <input type="file" class="form-control" name="doc_file_name" id="doc_file_name" style = "background-color:#80cbc4">
            </div>
            <br>
            <button type="button" class="btn btn-warning" onclick="history.back();" style = "background-color:#283593">Back</button>
            <button type="submit" class="btn btn-success" style = "background-color:#7986cb">Save</button>
        </form>
</body>

</html>