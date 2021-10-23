<?php
    include('./partials/menu.php');
?>
    <div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>


        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];

                $sql2="select * from tbl_food where id=$id";
                $res2 =mysqli_query($conn,$sql2);

                $count2=mysqli_num_rows($res2);

                if($count2==1)
                {
                    $row2 = mysqli_fetch_assoc($res2);
                    $title = $row2['title'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $featured=$row2['featured'];
                    $active=$row2['active'];
                }
                else{
                    $_SESSION['no-food-found']="<div class='error'>Food not found</div>";
                     header('Location:'.SITEURL.'admin/manage-food.php');
                    
                }
            }
            else{
                header('Location:'.SITEURL.'admin/manage-food.php');
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description::</td>
                <td>
                   <textarea name="description" cols="30" rows="5" > <?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current image:</td>
                <td>
                   <?php
                        if($current_image!=""){
                            ?>
                            <img src="<?php echo SITEURL; ?>/images/food/<?php echo $current_image; ?>" width="100px" alt="">
                            <?php
                        }
                        else{
                            echo "<div class='error'>Image Not Added</div>";
                        }
                   ?>
                </td>
            </tr>

            <tr>
                <td>New Image:</td>
                <td>
                    <input type="file" name="image" id="">
                </td>

            </tr>

            <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category" >
                               <?php 
                                $sql ="select * from tbl_category where active='Yes'";
                                $res=mysqli_query($conn,$sql);
                                $count=mysqli_num_rows($res);
                                if($count>0)
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title=$row['title'];
                                        $category_id=$row['id'];

                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id?>"><?php echo $category_title;?></option>
                                      
                                        <?php
                                    }
                                }
                                else{
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                               ?>
                            </select>
                        </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No

                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No

                </td>
            </tr>

            <tr>
                <td>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                
                </td>
            </tr>
        
        </table>
        </form>

            <?php
                if(isset($_POST['submit']))
                {
                    $id=$_POST['id'];
                    $title=$_POST['title'];
                    $current_image=$_POST['current_image'];
                    $price=$_POST['price'];
                    $current_category= $_POST['category'];
                    $featured= $_POST['featured'];
                    $active= $_POST['active'];


                    if(isset($_FILES['image']['name']))
                    {
                        $image_name=$_FILES['image']['name'];
                        if($image_name !="")
                        {
                                    //.A upload new image
                                    $temp=explode('.',$image_name);
                                    $ext =end($temp);
                                // Rename the image
                                $image_name = "Food_Name_".rand(000,999).'.'.$ext; // Food_Category_431.jpg


                                $source_path=$_FILES['image']['tmp_name'];
                                
                                $destination_path="../images/food/".$image_name;

                                // Finally
                                $upload= move_uploaded_file($source_path,$destination_path);
                                
                                // Check image is uploaded or not
                                // If not uploaded -> stop process and redirect with error message
                                if($upload=false)
                                {
                                    $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                                    header("location:".SITEURL.'admin/manage-food.php');
                                    die();  //Stop process
                                }
                                //B.Remove image

                                if($current_image!="")
                                {
                                    $remove_path="../images/food/".$current_image;
                                    $remove=unlink($remove_path);
                                    if($remove==false)
                                    {
                                        $_SESSION['failed-remove']="<div class='error'>Failed to Remove Current Image</div>";
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        die();
                                    }
                                }
                               
                        }
                        else{
                        $image_name=$current_image;


                        }
                    }
                    else{
                        $image_name=$current_image;
                    }

                    $sql3="update tbl_food set 
                            title='$title',
                            description='$description',
                            price=$price,
                            image_name='$image_name', 
                            category_id=$current_category,
                            featured='$featured', 
                            active='$active' 
                            where id=$id";

                            $res3=mysqli_query($conn,$sql3);

                    if($res3==true)
                    {
                        $_SESSION['update']="<div class='success'>Update Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        $_SESSION['update']="<div class='error'>Failed to Update Food</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }

            ?>
    </div>
    
    </div>   
<?php
    include('./partials/footer.php')
?>