

<div class="col main pt-5 mt-3 dashboard_main">
    <?php
   
// Get view type: monthly or weekly
$view = isset($_GET['view']) ? $_GET['view'] : 'monthly';

// Get current date or date from GET
$currentDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$timestamp = strtotime($currentDate);

// Determine start/end dates
if ($view === 'monthly') {
    $start = strtotime(date('Y-m-01', $timestamp));
    $end = strtotime(date('Y-m-t', $timestamp));
} else {
    // Weekly view: start from Monday
    $start = strtotime('monday this week', $timestamp);
    $end = strtotime('sunday this week', $timestamp);
}

// Previous and Next dates
if ($view === 'monthly') {
    $prevDate = date('Y-m-d', strtotime('-1 month', $timestamp));
    $nextDate = date('Y-m-d', strtotime('+1 month', $timestamp));
} else {
    $prevDate = date('Y-m-d', strtotime('-1 week', $timestamp));
    $nextDate = date('Y-m-d', strtotime('+1 week', $timestamp));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Calendar</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ccc; }
        .controls { text-align: center; margin: 20px 0; }
        .today { background-color: #d4edda; font-weight: bold; }
        button { padding: 6px 10px; margin: 0 5px; }
    </style>
</head>
<body>

<div class="controls">
    <form method="get" style="display: inline;">
        <input type="hidden" name="view" value="<?= $view ?>">
        <input type="hidden" name="date" value="<?= $prevDate ?>">
        <button type="submit">Previous</button>
    </form>

    <strong><?= date('F Y', $timestamp) ?></strong>

    <form method="get" style="display: inline;">
        <input type="hidden" name="view" value="<?= $view ?>">
        <input type="hidden" name="date" value="<?= $nextDate ?>">
        <button type="submit">Next</button>
    </form>
</div>

<div class="controls">
    <a href="?view=monthly&date=<?= $currentDate ?>"><button>Monthly View</button></a>
    <a href="?view=weekly&date=<?= $currentDate ?>"><button>Weekly View</button></a>
</div>

<table>
    <tr>
        <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day): ?>
            <th><?= $day ?></th>
        <?php endforeach; ?>
    </tr>
    <tr>
    <?php
    $day = $start;
    $endReached = false;

    // Align first row
    if (date('w', $start) != 0) {
        for ($i = 0; $i < date('w', $start); $i++) {
            echo "<td></td>";
        }
    }

    while (!$endReached) {
        $isToday = (date('Y-m-d', $day) == date('Y-m-d')) ? 'today' : '';
        $formattedDate = date('Y-m-d', $day);

        echo "<td class='$isToday'>";
        echo date('j', $day);

        // Check if any meeting exists for this date
        if (!empty($calendar_events[$formattedDate])) {
            echo "<br><ul style='padding-left:0; list-style:none; font-size:12px;'>";

            foreach ($calendar_events[$formattedDate] as $meeting) {
              
                $lead_id = isset($meeting['leadId']) ? $meeting['leadId'] : 0;
                $desc = $meeting['comment'];

                $url = base_url("admin/leads/view/{$lead_id}");
                echo "<li><a href='$url'>• $desc</a></li>";
            }

            echo "</ul>";
        }

        echo "</td>";

        if (date('w', $day) == 6) echo "</tr><tr>";

        if ($day >= $end) {
            $endReached = true;
        } else {
            $day = strtotime("+1 day", $day);
        }
    }

    echo "</tr>";
    ?>
</table>


</body>
</html>

                <h6 class="section-title">Meetings</h6>
                <?php if (!empty($meeting_tasks)): ?>
                <div class="table-main-div">
                    <table id="datatable1" class="table table-striped table-bordered table-sm display">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Task Name</th>
                                <th>Name</th>
                                <th>Pref. Location</th>
                                <th>Budget</th>
                                <th>Requirement</th>
                                <th>Date /Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $task_limit = min(100, count($meeting_tasks)); // Limit tasks to 100
                            if (!empty($meeting_tasks)) {
                                for ($i = 0; $i < $task_limit; $i++) {
                                    $task = $meeting_tasks[$i]; ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('admin/leads/view/' . $task['leadId']); ?>">
                                                <?php echo ($task['comment']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo ($task['uName']); ?></td>
                                        <td><?php echo ($task['location']); ?></td>
                                        <td><?php echo ($task['budget']); ?></td>
                                        <td>
                                            <?php 
                                            if (!empty($task['residential'])) {
                                                echo '<span class="badge badge-info">R: ' . ($task['residential']) . '</span>';
                                            }
                                            if (!empty($task['commercial'])) {
                                                if (!empty($task['residential'])) {
                                                    echo '<br>';
                                                }
                                                echo '<span class="badge badge-success">C: ' . ($task['commercial']) . '</span>';
                                            }
                                            ?>
                                        </td>
                                         <td><?php echo  date('d M Y h:iA',strtotime($task['nextdt'])); ?></td>
                                          <td><?php echo ($task['status']); ?></td>
                                         
                                    </tr>
                                <?php }
                            } else { ?>
                               <tr><td colspan="6" class="text-center">No tasks found</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No tasks found.</p>
                <?php endif; ?>
            </div>

<!-- Add custom CSS -->
<style>
.container {
    max-width: 1200px;
}

.content-box {
    background-color: #ffffff;
    padding-right:0 !important;
    border-radius: 10px;
    /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
}

.section-title {
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 1.5rem;
    text-align: center;
}

.table {
    margin-top: 20px;
    border-collapse: separate;
    border-spacing: 0;
}

.table th, .table td {
    padding: 15px;
    text-align: left;
}

.table thead th {
    background-color: #3498db;
    color: #ffffff;
    font-weight: bold;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #e1e1e1;
}

.table a {
    color: #2980b9;
    text-decoration: none;
}

.table a:hover {
    text-decoration: underline;
}

.badge-info {
    background-color: #17a2b8;
    color: #ffffff;
    padding: 5px 10px;
    border-radius: 5px;
}

.badge-success {
    background-color: #28a745;
    color: #ffffff;
    padding: 5px 10px;
    border-radius: 5px;
}

.text-center {
    text-align: center;
}

.text-muted {
    color: #6c757d;
}
</style>
