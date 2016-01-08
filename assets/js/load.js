window.onload=function()
{
	// Initialisation des comportements sur les liens
	var liens = document.getElementsByTagName('a');
	for (var i=0, iMax=liens.length ; i < iMax; i++) {
		behav_link(liens[i]);
	}
	
	// Initialisation des comportements sur les formulaires
	var formulaires = document.getElementsByTagName('form');
	for(var i = 0; i < formulaires.length; i++){
		formulaires[i].onsubmit = function(){ 
			return verif_form(this);
		}
	}
}

window.onunload = function() 
{

}