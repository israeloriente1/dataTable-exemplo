<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informação do país</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <?php
        require_once "../includes/banco.php";
        $code = $_GET["code"] ?? false; // Receberá o ID do país.
        $countryName = $_GET["country"] ?? false;

        # Irá verificar se os valores passado por parâmetro atende os requesitos.
        $code = preg_match("/^[A-Z]{3}$/", $code) ? $code : false;
    ?>

    <div class="tableContainer">
        <table id="cityTable" class="display">
            <thead>
                <tr>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">População</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($code <> false){
                        $cities = $banco->query("
                            select name, population, district from city
                            where countrycode = '$code';
                        ");
                    }
                    // Receberá o total da soma da população de cada cidade.
                    $total = $banco->query("
                            select sum(population) as total from city
                            where countrycode = '$code';
                        ");
                    if ($code == false or !$cities or !$total){
                        print "Ops parece que houve algum erro, por favor tente novamente mais tarde.";
                        $total = false;
        
                    }else {
                        while ($city = $cities->fetch_object()){
                            $population = number_format($city->population, 0, ".", ".");
        
                            print "
                                <tr>
                                    <td>$city->name</td>
                                    <td>$city->district</td>
                                    <td>$population</td>
                                </tr>
                            ";
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="2">Total</th>
                    <?php
                        if ($total <> false){
                            $total = $total->fetch_object()->total;
                            $total = number_format($total, 0, ".", ".");
                            print "<td>$total</td>";
                        }
                    ?>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="../index.php" target="_self" rel="prev" class="botao">Voltar</a>
    

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#cityTable").DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
                }
            });
        });

        titulo = document.getElementById("title");
        document.title = titulo.innerText;
    </script>
    <?php $banco->close() ?>
</body>
</html>