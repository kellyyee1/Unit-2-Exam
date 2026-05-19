<?php
function isPalindrome($str) {
    $lower = strtolower($str);
    return $lower === strrev($lower);
}

$result = null;
$input = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["word"])) {
    $input = $_GET["word"];
    $result = isPalindrome($input);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Palindrome Checker</title>
    <style>
        body { font-family: Georgia, serif; max-width: 500px; margin: 60px auto; background: #f9f6f1; color: #222; }
        h1 { font-size: 1.8rem; border-bottom: 2px solid #333; padding-bottom: 8px; }
        input[type="text"] { padding: 8px; font-size: 1rem; width: 300px; border: 1px solid #aaa; border-radius: 4px; }
        input[type="submit"] { padding: 8px 18px; font-size: 1rem; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 8px; }
        .result { margin-top: 20px; padding: 14px 18px; border-radius: 6px; font-size: 1.1rem; }
        .yes { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .no  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .back-btn { display: inline-block; margin-bottom: 20px; padding: 7px 18px; background: #555; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .back-btn:hover { background: #333; }
    </style>
</head>
<body>
    <a class="back-btn" href="index.html">← Back</a>
    <h1>Palindrome Checker</h1>
    <form method="get" action="palindrome.php">
        <label>Enter a word:
            <input type="text" name="word" value="<?= htmlspecialchars($input) ?>" />
        </label>
        <input type="submit" value="Check" />
    </form>

    <?php if ($result !== null): ?>
        <div class="result <?= $result ? 'yes' : 'no' ?>">
            "<?= htmlspecialchars($input) ?>" is
            <?= $result ? "It is a palindrome!" : "It is NOT a palindrome." ?>
        </div>
    <?php endif; ?>

    <h2>Test Cases</h2>
    <ul>
        <?php
        $tests = ["radar", "toot", "mom", "a", "", "Mom", "RAdar", "hello", "PHP"];
        foreach ($tests as $t) {
            $r = isPalindrome($t) ? "It is a palindrome" : "It is not palindrome";
            echo "<li><strong>" . htmlspecialchars(json_encode($t)) . "</strong>: $r</li>";
        }
        ?>
    </ul>
</body>
</html>