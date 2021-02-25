(function () {

    let form = document.getElementById("search-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let term = this.querySelector('input[name="search_word"]').value;
        let web = this.querySelector('select[name="web"]').value;
        let category = this.querySelector('select[name="category"]').value;

        if (!term) {
            alert("Por favor, digite alguma coisa!")
            return;
        }

        search(term, category, web);
        return;

    })

    function search(term, category = null, web = null) {

        // Get and Clear result DIV
        let resultDiv = document.getElementsByClassName("results")[0]
        resultDiv.innerHTML = "";

        let filter = new Map([
            ["celular", "MLB-CELLPHONES"],
            ["tv", "MLB-TELEVISIONS"],
            ["geladeira", "MLB-REFRIGERATORS"],
        ]);

        // Set Endpoints
        const _mercadoLivre = "https://api.mercadolibre.com/products/search?status=active&site_id=MLB&q=" + term
        const _mercadoLivreCategory = `https://api.mercadolibre.com/products/search?status=active&site_id=MLB&q=${term}&domain_id=${filter.get(category)}`;
        const _buscape = "search.php?term=" + term
        const _buscapeCategory = "search.php?filter=" + category + "&term=" + term

        let endPoint = (category) ? _mercadoLivreCategory : _mercadoLivre;

        if (web == "buscape") {
            endPoint = (category) ? _buscapeCategory : _buscape
        }

        // Create a new Request Obj
        let request = new Request(endPoint, {
            method: "GET"
        })

        // Dealing with the response
        fetch(request)
            .then((res) => res.json())
            .then((res) => {

                if (res.data) {
                    resultDiv.innerHTML = res.data;
                }

                if (res.paging.total) {

                    res.results.forEach(item => resultDiv.appendChild(renderProduct(item.pictures[0].url, item.name, "", "R$ 500")));

                } else {
                    alert("Não existem resultado");
                }

            })
    }

    function renderProduct(imgPath, title, description, price) {

        // Init Elements
        let productDiv = document.createElement("div")
        let productDescriptionDiv = document.createElement("div")
        let productImg = document.createElement("img")
        let productTitle = document.createElement("h1")
        let productPrice = document.createElement("span")
        let productLink = document.createElement("a");

        // Set CSS Classes
        productDiv.classList.add("product")
        productDescriptionDiv.classList.add("description")

        // Set Element Attrs
        productImg.setAttribute("src", imgPath)
        productTitle.innerText = title
        productPrice.innerText = price
        productLink.innerText = "Ir para web"

        // Append product description to description DIV
        productDescriptionDiv.appendChild(productTitle)
        productDescriptionDiv.appendChild(productPrice)

        // Append product info to results DIV
        productDiv.appendChild(productImg)
        productDiv.appendChild(productDescriptionDiv)
        productDiv.appendChild(productLink)

        return productDiv
    }

})();