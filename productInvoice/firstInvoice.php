<?php 
include('database_connection.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- datatable style cdn -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- jquery CDN -->
    <script src = "https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Datatable CDN -->
    <script src = "https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- initializing datatable -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
</head>
<body>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>order Id</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Invoice</th>
            </tr>
        </thead>

        <?php

            $sql = 'SELECT DISTINCT tbl_order.order_no,tbl_order.order_id, tbl_order.order_receiver_name, tbl_order.order_total_after_tax, tbl_order_item.order_item_quantity
            FROM tbl_order_item
            INNER JOIN tbl_order ON tbl_order.order_id=tbl_order_item.order_id;';

            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
        ?>

        <tbody>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['order_receiver_name']; ?></td>
                <td><?php echo $row['order_item_quantity']; ?></td>
                <td><?php echo $row['order_total_after_tax']; ?></td>
                <td><a href = "first_print_invoice.php?pdf=1&id=<?php echo $row['order_no']; ?>">Invoice</a></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</body>
</html>