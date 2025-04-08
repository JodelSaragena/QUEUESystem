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
