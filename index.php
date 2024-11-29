<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Formulário de usuário</title>
        <script src="js/jquery-3.7.1.min.js" type="text/javascript" ></script>
        <style>
               label{
                display: block;
            }
            .window{
                display:none;
                width:200px;
                height:300px;
                position:absolute;
                left:0;
                top:0;
                background:#FFF;
                z-index:9900;
                padding:10px;
                border-radius:10px;
            }
            #mascara{
                display:none;
                position:absolute;
                left:0;
                top:0;
                z-index:9000;
                background-color:#000;
            }
            .fechar{display:block; text-align:right;}
        </style>
    </head>
    <body>
        <a href="#janela1" rel="modal">Novo Usuario</a>
<!--        Tabela de exibição dos dados-->
        <div id="table">
            <table  border="1px" cellpadding="5px" cellspacing="0">
                <tr>
                    <td>Id</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Senha</td>
                </tr>
                <?php
//precisamos chamar esta página para realizarmos as queries com o banco
                include 'conexao.php';
// Select que traz todos os usuario cadastrados no banco de dados
          
                $sql = "SELECT * FROM USUARIO";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
       //resultado do select
//Enquanto existir usuários no banco ele insere uma nova linha e exibe os dados

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['ID_USUARIO'];
                    $nome = $row['NOME'];
                    $email = $row['EMAIL'];
                    $senha = $row['SENHA'];

                    echo"   <tr>
                <td>$id</td>
                <td>$nome</td>
                <td>$email</td>
                <td>$senha</td>
            </tr>";
                }
                ?>
            </table>






            <a href="#janela2" rel="modal">Nova Produto</a>
<!--        Tabela de exibição dos dados-->
        <div id="table">
            <table  border="1px" cellpadding="5px" cellspacing="0">
                <tr>
                    <td>Id</td>
                    <td>Nome</td>
                    <td>Valor</td>
                    <td>Marca</td>
                    <td>Ação</td>
                </tr>
                <?php
//precisamos chamar esta página para realizarmos as queries com o banco
                include 'conexao.php';
// Select que traz todos os usuario cadastrados no banco de dados
          
                $sql = "SELECT * FROM PRODUTO";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
       //resultado do select
//Enquanto existir usuários no banco ele insere uma nova linha e exibe os dados

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $idProduto = $row['id_produto'];
                    $nome = $row['nome'];
                    $valor = $row['valor'];
                    $marca = $row['marca'];

                    echo"   <tr>
                <td>$idProduto</td>
                <td>$nome</td>
                <td>$valor</td>
                <td>$marca</td>
              <td> <button class='btnExcluirProduto' data-id='$idProduto'>Excluir</button></td>

            </tr>";
                }
                ?>
            </table>


<!--            Modal que é aberto ao clicar novo usuario-->

<div class="window" id="janela1" role="dialog" aria-hidden="true">
    <a href="#" class="fechar">X Fechar</a>
    <h4>Cadastro de usuário</h4>
    <form id="cadUsuario" action="" method="post">
        <label>Nome:</label><input type="text" name="nome" id="nome" />
        <label>Email:</label><input type="text" name="email" id="email" />
        <label>Senha:</label><input type="password" name="senha" id="senha" />
        <br/><br/>
        <input type="button" value="Salvar" id="salvarU" />
    </form>
</div>
<div id="mascara"></div>


<div class="window" id="janela2" role="dialog" aria-hidden="true">
    <a href="#" class="fechar">X Fechar</a>
    <h4>Cadastro de Produto</h4>
    <form id="cadProduto" action="" method="post">
        <label>Nome:</label><input type="text" name="nomeProduto" id="nomeProduto" />
        <label>Valor</label><input type="text" name="valorProduto" id="valorProduto" />
        <label>Marca</label><input type="text" name="marca" id="marca" />
        <br/><br/>
        <input type="button" value="Salvar" id="salvarP" />
    </form>
</div>
<div id="mascara"></div>

</html>

<script type="text/javascript" language="javascript">
    
  $(document).ready(function () {
    // Função para abrir o modal
    $("a[rel=modal]").click(function (ev) {
        ev.preventDefault();

        const id = $(this).attr("href");
        $('#mascara').css({
            'width': '100%',
            'height': '100%',
            'position': 'fixed',
            'top': 0,
            'left': 0
        }).fadeIn(500).css('opacity', 0.8);

        $(id).fadeIn(500);
    });

    // Função para fechar o modal
    function fecharModal() {
        $('#mascara').fadeOut(500);
        $('.window').fadeOut(500);
    }

    $("#mascara, .fechar").click(function (ev) {
        ev.preventDefault();
        fecharModal();
    });



    // Enviar dados do formulário via AJAX
    $('#salvarU').click(function () {
        const dados = $('#cadUsuario').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'salvar.php',
            async: true,
            data: dados,
            success: function (response) {
                if (response.success) {
                    alert('Usuário salvo com sucesso!');
                    location.reload(); // Atualiza a página
                } else {
                    alert('Erro ao salvar usuário: ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor. Tente novamente.');
            }
        });

        return false; // Impede o envio padrão do formulário
    });

    $('#salvarP').click(function () {
        const dados = $('#cadProduto').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'salvarProduto.php',
            async: true,
            data: dados,
            success: function (response) {
                if (response.success) {
                    alert('Produto salvo com sucesso!');
                    location.reload(); // Atualiza a página
                } else {
                    alert('Erro ao salvar Produto: ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor. Tente novamente.');
            }
        });

        return false; // Impede o envio padrão do formulário
    });



     // Função genérica para envio de formulário via AJAX
    function enviarDados(formId, url, mensagemSucesso, mensagemErro) {
        const dados = $(formId).serialize();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            async: true,
            data: dados,
            success: function (response) {
                if (response.success) {
                    alert(mensagemSucesso);
                    location.reload(); // Atualiza a página
                } else {
                    alert(mensagemErro + ': ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor. Tente novamente.');
            }
        });
    }


 /*   $('#btnExcluirProduto').click(function () {
        const dados = $('#cadProduto').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'excluirProduto.php',
            async: true,
            data: dados,
            success: function (response) {
                if (response.success) {
                    alert('Apagado com sucesso!');
                    location.reload(); // Atualiza a página
                } else {
                    alert('Erro ao apagar Produto: ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor. Tente novamente.');
            }
        });

        return false; // Impede o envio padrão do formulário
    });*/


    $(document).on('click', '.btnExcluirProduto', function () {
    const idProduto = $(this).data('id');
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'excluirProduto.php',
            data: { id: idProduto },
            success: function (response) {
                if (response.success) {
                    alert('Produto excluído com sucesso!');
                    location.reload();
                } else {
                    alert('Erro ao excluir produto: ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    }
});
});
 
  
</script>


