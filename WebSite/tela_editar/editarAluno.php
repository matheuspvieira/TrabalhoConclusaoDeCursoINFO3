<?php
    include_once("../conexao.php");
    include_once ('../dados_login.php');
    $logged = $_SESSION['logged'] ?? null;
    if(!$logged){
        die(header("Location: ../index.php"));
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="icon" href="../imagens/icone_PrefeituraOuroBranco.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
        
</head>

<body>
    <?php
        include_once("../cabecalho/cabecalho_listar.php");

        //Buscar dados do objeto a ser editado no banco
        if(isset($_GET["matricula"])){
            $matricula = $_GET["matricula"];
            $sql = "SELECT * from Aluno where matricula = $matricula"; 
            $consulta = $conn->query($sql);
            $exibir = $consulta->fetch_assoc();
        }

    ?>
    <h1 style="text-align: center; margin-top: 20px;">Editar aluno</h1>
    <br>



    <div class="divCentralizada" style="width: 750px;">

        <form action="../php_atualizar/atualizarAluno.php?matricula=<?php echo $_GET['matricula'] ?>" method="POST">
            <label for="txtNome">Nome do aluno:</label>
            <input type="text" name="txtNome" id="txtNome" class="input-text" required value="<?php echo $exibir["nome"] ?>">
            <br><br>

            <div>
                <ul>
                    <li style="display: inline-block; width: 20%; margin-right: 15px;" >
                        <label for="listAnoTurma">Ano:</label> <br>
                        <select name="listAnoTurma" id="listAnoTurma" required style="width: 100%;" onchange="listarRegistros()">
                            <?php
                                
                                $sql = "SELECT distinct ano from Turma ORDER BY ano DESC;";

                                $turma = $conn->query($sql);

                                while ($rowTurma = $turma->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $rowTurma["ano"]; ?>"><?php echo $rowTurma["ano"]; ?></option>
                                    <?php
                                }

                            ?>
                        </select>
                    </li>
                    <li style="display: inline-block; width: 77%;">
                        <div class="resultados"></div>
                    </li>
                </ul>

            </div>

            
            <br>

            <label for="txtResponsavel">Responsável</label>
            <select name="txtResponsavel" id="txtResponsavel" style="width: 100%;" required>
                <option value="" selected disabled hidden>Selecionar</option>
                <?php
                    
                    $sql = "SELECT id, nome, email FROM Responsavel";

                    $dadosResponsavel = $conn -> query($sql);

                    while ($responsavel = $dadosResponsavel->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $responsavel["id"]; ?>"  <?php echo($responsavel["id"] == $exibir["Responsavel_id"])?"selected":"" ?>  ><?php echo $responsavel["nome"]; ?> - <?php echo $responsavel["email"]?> </option>
                        <?php
                    }

                ?>
            </select>
            <br><br>

            <label for="cartaoRFID">Cartões disponíveis</label>
            <select name="cartaoRFID" id="cartaoRFID" style="width: 100%;">
                <option value="0" selected  hidden>Selecionar</option>
                <?php
                    
                    $sql = "SELECT * FROM Cartao WHERE disponivel = 1 OR matriculaAluno = $matricula";

                    $dadosCartoes = $conn -> query($sql);

                    if(mysqli_num_rows($dadosCartoes)>0){
                        while ($cartoes = $dadosCartoes->fetch_assoc()) {
                            if($cartoes["matriculaAluno"] == $matricula){
                                ?>
                                    <option value="<?php echo $cartoes["uid"]; ?>" selected><?php echo $cartoes["uid"]; ?></option>
                                <?php
                            }
                            else{
                                ?>
                                    <option value="<?php echo $cartoes["uid"]; ?>"><?php echo $cartoes["uid"]; ?></option>
                                <?php
                            }
                            
                        }
                    }                    
                ?>
                <option value="0">Remover cartão</option>
            </select>
            <br><br>

            <div style="text-align: center;">
                <input type="submit" value="Editar" class="formBtn adicionar">
                <input type="reset" value="Limpar" class="formBtn limpar">
            </div>
            

        </form>

    </div>

</body>
<script>
    $(document).ready(function(){
        listarRegistros(); // Chamar a função assim que carregar a página
    });

    function listarRegistros() {
        let ano = $('#listAnoTurma').val();
        let dados = {
            anoTurma : ano
        }

        $.post("pesquisaDeDados/pesquisarTurmas.php", dados, function(retorna) {
            $(".resultados").html(retorna);
        });

    }
</script>


</html>