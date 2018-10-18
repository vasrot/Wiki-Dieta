<?php
    require_once 'easyrdf/vendor/autoload.php';
?>

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
        
        if($movement=="Q3314483"){
            $nombre="Frutas";
        }else if ($movement=="Q178"){
            $nombre="Pasta";
        }else if ($movement=="Q10990"){
            $nombre="Carnes";
        }else if ($movement=="Q12117"){
            $nombre="Cereales";
        }else{
            $movement=="Q11004";
            $nombre="Vegetales";
        }
        
        $cont=0;
        $sparql = new EasyRdf_Sparql_Client('http://query.wikidata.org/sparql');
        $sparql2 = new EasyRdf_Sparql_Client('http://query.wikidata.org/sparql');
        echo "<h2>Futuros articulos disponibles en ". $nombre .":</h2>";
        echo "<table cellspacing='0' cellpadding='0'>";

        

        $result2 = $sparql2->query(
            'SELECT ?imageLabel ?itemLabel '.
            'WHERE {  ?item wdt:P279 wd:'. $movement .'.'.
            '?item wdt:P18 ?image'.
            '  SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en". }'.
            '}'
            
        );

        $result = $sparql->query(
            'SELECT DISTINCT ?item ?kj WHERE {'.
            'SERVICE <http://dbpedia.org/sparql> {'.
            '?item <http://dbpedia.org/property/kj> ?kj'.
            '}'.
            '}'
            
        );
       $cont=0;
        //var_dump($array);
        foreach ($result2 as $row) {
            //echo "<tr>";
            //echo .$row->imageLabel.;
            //echo "<li>".$row->imageLabel."</li>";
            if(isset($row->itemLabel)){
                $myText = (string)$row->itemLabel;
               // $array = $array.$row->itemLabel;
               global $cont;
               //$array = "";


                  if($cont==0){
                    $cont++;
                    $array = "";
                $array = $array.$row->itemLabel; 
        	
              // array_push ( $array , "hola2" );
                //echo $array;
                if($myText[0]!='Q'){
                   // if($cont<$numresults){
                        if($row->itemLabel!="Wichs"){
                        
                        $calamar="http://dbpedia.org/resource/".$row->itemLabel;
                        
                        foreach ($result as $row2) {
                            // echo "holaa";
                             //echo "<li>".$row->item."</li>";
                            // $mengano=$row->item;
                             if(strcasecmp($calamar, $row2->item) == 0){//.$row->itemLabel.=="http://dbpedia.org/resource/"){
                                echo "<li>".$row->itemLabel."</li>";
                                echo "<img src='".$row->imageLabel."' border='0' width='300' height='100'>";
                                //echo "<li>".$row2->kj."</li>";
                                $kilocal=$row2->kj;
                                //echo "<li>".$kilocal."</li>";
                                $kilocal=(int)str_replace(' ', '', $kilocal);
                                $kilocal = $kilocal*0.239006;
                                echo "<li>".$kilocal."</li>";
                                
                             }
                            // echo "<p></p>";
                             
                         }
                        $cont++;
                        }
                    }
                  }else{
               if($array!=$row->itemLabel){
                $array = "";
                $array = $array.$row->itemLabel; 
        	
              // array_push ( $array , "hola2" );
                //echo $array;
                if($myText[0]!='Q'){
                   // if($cont<$numresults){
                        if($row->itemLabel!="Wichs"){
                        
                        $calamar="http://dbpedia.org/resource/".$row->itemLabel;
                        
                        foreach ($result as $row2) {
                            // echo "holaa";
                             //echo "<li>".$row->item."</li>";
                            // $mengano=$row->item;
                             if(strcasecmp($calamar, $row2->item) == 0){//.$row->itemLabel.=="http://dbpedia.org/resource/"){
                                 if($row->itemLabel!="cherry" && $row->itemLabel!="banana" && $row->itemLabel!="watermelon" && $row->itemLabel!="apricot"){
                                echo "<li>".$row->itemLabel."</li>";
                                echo "<img src='".$row->imageLabel."' border='0' width='300' height='100'>";
                                //echo "<li>".$row2->kj."</li>";
                                $kilocal=$row2->kj;
                                //echo "<li>".$kilocal."</li>";
                                $kilocal=(int)str_replace(' ', '', $kilocal);
                                $kilocal = $kilocal*0.239006;
                                echo "<li>".$kilocal."</li>";
                                 }
                             }
                            // echo "<p></p>";
                             
                         }
                        $cont++;
                        }
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
                <option value="Q3314483">Frutas</option>
                <option value="Q178">Pasta</option>
                <option value="Q10990">Carnes</option>
                <option value="Q12117">Cereales</option>
                <option value="Q11004">Vegetales</option>
                </select>
                </p>
                
                <p>
                <label hidden for="numresults">Número resultados:</label><br>
                <select hidden name="numresults">
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="99999999999">Todos</option>
                </select>
                </p>
                <input type="hidden" name="new_search" value="1"/>
                <button hidden type="submit">Buscar</button>
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