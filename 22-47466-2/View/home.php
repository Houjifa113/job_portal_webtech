<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f7f9fc; }
    form { margin: 15px 0; }
    input[type="submit"] {
      padding: 10px 20px;
      background: #3498db;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background: #217dbb;
    }
  </style>
</head>
<body>

<h1>Job Portal Home</h1>

<form action="../Controller/searchcontroller.php" method="POST">
  <input type="submit" name="submit" value="Go to Search Page">
</form>

<form action="../Controller/historyController.php" method="POST">
  <input type="submit" name="history" value="View Search History">
</form>

<form action="../Controller/applyHistoryController.php" method="POST">
  <input type="submit" name="apply_history" value="View Apply History">
</form>

<form action="../View/bookmarkHistory.php" method="GET">
  <input type="submit" name="bookmark_history" value="View Bookmark History">
</form>

</body>
</html>
