
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
    <main>
        <h1>Conversor de Moedas</h1>
        <?php 

            $dateInicio = date("m-d-Y", strtotime(" - 7 days")); // data atual menos 7 dias
            $dateAtual = date("m-d-Y"); // data atual do sistema formatado de acordo com a data da url

            // após copiar a url formatar a data com caracter de escape aantes das aspas simples \'00-00-0000\', porém iremos substituir pela data do sistema com a formatação igual a da url usando interpolação
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $dateInicio .'\'&@dataFinalCotacao=\''.$dateAtual.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dadosUrl = json_decode(file_get_contents($url), true); // true é um param opcional para retornar um array. false ou sem o param retorna object.
            //var_dump($dados); // mostra a estrutura dos dados
            $padraoCourrencyFtm = numfmt_create("pt_PT", NumberFormatter::CURRENCY); //definindo o padrao de formatação para moeda
            $cambio = $dadosUrl["value"][0]["cotacaoCompra"]; // navegando pelas 'chaves' que contém o dados que desejo 
        
            $real = $_GET["din"];
            $dolar = $real / $cambio;

            // numfmt_format_currency(NumberFormatter $formatter, float $amount, string $currency)
            echo "<p> Seus " . numfmt_format_currency($padraoCourrencyFtm, $real, "BRL") . " <br> Equivalem a: " . numfmt_format_currency($padraoCourrencyFtm, $dolar, "USD");


        ?>
    </main>
</html>