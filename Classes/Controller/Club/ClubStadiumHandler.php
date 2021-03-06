<?php

namespace System25\T3sports\Controller\Club;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2020 Rene Nitzsche (rene@system25.de)
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

/**
 * Die Klasse verwaltet Stadien eines Vereins.
 * Es implementiert das Tab "Stadien" im Vereinsmodul.
 */
class ClubStadiumHandler
{
    /**
     * Returns an instance.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return '###LABEL_TAB_STADIUMS###';
    }

    public function handleRequest(\tx_rnbase_mod_IModule $mod)
    {
    }

    /**
     * @param \tx_cfcleague_models_Club $club
     * @param \tx_rnbase_mod_IModule $mod
     */
    public function showScreen($club, \tx_rnbase_mod_IModule $mod)
    {
        global $LANG;

        $searcher = \tx_rnbase::makeInstance('tx_cfcleague_mod1_searcher_Stadium', $mod);
        $searcher->setClub($club->getUid());

        $result = $searcher->getResultList();
        if ($result['totalsize'] > 0) {
            $content .= $result['pager'];
            $content .= $result['table'];
            $content .= $result['pager'];
        } else {
            $content .= $mod->getDoc()->section($LANG->getLL('label_msg_nostadiumsfound'), '', 0, 1, \tx_rnbase_mod_IModFunc::ICON_INFO);
        }

        $options = [
            'params' => '&defVals[tx_cfcleague_stadiums][clubs]='.$club->getUid(),
        ];
        $content .= $mod->getFormTool()->createNewLink('tx_cfcleague_stadiums', $club->getProperty('pid'), '###LABEL_BTN_ADDSTADIUM###', $options);

        return $content;
    }

    public function makeLink(\tx_rnbase_mod_IModule $mod)
    {
    }
}
