<?php
session_start();

if (!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");


if ($_POST){
    $id = $_POST['id'];
    $doc_num = $_POST['doc_num'];
    $doc_title = $_POST['doc_title'];
    $doc_start_date = $_POST['doc_start_date'];
    $doc_to_date = $_POST['doc_to_date'];
    $doc_status = $_POST['doc_status'];
    $doc_file_name = $_FILES["doc_file_name"]["name"];
   
   //อย่าลืม enctype="multipart/form-data" !!!!


    //$doc_file_name = isset($_FILES["doc_file_name"]["name"]) ? $_FILES["doc_file_name"]["name"] : ""; 

   /* print_r($_FILES);


    $doc_file_name = "";
    if(array_key_exists("doc_file_name", $_FILES)){
        $doc_file_name = $_FILES["doc_file_name"]["name"];
    }else{
        $doc_file_name = "";
    }
    echo $doc_file_name."Hello";
*/
    if($doc_file_name<>""){
        $sql = "UPDATE documents 
            SET doc_num = ?, 
                doc_title = ?,
                doc_start_date = ?,
                doc_to_date = ?,
                doc_status = ?,
                doc_file_name = ?
            WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssssi",$doc_num,$doc_title,$doc_start_date,$doc_to_date,$doc_status,$doc_file_name, $id);
        $stmt->execute();

        //uploadpart
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["doc_file_name"]["name"]);
        if (move_uploaded_file($_FILES["doc_file_name"]["tmp_name"], $target_file)) {
            //echo "The file ". htmlspecialchars( basename( $_FILES["doc_file_name"]["name"])). " has been uploaded.";
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }

    
    

        
    }else {
        $sql = "UPDATE documents 
            SET doc_num = ?, 
                doc_title = ?,
                doc_start_date = ?,
                doc_to_date = ?,
                doc_status = ?
            WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssssi",$doc_num,$doc_title,$doc_start_date,$doc_to_date,$doc_status,$id);
        $stmt->execute();
    }


    header("location: documents.php");
} else {
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM documents 
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
  <title>Edit Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style = "background-color:#B3DBD8">
    <div class="container">
        <h1>Edit Order</h1>
        <form action="editactor.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="doc_num">Order</label>
                <input type="text" class="form-control" name="doc_num" id="doc_num" value="<?php echo $row->doc_num;?>" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_title">Order name</label>
                <input type="text" class="form-control" name="doc_title" id="doc_title" value="<?php echo $row->doc_title;?>" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_start_date">Start Date</label>
                <input type="date" class="form-control" name="doc_start_date" id="doc_start_date" value="<?php echo $row->doc_start_date;?>" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_to_date">To Date</label>
                <input type="date" class="form-control" name="doc_to_date" id="doc_to_date" value="<?php echo $row->doc_to_date;?>" style = "background-color:#80cbc4">
            </div>
            <div class="form-group">
                <label for="doc_status">Status</label>
                <input type="radio"  name="doc_status" id="doc_status" value="Active"
                    <?php if($row->doc_status == "Active"){echo "checked";}?>> Active
                <input type="radio"  name="doc_status" id="doc_status" value="Expire"
                    <?php if($row->doc_status == "Expire"){echo "checked";}?>> Expire
            </div>
           
            <!-- <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="mySwitch" name="doc_status" value="yes" checked>
                <label class="form-check-label" for="mySwitch">Active</label>
            </div> -->


            <div class="form-group">
                <label for="doc_file_name">Uploads File</label>
                <input type="file" class="form-control" name="doc_file_name" id="doc_file_name" style = "background-color:#80cbc4">
            </div>
            <br>
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="button" class="btn btn-warning" onclick="history.back();" style = "background-color:#283593">Back</button>
            <button type="submit" class="btn btn-success" style = "background-color:#7986cb">Update</button>
        </form>
</body>

</html>