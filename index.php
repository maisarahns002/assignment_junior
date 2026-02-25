<?php

function calculateElectricity($voltage, $current, $rate) {

    $power = $voltage * $current; // Wh

    $results = [];

    for ($hour = 1; $hour <= 24; $hour++) {

        $energy = ($power * $hour) / 1000; // kWh
        $total = $energy * ($rate / 100);  // RM

        $results[] = [
            'hour' => $hour,
            'energy' => $energy,
            'total' => $total
        ];
    }

    return [
        'power' => $power,
        'results' => $results
    ];
}

if (isset($_POST['calculate'])) {

    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $rate = $_POST['rate'];

    $data = calculateElectricity($voltage, $current, $rate);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Electricity Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Electricity Calculator</h2>

<form method="POST">
    <div class="form-group">
        <label>Voltage (V)</label>
        <input type="number" step="any" name="voltage" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Current (A)</label>
        <input type="number" step="any" name="current" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Current Rate (sen/kWh)</label>
        <input type="number" step="any" name="rate" class="form-control" required>
    </div>

    <button type="submit" name="calculate" class="btn btn-primary">
        Calculate
    </button>
</form>

<?php if(isset($data)) { ?>

<hr>

<h4>Power: <?php echo number_format($data['power'],2); ?> Wh</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Hour</th>
            <th>Energy (kWh)</th>
            <th>Total (RM)</th>
        </tr>
    </thead>
    <tbody>

    <?php 
    $i = 1;
    foreach($data['results'] as $row) { ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['hour']; ?></td>
            <td><?php echo number_format($row['energy'],5); ?></td>
            <td><?php echo number_format($row['total'],2); ?></td>
        </tr>
    <?php } ?>

    </tbody>
</table>

<?php } ?>

</body>
</html>
