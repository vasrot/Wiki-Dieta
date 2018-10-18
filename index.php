<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wiki Dieta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<?php 
    function movement_wikidata_call($numresults, $movement){
        
        if($movement=="Q11442"){
            $nombre="Bicicletas";
        }else if ($movement=="Q6149036"){
            $nombre="Decoracion";
        }else if ($movement=="Q11460"){
            $nombre="Ropa";
        }else{
            $nombre="Tecnologia";
        }
        
        $cont=0;
        $sparql = new EasyRdf_Sparql_Client('http://query.wikidata.org/sparql');
        
        echo "<h2>Futuros articulos disponibles en ". $nombre .":</h2>";
        echo "<table cellspacing='0' cellpadding='0'>";

        $result = $sparql->query(
            'SELECT ?imageLabel ?itemLabel '.
            'WHERE {  ?item wdt:P31 wd:'. $movement .'.'.
            '?item wdt:P18 ?image'.
            '  SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en". }'.
            '}'
            
        );
        foreach ($result as $row) {
            //echo "<tr>";
            //echo .$row->imageLabel.;
            //echo "<li>".$row->imageLabel."</li>";
            if(isset($row->itemLabel)){
                $myText = (string)$row->itemLabel;
                
                if($myText[0]!='Q'){
                    if($cont<$numresults){
                        if($row->itemLabel!="Wichs"){
                        echo "<li>".$row->itemLabel."</li>";
                        //echo '<img src="https://commons.wikimedia.org/wiki/File:39%20x%2024%20Star%20Bicycle.jpg">';
                        echo "<img src='".$row->imageLabel."' border='0' width='300' height='100'>";
                        
                        $cont++;
                        }
                    }
                }
            }else {
                echo "<h5>Error</h5>";
            }
            //echo $movement;
            echo "<p></p>";
            
        }
            
    }
?>

<body>
    
    <div class="wrap">
        <fieldset>
            <legend>Próximos artículos disponibles</legend>
            <p>Consulta por categorías los artículos que estarán disponibles próximamente en commerce eXtreme</p>
            <form method="post" name="front_end" action="" >
                <p>
                <label for="numresults">Categoría:</label><br>
                <select name="movement">
                <option value="Q11442">Bicicletas</option>
                <option value="Q6149036">Decoración</option>
                <option value="Q11460">Ropa</option>
                <option value="Q2425052">Tecnología</option>
                </select>
                </p>
                
                <p>
                <label for="numresults">Número resultados:</label><br>
                <select name="numresults">
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="99999999999">Todos</option>
                </select>
                </p>
                <input type="hidden" name="new_search" value="1"/>
                <button type="submit">Buscar</button>
            </form>
        </fieldset>

        <?php
        if(isset($_POST['new_search']) == '1') {
            $movement = $_POST['movement'];
            
            //if(isset($numresults))
                $numresults = $_POST['numresults'];
            //else
                //$numresults = 10;
            
            movement_wikidata_call($numresults, $movement);
        }
        ?>
        
    </div><!-- .wrap -->

</body>

</html>