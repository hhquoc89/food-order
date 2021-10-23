<?php
include('../config/constants.php');

if(isset($_GET['id']) and isset($_GET['image_name']))
{
    $id = $_GET['id'];;
    $image_name = $_GET['image_name'];

    if($image_name !="")
    {
        $path="../images/category/".$image_name;
        $remove =unlink($path);
        
        if($remove==false)
        {
            $_SESSION['remove']="<div class='error'>Failed to remove Category Image</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }

    $sql="delete from tbl_category where id=$id";
    $res =mysqli_query($conn,$sql);
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Category deleted successfully.</div>";
         header('Location:'.SITEURL.'admin./manage-category.php');

    }
    else{
        $_SESSION['delete']="<div class='error'>Failed to delete category</div>";
         header('Location:'.SITEURL.'admin./manage-category.php');
    }
}
else
{
    $_SESSION['remove']="<div class='error'>Failed to remove Category Image</div>";
    header('Location:'.SITEURL.'admin./manage-category.php');
}
?>