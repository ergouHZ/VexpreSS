<?php
include '../../view/header.php';
require '../../model/database.php';
require '../../model/getAccessPoints.php';

try {
    $accesspoints = get_points();
} catch (PDOException $e) {
    // catch PDO exceptions
    echo "Database error occurred";
    echo "Error: " . $e->getMessage();

} catch (Exception $e) {
    // catch all other exceptions
    echo "Some other error occurred";
    echo "Error: " . $e->getMessage();
}
?>



<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">

            <table>
                <tr>
                    <th>name</th>
                    <th>status <el-button icon="el-icon-search" circle small @click="introStatus"></el-button></th>
                    <th class="table-right">location</th>
                    <th>rate</th>
                </tr>
                <?php

                if ($accesspoints == null) {
                    echo "<tr><td colspan='5'>no services now</td></tr>";
                } else {

                    foreach ($accesspoints as $accesspoint): ?>
                        <tr>
                            <td>
                                <?php echo $accesspoint['Name']; ?>
                            </td>
                            <td>
                                <!-- here the if will display a green dot or a red one by using the span attribute -->
                                <?php
                                if ($accesspoint['status'] == 1) {
                                    echo '<span style="display:inline-block; width:10px; height:10px; border-radius:50%; background-color:green;"></span>';
                                } else {
                                    echo '<span style="display:inline-block; width:10px; height:10px; border-radius:50%; background-color:red;"></span>';
                                }
                                ?>
                            </td>
                            <td class="right">
                                <?php echo $accesspoint['location']; ?>
                            </td>
                            <td>
                                <?php echo $accesspoint['rate'].' X'; ?>
                            </td>
                        </tr>

                    <?php endforeach;
                }
                ?>
            </table>

        </div>
    </el-col>
</el-row>

<?php include '../../view/footer.php'; ?>