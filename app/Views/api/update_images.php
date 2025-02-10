<!DOCTYPE html>
<html>
<head>
    <title>Drug Image Update Results</title>
</head>
<body>
    <h1>Drug Image Update Results</h1>
    <ul>
        <?php foreach ($results as $result): ?>
            <li><?= esc($result) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
