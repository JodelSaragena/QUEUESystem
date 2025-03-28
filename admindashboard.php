<?php
include 'sidebar.php';
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
        }

        .queue-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .list-group {
            flex-grow: 1;
            max-height: 350px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="queue-card">
                    <h5 class="text-capitalize text-center">Waiting</h5>
                    <ul class="list-group queue-waiting"></ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="queue-card">
                    <h5 class="text-capitalize text-center">Serving</h5>
                    <ul class="list-group queue-serving"></ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="queue-card">
                    <h5 class="text-capitalize text-center">Done</h5>
                    <ul class="list-group queue-done"></ul>
                </div>
            </div>
        </div>
    </div>

    <script>
    function fetchQueueData() {
        fetch('fetch_queue.php')
            .then(response => response.json())
            .then(data => {
                updateQueueList('queue-waiting', data.Waiting);
                updateQueueList('queue-serving', data.Serving);
                updateQueueList('queue-done', data.Done);
            })
            .catch(error => console.error('Error fetching queue data:', error));
    }

    function updateQueueList(className, queueList) {
        let listContainer = document.querySelector(`.${className}`);
        listContainer.innerHTML = '';

        if (queueList.length > 0) {
            queueList.forEach(queue => {
                let listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `<strong>${queue.queue_number}</strong> - ${queue.services}
                    <span class="badge bg-primary">${queue.status}</span>`;
                listContainer.appendChild(listItem);
            });
        } else {
            listContainer.innerHTML = `<li class="list-group-item text-muted text-center">No data available</li>`;
        }
    }

    setInterval(fetchQueueData, 5000);
    fetchQueueData();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>