<?php
session_start();
$history = $_SESSION['history'] ?? [];
?>

<html>
<head>
    <title>Search History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: #3498db;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:nth-child(even) {
            background: #f2f6fa;
        }

        tr:hover {
            background: #eaf2fb;
        }

        a {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
        }

        a:hover {
            background: #217dbb;
        }

        p {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Your Search History</h2>
    <?php if (empty($history)): ?>
        <p>No search history found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Status</th>
                <th>Search Date</th>
            </tr>
            <?php foreach ($history as $entry): ?>
            <tr>
                <td><?php echo $entry['search_term']; ?></td>
                <td><?php echo $entry['status']; ?></td>
                <td><?php echo $entry['search_time']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <div style="text-align:center;">
        
        <a href="home.php">Back to Home</a>
    </div>
</body>
</html>
