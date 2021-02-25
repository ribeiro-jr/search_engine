
    <?php
    include("sample/simple_html_dom.php");

    $filter = [
        "celular" => "celular/smartphone",
        "tv" => "tv",
        "geladeira" => "geladeira"
    ];

    if (isset($_GET["filter"])) {

        $url =  "https://www.buscape.com.br/{$filter[$_GET["filter"]]}/" . urlencode($_GET["term"]);
    } else {
        $url = "https://www.buscape.com.br/search?q=" . urlencode($_GET["term"]);
    }


    $html = file_get_html($url);

    $articles = "";
    // Find all article blocks
    foreach ($html->find('div.card--prod') as $article) {

        if (isset($article->find("a.cardImage img")[0])) {
            $item["img"] = $article->find("a.cardImage img")[0]->attr["src"];
            $item["title"] = $article->find("a.cardImage img")[0]->attr["title"];
        }

        if (isset($article->find("span.customValue .mainValue")[0])) {
            $item["price"] = $article->find("span.customValue .mainValue")[0]->innertext();
        }

        insertData("busca", $item["title"], $item["img"], $item["price"]);

        $articles .= '<div class="product">
                            <img src="' . $item["img"] . '" alt="">
                            <div class="description">
                                <h1>' . $item["title"] . '</h1>
                                <span class="price">' . $item["price"] . '</span>
                            </div>
                            <a href="">Ir para web</a>
                        </div>';
    }

    echo json_encode([
        "data" => $articles
    ]);


    function insertData($web,  $titulo, $img, $preco)
    {
        $servername = "localhost";
        $database = "e-commerce";
        $username = "root";
        $password = "";

        try {

            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM product WHERE titulo = '{$titulo}' AND preco = '{$preco}'");
            $stmt->execute();


            if ($stmt->rowCount() > 0)
                return true;

            $stmt = $conn->prepare("INSERT INTO product (web, titulo, img, preco) VALUES (:web, :titulo, :img, :preco)");
            $stmt->bindParam(':web', $web);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':preco', $preco);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
        $conn = null;
    }
