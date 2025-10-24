<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="img/favIcon.png">
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/index.css" />
    <script src="js/index.js"></script>
    <title>Albuns</title>
</head>

<body>
    <?php include_once 'menu.php'; ?>

    <div class="container-melhor">
        <div class="melhor">
            <div class="melhor-titulo">Melhor banda</div>
            <div>
                <img class="melhor-img" id="fotoMelhorBanda" src="">
            </div>
            <div class="melhor-subtitulo" id="nomeMelhorBanda"></div>
        </div>
        <div class="melhor">
            <div class="melhor-titulo">Melhor album</div>
            <div>
                <img class="melhor-img" id="fotoMelhorAlbum" src="">
            </div>
            <div class="melhor-subtitulo" id="nomeMelhorAlbum"></div>
        </div>
        <div class="melhor">
            <div class="melhor-titulo">Melhor musica</div>
            <div>
                <img class="melhor-img" id="fotoMelhorMusicaAlbum" src="">
            </div>
            <div class="melhor-subtitulo" id="nomeMelhorMusica"></div>
        </div>
        <div class="melhor">
            <div class="melhor-titulo">Ultimo show</div>
            <div class="melhor-subtitulo" id="nomeUltimoShow"></div>
        </div>
    </div>
</body>

</html>