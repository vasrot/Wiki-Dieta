<?php
 
/*
Plugin Name: Wikidata Plugin
Plugin URI: 
Description: Create a search page for wikidata.
Version: 1.0
Author: Pablo Guijarro Marco
Author URI: 
*/
 
/**
 * Función que instancia el Widget
 */
//function mywikidata_create_widget(){    
    //include_once(plugin_dir_path( __FILE__ ).'/includes/widget.php');
    //register_widget('mywikidata_widget');
//}
//add_action('widgets_init', 'mywikidata_create_widget');

require_once 'easyrdf/vendor/autoload.php';

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

register_activation_hook(__FILE__,'mywikidata_install');

function mywikidata_install() {
   global $wp_version;
   If (version_compare($wp_version, "2.9", "<")) 
    { 
      deactivate_plugins(basename(__FILE__)); // Deactivate plugin
      wp_die("This plugin requires WordPress version 2.9 or higher.");
    }
    
    // create page
    check_pages_live();
}

add_filter( 'template_include', 'wikidata_page_template');

function wikidata_page_template( $template ) {

    if ( is_page( 'wikidata-search' )  ) {
        $new_template = plugin_dir_path( __FILE__ ) . 'templates/wikidata-page-template.php';
		return $new_template;
    }

    return $template;
}


function check_pages_live(){
    if(get_page_by_title( 'wikidata-search') == NULL) {
        create_pages_fly('wikidata-search');
    }
}

function create_pages_fly($pageName) {
	$createPage = array(
	  'post_title'    => $pageName,
	  'post_content'  => 'Wikidata Search Example',
	  'post_status'   => 'publish',
	  'post_author'   => 1,
	  'post_type'     => 'page',
	  'post_name'     => $pageName
	);

	// Insert the post into the database
	wp_insert_post( $createPage );
}

function example_dbpedia_call(){
	
	EasyRdf_Namespace::set('category', 'http://dbpedia.org/resource/Category:');
    EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');
    EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
    EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');
	
	$sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
	
	echo "<h2>List of countries</h2>";
    echo "<ul>";

		$result = $sparql->query(
			'SELECT * WHERE {'.
			'  ?country rdf:type dbo:Country .'.
			'  ?country rdfs:label ?label .'.
			'  ?country dc:subject category:Member_states_of_the_United_Nations .'.
			'  FILTER ( lang(?label) = "en" )'.
			'} ORDER BY ?label'
		);
		foreach ($result as $row) {
			echo "<li>".$row->label."</li>\n";
		}

	echo "</ul>";
	echo "<p>Total number of countries:". $result->numRows() ."</p>";
	
	/*$foaf = new EasyRdf_Graph("http://njh.me/foaf.rdf");
	$foaf->load();
	$me = $foaf->primaryTopic();
	echo "My name is: ".$me->get('foaf:name')."\n";*/
}

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