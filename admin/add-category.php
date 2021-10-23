<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Category </h1>

        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        
        ?>
        <br><br>
        <!-- Add category form starts -->
        <form action=""method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>                
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Feature: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category"class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add category form ends -->
        <?php
        
            // Check Submit Button is Clicked or not
            if(isset($_POST['submit']))
            {
                // 1.Get value from Category form
                $title= $_POST['title'];
                // For radio input, we check button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get a value from form 
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set default
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                // Check whether the image is selected or not and set the value for image name
                if (isset($_FILES['image']['name']))
                {
                    //Upload the image
                    // To upload image we need image name,source path and destination path
                    $image_name=$_FILES['image']['name'];

                    if($image_name!="")
                    {
                    
                    // Auto Rename our Image
                    // Get the Extension of our image(jpg,png,gif,etc,..)
                        $ext =end(explode('.',$image_name));
                        // Rename the image
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext; // Food_Category_431.jpg


                        $source_path=$_FILES['image']['tmp_name'];
                        
                        $destination_path="../images/category/".$image_name;

                        // Finally
                        $upload= move_uploaded_file($source_path,$destination_path);
                        
                        // Check image is uploaded or not
                        // If not uploaded -> stop process and redirect with error message
                        if($upload=false)
                        {
                            $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                            header("location:".SITEURL.'admin/add-category.php');
                            die();  //Stop process
                        }
                     }
                }
                else
                {
                    //Don't upload and set value as blank 
                    $image_name="";
                }


                // 2. Create SQL query to insert
                $sql= "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                // 3. Execute the query

                $res = mysqli_query($conn,$sql);
                
                // 4. Check the query executed or not and data add or not
                if ($res==true)
                {
                    //Done
                    $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Fail
                    $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }

            }
  
        ?>
    
    </div>
</div>




<?php include('partials/footer.php') ; ?>
