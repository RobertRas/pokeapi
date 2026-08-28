<?php

// define quantos queremos buscar
$limite = 1; 

// monta a URL da API que ira devolver a lista de pokemons
$url_lista = "https://pokeapi.co/api/v2/pokemon/?limit=$limite";

// faz uma requisicao para a url e pega a resposta
// a resposta vem em formato JSON (textual)
$resposta_lista = file_get_contents($url_lista);

// converte o json em um array do PHP
// o parametro "true" faz com que o array seja associativo(ou seja, chave : valor)  ao inves de objetos
$listagem = json_decode($resposta_lista, true);

// crio um array vazio
// ele vai servir para guardar os detalhes de cada pokemon
$detalhes = array();

// vamos ler cada pokemon encontrado dentro de "results"
// $listagem['results'] contem a lista de pokes retornada pela api
// a cada repeticao a variavel $poke representa UM pokemon
foreach ($listagem['results'] as $poke) {
    // pega o nome do pokemon atual e salva na variavel
    $atual = $poke['name'];
    // monta uma outra URL que usa o nome dos pokemons e tras seus detalhes
    $url_detalhes = "https://pokeapi.co/api/v2/pokemon/$atual/";
    // faz a requisicao
    $resposta_detalhes = file_get_contents($url_detalhes);
    // converte o json para array associativo php
    // adiciona dentro do array vazio
    // [] significa: adicione o novo elemento no final do array
    $detalhes[] = json_decode($resposta_detalhes, true);
}

//echo "<pre>";
//var_dump($detalhes);
//echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: "Press Start 2P", system-ui;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Pokémon</a>
            </div>
        </nav>

    </header>

    <main>
        <div class="container">
            <div class="row">
                <!-- 
                    a cada rodada coloque um dos pokemons da lista
                    detalhes dentro da variavel poke
                 
                    obs: o formato de escrita do foreach tambem é diferente
                    ao inves de usar { usamos : e fechamos com endforeach
                    ao inves de usar }
                 -->
                <?php foreach ($detalhes as $poke): ?>
                    <div class="col">
                        <div class="card my-3" style="width: 18rem;">
                            <!-- 
                                pegue o pokemon da vez
                                e dentro do array procure a chave sprites
                                sprites tmb é array entao acessamos mais uma chave front_default
                                no fim ele devolve um link que esta la dentro, 
                                esse link é o endereco da foto e ele vira o valor do src

                                obs: a forma de escrita da tag tmb usamos uma alternativa
                                o '=' substitui 'php echo'
                                é uma forma simplificada de fazer echo (exibir coisas)
                            -->
                            <img src="<?= $poke['sprites']['front_default'] ?>" class="card-img-top" alt="...">
                            <div class="card-body text-center">
                                <!-- 
                                    pegue o pokemon da vez
                                    procure a chave name dentro do array
                                    exiba o valor
                                -->
                                <h5 class="card-title"><?= $poke['name'] ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>

</html>
