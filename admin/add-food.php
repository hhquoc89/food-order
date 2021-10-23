+<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Food </h1>

        <br> <br>
            <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        
            ?>
        <form action=""method="POST" enctype="multipart/form-data">
            <table class='tbl-30'>
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text"name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <textarea type="text"name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                 <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number"name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                     <input type="file"name="image" accept="image/*">
                    </td>
                 </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Create PHP Code to display categories from Database
                            // 1.Create SQL to get all active categories from database
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                            // Execute
                            $res= mysqli_query($conn,$sql);
                            // Count rows check have categories or not

                            $count=mysqli_num_rows($res);
                            // If categories > 0 -> show or not show
                            if($count>0)
                            {
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>
                                    <option value="<?php echo $id?>"><?php echo $title;?></option>
                                  
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            // 2.Display dropdown
                            ?>
                            
                         </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio"name="featured"value="Yes">Yes
                        <input type="radio"name="featured"value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio"name="active"value="Yes">Yes
                        <input type="radio"name="active"value="No">No
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food"class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            // Check button clicked or not 
            if(isset($_POST['submit']))
            {
                // 1.Get the data
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];
                // For radio input, we check featured or active is selected or not
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
                    $active = "No"; //default value
                }
                // 2.Upload Image
                if (isset($_FILES['image']['name']))
                {
                   //Upload the image
                    // To upload image we need image name,source path and destination path
                    $image_name=$_FILES['image']['name'];

                    if($image_name!="")
                    {
                    
                    // Auto Rename our Image
                    // Get the Extension of our image(jpg,png,gif,etc,..)
                        $temp=explode('.',$image_name);
                        $ext =end($temp);
                        // Rename the image
                        $image_name = "Food_Name_".rand(000,999).".".$ext; // Food_Category_431.jpg


                        $source_path=$_FILES['image']['tmp_name'];
                        
                        $destination_path="../images/food/".$image_name;

                        // Finally
                        $upload= move_uploaded_file($source_path,$destination_path);
                        
                        // Check image is uploaded or not
                        // If not uploaded -> stop process and redirect with error message
                        if($upload==false)
                        {
                            $_SESSION['upload']="<div class='error'>Failed to Upload Food.</div>";
                            header("location:".SITEURL.'admin/add-food.php');
                            die();  //Stop process
                        }
                     }
                }
                else
                {
                    //Don't upload and set value as blank 
                    $image_name="";
                }
                
                // 3. Create SQL query to insert
                $sql2= "INSERT INTO tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id=$category,
                    featured='$featured',
                    active='$active'
                ";

                // 4. Execute the query

                $res2 = mysqli_query($conn,$sql2);
                
                // 5. Check the query executed or not and data add or not
                if ($res2==true)
                {
                    //Done
                    $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Fail
                    $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                    
                }
            }
        
        
        
        
        ?>
    </div>
</div>

<?php include('partials/footer.php') ; ?>