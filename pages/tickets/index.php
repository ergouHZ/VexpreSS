<?php include '../../view/header.php';
require '../../model/database.php';

session_start(); //this must before the get profile function, because the get profile function needs a session username

//if call the php without checking, it will be error
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require '../../model/GetTicket.php';
    require '../../model/getUserOrders.php';
    if (empty($orders)) {
        echo "<script>alert('Please subscribe and then leave the ticket here');</script>";
    }
} else {
    echo "<script>alert('Please submit the tickets after subscribing');</script>";
}
?> <!-- import database method -->


<el-row>
    <el-col :span="10" :offset="1">
        <div class="grid-content bg-white ticket-title">
            <p>Tickets List</p>
        </div>
    </el-col>
    <el-col :span="6" :offset="6">
        <div class="grid-content bg-white ticket-title">
            <el-button type="primary" @click="onClickCreate">My ticket</el-button>
        </div>
    </el-col>
</el-row>

<!-- must check there is a username the display all the information -->
<?php
if (isset($tickets)) {
    ?>
    <el-row>
        <el-col :span="22" :offset="1">
            <div class="grid-content bg-white">

                <table>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>date</th>
                        <th></th>
                    </tr>

                    <?php
                    if (empty($tickets)) {
                        echo "<tr><td colspan='5'>no tickets now</td></tr>";
                    } else {

                        foreach ($tickets as $ticket): ?>
                            <tr>
                                <td>
                                    <?php echo $ticket['ticket_id']; ?>
                                </td>
                                <td>
                                    <?php echo $ticket['title']; ?>
                                </td>
                                <td>
                                    <?php echo $ticket['description']; ?>
                                </td>
                                <td>
                                    <?php echo $ticket['date']; ?>
                                </td>
                                <td>
                                    <!-- <button onclick="deleteOrder(<?php echo $ticket['ticket_id']; ?>)">Delete</button> -->
                                    <button data-ticket-id="<?php echo $ticket['ticket_id']; ?>" onclick="deleteOrder(this)">Delete</button>
                                    <!-- this will delete the certain one -->
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
<?php
/* check if there is order to see the user authority */
if (!empty($orders)) {
    ?>
    <!-- this will be pushed after select the subscription -->
    <el-dialog class="confirm-window" title="Confirm subscription" :visible.sync="dialogVisible">
        <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="Title">
                <el-input v-model="form.title"></el-input>
            </el-form-item>

            <el-form-item label="Describe">
                <el-input type="textarea" v-model="form.desc"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">Create</el-button>
                <el-button @click="dialogVisible = false">Cancel</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>

    <?php
}
?>
<?php include '../../view/footer.php'; ?>