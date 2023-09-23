<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Tradutor binário</title>
</head>
<body>
    <?php
        $texto = "";
        $codigo = "" ;
        $binario = "";
        if (isset($_POST['sub-texto'])) {
            $texto = $_POST['texto'];
            $qtd = strlen($texto);
            
            for ($i=0; $i < $qtd; $i++) {
             
                $letra = substr($texto,$i,1);
                
                $codigo = "" ;
                $ascii = ord($letra);

                do {
                    if ($ascii % 2 == 0) {
                        $codigo .= "0";
                    }else  {
                        $codigo .= "1";
                    }

                    $ascii = intdiv($ascii,2);
                    
                } while ($ascii != 0);
                if (is_numeric($letra) or $letra == " "){
                    $codigo .= "00";
                }else{
                    $codigo .= "0";
                }
                $binario .= strrev($codigo)." ";
            }
        }
        
        if (isset($_POST['sub-binario'])) {
            $binario = $_POST['binario'];
            $binario = preg_replace('/\s+/', '', $binario);
            $bytes = str_split($binario, 8);

            foreach ($bytes as $byte) {
                $decimal = 0;
                $tamanho = strlen($byte);

                for ($i = $tamanho - 1, $j = 0; $i >= 0; $i--, $j++) {
                    $bit = $byte[$i];
                    $decimal += $bit * pow(2, $j);
                }

                $texto .= chr($decimal);
            }
        }
    ?>
    <div class="container">
        <div class="left-side">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="idtexto">Texto para codificar:</label>
                <textarea name="texto" id="idtexto"><?=$texto?></textarea>
                <input type="submit" value="Codificar" name="sub-texto">
            </form>
        </div>
        <div class="right-side">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="idbinario">Binario para decodificar:</label>
                <textarea type="number" name="binario" id="idbinario"><?=$binario?></textarea>
                <input type="submit" value="Decodificar" name="sub-binario">
            </form>
        </div>
    </div>
</body>
</html>