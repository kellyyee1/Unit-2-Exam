<?php
function lineSum($filename, $lineNumber) {
    if (!file_exists($filename)) return null;
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lineNumber < 1 || $lineNumber > count($lines)) return null;
    $line = $lines[$lineNumber - 1];
    $nums = array_map('intval', preg_split('/\s+/', trim($line)));
    return array_sum($nums);
}

$result = null;
$lineNum = "";
$filename = "sums.txt";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["line"])) {
    $lineNum = intval($_GET["line"]);
    $result = lineSum($filename, $lineNum);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Line Sum</title>
    <style>
        body { font-family: Georgia, serif; max-width: 550px; margin: 60px auto; background: #f9f6f1; color: #222; }
        h1 { font-size: 1.8rem; border-bottom: 2px solid #333; padding-bottom: 8px; }
        input[type="number"] { padding: 8px; font-size: 1rem; width: 120px; border: 1px solid #aaa; border-radius: 4px; }
        input[type="submit"] { padding: 8px 18px; font-size: 1rem; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 8px; }
        .result { margin-top: 20px; padding: 14px 18px; border-radius: 6px; font-size: 1.1rem; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        pre { background: #eee; padding: 12px; border-radius: 6px; font-size: 0.9rem; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 12px; text-align: left; }
        th { background: #333; color: #fff; }
        .back-btn { display: inline-block; margin-bottom: 20px; padding: 7px 18px; background: #555; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .back-btn:hover { background: #333; }
    </style>
</head>
<body>
    <a class="back-btn" href="index.html">← Back</a>
    <h1>Line Sum</h1>
    <p>File used: <code>sums.txt</code></p>
    <pre><?php echo htmlspecialchars(file_get_contents($filename)); ?></pre>

    <form method="get" action="linesum.php">
        <label>Line number:
            <input type="number" name="line" min="1" value="<?= htmlspecialchars($lineNum) ?>" />
        </label>
        <input type="submit" value="Get Sum" />
    </form>

    <?php if ($result !== null): ?>
        <div class="result">Sum of line <?= $lineNum ?>: <strong><?= $result ?></strong></div>
    <?php elseif ($lineNum !== ""): ?>
        <div class="result error">Line <?= $lineNum ?> does not exist in the file.</div>
    <?php endif; ?>

    <h2>All Line Sums</h2>
    <table>
        <tr><th>Line #</th><th>Content</th><th>Sum</th></tr>
        <?php
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $i => $line) {
            $n = $i + 1;
            $sum = lineSum($filename, $n);
            echo "<tr><td>$n</td><td>" . htmlspecialchars($line) . "</td><td>$sum</td></tr>";
        }
        ?>
    </table>
</body>
</html>