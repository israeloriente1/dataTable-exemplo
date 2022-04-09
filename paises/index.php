<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paises</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <div class="tableContainer">
        <table id="countriesTable" class="display">
            <caption>População das Unidades Federativas</caption>
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Continente</th>
                    <th scope="col">Região</th>
                    <th scope="col">Linguagem</th>
                    <th scope="col">População</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once "./includes/banco.php";
                    $countries = $banco->query("select * from getCountries;");
                    $total = $banco->query("select sum(population) as total from getCountries;"); // Irá receber a soma do total das população de todos os países.

                    if (!$countries or !$total){ // Caso alguma das variáveis não retorne o registro preciso
                        print "<p class='erro'>Ops parece que houve algum problema, por favor tente novamente mais tarde.</p>";
                        $total = false;
                    }else {
                        if ($countries->num_rows > 1){
                            while ($country = $countries->fetch_object()){
                                $population = number_format($country->population, 0, ".", ".");
                                print "
                                    <tr>
                                        <td><a href='./pages/countryinfo.php?code=$country->code&country=$country->name'>$country->name</a></td>
                                        <td>$country->continent</td>
                                        <td>$country->region</td>
                                        <td>$country->language</td>
                                        <td>$population</td>
                                    </tr>
                                ";
                            }
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="4">Total</th>
                    <?php
                        if ($total <> false){
                            $total = $total->fetch_object()->total;
                            $total = number_format($total, 0, ".", ".");
                        }
                        print "<td>$total</td>";
                    ?>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#countriesTable").DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
                }
            });
        });

        titulo = document.getElementById("title");      
        document.title = titulo.innerText;
    </script>

    <?php $banco->close(); ?>
</body>
</html>