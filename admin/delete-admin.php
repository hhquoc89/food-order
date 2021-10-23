<?php

// Include constant.php file here
include('../config/constants.php');
//1.get the ID of Admin to be deleted 
$id = $_GET['id'];
//2. Create Sql Query to Delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";
//Excute the Query
$res = mysqli_query($conn,$sql);

// Check whether the query executed successfully or not 
if ($res == true)
{
    // Successfully
    // echo "Admin Deleted";
    // Create session variable to display message
    $_SESSION['delete'] = "<div class='success'> Admin Deleted Successfully</div>";
    //  Redirect to Manage Admin Page 
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    //Fail
    // echo "Failed to Delete Admin";
    $_SESSION['delete'] = "<div class='error'> Failed to Delete Admin .Try again</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}
//3. Redirect to Manage Admin page with message (success/error)


?>