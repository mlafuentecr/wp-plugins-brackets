<?php
include 'utils.php';

$brackets = get_field('create_a_bracket', 'option');
if ($brackets)
{
    foreach ($brackets as $row)
    {
        $league = $row['select_a_league']['value'];
        if ($league === 'NHL'):

            //ACF VARIABLES
            $data = $row['lista_de_teams_json'];
            $json = json_decode($data, true);
            $nhlObj = $row['NHL'];
            $bracket_title = $row['bracket_title'];

            /** **************************
             * Getting Left League
             **************************
             */
            $stages = $nhlObj['league_left'];
            $legue_logo_L = $nhlObj['league_left']['logo'];

            //1ST ROUND
            $wildDate = $nhlObj['league_left']['teams_wildcard']['date'];
            $wildMatches = $nhlObj['league_left']['teams_wildcard'];
            //2ND ROUND
            $divisionDate = $nhlObj['league_left']['teams_division']['date'];
            $divisionMatches = $nhlObj['league_left']['teams_division'];
            //CONFERENCE
            $championshipDate = $nhlObj['league_left']['teams_championship']['date'];
            $championshipMatches = $nhlObj['league_left']['teams_championship'];

            /** **************************
             * Getting Center worldseries
             **************************
             */
            //worldseries
            $worldseriesMatches = $nhlObj['teams_worldseries'];
            $worldseries_logo = $nhlObj['teams_worldseries']['logo'];
            $worldseries_link = $nhlObj['teams_worldseries']['match_1']['url'];
            $championid = $nhlObj['team_champion']['team_name'];
            $championurl = $nhlObj['team_champion']['url'];
            
            /** **************************
             * Getting RIGHT League
             **************************
             */
            $legue_logo_R = $nhlObj['league_right']['logo'];

            //1ST ROUND
            $wildDate_R = $nhlObj['league_right']['teams_wildcard']['date'];
            $wildMatches_R = $nhlObj['league_right']['teams_wildcard'];
            //2ND ROUND
            $divisionDate_R = $nhlObj['league_right']['teams_division']['date'];
            $divisionMatches_R = $nhlObj['league_right']['teams_division'];
            //CONFERENCE
            $championshipDate_R = $nhlObj['league_right']['teams_championship']['date'];
            $championshipMatches_R = $nhlObj['league_right']['teams_championship'];
            //ACF VARIABLES \
            

            
            /** **************************
             * HTML
             **************************
             */
            $htmlContent = '<main class="bracket_container bracket-nhl">';

            $htmlContent .= '<section class="bracket-mobile">';
                $htmlContent .= '<div class="menu"> ';
                $htmlContent .= '<h2>' . $bracket_title . '</h2>';
                $htmlContent .= '<div class="logos"> ';
                $htmlContent .= '<div  class="logo legue_logo_L active" > <img alt="' . $legue_logo_R['url'] . '" width="269px" src="' . $legue_logo_L['url'] . '"></div>';
                $htmlContent .= '<div  class="logo legue_logo_R"        > <img alt="' . $legue_logo_R['url'] . '"width="269px" src="' . $legue_logo_R['url'] . '"></div>';
                $htmlContent .= '</div>';

                $htmlContent .= '<div class="series"> ';
                $htmlContent .= '<div data-type="group-1" class="serie active" >1ST ROUND <span>Series</span> </div>';
                $htmlContent .= '<div data-type="group-2" class="serie "       >2ND ROUND <span>Series</span> </div>';
                $htmlContent .= '<div data-type="group-3" class="serie "   >CONFERENCE<span>Series</span> </div>';
                $htmlContent .= '<div data-type="group-4" class="serie "    >FINAL</div>';
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
                $htmlContent .= '<section class="group-stages">';
                $htmlContent .= '<div><div class="stages-link">1ST ROUND <span>Series</span></div>  <div class="date"> ' . $wildDate . '</div> </div>';
                $htmlContent .= '<div><div class="stages-link division">2ND ROUND <span>Series</span></div> <div class="date"> ' . $divisionDate . '</div> </div>';
                $htmlContent .= '<div><div class="stages-link championship">CONFERENCE <span>Series</span></div> <div class="date"> ' . $championshipDate . '</div> </div>';
                $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div></div>';
                $htmlContent .= '</section>';

                $htmlContent .= '<section class="group-match">';
                //1st round
                $htmlContent .= '<div id="group-1" class="group-1 group-wildcard">';
                $htmlContent .= '<img class="logo_league"  width="269px" src="' . $legue_logo_L['url'] . '">';
                $htmlContent .= matchContent($wildMatches, $json, 'wildcard');
                $htmlContent .= '</div>';
                //2nd round
                $htmlContent .= '<div id="group-2" class="group-2 group-division">';
                $htmlContent .= matchContent($divisionMatches, $json, 'division');
                $htmlContent .= '</div>';

                //conference
                $htmlContent .= '<div id="group-3" class="group-3 group-championship">';
                $htmlContent .= matchContent($championshipMatches, $json, 'championship');
                $htmlContent .= '</div>';

                $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //match-group
            
            /** **************************
             * Getting Center
             **************************
             */
            $htmlContent .= '<div id="group-4" class="group-center">';
                //final
                $htmlContent .= '<div  id="group-4_R" class="group-4 group-worldseries">';
                $htmlContent .= '<img width="269px" class="logo" alt="' . $legue_logo_R['alt'] . '" src="' . $worldseries_logo['url'] . '">';

                //final
                $htmlContent .= '<div href="' . $worldseries_link . '" class="worldseries">';
                $htmlContent .= '<div class="title">FINAL</div>';
                $htmlContent .= '<div class="worldseries-wrap">';
                $htmlContent .= matchContent($worldseriesMatches, $json, 'worldseries');
                $htmlContent .= '</div>';
                $htmlContent .= '</div>' ;
                
                //champ
                $htmlContent .= '<a href="' . $championurl . '" class="match-row 11">' ;
                $htmlContent .= '<div class="matchBox champ">';
                    $htmlContent .= '<div class="title">CHAMPION</div>';
                    $htmlContent .= '<div class="champ-wrap">';
                    $htmlContent .= '<img class="thumb" src="' . teamDestructur($championid, $json, 'thumb') . '">';
                    $htmlContent .= '<div class="name">' . teamDestructur($championid, $json, 'name') . '</div>';
                $htmlContent .= '</div> ';
                $htmlContent .= '</div>';
                $htmlContent .=  '</a>';
                //champ ./
                $htmlContent .= '</div>';
            $htmlContent .= '</div>'; //group-center
            
            /** **************************
             * Getting Right League
             **************************
             */
            $htmlContent .= '<div class="group-right">';
            $htmlContent .= '<section class="group-stages">';
            $htmlContent .= '<div><div class="stages-link">1ST ROUND <span>Series</span></div>  <div class="date"> ' . $wildDate_R . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link division">2ND ROUND <span>Series</span></div> <div class="date"> ' . $divisionDate_R . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link championship">CONFERENCE <span>Series</span></div> <div class="date"> ' . $championshipDate_R . '</div> </div>';
            $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div></div>';
            $htmlContent .= '</section>';

            $htmlContent .= '<section class="group-match">';
            //1st round
            $htmlContent .= '<div id="group-1_R" class="group-1 group-wildcard">';
            $htmlContent .= '<img class="logo_league"  width="269px" src="' . $legue_logo_R['url'] . '">';
            $htmlContent .= matchContent($wildMatches_R, $json, 'wildcard');
            $htmlContent .= '</div>';
            //2nd round
            $htmlContent .= '<div id="group-2_R" class="group-2 group-division">';
            $htmlContent .= matchContent($divisionMatches_R, $json, 'division');
            $htmlContent .= '</div>';

            //conference
            $htmlContent .= '<div id="group-3_R" class="group-3 group-championship">';
            $htmlContent .= matchContent($championshipMatches_R, $json, 'championship');
            $htmlContent .= '</div>';

            $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //match-right

            $htmlContent .= '</div>'; //scroll-wrap
            $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //bracketContest-wrap
            $htmlContent .= '</div>';
            $htmlContent .= '</div>';
            $htmlContent .= '</main>';
            echo $htmlContent;

        endif;
    }
}
