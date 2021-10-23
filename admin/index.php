<?php  include('partials/menu.php');  ?>

       <!-- Main -->
        <div class="main-content">
            <div class="wrapper">
             <h1>Dashboard</h1>
                <br>
             <?php 
                    if(isset($_SESSION['login'])) {
                      echo $_SESSION['login'];
                      unset($_SESSION['login']);
                    }
            ?>
                <div class="col-4 text-center">

                    <?php 
                        $sql="select * from tbl_category";
                        $res=mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1> 
                    <br/>
                    Category
                </div>

                <div class="col-4 text-center">
                     <?php 
                        $sql1="select * from tbl_food";
                        $res1=mysqli_query($conn,$sql1);
                        $count1=mysqli_num_rows($res1);
                    ?>
                    <h1><?php echo $count1; ?></h1> 
                    <br/>
                    Foods
                </div>

                <div class="col-4 text-center">
                    <?php 
                        $sql2="select * from tbl_order where status='Delivered'";
                        $res2=mysqli_query($conn,$sql2);
                        $count2=mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>  
                    <br/>
                    Total Orders
                </div>

                <div class="col-4 text-center">
                   <?php 
                        $sql4="select SUM(total) as Total from tbl_order";
                        $res4=mysqli_query($conn,$sql4);
                        $row4=mysqli_fetch_assoc($res4);
                        $total_revenue=$row4['Total'];
                    ?>
                    <h1>$<?php echo $total_revenue; ?></h1> 
                    <br/>
                    revenue Generated
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- end Main -->

        <?php  include('partials/footer.php');  ?>


