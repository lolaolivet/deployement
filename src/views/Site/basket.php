<?php
use \Models\Articles;

// Ajout au panier
if(@$_REQUEST["action"] == 'add'){		
	$article = Articles::findByPk($_REQUEST["id"]);
	// Si l'article est déjà dans le panier, on en ajoute 1, sinon on en met un premier
	$nombre = 0;
	if(isset($_SESSION["panier"][$_REQUEST["id"]]))
		$nombre = $_SESSION["panier"][$_REQUEST["id"]]["nombre"];
	
	// On ajoute l'article à la session panier
	$_SESSION["panier"][$_REQUEST["id"]] = array('id'=>$_REQUEST["id"], 'titre'=>$article["title"], 'prix'=>$article["price"], 'nombre'=>$nombre+1);
	Header("Location:".parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

// Modification d'un article du panier
if(@$_REQUEST["action"] == 'mod'){
	if(@$_REQUEST["id"] != ''){
		// Suppression de l'article du panier
		if(@$_REQUEST["nombre"] == 0){
			unset($_SESSION["panier"][$_REQUEST["id"]]);
			// S'il n'y a plus d'articles dans le panier, on le supprime
			if(count($_SESSION["panier"]) == 0)
				unset($_SESSION["panier"]);
		}
		// Modification de la quantité d'un article
		else{
			$_SESSION["panier"][$_REQUEST["id"]]["nombre"] = $_REQUEST["nombre"];
		}
	}
	Header("Location:".parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

// Suppression d'un article ou de tous les articles
if(@$_REQUEST["action"] == 'del'){
	// Suppression d'un article
	if(@$_REQUEST["id"] != ''){
		unset($_SESSION["panier"][$_REQUEST["id"]]);
		// S'il n'y a plus d'articles dans le panier, on le supprime
		if(count($_SESSION["panier"]) == 0){
			unset($_SESSION["panier"]);
		}
	}
	// Suppression du panier
	else{
		unset($_SESSION["panier"]);
	}
	Header("Location:".parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
?>

<div id="list"><?php
if(isset($_SESSION["panier"])){?>
<table>
	<tr>
		<th>Article</th>
		<th>Nombre</th>
		<th>Prix unitaire</th>
		<th>Prix total</th>
		<th></th>
	</tr><?php
	$prixTotal = 0;
	foreach($_SESSION["panier"] as $line){?>
		<tr>
			<td><a href="view?id=<?php echo $line["id"];?>"><?php echo utf8_encode($line["titre"]);?></a></td>
			<td><?php echo '
				<form action="'.htmlentities($_SERVER["REQUEST_URI"]).'" method="post">
				<input type="hidden" name="action" value="mod" />
				<input type="hidden" name="id" value="'.$line["id"].'" />
				<input type="text" name="nombre" value="'.$line["nombre"].'" size="2" maxlength="2" />
				<input type="submit" value="GO" />
				</form>';?>
			</td>
			<td class="prix"><?php echo number_format($line["prix"], 2);?></td>
			<td class="prix"><?php echo number_format($line["nombre"] * $line["prix"], 2);?></td>
			<td><a href="basket?action=del&amp;id=<?php echo $line["id"];?>">Supprimer cet article</a>
		</tr><?php
		$prixTotal += $line["nombre"] * $line["prix"];
	}?>
	<tr>
		<td class="prix" colspan="3">Total</td>
		<td class="prix"><?php echo number_format($prixTotal, 2);?></td>
		<td><a href="basket?action=del">Effacer tout le panier</a></td>
	</tr>
</table>
<br /><br /><?php
}
else{
	$flashMessage = "Panier vide!";
}?>
</div>