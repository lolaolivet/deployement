function behav_link(lien){
	//Ouverture des liens dans une fenêtre externe
	if(lien.getAttribute('data-behavior') == 'ext'){
		lien.title = 'Ouvrir dans une nouvelle fenêtre';
		lien.onclick = function(){
			window.open(this.href);
			return false;
		};
	}
	//Confirmation
	if(lien.getAttribute('data-behavior') == 'confirm'){
		lien.title = 'Confirmer l\'action';
		lien.onclick = function(){
			if(confirm('Ouvrir ce site ?'))
				document.location.href = this.href;
			return false;
		};
	}
	//Fermeture des fenêtres
	if(lien.getAttribute('data-behavior') == 'close'){
		lien.title = 'Fermer la fenêtre en cours';
		lien.onclick = function(){
			window.close();
			return false;
		};
	}
	//Print
	if(lien.getAttribute('data-behavior') == 'print'){
		lien.title = 'Imprimer la fenêtre en cours';
		lien.onclick = function(){
			window.print();
			return false;
		};
	}
	//Ouverture d'une image en PopUp
	if(lien.getAttribute('data-behavior') == 'popup'){
		lien.title = 'Ouvrir l\'image';
		lien.onclick = function(){
			var ImagesLoader = new Image();
			ImagesLoader.onload = function(){ 
				window.open(ImagesLoader.src, '',
					'width='+ImagesLoader.width+', '+
					'height='+ImagesLoader.height+', '+
					'left='+(screen.width-ImagesLoader.width)/2+', '+
					'top=0'
				);
			};
			ImagesLoader.src = this.href;
			return false;
		};
	}
}