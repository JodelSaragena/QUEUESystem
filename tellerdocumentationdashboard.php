<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellerdocumentation') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_document'])) {
    $document_id = $_POST['document_id'];
    $file_path = $_POST['file_path'];

    if (!empty($document_id) && !empty($file_path)) {
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
        $stmt->bind_param("i", $document_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Document deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete document.";
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Invalid document data.";
    }

    header("Location: tellerdocumentationdashboard.php");
    exit();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #433878;
            color: white;
            font-weight: bold;
        }
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        .left-section, .center-section, .right-section {
            flex: 1;
        }
        .uploaded-docs-container {
            max-height: 250px;
            width: 100%;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="dashboard-container mt-2">
            <div class="left-section">
                <div class="card mt-1 shadow">
                    <div class="card-header">📌 Teller Documentation Officer</div>
                    <div class="card-body">
                        <p>✅ You are responsible for maintaining company documents.</p>
                    </div>
                </div>
            </div>

            <div class="center-section">
                <div class="card shadow">
                    <div class="card-header">✍️ Create a Document</div>
                    <div class="card-body">
                        <form method="POST" action="upload_document.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Document Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description:</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload File:</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Upload Document</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <div class="card shadow">
                    <div class="card-header">📂 Uploaded Documents</div>
                    <div class="card-body">
                        <div class="uploaded-docs-container">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Filename</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>CreatedBy</th>
                                        <th>Download</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $documents_query = $conn->query("SELECT id, file_path, title, description, created_by FROM documents ORDER BY created_at DESC");
                                    $count = 1;
                                    while ($doc = $documents_query->fetch_assoc()) {
                                        $filename = basename($doc['file_path']);
                                        echo '<tr>';
                                        echo '<td>' . $count++ . '</td>';
                                        echo '<td>' . htmlspecialchars($filename) . '</td>';
                                        echo '<td>' . htmlspecialchars($doc['title']) . '</td>';
                                        echo '<td>' . htmlspecialchars($doc['description']) . '</td>';
                                        echo '<td>' . htmlspecialchars($doc['created_by']) . '</td>';
                                        echo '<td><a href="' . htmlspecialchars($doc['file_path']) . '" class="btn btn-sm btn-success" download>Download</a></td>';
                                        echo '<td>
                                                <form method="POST" style="display:inline-block;" onsubmit="return confirm(&quot;Are you sure you want to delete this document?&quot;)">
                                                    <input type="hidden" name="document_id" value="' . $doc['id'] . '">
                                                    <input type="hidden" name="file_path" value="' . htmlspecialchars($doc['file_path']) . '">
                                                    <button type="submit" name="delete_document" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                              </td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
