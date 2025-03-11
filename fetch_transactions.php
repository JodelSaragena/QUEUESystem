<?php
require 'db.php';

$sql = "SELECT * FROM queue ORDER BY status, queue_number ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td><strong>{$row['queue_number']}</strong></td>
        <td>
            <select class='form-select type-select' data-id='{$row['id']}'>
                <option value='withdrawal' " . ($row['transaction_type'] == 'withdrawal' ? 'selected' : '') . ">Withdrawal</option>
                <option value='deposit' " . ($row['transaction_type'] == 'deposit' ? 'selected' : '') . ">Deposit</option>
                <option value='open_account' " . ($row['transaction_type'] == 'open_account' ? 'selected' : '') . ">Open Account</option>
            </select>
        </td>
        <td>
            <select class='form-select status-select' data-id='{$row['id']}'>
                <option value='waiting' " . ($row['status'] == 'waiting' ? 'selected' : '') . ">Waiting</option>
                <option value='serving' " . ($row['status'] == 'serving' ? 'selected' : '') . ">Serving</option>
                <option value='done' " . ($row['status'] == 'done' ? 'selected' : '') . ">Done</option>
            </select>
        </td>
        <td>
            <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Delete</button>
        </td>
    </tr>";
}
?>
