<?php
$query = isset($_GET["query"]) ? trim($_GET["query"]) : "";
$matches = [];

if ($query !== "") {
    $imageDir = "images/";
    $files = scandir($imageDir);
    foreach ($files as $file) {
        if ($file === "." || $file === "..") continue;
        // Case-insensitive: does the filename contain the query?
        if (stripos($file, $query) !== false) {
            $matches[] = $file;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Gallery Search Results</title>
    <style>
        body { font-family: Georgia, serif; max-width: 600px; margin: 60px auto; background: #f9f6f1; color: #222; }
        h1 { font-size: 1.8rem; border-bottom: 2px solid #333; padding-bottom: 8px; }
        fieldset { border: 1px solid #aaa; border-radius: 6px; padding: 16px; }
        input[type="text"] { padding: 8px; font-size: 1rem; width: 300px; border: 1px solid #aaa; border-radius: 4px; }
        input[type="submit"] { padding: 8px 18px; font-size: 1rem; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 8px; }
        ul { list-style: disc; padding-left: 20px; }
        li a { color: #0055aa; text-decoration: none; }
        li a:hover { text-decoration: underline; }
        .no-results { color: #888; font-style: italic; }
        .back-btn { display: inline-block; margin-bottom: 20px; padding: 7px 18px; background: #555; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .back-btn:hover { background: #333; }
    </style>
</head>
<body>
    <a class="back-btn" href="index.html">← Back</a>
    <h1>Image Gallery Search</h1>
    <form action="search.php" method="get">
        <fieldset>
            Type a query: <input type="text" name="query" value="<?= htmlspecialchars($query) ?>" /> <br /><br />
            <input type="submit" value="Search" />
        </fieldset>
    </form>

    <?php if ($query === ""): ?>
        <p class="no-results">Enter a query to search.</p>
    <?php elseif (empty($matches)): ?>
        <p class="no-results">No images found matching "<?= htmlspecialchars($query) ?>".</p>
    <?php else: ?>
        <h2>Results for "<?= htmlspecialchars($query) ?>"</h2>
        <ul>
            <?php foreach ($matches as $file): ?>
                <li><a href="images/<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>