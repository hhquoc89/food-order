<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Admin </h1>
        <br>
        <?php 
                  if(isset($_SESSION['add']))
                  {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                  }
        ?>
         <br>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td >Full Name:</td>
                    <td> <input type="text" name="full_name" placeholder="Enter Your Name"> </td>
                 
                </tr>

                <tr>
                    <td >Username:</td>
                    <td> <input type="text" name="username" placeholder="Enter Your Username"> </td>
                </tr>

                <tr>
                    <td >Password:</td>
                    <td> <input type="password" name="password" placeholder="Enter Your Password"> </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin"class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>


    </div>
</div>

<?php include('partials/footer.php') ; ?>

<?php 
// save in database
if (isset($_POST['submit']))
{
    //get data from form
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password=md5($_POST['password']);

    // sql query to save
    $sql = "insert into tbl_admin set
            full_name='$full_name',
            username='$username',
            password='$password'
    ";
   
    //execute query
    $res = mysqli_query($conn, $sql) or die(mysqli_error());
    // check query executed
    if($res==true) {
        $_SESSION['add']="<div class='success'>Admin Added Successfully</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        $_SESSION['add']="<div class='error'>Failed to Add Admin</div>";
        header("location:".SITEURL.'admin/add-admin.php');
    }
}
else{
    // echo "Button not clicked";
}

?>