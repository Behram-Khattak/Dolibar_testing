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

// Load Dolibarr environment
// print '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

// Load translation files required by the page
// $langs->load("categories");

// Security check
$socid = GETPOSTINT('socid');
if (!$user->hasRight('categorie', 'lire')) {
    accessforbidden();
}

$action = GETPOST('action', 'alpha');
$cancel        = GETPOST('cancel', 'alpha');
$origin        = GETPOST('origin', 'alpha');
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

$output = "";
llxHeader("", 'Container List', $help_url);
$output .="
<div class=' w-100 d-flex align-items-center justify-content-between'>
".load_fiche_titre('Container List')."
<a href='/htdocs/container/card.php' class='btn btn-primary'>Create New</a>
</div>
";
$output .= "<div class='row d-flex align-items-center justify-content-center'>
<div class='col-md-12'>";



// print '<tr class="liste_titre">';
$output = "

<style>
    
    
    .table {
        border: 1px solid #000; /* Setting border for the table */
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #000; /* Setting border for table headers and cells */
        padding: 10px;
    }
    .table thead th {
        background-color: #ffc107; /* Yellow color for table header */
        color: #000; /* Black text color */
    }
   
    
</style>

<div class='container-fluid'> <!-- Use container-fluid for full-width responsiveness -->
    <div class='row justify-content-center'>
        <div class='col-md-12'>
                    <div class='table-responsive'>
                        <table class='table table-bordered table-striped table-hover' style='width:100%;'>
                            <thead>
                                <tr>
                                    <th scope='col'>#ID</th>
                                    <th scope='col'>Container ID</th>
                                    <th scope='col'>Container Type</th>
                                    <th scope='col'>Container Name</th>
                                    <th scope='col'>Container Arrival Date</th>
                                    <th scope='col'>View</th>
                                    <th scope='col'>Edit</th>
                                    <th scope='col'>Delete</th>
                                </tr>
                            </thead>
                            <tbody id='getContainer'>";





echo $output;


$script_output = "
<script>
$(document).ready(function(){
    let get_container_url ='" . $dolibarr_main_url_root . "/container/ajax/get-container.php'
    let get_container_delete ='" . $dolibarr_main_url_root . "/container/ajax/delete-container.php'
    const getContainer=()=>{
        $.ajax({
            'type':'GET',
            url:get_container_url,
            dataType:'json',
            success:(data)=>{
                if(data.success){
                    $('#getContainer').html(data.data)
                }else{
                    alert(data.message);
                }
            }
        })
    }
    getContainer();

    $(document).on('click','#deleteContainer',function(){
        $.ajax({
            type:'GET',
            url:get_container_delete,
            dataType:'json',
            data:{id:$(this).data('id')},
            success:(data)=>{
            if(data.success){
            alert(data.message);
            }else{
            alert(data.message);
        }
            }
        })
    })
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
