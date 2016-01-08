<div id="view">
	<h1><?php echo $model->title;?></h1>
	<img src="<?php echo App::getBaseUrl();?>/assets/images/articles/<?php echo $model->picture;?>" alt="<?php echo $model->title;?>" />
	<p><?php echo $model->description;?></p>
	<div class="prix"><?php echo number_format($model->price, 2);?></div>
	<a href="<?php echo App::getBaseUrl();?>/basket?action=add&amp;id=<?php echo $model->id;?>">Ajouter au panier</a>
</div>