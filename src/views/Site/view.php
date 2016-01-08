<?php
use \Models\Articles;

$article = Articles::findByPk($_GET["id"]);
?>

<div id="view">
	<h1><?php echo $article->title;?></h1>
	<img src="assets/images/articles/<?php echo $article->picture;?>" alt="<?php echo $article->title;?>" />
	<p><?php echo $article->description;?></p>
	<div class="prix"><?php echo number_format($article->price, 2);?></div>
	<a href="basket?action=add&amp;id=<?php echo $article->id;?>">Ajouter au panier</a>
</div>