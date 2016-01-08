<div id="list">

<?php
use \Models\Articles;
use \Models\Categories;
?>

<form action="<?php echo htmlentities($_SERVER["REQUEST_URI"]);?>" method="get">
<select name="category_id" onchange="this.form.submit();">
<option value="0">--- Tout ---</option><?php
$categories = Categories::find();
foreach($categories as $category){?>
	<option value="<?php echo $category->primaryKey;?>"<?php if($category->primaryKey == @$_GET["category_id"]) echo 'selected="selected"';?>><?php echo $category->category;?></option><?php
}?>
</select>
</form>

<table><?php
if(@$_GET["category_id"] != 0)
	$categories = array(Categories::findByPk($_GET["category_id"]));
else
	$categories = Categories::find();
foreach($categories as $category){
?>
	<tr><td colspan="4"><h2><?php echo $category->category;?></h2></td></tr>
	<tr>
		<th>Image</th>
		<th>Titre</th>
		<th>Prix</th>
		<th>Panier</th>
	</tr><?php
	$articles = $category->articles;
	foreach($articles as $article){?>
		<tr>
			<td><img src="assets/images/articles/<?php echo $article->picture;?>" alt="<?php echo $article->title;?>" /></td>
			<td><a href="view?id=<?php echo $article->primaryKey;?>"><?php echo $article->title;?></a></td>
			<td class="prix"><?php echo number_format($article->price, 2);?></td>
			<td><a href="basket?action=add&amp;id=<?php echo $article->primaryKey;?>">Ajouter au panier</a></td>
		</tr><?php
	}
}?>
</table>

</div>