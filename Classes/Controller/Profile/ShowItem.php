<?php
use TYPO3\CMS\Backend\Controller\ContentElement\ElementInformationController;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
/*
 *  Copyright notice
 *
 *  (c) 2007-2020 Rene Nitzsche (rene@system25.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class Tx_Cfcleague_Controller_Profile_ShowItem extends ElementInformationController {
	/**
	 * Constructor
	 */
	public function __construct() {
		// Der parent-Konstruktor darf nicht aufgerufen werden.
		$this->iconFactory = tx_rnbase::makeInstance(IconFactory::class);
	}

	public function getInfoScreen($table, $uid) {
		$this->initByParams($table, $uid);

		$this->main();
		$content = $this->moduleTemplate->getView()->getRenderingContext()->getVariableProvider()->get('content');

		return $content;
	}
	protected function initByParams($table, $uid) {
		$this->table = $table;
		$this->uid = $uid;
		$this->permsClause = $this->getBackendUser()->getPagePermsClause(Permission::PAGE_SHOW);
		$this->moduleTemplate = \tx_rnbase::makeInstance(ModuleTemplate::class);
		$this->moduleTemplate->getDocHeaderComponent()->disable();

		if (isset($GLOBALS['TCA'][$this->table])) {
			$this->initDatabaseRecord();
		} elseif ($this->table == '_FILE' || $this->table == '_FOLDER' || $this->table == 'sys_file') {
			$this->initFileOrFolderRecord();
		}
	}
}

