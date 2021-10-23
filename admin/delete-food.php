<?php
include('../config/constants.php');

if(isset($_GET['id']) and isset($_GET['image_name']))
{
    $id = $_GET['id'];;
    $image_name = $_GET['image_name'];

    if($image_name !="")
    {
        $path="../images/food/".$image_name;
        $remove =unlink($path);
        
        if($remove==false)
        {
            $_SESSION['remove']="<div class='error'>Failed to remove Food Image</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }
    }

    $sql="delete from tbl_food where id=$id";
    $res =mysqli_query($conn,$sql);
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Food deleted successfully.</div>";
         header('Location:'.SITEURL.'admin./manage-food.php');

    }
    else{
        $_SESSION['delete']="<div class='error'>Failed to delete Food</div>";
         header('Location:'.SITEURL.'admin./manage-food.php');
    }
}
else
{
    $_SESSION['remove']="<div class='error'>Failed to remove Food Image</div>";
    header('Location:'.SITEURL.'admin./manage-food.php');
}
?>