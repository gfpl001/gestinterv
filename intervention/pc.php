<!-- PC FIXES ET PC PORTABLES -->

<form action="intervention/ajout-intervention-pc.php" method="POST">
<!-- Variables "cachées" - lien entre les tables / informations -->
<input type="hidden" name="codePreInterv" value="<?php echo $id; ?>"> <!-- Code pré-intervention -->
<input type="hidden" name="codeClient" value="<?php echo $ligne['codeClient']; ?>"> <!-- Code Client -->

<fieldset> <legend><h1>Nouvelle intervention</h1></legend>

	<div class="ligne"><b>Date de l'intervention</b> : <input name="dateInterv" type="text" size="8" class="calendrier" value="<?php echo date('d/m/Y'); ?>" size="5"> (date du jour)</div><br />
	
	<fieldset id="cadre" style="background-color:#dfdfdf"> <legend> <h4>Nouvelle intervention</h4> </legend>
		<div class="ligne">
			<center>État de l'intervention : <select name="statut">
			<option name="À faire">À faire</option>
			<option name="En cours">En cours</option>
			<option name="Terminé - OK">Terminé - OK</option>
			<option name="En attente">En attente</option>
			</select></center>
		</div>
	</fieldset>
		
	<br />
	
	<fieldset id="cadre"><legend><h3>Partie 1 - Analyses antivirus / anti-spywares</h3></legend>
	<table>
		<td>	
			<table border="1" rules="rows">
				<tr> <td>&nbsp;</td> <td>Analyses<br /><b>externes</b></td> <td>Analyses<br /><b>internes</b></td> <td>Informations<br />complémentaires</td></tr>
				<tr> <td>Virus</td> <td><input name="antivirus-externe" type="text" size="6"></td> <td><input name="antivirus-interne" type="text" id="saisie" size="6"></td> <td><input type="checkbox" name="cookies" value="Cookies traçeurs uniquement"/> Cookies traçeurs uniquement</td> </tr>
				<tr> <td>Malwares</td> <td><input name="malwares-externe" type="text" size="6"></td> <td><input name="malwares-interne" type="text" size="6"></td> <td><input type="radio" name="malwaresbytes-mode" value="Mode COMPLET" /> Mode complet - <input type="radio" name="malwaresbytes-mode" value="Mode RAPIDE" /> Mode rapide</td> </tr>
				<tr> <td>Spybot</td> <td><input name="spybot" type="text" size="6"></td> <td><input type="text" size="6" readonly style="background-color:#dbdbdb;"></td> <td><input type="checkbox" name="scan-redemarrage" value="Scan au redémarrage effectué" /> Scan au redémarrage effectué.</td> </tr>
				<tr> <td colspan="4" align="center" style="padding: 6px 6px 6px 6px;"><b>Informations complémentaires quant aux nettoyages</b></td> </tr>
				<tr> <td colspan="4">Autre : <input type="text" name="nettoyage-annexe" size="55" /></td> </tr>
			</table>
		</td>
		
		<td>
			<table border="1" rules="rows"><th colspan="2">Logiciels de nettoyage annexes</th>
			<tr> <td><input type="checkbox" name="adwcleaner" value="ADW Cleaner effectué"/></td> <td>ADW Cleaner</td> </tr>
			<tr> <td><input type="checkbox" name="ccleaner" value="CCLeaner effectué"/></td> <td>CCleaner</td> </tr>
			<tr> <td>Autre :</td> <td><input type="text" name="nettoyage-annexe" size="25" /></td> </tr>
			</table>
		</td>
	</table>
	</fieldset>

	<br />

	<fieldset id="cadre"><legend><h3>Partie 2 - Sauvegarde des documents</h3></legend>
		<table border="1" rules="all">
			<tr> <th>Dossier "Mes documents" + Bureau</th> <th>Dossiers annexes</th> </tr>
			<tr> <td align="center"><i><input type="text" name="sauvegarde[]" size="50" value="<?php echo $preInterv['dossierMesDocs']; ?>" /></i></td> <td align="center"><i><input type="text" name="sauvegarde[]" size="50" value="<?php echo $preInterv['dossierClt']; ?>" /></i></td> </tr>
			<?php if ( ($preInterv['dossierMesDocs'] != "Aucun document à sauvegarder - ACCORD CLIENT.") || ($preInterv['dossierClt'] != "Aucun document à sauvegarder - ACCORD CLIENT.") ) 
			{ // Si il y a des dossiers à sauvegarder, on affiche une liste pour savoir sur quel serveur les fichiers sont sauvegardés ?>
			<tr> <td colspan="2" align="center"> <div class="ligne">Serveur sur lequel les fichiers sont sauvgardés :<br />
			<select name="sauvegarde[]">
				<option name="Fichiers sauvegardés sur Atelier HAUT">Atelier HAUT</option>
				<option name="Fichiers sauvegardés sur Atelier BAS">Atelier BAS</option>
				<option name="Fichiers sauvegardés sur Atelier 1">Atelier 1</option>
				<option name="Fichiers sauvegardés sur Atelier 2">Atelier 2</option>			
				<option name="Fichiers sauvegardés sur Atelier WIN7">Atelier WIN7</option>			
				</td> </div></tr>
			<?php
			} ?>
		</table>
	</fieldset>
	
	<br />
	
	<fieldset id="cadre"><legend><h3>Partie 3 - Installation / Mise à jour logiciels</h3></legend>
	<div class="ligne"> <b>Suppresion</b> de l'ancien antivirus ->
	<select name="suppression-ancien-antivirus">
		<option name="Non nécessaire">Non nécessaire</option>
		<option name="Antivir">Antivir</option>
		<option name="Avast">Avast</option>
		<option name="AVG">AVG</option>
		<option name="Bitdefender">Bitdefender</option>
		<option name="Comodo">Comodo</option>
		<option name="G-Data">G-Data</option>
		<option name="Kaspersky">Kaspersky</option>
		<option name="McAfee">McAfee</option>
		<option name="Norton">Norton</option>
		<option name="Panda">Panda</option>
	</select></div>
	<ul>
	<?php
	// Requête d'affichage des LOGICIELS
		$logiciels = mysql_query ( "SELECT * FROM tlogiciels ;" ) or die ( mysql_error() ) ;
	// Boucle d'affichage
		while ( $logiciel_affichage = mysql_fetch_array($logiciels) )
		{ echo " <div class='ligne'><li>". $logiciel_affichage['nom'] ."</b> ----> <label> <input type='checkbox' name='logiciels[]' value='Installation ".$logiciel_affichage['nom']."' /> Installation</label> - <label><input type='checkbox' name='logiciels[]' value='MàJ ".$logiciel_affichage['nom']."' /> MàJ</label> </li></div>" ; }
	?>
	</ul>
	<div class="ligne"><label><input type="checkbox" name="maj[]" value="Mises à jour système" /> Installation des <b>mises à jour</b> du système</label> --- <label><input type="checkbox" name="maj[]" value="Service Pack Windows installé(s)" /> <b>Service Pack</b> Windows installé(s)</label></div>
	<div class="ligne"><label><input type="checkbox" name="maj[]" value="Activation Windows" /> <b>Activation</b> Windows</label></div>
	</fieldset>

	<br />

	<fieldset id="cadre"><legend><h3>Partie 4 - Observations & informations complémentaires</h3></legend>
	<div class="ligne"><label><input type="checkbox" name="virus[]" value="PC infecté par des virus & spywares" /> -> <b>PC infecté</b> par des virus & spywares</label> --- <label><input type="checkbox" name="virus[]" value="PC TRES infecté par de nombreux virus & spywares" /> -> <u><b>PC TRES infecté</b> par de nombreux virus & spywares</u></label></div>
	<div class="ligne"><label><input type="checkbox" name="virus[]" value="Présence de Toolbars" /> -> Présence de <b>Toolbars</b>. </label></div>
	<div class="ligne"><label><input type="checkbox" name="virus[]" value="Fiabilité PC douteuse" /> -> <b>Fiabilité PC douteuse</b></label> - Informations complémentaires : <input type="text" name="fiabilite" size="50" /></div>
	<div class="ligne"><label><input type="checkbox" name="virus[]" value="Optimisation du démarage" /> -> <b>Optimisation</b> du démarage.</label> --- <label><input type="checkbox" name="virus[]" value="Réinitialisation des navigateurs web" /> -> <b>Réinitialisation</b> des navigateurs web.</label></div>
	<div class="ligne"><label><input type="checkbox" name="virus[]" value="Fichiers croisés au démarrage - Fiabilité HDD à voir" /> -> <b>Fichiers croisés</b> au démarrage - Fiabilité HDD à voir.</label></div>
	
	<br /><br />
	
	<fieldset><legend><h4>Mémoire</h4></legend>
	<div class="ligne"><label><input type="checkbox" name="ram[]" value="Ajout RAM nécessaire"> <b>Ajout de mémoire vive (RAM) nécessaire</b> pour plus de rapidité</label> - 
		<b>Quantité de mémoire vive à ajouter</b> :
		<select name="ram[]">
			<option value="Pas d'ajout de RAM nécessaire"></option>
			<option value="512 Mo">512 Mo</option>
			<option value="1 Go">1 Go</option>
			<option value="2 Go">2 Go</option>
			<option value="3 Go">3 Go</option>
			<option value="4 Go">4 Go</option>
		</select>
	| 
	<b>Type de RAM</b> :
		<select name="ram[]">
			<option value=""></option>
			<option value="DDR">DDR</option>
			<option value="DDR2">DDR 2</option>
			<option value="DDR3">DDR 3</option>
			<option value="SO-DIMM">SO-DIMM</option>
		</select>
	</div>
		
	<div class="ligne"><label><input type="checkbox" name="ram[]" value="RAM déjà installée dans le PC - Voir accord client"> <b>RAM déjà installée dans le PC</b> - <u>Voir pour accord / acceptation client.</u></label></div>
	</fieldset>
	
	<br />

	<div class="ligne">	Type d'intervention :
		<select name="intervention">
		<option selected value="<?php echo $preInterv['typeInterv']; ?>">[ Présélection ] - <?php echo $preInterv['typeInterv']; ?></option>
		<?php
		// Requête d'affichage des TYPE D'INTERVENTIONS
			$type_interv = mysql_query ( "SELECT * FROM ttypeinterv ;" ) or die ( mysql_error() ) ;
		// Boucle d'affichage
			while ( $interv = mysql_fetch_array($type_interv) )
			{ echo "<option value='" . $interv['interv'] . "'>" . $interv['interv'] . "</option>"; }
		?>
		</select></div>
		
	<div class="ligne">	Matériel :
		<select name="materiel">
			<option selected value="<?php echo $preInterv['materiel']; ?>">[ Présélection ] - <?php echo $preInterv['materiel']; ?></option>
			<?php
			$req3 = mysql_query ( "SELECT * FROM ttypemateriel ;" )  or  die ( mysql_error() ) ; // Requête d'affichage des TYPE D'INTERVENTIONS
			while ( $ligne33 = mysql_fetch_array($req3) ) // Boucle d'affichage
			{ echo "<option value='" . $ligne33['materiel'] . "'>" . $ligne33['materiel'] . "</option>"; }
			?>
		</select></div>
		
	<div class="ligne">	Observations : <textarea name="observation" type="text" cols="60" rows="8"><?php echo $preInterv['observations'] ; ?></textarea></div>
		
	<div class="ligne">	Suivi par :
		<select name="technicien">
		<?php
		// Requête d'affichage des TYPE D'INTERVENTIONS
			$req2 = mysql_query ( "SELECT * FROM ttechniciens ;" ) or die ( mysql_error() ) ;
		
		// Boucle d'affichage
			while ( $ligne22 = mysql_fetch_array($req2) )
			{ echo "<option value='" . $ligne22['nom'] . "'>" . $ligne22['nom'] . "</option>"; } ?>
		</select>
	</div>
		
	<div class="ligne">	Coût total : <input name="prix" type="text" size="4" required> €</div>
	</fieldset>
	<br /><br />
	
	<center><button id="bouton">Ajouter & IMPRIMER</button></center>
	<br />
	
</fieldset>
</form>
