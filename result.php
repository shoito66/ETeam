<?php
session_start();
$results = $_SESSION['results'];
$firstRow = $results[0];
$series = $firstRow['series'];
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $series; ?> - ポケモン図鑑</title>
        <link rel="stylesheet" href="result.css">
    </head>
    <body>
        <div id="page">
            <header>
                <a href="index.html">
                    <img class="logo" id="logo" src="Pokemon.png" alt="ポケモン図鑑" />
                </a>
                <ul id="topicPath">
                    <a href="index.html">トップページ</a> &gt;&gt;<br>
                    <?php echo $series; ?>
                </ul>  
            </header>
            <div id="content">
                <h2><?php echo $series; ?>で登場するポケモンたち</h2>
                <p>
                <ul class = "main">
                <?php foreach ($results as $row): ?>
                    <a href="syousai.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                    <div class="detail-img-wrapper3">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/dream-world/<?php echo htmlspecialchars($row['id']); ?>.svg" alt="" />
                        <li><?php echo htmlspecialchars($row['name']); ?></li>
                    </div>
                    </a>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </body>
</html>
