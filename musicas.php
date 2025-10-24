<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="img/favIcon.png">
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/musicas.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <script src="js/musicas.js"></script>
    <title>Musicas</title>
</head>

<body>
    <?php include_once 'menu.php'; ?>

    <div class="container-melhor">
        <div class="melhor">
            <div class="melhor-titulo">Musica</div>
            <div class="container-formulario">
                <form action="" id="formularioMusicas" enctype="multipart/form-data">
                    <input type="hidden" id="ctrlFormulario" value="incluir">
                    <input type="hidden" id="frmId" name="frmId" value="0">
                    <div>
                        <button type="button" class="botao-confirmar" id="botaoConfirmarInclusao">Confirmar</button>
                    </div>
                    <div class="container-campos">
                        <div>
                            <label for="">Album:</label>
                            <select class="select-album-id" name="frmAlbumId" id="frmAlbumId"></select>
                        </div>
                        <div>
                            <label for="">Nome:</label>
                            <input class="input-nome" type="text" id="frmNome" name="frmNome">
                        </div>
                        <div>
                            <label for="">Nota:</label>
                            <input class="input-nota" type="number" id="frmNota" name="frmNota">
                        </div>
                        <div>
                            <label for="">Duração:</label>
                            <input class="input-duracao" type="text" id="frmDuracao" name="frmDuracao" oninput="mascaraDuracao();">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="melhor">
            <div class="melhor-titulo">Grade de registros</div>
            <div class="container-tabela">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th class="tabela-titulo" style="width: 25%">Album</th>
                            <th class="tabela-titulo" style="width: 35%">Nome</th>
                            <th class="tabela-titulo" style="width: 10%;">Nota</th>
                            <th class="tabela-titulo" style="width: 20%">Duração</th>
                            <th class="tabela-titulo" style="width: 10%;">Opções</th>
                        </tr>
                    </thead>
                    <tbody id="gradeRegistros">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>