<?php

/* Copyright (C) 2005		Matthieu Valleton	<mv@seeschloss.org>
 * Copyright (C) 2006-2021	Laurent Destailleur	<eldy@users.sourceforge.net>
 * Copyright (C) 2005-2014	Regis Houssin		<regis.houssin@inodbox.com>
 * Copyright (C) 2007		Patrick Raguin		<patrick.raguin@gmail.com>
 * Copyright (C) 2013		Florian Henry		<florian.henry@open-concept.pro>
 * Copyright (C) 2015       Raphaël Doursenaud  <rdoursenaud@gpcsolutions.fr>
 * Copyright (C) 2020       Frédéric France     <frederic.france@netlogic.fr>
 * Copyright (C) 2024		MDW							<mdeweerd@users.noreply.github.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *		\file       htdocs/categories/card.php
 *		\ingroup    category
 *		\brief      Page to create a new category
 */

use function RectorPrefix202406\print_node;

// Load Dolibarr environment
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

// Load translation files required by the page
// $langs->load("categories");

// Security check


$container_record = $_GET['rowid'];


$sql = "SELECT * FROM llx_containers WHERE rowid ='{$container_record}'";
$result = $db->query($sql);
$result = mysqli_fetch_object($result);


$socid = GETPOSTINT('socid');
// echo "<pre>";
// print_r($user);
// die();
if (!$user->hasRight('categorie', 'lire')) {
	accessforbidden();
}







// $socid = GETPOSTINT('socid');

// // Debugging the user object and its rights
// echo "<pre>";
// var_dump($user->rights); // Dump the user's rights object for debugging
// echo "Checking if user has 'categorie' rights...\n";
// echo "Has right 'categorie'? " . (isset($user->rights->categorie) ? 'Yes' : 'No') . "\n";
// echo "Has right 'lire'? " . (isset($user->rights->categorie->lire) ? 'Yes' : 'No') . "\n";
// echo "</pre>";



















$action = GETPOST('action', 'alpha');
$cancel		= GETPOST('cancel', 'alpha');
$origin		= GETPOST('origin', 'alpha');
$catorigin  = GETPOSTINT('catorigin');
$type = GETPOST('type', 'aZ09');
$urlfrom = GETPOST('urlfrom', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');

$name = (string) GETPOST('name', 'alphanohtml');
// $description = (string) GETPOST('description', 'restricthtml');
// $color = preg_replace('/[^0-9a-f#]/i', '', (string) GETPOST('color', 'alphanohtml'));
// $position = GETPOSTINT('position');
// $visible = GETPOSTINT('visible');
// $parent = GETPOSTINT('parent');

// if ($origin) {
// 	if ($type == Categorie::TYPE_PRODUCT) {
// 		$idProdOrigin     = $origin;
// 	}
// 	if ($type == Categorie::TYPE_SUPPLIER) {
// 		$idSupplierOrigin = $origin;
// 	}
// 	if ($type == Categorie::TYPE_CUSTOMER) {
// 		$idCompanyOrigin  = $origin;
// 	}
// 	if ($type == Categorie::TYPE_MEMBER) {
// 		$idMemberOrigin   = $origin;
// 	}
// 	if ($type == Categorie::TYPE_CONTACT) {
// 		$idContactOrigin  = $origin;
// 	}
// 	if ($type == Categorie::TYPE_PROJECT) {
// 		$idProjectOrigin  = $origin;
// 	}
// }

// if ($catorigin && $type == Categorie::TYPE_PRODUCT) {
// 	$idCatOrigin = $catorigin;
// }
// if (!GETPOSTISSET('parent') && $catorigin) {
// 	$parent = $catorigin;
// }



$object = new Categorie($db);
// $extrafields = new ExtraFields($db);
// $extrafields->fetch_name_optionals_label($object->table_element);

// // Initialize technical object to manage hooks. Note that conf->hooks_modules contains array array
// $hookmanager->initHooks(array('categorycard'));

$error = 0;


/*
 *	Actions
 */
// $parameters = array('socid' => $socid, 'origin' => $origin, 'catorigin' => $catorigin, 'type' => $type, 'urlfrom' => $urlfrom, 'backtopage' => $backtopage, 'name' => $name);
// // Note that $action and $object may be modified by some hooks
// $reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action);
// if ($reshook < 0) {
// 	setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
// }

// if (empty($reshook)) {
// 	// Add action
// 	if ($action == 'add' && $user->hasRight('categorie', 'creer')) {
// 		// Action add a category
// 		if ($cancel) {
// 			if ($urlfrom) {
// 				header("Location: " . $urlfrom);
// 				exit;
// 			} elseif ($backtopage) {
// 				header("Location: " . $backtopage);
// 				exit;
// 			} elseif ($idProdOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idProdOrigin . '&type=' . $type);
// 				exit;
// 			} elseif ($idCompanyOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idCompanyOrigin . '&type=' . $type);
// 				exit;
// 			} elseif ($idSupplierOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idSupplierOrigin . '&type=' . $type);
// 				exit;
// 			} elseif ($idMemberOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idMemberOrigin . '&type=' . $type);
// 				exit;
// 			} elseif ($idContactOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idContactOrigin . '&type=' . $type);
// 				exit;
// 			} elseif ($idProjectOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idProjectOrigin . '&type=' . $type);
// 				exit;
// 			} else {
// 				header("Location: " . DOL_URL_ROOT . '/categories/index.php?leftmenu=cat&type=' . $type);
// 				exit;
// 			}
// 		}
// 		$object->name			= $name;
// 		// $object->color			= $color;
// 		// $object->position		= $position;
// 		// $object->description = dol_htmlcleanlastbr($description);
// 		$object->socid			= ($socid > 0 ? $socid : 0);
// 		// $object->visible = $visible;
// 		// $object->type = $type;

// 		// if ($parent != "-1") {
// 		// 	$object->fk_parent = $parent;
// 		// }

// 		// $ret = $extrafields->setOptionalsFromPost(null, $object);
// 		// if ($ret < 0) {
// 		// 	$error++;
// 		// }

// 		// if (!$object->label) {
// 		// 	$error++;
// 		// 	setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Ref")), null, 'errors');
// 		// 	$action = 'create';
// 		// }

// 		// Create category in database
// 		if (!$error) {
// 			$result = $object->create($user);
// 			if ($result > 0) {
// 				$action = 'confirmed';
// 			} else {
// 				setEventMessages($object->error, $object->errors, 'errors');
// 			}
// 		}
// 	}
// 	// Confirm action
// 	if (($action == 'add' || $action == 'confirmed') && $user->hasRight('categorie', 'creer')) {
// 		// Action confirmation of creation category
// 		if ($action == 'confirmed') {
// 			if ($urlfrom) {
// 				header("Location: " . $urlfrom);
// 				exit;
// 			} elseif ($backtopage) {
// 				header("Location: " . $backtopage);
// 				exit;
// 			} elseif ($idProdOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idProdOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			} elseif ($idCompanyOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idCompanyOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			} elseif ($idSupplierOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idSupplierOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			} elseif ($idMemberOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idMemberOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			} elseif ($idContactOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idContactOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			} elseif ($idProjectOrigin) {
// 				header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $idProjectOrigin . '&type=' . $type . '&mesg=' . urlencode($langs->trans("CatCreated")));
// 				exit;
// 			}

// 			header("Location: " . DOL_URL_ROOT . '/categories/viewcat.php?id=' . $result . '&type=' . $type);
// 			exit;
// 		}
// 	}
// }

/*
 * View
 */

$form = new Form($db);
$formother = new FormOther($db);



$help_url = 'EN:Module_Categories|FR:Module_Catégories|DE:Modul_Kategorien';


llxHeader("", $langs->trans("Create Container"), $help_url);
echo load_fiche_titre('Create Container');
$output = "";
$output .= "<div class='row'>
<div class='col-md-8 d-flex align-items-center justify-content-center'>";
$output .= "
		<form class='w-100' id='saveContainer'   method='POST'>
		 <input type='hidden' name='token' value='" . newToken() . "'>
		 <input type='hidden' name='urlfrom' value=''.$urlfrom.''>
		 <input type='hidden' name='action' value='add'>
		 <input type='hidden' name='id' value=''.GETPOST('origin', 'alpha').''>
		 <input type='hidden' name='type' value=''.$type.''>
		 <input type='hidden' name='backtopage' value=''.$backtopage.''>

		<div class='my-2'>
		 <label class=''>Container Id</label>
		 <input type='number' id='container_id' class='form-control mt-3' name='container_id'>
		</div>
		<div class='my-2'>
		 <label>Container  Type</label>
		  <select name='container_type' id='container_type' class='form-control'>
			<option value=''>Select Type</option>
			<option value='by air'>By Air</option>
			<option value='by ship'>By Ship</option>
		</select>
		
		</div>
		<div class='my-2'>
		 <label>Container Container Name</label>
		 <input type='text' id='container_name' class='form-control mt-3' name='container_name'>
		</div>
		<div class='my-2'>
		 <label>Container Arrival Date</label>
		 <input type='date' id='arrival_date' class='form-control mt-3' name='arrival_date'>
		</div>
		 <div class='my-3'>
		<button type='submit' class='button btn'>Create Rack</button>
		 </div>
		</form> 
		</div>
		</div>
		";

echo $output;


$script_output = "
<script>
$(document).on('submit','#saveContainer',async function(e){
	e.preventDefault();
	let contianer_id=$('#container_id').val();
	let container_type=$('#container_type').val();
	let container_name=$('#container_name').val();
	let arrival_date=$('#arrival_date').val();
	console.log(container_id,container_type,container_name,arrival_date);
	if(contianer_id.length <= 0){
		alert('Please fill the Contianer Id field')
		return 0;
	}
	if(container_type.length <= 0){
		alert('Please fill the Container Type field')
		return 0;
	}
	if(container_name.length <= 0){
		alert('Please fill the Container Name field')
		return 0;
	}
	if(arrival_date.length <= 0){
		alert('Please fill the Arrival Date field')
		return 0;
	}
	let formData=new FormData(this);
	let url ='" . $dolibarr_main_url_root . "/container/ajax/create-container.php'
	let response=await fetch(url,{
	    method:'POST',
        body:formData,
	});
	let data=await response.json();
	if(data.success){
		alert(data.message);
		$('#saveContainer').trigger('reset');
		window.location.href='/htdocs/container/index.php'
		}else{
		alert(data.message);
	}
});
</script>
";

echo $script_output;
// if ($user->hasRight('categorie', 'creer')) {
// 	// Create or add
// 
// 	if ($action == 'create' || $action == 'add') {
// 		// dol_set_focus('#label');

// 		// print '<form action="'.$_SERVER['PHP_SELF'].'?type='.$type.'" method="POST">';
// 		// print '<input type="hidden" name="token" value="'.newToken().'">';
// 		// print '<input type="hidden" name="urlfrom" value="'.$urlfrom.'">';
// 		// print '<input type="hidden" name="action" value="add">';
// 		// print '<input type="hidden" name="id" value="'.GETPOST('origin', 'alpha').'">';
// 		// print '<input type="hidden" name="type" value="'.$type.'">';
// 		// print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
// 		// if ($origin) {
// 		// 	print '<input type="hidden" name="origin" value="'.$origin.'">';
// 		// }
// 		// if ($catorigin) {
// 		// 	print '<input type="hidden" name="catorigin" value="'.$catorigin.'">';
// 		// }

// 		// print 

// 		// print dol_get_fiche_head();

// 		// print '<table class="border centpercent">';

// 		// // Ref
// 		// print '<tr>';
// 		// print '<td class="titlefieldcreate fieldrequired form-control">Rack Name</td><td><input id="label" class="minwidth100 form-control" name="label" value="'.dol_escape_htmltag($label).'">';
// 		// print'</td></tr>'; 
// 		// print '</table>';

// 		// print dol_get_fiche_end();

// 		// print '<div class="center">';
// 		// print '<input type="submit" class="button b" value="'.$langs->trans("CreateThisCat").'" name="creation" />';
// 		// print '&nbsp; &nbsp; &nbsp;';
// 		// print '<input type="submit" class="button button-cancel" value="'.$langs->trans("Cancel").'" name="cancel" />';
// 		// print '</div>';

// 		// print '</form>';

// 	}
// }



// End of page
llxFooter();
$db->close();