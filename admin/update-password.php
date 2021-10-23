<?php  include('partials/menu.php');  ?>
<div class = 'main-content'>
    <div class='wrapper'>
        <h1>Change Password</h1>
        <br> <br> 

        <?php
            if(isset($_GET['id']))
            {
                $id =$_GET['id'];
            }
        ?>

        <form action="" method="POST">
        <table class=tbl-40>
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>
            
            <tr>
               <td>Confirm Password</td> 
               <td>
                   
                   <input type="password" name="confirm_password" placeholder="Confirm Password">
    
               </td>
            </tr>
            <tr>
                <td colspan ="2">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <input type="submit"name ="submit" value ="Change Password" class ="btn-secondary">
                </td>
            </tr>

        </table>

        </form>
    </div>
</div>
  
<?php
// Check the button 
if(isset($_POST['submit']))
{
    // echo "Clicked"

    // 1.Get data from form
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // 2.Check current ID adn current Password exist or not
    $sql=  "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // 3.Execute the query
    $res = mysqli_query($conn,$sql);
    if ($res== True)
    {
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            // echo "User Found";
            if($new_password==$confirm_password)
            {
                // Update the password
                // echo "Password Match";
                $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                    ";
                // Execute
                $res2 =mysqli_query($conn,$sql2);
                // Check execute or not 
                if ($res2==true)
                {
                    // Display success message
                    $_SESSION['change-pwd']= "<div class='success'>Password Changed Successfully</div>";
                    // Redirect to Admin Page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
                else
                {   
                    // Display error message 
                    $_SESSION['change-pwd']= "<div class='error'>Failed to Change Password</div>";
                    // Redirect to Admin Page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }

            }
            
            else
            {
                // Password does not match
                $_SESSION['pwd-not-match']= "<div class='error'>Password Did not Match</div>";
                // Redirect to Admin Page
                header("location:".SITEURL.'admin/manage-admin.php');
            }
            
        }
        else
        {
            // User does not exist ,Set message and Redirect
            $_SESSION['user-not-found']= "<div class='error'> Invalid user or password</div>";
            // Redirect to Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }
    // 3. Check new password and Confirm password match or not

    // 4. Change password if all above is true



}


?>

<?php  include('partials/footer.php');  ?>