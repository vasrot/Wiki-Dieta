<?php
/**
 * Template Name: Wikidata Page
 *
 */
?>

<?php get_header() ?>

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


<?php get_footer() ?>