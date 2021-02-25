<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurar Produtos</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div class="form-search">
        <form action="" id="search-form" method="POST">
            <select name="web">
                <option value="">Web</option>
                <option value="all">Todas</option>
                <option value="mercado_livre">Mercado Livre</option>
                <option value="buscape">Buscapé</option>
            </select>
            <select name="category">
                <option value="">Categorias</option>
                <option value="geladeira">Geladeira</option>
                <option value="tv">TV</option>
                <option value="celular">Celular</option>
            </select>
            <input type="text" name="search_word" placeholder="Tags: Telemóveis, Computadores...">
            <button>Search</button>
        </form>
    </div>
    <div class="results">
        <div class="product">
            <img src="assets/imgs/samsung_phone.jpg" alt="">
            <div class="description">
                <h1>Product #1</h1>
                <span class="price">500 $</span>
            </div>
            <a href="">Ir para web</a>
        </div>
    </div>

</body>

<script src="assets/script.js"></script>

</html>