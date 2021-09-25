<?php
    include_once("../arquivosPHP/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>


    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../pesquisa/pesquisa.css">
        
</head>

<body>
    <?php
        include_once("../cabecalho/cabecalho.html");
    ?>
    <h1 style="text-align: center; margin-top: 20px;">Cadastrar aluno</h1>
    <br>



    <div class="divCentralizada" style="width: 750px;">

        <form action="">
            <label for="txtNome">Nome do aluno:</label>
            <input type="text" name="txtNome" id="txtNome" class="input-text" required>
            <br><br>

            <label for="listTurma">Turma do aluno:</label>
            <select name="listTurma" id="listCurso" required style="width: 100%;">
                <option value="" selected disabled hidden>Selecionar</option>
                <?php
                    
                    $sql = "SELECT idTurma, nome FROM Turma";

                    $turma = $conn -> query($sql);

                    while ($rowTurma = $turma->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $rowTurma["idTurma"]; ?>"><?php echo $rowTurma["nome"]; ?></option>
                        <?php
                    }

                ?>
            </select>
            <br><br>

            <label for="txtResponsavel">Responsável</label>
            <select name="txtResponsavel" id="txtResponsavel" style="width: 100%;" required>
                <option value="" selected disabled hidden>Selecionar</option>
                <?php
                    
                    $sql = "SELECT id, nome, email FROM Responsavel";

                    $dadosResponsavel = $conn -> query($sql);

                    while ($responsavel = $dadosResponsavel->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $responsavel["id"]; ?>"><?php echo $responsavel["nome"]; ?> - <?php echo $responsavel["email"]?></option>
                        <?php
                    }

                ?>
            </select>
            <br><br>

            <div style="text-align: center;">
                <input type="submit" value="Adicionar" class="formBtn adicionar">
                <input type="reset" value="Limpar" class="formBtn limpar">
            </div>
            

        </form>

    </div>

</body>


</html>