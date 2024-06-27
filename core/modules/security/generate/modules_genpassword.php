<?php
/* Copyright (C) 2007-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2024		Frédéric France			<frederic.france@free.fr>
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
 * or see https://www.gnu.org/
 */

/**
 *		\file       htdocs/core/modules/security/generate/modules_genpassword.php
 *		\ingroup    core
 *		\brief      File with parent class for password generating classes
 */
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions.lib.php';


/**
 *  Parent class for password rules/management modules
 */
abstract class ModeleGenPassword
{
	public $picto = 'generic';

	/**
	 * Flag to 1 if we must clean ambiguous characters for the autogeneration of password (List of ambiguous char is in $this->Ambi)
	 *
	 * @var integer
	 */
	public $WithoutAmbi = 0;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var Conf dolibarr conf
	 */
	public $conf;

	/**
	 * @var Translate Translate Object
	 */
	public $langs;

	/**
	 * @var User user
	 */
	public $user;

	/**
	 * Minimum length (text visible by end user)
	 *
	 * @var string
	 */
	public $length;

	/**
	 * Minimum length in number of characters
	 *
	 * @var integer
	 */
	public $length2;

	/**
	 * 		Return if a module can be used or not
	 *
	 *      @return		boolean     true if module can be used
	 */
	public function isEnabled()
	{
		return true;
	}

	/**
	 *		Return description of module
	 *
	 *      @return     string      Description of text
	 */
	public function getDescription()
	{
		global $langs;
		return $langs->trans("NoDescription");
	}

	/**
	 *  Return an example of password generated by this module
	 *
	 *  @return     string      Example of password
	 */
	public function getExample()
	{
		global $langs;
		$langs->load("bills");
		return $langs->trans("NoExample");
	}

	/**
	 *  Build new password
	 *
	 *  @return     string      Return a new generated password
	 */
	public function getNewGeneratedPassword()
	{
		global $langs;
		return $langs->trans("NotAvailable");
	}

	/**
	 * 	Validate a password.
	 * 	This function is called by User->setPassword() and internally to validate that the password matches the constraints.
	 *
	 *	@param		string	$password	Password to check
	 *  @return     int					0 if KO, >0 if OK
	 */
	public function validatePassword($password)
	{
		return 1;
	}
}