<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006-2018 Rene Nitzsche
 *  Contact: rene@system25.de
 *  All rights reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 ***************************************************************/
tx_rnbase::load('tx_rnbase_util_SearchBase');
tx_rnbase::load('tx_rnbase_util_Misc');

/**
 * Class to search matches from database.
 *
 * @author Rene Nitzsche
 */
class tx_cfcleague_search_Stadium extends tx_rnbase_util_SearchBase
{
    protected function getTableMappings()
    {
        $tableMapping = [];
        $tableMapping['STADIUM'] = 'tx_cfcleague_stadiums';
        $tableMapping['STADIUMMM'] = 'tx_cfcleague_stadiums_mm';
        $tableMapping['CLUB'] = 'tx_cfcleague_club';
        $tableMapping['TEAM'] = 'tx_cfcleague_teams';
        $tableMapping['MATCH'] = 'tx_cfcleague_games';
        $tableMapping['COMPETITION'] = 'tx_cfcleague_competition';

        // Hook to append other tables
        tx_rnbase_util_Misc::callHook('cfc_league', 'search_Stadium_getTableMapping_hook', array(
            'tableMapping' => &$tableMapping,
        ), $this);

        return $tableMapping;
    }

    protected function getBaseTable()
    {
        return 'tx_cfcleague_stadiums';
    }

    public function getWrapperClass()
    {
        return 'tx_cfcleague_models_Stadium';
    }

    protected function getJoins($tableAliases)
    {
        $join = '';
        if (isset($tableAliases['STADIUMMM']) || isset($tableAliases['CLUB']) || isset($tableAliases['TEAM'])) {
            $join .= ' JOIN tx_cfcleague_stadiums_mm ON tx_cfcleague_stadiums_mm.uid_local = tx_cfcleague_stadiums.uid ';
        }
        if (isset($tableAliases['CLUB']) || isset($tableAliases['TEAM'])) {
            $join .= ' JOIN tx_cfcleague_club ON tx_cfcleague_stadiums_mm.uid_foreign = tx_cfcleague_club.uid ';
        }
        if (isset($tableAliases['TEAM'])) {
            $join .= ' JOIN tx_cfcleague_teams ON tx_cfcleague_teams.club = tx_cfcleague_club.uid ';
        }
        if (isset($tableAliases['MATCH']) || isset($tableAliases['COMPETITION'])) {
            $join .= ' JOIN tx_cfcleague_games ON tx_cfcleague_stadiums.uid = tx_cfcleague_games.arena ';
        }
        if (isset($tableAliases['COMPETITION'])) {
            $join .= ' JOIN tx_cfcleague_competition ON tx_cfcleague_competition.uid = tx_cfcleague_games.competition ';
        }

        // Hook to append other tables
        tx_rnbase_util_Misc::callHook('cfc_league', 'search_Stadium_getJoins_hook', array(
            'join' => &$join,
            'tableAliases' => $tableAliases,
        ), $this);

        return $join;
    }
}
