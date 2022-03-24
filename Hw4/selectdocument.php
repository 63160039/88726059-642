<!DOCTYPE html>
<html lang="en">

<head>
    <title> คำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style = "background-color:#B3DBD8">
    <div align =center class="container">
    <h1 align =right>ค้นหารายชื่อการแต่งตั้ง&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <a href='documents.php'><span class='glyphicon glyphicon-home'></span></a></h1>
        <form align =center action="#" method="post">
            <input type="text" name="kw" placeholder="Enter document name" value="" size=140 style = "background-color:#80cbc4">
            <button type="submit" class="glyphicon glyphicon-search btn btn-info"></button>
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT DISTINCT documents.* 
FROM documents LEFT JOIN doc_staff ON documents.id=doc_staff.doc_id
      LEFT JOIN staff ON doc_staff.stf_id=staff.id 
WHERE concat(doc_num, doc_title,stf_name) LIKE ?
ORDER BY doc_num;";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo  "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Order</th>
                                <th scope='col'>Order Name</th>
                                <th scope='col'>Start Date</th>
                                <th scope='col'>To Date</th>
                                <th scope='col'>Status</th>
                                <th scope='col'>File Name</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
             
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num &emsp;</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</body>

</html>