<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
  
if(isset($_POST['add']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$sql="INSERT INTO  tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice) VALUES(:bookname,:category,:author,:isbn,:price)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
$query->bindParam(':price',$price,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Retrived";
header('location:dashboard.php');
}
} 
  ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">USER DASHBOARD</h4>
                
                            </div>

        </div>
             
        <div class="panel-body">
            <form role="form" method="post" action="issued-books.php">
                <div class="form-group">
                    <label> Districts</label>
                    <select class="form-control" name="category">
                    <option value=""> Select District</option>
                        <?php 
                        $status=1;
                        $sql = "SELECT * from  tblcategory where Status=:status";
                        $query = $dbh -> prepare($sql);
                        $query -> bindParam(':status',$status, PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {               ?>  
                        <option value="<?php echo htmlentities($result->CategoryName);?>"><?php echo htmlentities($result->CategoryName);?></option>
                        <?php }} ?> 
                     </select>
                </div>


<div class="form-group">
<label> Areas</label>
<select class="form-control" name="author">
<option value=""> Select Area</option>
<?php 

$sql = "SELECT * from  tblauthors ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->AuthorName);?>"><?php echo htmlentities($result->AuthorName);?></option>
 <?php }} ?> 
</select>
</div>
<button type="submit" class="btn btn-info">Add </button>

                                    </form>
                            </div>
                        </div>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
