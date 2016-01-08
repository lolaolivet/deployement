// Vérification d'email par expression régulière
function verifEmailByReg(mail) {
	// Motif simple
	var pattern = '^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$';
	// Motif complexe ~99.99% de la norme RFC2822
	var pattern2822 = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
	var reg = new RegExp(pattern2822);
	return reg.test(mail);
}

// Vérification d'url par expression régulière
function verifUrlByReg(url) {
	//Motif simple
	var pattern = /(((http|ftp|https):\/\/)|www\.)[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#!]*[\w\-\@?^=%&amp;/~\+#])?/;
	// Motif complet de la norme RFC3986
	var pattern3986 = /^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/;
	var reg = new RegExp(pattern);
	return reg.test(url);
}

function verif_form(formulaire){
	var fields = formulaire.elements;
	for(var i = 0; i < fields.length; i++){
		var input = fields[i];
		//Si un champ obligatoire est vide
		if(input.value == '' && input.getAttribute('required') == 'required'){
			alert('Veuillez entrer quelque chose dans le champ ' + input.name +' svp !');	
			input.focus();
			return false ;
		}
		//Si c'est un mail
		if(input.type == 'email' && input.value != '' && !verifEmailByReg(input.value)){
			alert('Cette adresse e-mail est invalide !');
			input.focus();
			return false ;
		}
		//Si c'est un lien
		if(input.type == 'url' && input.value != '' && !verifUrlByReg(input.value)){
			alert('Ce lien est invalide !');
			input.focus();
			return false ;
		}
	}
	return true;
}