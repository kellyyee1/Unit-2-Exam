<?php
/**
 * Parse a query string into search terms.
 * Phrases wrapped in double quotes are treated as a single term.
 * Otherwise, split by whitespace.
 */
function searchTerms($query) {
    $terms = [];
    // Match quoted phrases first, then individual words
    preg_match_all('/"([^"]+)"|(\S+)/', $query, $matches);
    foreach ($matches[0] as $i => $raw) {
        if (!empty($matches[1][$i])) {
            $terms[] = $matches[1][$i]; // quoted phrase (without quotes)
        } else {
            $terms[] = $matches[2][$i]; // single word
        }
    }
    return $terms;
}

$query = isset($_GET["query"]) ? trim($_GET["query"]) : "";
$matches = [];

if ($query !== "") {
    $terms = searchTerms($query);
    $imageDir = "images/";
    $files = scandir($imageDir);
    foreach ($files as $file) {
        if ($file === "." || $file === "..") continue;
        // Image matches if filename contains ANY term
        foreach ($terms as $term) {
            if (stripos($file, $term) !== false) {
                $matches[] = $file;
                break; // avoid duplicates
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Gallery Smart Search</title>
    <style>
        body { font-family: Georgia, serif; max-width: 700px; margin: 60px auto; background: #f9f6f1; color: #222; }
        h1 { font-size: 1.8rem; border-bottom: 2px solid #333; padding-bottom: 8px; }
        fieldset { border: 1px solid #aaa; border-radius: 6px; padding: 16px; }
        input[type="text"] { padding: 8px; font-size: 1rem; width: 350px; border: 1px solid #aaa; border-radius: 4px; }
        input[type="submit"] { padding: 8px 18px; font-size: 1rem; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 8px; }
        .gallery { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 20px; }
        .gallery a { display: block; text-align: center; text-decoration: none; color: #333; font-size: 0.85rem; }
        .gallery img { height: 100px; border: 2px solid #ccc; border-radius: 4px; display: block; margin-bottom: 4px; }
        .gallery a:hover img { border-color: #333; }
        .no-results { color: #888; font-style: italic; }
        .back-btn { display: inline-block; margin-bottom: 20px; padding: 7px 18px; background: #555; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .back-btn:hover { background: #333; }
        .terms { background: #eee; border-radius: 4px; padding: 6px 12px; font-size: 0.9rem; margin-top: 10px; }
    </style>
</head>
<body>
    <a class="back-btn" href="index.html">← Back</a>
    <h1>Image Gallery Smart Search</h1>
    <form action="search2.php" method="get">
        <fieldset>
            Type a query: <input type="text" name="query" value="<?= htmlspecialchars($query) ?>" /> <br /><br />
            <input type="submit" value="Search" />
        </fieldset>
    </form>

    <?php if ($query === ""): ?>
        <p class="no-results">Enter a query to search. Wrap phrases in quotes for exact multi-word matches.</p>
    <?php else: ?>
        <div class="terms">
            Searching for terms: <strong><?= implode("</strong>, <strong>", array_map("htmlspecialchars", searchTerms($query))) ?></strong>
        </div>
        <?php if (empty($matches)): ?>
            <p class="no-results">No images found matching "<?= htmlspecialchars($query) ?>".</p>
        <?php else: ?>
            <h2>Results (<?= count($matches) ?> found)</h2>
            <div class="gallery">
                <?php foreach ($matches as $file): ?>
                    <a href="images/<?= htmlspecialchars($file) ?>">
                        <img src="images/<?= htmlspecialchars($file) ?>" alt="<?= htmlspecialchars($file) ?>" height="100" />
                        <?= htmlspecialchars($file) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>