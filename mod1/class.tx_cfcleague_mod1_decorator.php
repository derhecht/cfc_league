<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Rene Nitzsche (rene@system25.de)
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


require_once('../class.tx_cfcleague_form_tool.php');

/**
 * Die Klasse bereitet Objekte für die Darstellung im Backend auf
 */
class tx_cfcleague_mod1_decorator {

	static function prepareMatches($matches, &$competition, $columns, $formTool, $options) {
		// Ist kein Wettbewerb vorhanden, dann wird nur das Endergebnis angezeigt
		$parts = (!$competition) ? 0 : $competition->getNumberOfMatchParts();
		$arr = Array( 0 => Array( self::getHeadline($parts, $columns, $options) ));
		foreach($matches As $match){
			$matchRec = is_object($match) ? $match->record : $match;
			$isNoMatch = is_object($match) ? $match->isDummy() : $matchRec['no_match_home'] || $matchRec['no_match_guest'];
			
			$row = array();
			if(isset($options['checkbox'])) {
				// Check if match is checkable
				if(!is_array($options['dontcheck']) || !array_key_exists($matchRec['uid'], $options['dontcheck']))
					$row[] = $formTool->createCheckbox('checkMatch[]', $matchRec['uid']);
				else
					$row[] = '<img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'],'gfx/zoom2.gif','width="11" height="12"').' title="Info: '. $options['dontcheck'][$matchRec['uid']] .'" border="0" alt="" />';
			}
			if(!$isNoMatch) {
				reset($columns);
				foreach($columns As $column => $data) {
					$row[] = isset($data['method']) ? call_user_func(array($match, $data['method'])) : $matchRec[$column];
				}
				if(isset($options['linker']))
					$row[] = self::addLinker($options, $match, $formTool);
				$arr[0][] = $row;
			}
		}

		return $arr;
	}
	/**
	 * Liefert die passenden Überschrift für die Tabelle
	 *
	 * @param int $parts
	 * @return array
	 */
	static function getHeadline($parts, $columns, $options) {
		global $LANG;
		$LANG->includeLLFile('EXT:cfc_league/locallang_db.xml');
		$arr = array();
		if(isset($options['checkbox'])) {
			$arr[] = '&nbsp;'; // Spalte für Checkbox
		}
		foreach($columns As $column => $data) {
			if(intval($data['nocolumn'])) continue;
			$arr[] = intval($data['notitle']) ? '' :
					$LANG->getLL((isset($data['title']) ? $data['title'] : 'tx_cfcleague_games.' . $column));
		}
		if(isset($options['linker']))
			$arr[] = $LANG->getLL('label_action');
    return $arr;
  }
	static function addLinker($options, $obj, $formTool) {
		$out = '';
		if(isset($options['linker'])) {
			$linkerArr = $options['linker'];
			if(is_array($linkerArr) && count($linkerArr)) {
				$currentPid = intval($options['pid']);
				foreach($linkerArr As $linker) {
					$out .= $linker->makeLink($obj, $formTool, $currentPid, $options);
					$out .= $options['linkerimplode'] ? $options['linkerimplode'] : '<br />';
				}
			}
		}
		return $out;
	}
}

interface tx_cfcleague_mod1_Linker {
	function makeLink($obj, $formTool, $currentPid, $options);
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cfc_league/mod1/class.tx_cfcleague_mod1_decorator.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cfc_league/mod1/class.tx_cfcleague_mod1_decorator.php']);
}


?>