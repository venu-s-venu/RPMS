<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(strlen($_SESSION['bpmsadid']==0)){
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
        {
            $catname=$_POST['catname'];
            $ret="select CategoryName from tblcategory where CategoryName=:catname";
            $query= $dbh -> prepare($ret);
            $query-> bindParam(':catname', $catname, PDO::PARAM_STR);
            $query-> execute();
            $results = $query -> fetchAll(PDO::FETCH_OBJ);
            if($query -> rowCount() == 0)
            {
                $sql="insert into tblcategory(CategoryName)values(:catname)";
                $query=$dbh->prepare($sql);
                $query->bindParam(':catname',$catname,PDO::PARAM_STR);
                $query->execute();
                $LastInsertId=$dbh->lastInsertId();
                if ($LastInsertId>0) {
               echo '<script>alert("Category has been added.")</script>';
               echo '<script>window.location.href="add_category.php"</script>';
                }
            else
            {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
            }
            else
            {
                echo '<script>alert("Category name already exists. Please try again")</script>';
            }
            }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Railway Pass Management System | Add Category</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />
    </head>
    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include_once('includes/header.php');?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include_once('includes/sidebar.php');?>
            <!-- end navbar side -->

            <!--  page-wrapper -->
            <div id="page-wrapper">
                <div class="row">
                    <!-- Page Header -->
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Category</h1>
                    </div>
                    <!--End Page Header -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Category Name</label>
                                                <input type="text" class="form-control"  name="catname" required='true'>
                                            </div>
                                            <p style="padding-left:450px">
                                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Add</button>
                                            </p>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>
            </div>
            <!-- end page-wrapper -->   
        </div>
        <!-- end wrapper -->
        <!-- Core Scripts - Include with every page -->
        <script src="assets/plugins/jquery-1.10.2.js"></script> 
        <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="assets/plugins/pace/pace.js"></script>
        <script src="assets/scripts/siminta.js"></script>
    </body>
    </html>
    <?php }  ?>