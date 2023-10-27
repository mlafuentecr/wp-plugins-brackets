<?php
include 'utils.php';
$brackets = get_field('create_a_bracket', 'option');

if ($brackets)
{
    foreach ($brackets as $row)
    {
        $league = $row['select_a_league']['value'];

        if ($league === 'NBA'):
            
        //ACF VARIABLES
            $data = $row['lista_de_teams_json'];
            $json = json_decode($data, true);
            $nhlObj = $row['NBA'];
            $bracket_title = $row['bracket_title'];

            /** **************************
             * Getting Left League
             **************************
                */
            $stages = $nhlObj['league_left'];
            $legue_logo_L = $nhlObj['league_left']['logo'];

            //divisiona
            $divisionaDate = $nhlObj['league_left']['teams_divisional']['date'];
            $divisionalMatches = $nhlObj['league_left']['teams_divisional'];
            //Round1st
            $round1stDate = $nhlObj['league_left']['teams_1st_round']['date'];
            $round1stMatches = $nhlObj['league_left']['teams_1st_round'];
            //semifinals
            $semifinalsDate = $nhlObj['league_left']['teams_seminals']['date'];
            $semifinalsMatches = $nhlObj['league_left']['teams_seminals'];
            //finals
            $finalsDate = $nhlObj['league_left']['teams_finals']['date'];
            $finalsMatches = $nhlObj['league_left']['teams_finals'];
            /** **************************
             * Getting Center worldseries
             **************************
                */
            //Championship
            $championshipMatches = $nhlObj['teams_championship'];
            $championship_logo = $nhlObj['teams_championship']['logo'];
            $championid = $nhlObj['team_champion']['team_name'];
            $championurl = $nhlObj['team_champion']['url'];

            /** **************************
             * Getting RIGHT League
             **************************
                */
            $legue_logo_R = $nhlObj['league_right']['logo'];

            //divisiona
            $divisionaDate_R = $nhlObj['league_right']['teams_divisional']['date'];
            $divisionalMatches_R = $nhlObj['league_right']['teams_divisional'];
            //Round1st
            $round1stDate_R = $nhlObj['league_right']['teams_1st_round']['date'];
            $round1stMatches_R = $nhlObj['league_right']['teams_1st_round'];
            //semifinals
            $semifinalsDate_R = $nhlObj['league_right']['teams_seminals']['date'];
            $semifinalsMatches_R = $nhlObj['league_right']['teams_seminals'];
            //finals
            $finalsDate_R = $nhlObj['league_right']['teams_finals']['date'];
            $finalsMatches_R = $nhlObj['league_right']['teams_finals'];
        //ACF VARIABLES \

        /** **************************
         * HTML
         **************************
            */
        $htmlContent = '<main class="bracket_container bracket-nba">';

        $htmlContent .= '<section class="bracket-mobile">';
        $htmlContent .= '<div class="menu"> ';
        $htmlContent .= '<h2>' . $bracket_title . '</h2>';
        $htmlContent .= '<div class="logos"> ';
        $htmlContent .= '<div  class="logo legue_logo_L active" > <img width="269px" src="' . $legue_logo_L . '"></div>';
        $htmlContent .= '<div  class="logo legue_logo_R"        > <img width="269px" src="' . $legue_logo_R . '"></div>';
        $htmlContent .= '</div>';

        $htmlContent .= '<div class="series"> ';
        $htmlContent .= '<div data-type="group-1" class="serie active" >Play-In</div>';
        $htmlContent .= '<div data-type="group-2" class="serie "       >1ST Round</div>';
        $htmlContent .= '<div data-type="group-3" class="serie "   >Semifinals </div>';
        $htmlContent .= '<div data-type="group-4" class="serie "    >FINALS </div>';
        $htmlContent .= '<div data-type="group-5" class="serie "    >Championship </div>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';
        $htmlContent .= '</section>';

        $htmlContent .= '<div class="bracket-contest">';
        $htmlContent .= '<h2>' . $bracket_title . '</h2>';
        $htmlContent .= '<div class="bracketContest-wrap">';
        $htmlContent .= '<div class="scroll-wrap">';
        $htmlContent .= '<section class="group">';

        /** **************************
         * Getting Left League
         **************************
            */
        $htmlContent .= '<div class="group-left">';
            $htmlContent .= '<img class="logo_league"  width="269px" src="' . $legue_logo_L . '">';

            $htmlContent .= '<section class="group-stages">';
            $htmlContent .= '<div><div class="stages-link">Divisional </div>  <div class="date"> ' . $divisionaDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">1st Round </div> <div class="date"> ' . $round1stDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">Semifinals </div> <div class="date"> ' . $semifinalsDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">Finals </div> <div class="date"> ' . $finalsDate . '</div></div>';
            $htmlContent .= '</section>';

            $htmlContent .= '<section class="group-match">';
            //wildcard
            $htmlContent .= '<div id="group-1" class="group-1 group-divisional">';
            $htmlContent .= matchContent($divisionalMatches, $json, 'divisional');
            $htmlContent .= '</div>';
            //division
            $htmlContent .= '<div id="group-2" class="group-2 group-round1st">';
            $htmlContent .= matchContent($round1stMatches, $json, 'round1st');
            $htmlContent .= '</div>';

            //championship
            $htmlContent .= '<div id="group-3" class="group-3 group-semifinals">';
            $htmlContent .= matchContent($semifinalsMatches, $json, 'semifinals');
            $htmlContent .= '</div>';

            //finals
            $htmlContent .= '<div id="group-4" class="group-4 group-finals">';
            $htmlContent .= matchContent($finalsMatches, $json, 'finals');
            $htmlContent .= '</div>';
            $htmlContent .= '</section>'; //match-group
        $htmlContent .= '</div>'; //group-left
        
        /** **************************
         * Getting Center
         **************************
        */
        $htmlContent .= '<div id="group-5" class="group-center">';
            //CHAMPIONSHIP
            $htmlContent .= '<div class="group-5 group-worldseries  group-championship">';
            $htmlContent .= '<img width="165px" class="logo" src="' . $championship_logo . '">';
            //CHAMPIONSHIP
            $htmlContent .= '<div class="worldseries CHAMPIONSHIP">';
            $htmlContent .= '<div class="title">CHAMPIONSHIP<br>GAME</div>';
            $htmlContent .= '<div class="worldseries-wrap">';
            $htmlContent .= matchContent($championshipMatches, $json, 'worldseries');
            $htmlContent .= '</div>';
            //champ
            $htmlContent .= '<div class="match-row">';
            $htmlContent .= '<a href="'.$championurl.'" target="_blank"  class="matchBox champ">';
            $htmlContent .= '<div class="title">CHAMPION</div>';
            $htmlContent .= '<div class="champ-wrap">';
            $htmlContent .= '<img class="thumb" src="' . teamDestructur($championid, $json, 'thumb') . '">';
            $htmlContent .= '<div class="name">' . teamDestructur($championid, $json, 'name') . '</div>';
            $htmlContent .= '</div> ';
            $htmlContent .= '</a>';
            $htmlContent .= '</div>';
            $htmlContent .= '</div>'; //CHAMPIONSHIP ./
            $htmlContent .= '</div>'; //
        $htmlContent .= '</div>'; //group-center
        
        /** **************************
         * Getting Right League
         **************************
        */
        $htmlContent .= '<div class="group-right">';
            $htmlContent .= '<img class="logo_league"  width="269px" src="' . $legue_logo_R . '">';

            $htmlContent .= '<section class="group-stages">';
            $htmlContent .= '<div><div class="stages-link">Divisional </div>  <div class="date"> ' . $divisionaDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">1st Round </div> <div class="date"> ' . $round1stDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">Semifinals </div> <div class="date"> ' . $semifinalsDate . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link">Finals </div> <div class="date"> ' . $finalsDate . '</div></div>';
            $htmlContent .= '</section>';

            $htmlContent .= '<section class="group-match">';
            //wildcard
            $htmlContent .= '<div id="group-1_R" class="group-1 group-1_R group-divisional">';
            $htmlContent .= matchContent($divisionalMatches, $json, 'divisional');
            $htmlContent .= '</div>';
            //division
            $htmlContent .= '<div id="group-2_R" class="group-2 group-2_R  group-round1st">';
            $htmlContent .= matchContent($round1stMatches, $json, 'round1st');
            $htmlContent .= '</div>';

            //championship
            $htmlContent .= '<div id="group-3_R" class="group-3 group-3_R  group-semifinals">';
            $htmlContent .= matchContent($semifinalsMatches, $json, 'semifinals');
            $htmlContent .= '</div>';

            //finals
            $htmlContent .= '<div id="group-4_R" class="group-4  group-4_R group-finals">';
            $htmlContent .= matchContent($finalsMatches, $json, 'finals');
            $htmlContent .= '</div>';

            $htmlContent .= '</section>'; //match-group
        $htmlContent .= '</div>'; //group-right

        $htmlContent .= '</section>'; //match-group
        $htmlContent .= '</div>'; //bracketContest-wrap
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';
        $htmlContent .= '</main>';
        echo $htmlContent;

        endif;
    }
}
