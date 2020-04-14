<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008-2015 Rene Nitzsche (rene@system25.de)
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

tx_rnbase::load('tx_cfcleague_sports_ISports');
tx_rnbase::load('Tx_Rnbase_Service_Base');

class tx_cfcleague_sports_Football extends Tx_Rnbase_Service_Base implements tx_cfcleague_sports_ISports
{
    /**
     * Get match provider.
     *
     * @return tx_cfcleaguefe_table_ITableType
     */
    public function getLeagueTable()
    {
        if (tx_rnbase_util_Extensions::isLoaded('cfc_league_fe')) {
            return tx_rnbase::makeInstance('tx_cfcleaguefe_table_football_Table');
        }

        return null;
    }

    /**
     * @return array
     */
    public function getTCAPointSystems()
    {
        return array(
            array(tx_rnbase_util_Misc::translateLLL('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_competition.point_system_2'), 1),
            array(tx_rnbase_util_Misc::translateLLL('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_competition.point_system_3'), 0),
        );
    }

    public function getTCALabel()
    {
        return 'Football';
    }

    public function isSetBased()
    {
        return false;
    }

    private $matchInfo = null;

    /* (non-PHPdoc)
     * @see tx_cfcleague_sports_ISports::getMatchInfo()
     */
    public function getMatchInfo()
    {
        if (null == $this->matchInfo) {
            tx_rnbase::load('tx_cfcleague_sports_MatchInfo');
            $this->matchInfo = tx_rnbase::makeInstance('tx_cfcleague_sports_MatchInfo', array(
                    tx_cfcleague_sports_MatchInfo::MATCH_TIME => 90,
                    tx_cfcleague_sports_MatchInfo::MATCH_PARTS => 2,
                    tx_cfcleague_sports_MatchInfo::MATCH_EXTRA_TIME => 30,
            ));
        }

        return $this->matchInfo;
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cfc_league/sports/class.tx_cfcleague_sports_Football.php']) {
    include_once $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cfc_league/sports/class.tx_cfcleague_sports_Football.php'];
}
