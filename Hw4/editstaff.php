<?php
session_start();

if (!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะลบ
if ($_POST){
    $id = $_POST['id'];
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];

    $sql = "UPDATE staff
            SET stf_code = ?, 
            stf_name = ?
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $stf_code, $stf_name,$id);
    $stmt->execute();

    header("location: staff.php");
} else {
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM staff
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
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

<body style = "background-color:#B3DBD8" >
    <div class="container">
        <h1>Edit Employee</h1>
        <form action="editstaff.php" method="post">
            <div class="form-group">
                <label for="stf_code">ID</label>
                <input type="text" class="form-control" name="stf_code" id="stf_code" value="<?php echo $row->stf_code;?>" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="stf_name">Employee</label>
                <input type="text" class="form-control" name="stf_name" id="stf_name" value="<?php echo $row->stf_name;?>" style = "background-color:#80cbc4">
            </div>
            
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="submit" class="btn btn-success" style = "background-color:#7986cb">Update</button>
        </form>
</body>

</html>