<?php
require_once('tcpdf/tcpdf.php');
require 'db.php';

// Get transaction type from URL
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Validate transaction type
$valid_types = ['deposit', 'withdrawal', 'open_account'];
if (!in_array($type, $valid_types)) {
    die('Invalid transaction type');
}

// Create a new PDF instance
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle(ucfirst(str_replace('_', ' ', $type)) . ' Transactions');
$pdf->SetHeaderData('', 0, ucfirst(str_replace('_', ' ', $type)) . ' Transactions Report', '');
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Fetch transactions based on type
$sql = "SELECT queue_number, transaction_type, status, created_at FROM queue WHERE transaction_type=? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();

// Build HTML table for PDF
$html = '<h2>' . ucfirst(str_replace('_', ' ', $type)) . ' Transactions Report</h2>
<table border="1" cellpadding="5">
    <tr>
        <th><b>Queue No.</b></th>
        <th><b>Transaction Type</b></th>
        <th><b>Status</b></th>
        <th><b>Date</b></th>
    </tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['queue_number'] . '</td>
        <td>' . ucfirst(str_replace('_', ' ', $row['transaction_type'])) . '</td>
        <td>' . ucfirst($row['status']) . '</td>
        <td>' . $row['created_at'] . '</td>
    </tr>';
}

$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF
$pdf->Output($type . '_transactions.pdf', 'D'); // 'D' forces download

exit();
?>
