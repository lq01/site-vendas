 function carregarPagina(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById("conteudo").innerHTML = html;
        })
        .catch(error => console.error('Erro ao carregar página:', error));
}

/*explicação disso pra relembrar:
O fetch(pagina.php) retorna uma Promise com um objeto Response (a resposta da requisição).

O primeiro .then() recebe essa resposta.

Os próximos .then() recebem o valor que foi retornado pelo .then() anterior — ou seja, 
uma transformação da resposta original, não outra resposta nova.

*/