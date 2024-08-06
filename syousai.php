<?php
// 引数を受け取る
$id = urldecode($_GET['id']);

session_start();
$results = $_SESSION['results'];
foreach ($results as $result) {
    if ($result['id'] == $id) {
        // var_dump($result);
        $name = $result['name'];        // 名前
        $type1 = $result['type1'];      // タイプ１
        $type2 = $result['type2'];      // タイプ２
        $series = $result['series'];    // 登場シリーズ
        break;
    }
}

// $result = $results[intval($id)];


$pokemon_url = "https://pokeapi.co/api/v2/pokemon/{$id}";
$pokemon_response = file_get_contents($pokemon_url);
$pokemon_data = json_decode($pokemon_response, true);


// 違う形式でJSONを受け取り、説明文を取得する
// PokeAPIのURLを用いてHTTPリクエストを送信し、レスポンスを取得
$response = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/{$id}/");
// JSON形式のレスポンスをPHPの連想配列に変換
$data = json_decode($response, true);
// 説明文を取得
$flavorTextEntries = $data['flavor_text_entries'];
$flavorText = null;
// 日本語の説明文を表示
foreach ($flavorTextEntries as $entry) {
    // 言語が日本語である場合のみ説明文を表示します。
    if ($entry['language']['name'] === 'ja') {
        $flavorText = $entry['flavor_text'];
        break; // 最初に見つかった日本語の説明文を表示したらループを終了
    }
}


// 日本語の特性情報を取得する関数
function getAbilityInJapanese($ability_url) {
    $ability_response = file_get_contents($ability_url);
    $ability_data = json_decode($ability_response, true);

    foreach ($ability_data['names'] as $name) {
        if ($name['language']['name'] === 'ja-Hrkt') {
            return $name['name'];
        }
    }
    return '不明';
}

// ポケモンの特性情報を取得
$abilities = [];
foreach ($pokemon_data['abilities'] as $ability) {
    $abilities[] = getAbilityInJapanese($ability['ability']['url']);
}


$weight = $pokemon_data['weight'] / 10; // 重さ（kg）
$height = $pokemon_data['height'] / 10; // 高さ（m）
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $name; ?> - ポケモン図鑑</title>
        <link rel="stylesheet" href="../../../../css/base.css" />
        <link rel="stylesheet" href="../../css/species.css" />
        <link rel="stylesheet" href="syousai.css">
        <link rel="" href="syousai.css">
    </head>
    <body>
        <div id="page">
            <header>
                <a href="index.html">
                    <img id="logo" src="Pokemon.png" alt="ポケモン図鑑" />
                </a>
                <ul id="topicPath">
                    <a href="index.html">トップページ</a> &gt;&gt;</br>
                    <a href="result.php"><?php echo $series; ?></a> &gt;&gt;</br>
                    <?php echo $name; ?>
                </ul>
            </header>
            <div id="content">
                <h3><?php echo $name; ?></h3>
                <div class="detail-img-wrapper">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/dream-world/<?php echo $id; ?>.svg" alt="" />

                </div>
                <div id="profile" class="clearfix">
                    <div id="data">
                        <h4>ポケモンデータ</h4>
                        <table id="dataTable">
                            <colgroup class="tableHead"></colgroup>
                            <colgroup class="tableBody"></colgroup>
                            <tr>
                                <th>タイプ</th><td><?php echo $type1; ?><br><?php echo $type2; ?></td>
                            </tr>
                            <tr>
                                <th>たかさ</th><td><?php echo $height; ?>m</td>
                            </tr>
                            <tr>
                                <th>おもさ</th><td><?php echo $weight; ?>kg</td>
                            </tr>
                            <tr>
                                <th>特性</th><td><?php for ($i = 0; $i < count($abilities); $i++) { echo "<li>" . htmlspecialchars($abilities[$i]) . "</li>" ;} ?></td>
                            </tr>
                        </table>
                    </div>
                    <div id="explanation">
                        <h4>解説</h4>
                        <p>
                            <?php echo $flavorText; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="app.js"></script>
    </body>
</html>
