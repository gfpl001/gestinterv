﻿<center>
<fieldset><legend>﻿<h4>Recherche d'un client</h4></legend>
<center>
<form name="Recherche client par le NOM" action="index.php?p=seeknom" method="POST" class="form-seek">
	<input type="text" name="nom" id="search" placeholder="NOM du client"> <input type="submit" value="Recherche" id="submit">
</form>
<form name="Recherche client par un TELEPHONE" action="index.php?p=seektel" method="POST" class="form-seek">
	<input type="text" name="tel" id="search" placeholder="Téléphone FIXE" > <input type="submit" value="Recherche" id="submit">
</form>
</fieldset>
</center>
<br /><br />
<?php
//Création de la fiche client si les "_POST" ne sont pas vides
if ( (isset($_POST['verif'])) && ($_POST['verif']=='add-formulaire') && (count($_POST) != 0) )
{
	$nom		= $_POST["nom"]; $nom = addslashes($nom);
	$telFixe	= $_POST["telFixe"];
	$telPort	= $_POST["telPort"]; 
	$adresse 	= $_POST["adresse"]; $adresse = addslashes($adresse);

// Ajout dans la base de données
	$add		= "INSERT INTO tclients VALUES ('','$nom','','$telFixe','$telPort','$adresse');" ;
	$ajout1		= mysql_query ( $add )  or  die( mysql_error() ) ;
			
// Reprise du code client
	$client		= mysql_query ( "SELECT codeClient FROM tclients WHERE nom='$nom';" )  or  die( mysql_error() ) ;
	$ligne		= mysql_fetch_array( $client );
	$id			= $ligne['codeClient'];
		
// PRE-INTERVENTION
	$dateDepot = $_POST["dateDepot"];
	$dateRestitution = $_POST["dateRestitution"];
	$materiel = $_POST["materiel"];
	$password = $_POST["password"]; $password = addslashes($password);
	$typeInterv = $_POST["typeInterv"];
	$observations = $_POST["observations"]; $observations = addslashes($observations);

	if ( !empty($_POST['dossierMesDocs']) )
	{ $dossierMesDocs = $_POST['dossierMesDocs']; }
	else { $dossierMesDocs = "Aucun document à sauvegarder - ACCORD CLIENT."; }
		
	if ( !empty($_POST['dossiersClt']) )
	{ $dossiersClt = $_POST['dossiersClt']; $dossiersClt = addslashes($dossiersClt); }
	else { $dossiersClt = "Aucun document à sauvegarder - ACCORD CLIENT."; }
	
	$add1		= "INSERT INTO tpreinterv VALUES ('','$id','$dateDepot','$dateRestitution','$materiel','$typeInterv','$observations','$password','$dossierMesDocs','$dossiersClt');" ;
	$ajout2		= mysql_query ( $add1 )  or  die( mysql_error() ) ;
	
	$lastadd = mysql_insert_id(); // Reprise du code de l'intervention pour la redirection
	
	echo "<hr /><center><h2> Ajout réussi !</h2><br />
	Cliquez sur le bouton pour imprimer : <form action='interventions/print_preinterv.php' method='post'> <input type='hidden' name='id' value='".$lastadd."'> <input type='submit' value='IMPRIMER' style='width:250px; height:50px;font-size:14px;'></form>
	</center><hr />";
}
//else { echo "Aucune donnée en cache. <br />"; }

if ( (isset($_POST['lien'])) && ($_POST['lien']=='add-tabClient') && (count($_POST) != 0) )
{ $id = $_POST["id"];
$sql = mysql_query ( "SELECT * FROM tclients WHERE codeClient='$id'" )  or  die ( mysql_error() ) ;
$ligne = mysql_fetch_array($sql);
?>
<form action="#" method="POST">
<fieldset style="width:600px; text-align:justify;"><legend><h3>Coordonnés client</h3></legend>
	<b>NOM</b> : <input name="nom" type="text" required value="<?php echo $ligne['nom']; ?>"><br />
	<b>Tél fixe</b> : <input name="telFixe" value="<?php echo $ligne['telFixe']; ?>" type="text"> - Tél portable : <input name="telPort" value="<?php echo $ligne['telPort']; ?>" type="text"><br />
	Adresse : <input name="adresse" value="<?php echo $ligne['adresse']; ?>" type="text" size="55">
</fieldset>
<br />
<?php }

else {?>
<form action="#" method="POST">
<fieldset style="width:600px; text-align:justify;"><legend><h3>Coordonnés client</h3></legend>
	<b>NOM</b> : <input name="nom" type="text" required><br />
	<b>Tél fixe</b> : <input name="telFixe" type="text"> - Tél portable : <input name="telPort" type="text"><br />
	Adresse : <input name="adresse" type="text" size="55">
</fieldset>
<br />
<?php };?>
<br />

<fieldset style="width:600px; text-align:justify;"><legend><h3>Intervention à effectuer</h3></legend>
	<b>Date de dépôt</b> du matériel <input name="dateDepot" type="text" value="<?php echo date('d/m/Y'); ?>" size="8" class="calendrier"> | <b>Date de restitution</b> prévue : <input name="dateRestitution" type="text" size="8" class="calendrier"><br />
	<b>Matériel</b> :
	<select name="materiel">
	<?php
		$req3 = mysql_query ( "SELECT * FROM ttypemateriel ;" )  or  die ( mysql_error() ) ; // Requête d'affichage des TYPE D'INTERVENTIONS
		while ( $ligne33 = mysql_fetch_array($req3) ) // Boucle d'affichage
		{ echo "<option value='" . $ligne33['materiel'] . "'>" . $ligne33['materiel'] . "</option>"; }
	?>
	</select>
	<br />
	<b>Mot de passe</b> de session : <input type="text" name="password"><br />
	<b>Type d'intervention</b> :
	<select name="typeInterv">
	<?php
	// Requête d'affichage des TYPE D'INTERVENTIONS
		$type_interv = mysql_query ( "SELECT * FROM ttypeinterv ;" )  or  die ( mysql_error() ) ;
	// Boucle d'affichage
		while ( $interv = mysql_fetch_array($type_interv) )
		{ echo "<option value='" . $interv['interv'] . "'>" . $interv['interv'] . "</option>"; }
	?>
	</select><br />
	<b>Observations</b> :<br />
	<textarea name="observations" cols="60" rows="8"></textarea><br /><br />
	<fieldset style="text-align:justify;"><legend><h3>Fichiers à sauvegarder</h3></legend>
	<label><input type="checkbox" name="dossierMesDocs" value="Dossier Mes documents + Bureau"> Dossier <b>Mes documents</b> + <b>Bureau</b></label><br />
	<b>Dossier(s) spécifique(s) à sauvegarder</b> : <input type="text" name="dossiersClt">
	</fieldset>
<input type="hidden" name="verif" value="add-formulaire" />
</fieldset>
<br />
<center><input type="submit" value="Ajouter & IMPRIMER" style="width:250px; height:50px;font-size:14px;"></center>

</form>
</center>
