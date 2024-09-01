<?php include '../../view/header.php';
require '../../model/database.php';

session_start(); //this must before the get profile function, because the get profile function needs a session username

//if call the php without checking, it will be error
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require '../../model/getUserOrders.php';
} else {
    echo "<script>alert('Please Login to check the orders');</script>";
}
?> <!-- import database method -->


<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <p>Order list here</p>
            <br>

        </div>
    </el-col>
</el-row>

<!-- must check there is a username the display all the information -->
<?php
if (isset($orders)) {
    ?>
    <el-row>
        <el-col :span="22" :offset="1">
            <div class="grid-content bg-white">

                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>type</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Total volumn</th>
                    </tr>

                    <?php
                    if (empty($orders)) {
                        echo "<tr><td colspan='5'>no orders now</td></tr>";
                    } else {

                        foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <?php echo $order['order_id']; ?>
                                </td>
                                <td>
                                    <?php echo $order['type']; ?>
                                </td>
                                <td>
                                    <?php echo $order['start_date']; ?>
                                </td>
                                <td>
                                    <?php echo $order['end_date']; ?>
                                </td>
                                <td>
                                    <?php echo $order['volumn_total']; ?>
                                </td>
                            </tr>

                        <?php endforeach;
                    }
                    ?>
                </table>

            </div>
        </el-col>
    </el-row>
    <?php
}
?>

<?php include '../../view/footer.php'; ?>