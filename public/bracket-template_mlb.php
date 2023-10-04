i
    <?php 
    $create_a_bracket = get_field('create_a_bracket', 'option');
  
 
  
  function findTeamByID($jsonTeams, $teamID) {
    foreach ($jsonTeams as $team) {
        if ($team['teamID'] === $teamID) {
            return $team;
        }
    }
    return null; 
}

  function matchContent($wildMatches, $jsonTeams, $class) {
    $box = '';
    
    foreach ($wildMatches as $matchKey => $matchesValue) {
      if($matchKey !== 'date' && $matchKey !== 'logo'){
        //I have date and logo in the same tab but 
        //I only need teams
        $box .= '<div class="match-row '. $matchKey  .'">';
        $box .= '<div class="matchBox '.$class.'">';
        foreach ($matchesValue as $key => $matches) {

          $teamID     = $matches['team_name'];
          $rank       = $matches['team_rank'];
          $foundTeam  = findTeamByID($jsonTeams, $teamID);

          if ($foundTeam) {
              $teamName       = $foundTeam['teamFirstName'];
              $teamNickname   = $foundTeam['teamShortName'];
              $teamLogo       = $foundTeam['teamImageURL'];
              $teamThumb      = $foundTeam['thumbNailURL'];

              // Build the HTML for each match
              $box .= '<div class="matchBox-team">';
              $box .= '<img class="matchBox-logo" src="' .  $teamThumb . '" alt="Team Logo">';
              $box .= '<div class="matchBox-nickname">' .   $teamNickname . '</div>';
              $box .= '<div class="matchBox-teamName">' .   $teamName . '</div>';
             if($rank) {$box .= '<div class="matchBox-rank">#' .      $rank . '</div>';}
              $box .= '</div>';
             
          
          } else {
              return 'No team found';
          }
        }
        $box .= '</div>';
        $box .= '</div>';
      }
    }

   
   return $box; 
  }
 
  function teamDestructur($teamID, $jsonTeams, $logoType) {
 
    $foundTeam  = findTeamByID($jsonTeams, $teamID);
    if ( $logoType === 'logo') {
        return  $foundTeam['teamImageURL'];
    }elseif ( $logoType === 'thumb'){
        return  $foundTeam['thumbNailURL'];
    }else {
        return  $foundTeam['teamFirstName'];
    }

   
   return $box; 
  }
 
    if (have_rows('create_a_bracket', 'option')):

        while (have_rows('create_a_bracket', 'option')) : the_row();

            //Get Subfield
            $data               = get_sub_field('lista_de_teams_json');
            $json               = json_decode($data, true);
            $league             = get_sub_field('select_a_league')['value'];
            $bracket_title      = get_sub_field('bracket_title');
            $mlbObj             = get_sub_field('MLB');
            /** **************************
            * Getting Left League
            ************************** */
            $stages             = $mlbObj['league_left'];
            $legue_logo_L       = $mlbObj['league_left']['logo'];


            //WILDCARD
            $wildDate           = $mlbObj['league_left']['teams_wildcard']['date'];
            $wildMatches        = $mlbObj['league_left']['teams_wildcard'];
            //division
            $divisionDate       = $mlbObj['league_left']['teams_division']['date'];
            $divisionMatches    = $mlbObj['league_left']['teams_division'];
            //Championship
            $championshipDate    = $mlbObj['league_left']['teams_championship']['date'];
            $championshipMatches = $mlbObj['league_left']['teams_championship'];
            
            /** **************************
            * Getting Center worldseries
            ************************** */
            //worldseries
            $worldseriesMatches = $mlbObj['teams_worldseries'];
            $worldseriesDate    = $mlbObj['teams_worldseries']['date'];
            $worldseries_logo   = $mlbObj['teams_worldseries']['logo'];
            $championid         = $mlbObj['team_champion']['team_name'];

            /** **************************
            * Getting RIGHT League
            ************************** */
            $legue_logo_R       = $mlbObj['league_right']['logo'];

            //WILDCARD
            $wildDate_R         = $mlbObj['league_right']['teams_wildcard']['date'];
            $wildMatches_R      = $mlbObj['league_right']['teams_wildcard'];
            //division
            $divisionDate_R     = $mlbObj['league_right']['teams_division']['date'];
            $divisionMatches_R  = $mlbObj['league_right']['teams_division'];
            //Championship
            $championshipDate_R = $mlbObj['league_right']['teams_championship']['date'];
            $championshipMatches_R = $mlbObj['league_right']['teams_championship'];


if ($league === 'MLB') {

    echo'<section class="bracket-mobile-menu">';
    echo'<div>menu</div>';
    echo'<h2>'.$bracket_title.'</h2>';
    echo'</section>';

  echo '<main class="bracketContest bracket-mlb">';
        $htmlContent = '<h2>'.$bracket_title.'</h2>';
        $htmlContent .= '<main class="bracketContest-wrap">';
          $htmlContent .= '<section class="group">';

            /** **************************
            * Getting Left League
            ************************** */
            $htmlContent .= '<div class="group-left">';
              $htmlContent .= '<section class="group-stages">';
                $htmlContent .= '<div> <a href="#wildcard" class="stages-link">WILDCARD <span>Series</span></a>  <div class="date"> '.$wildDate.'</div> </div>';
                $htmlContent .= '<div> <a href="#division" class="stages-link division">DIVISION <span>Series</span></a> <div class="date"> '.$divisionDate.'</div> </div>';
                $htmlContent .= '<div> <a href="#championship" class="stages-link championship">CHAMPIONSHIP <span>Series</span></a> <div class="date"> '.$championshipDate.'</div> </div>';
                $htmlContent .= '<div> <a href="#worldSeries" class="stages-link worldSeries">World <span>Series</span></a></div>';
              $htmlContent .= '</section>';
          
              $htmlContent .= '<section class="group-match">';
                //wildcard
                $htmlContent .= '<div id="wildcard" class="group-1 group-wildcard">';
                $htmlContent .=  '<img width="269px" class="logo" src="'. $legue_logo_L . '">';
                $htmlContent .=  matchContent($wildMatches, $json, 'wildcard');
                $htmlContent .= '</div>';
                //division
                $htmlContent .= '<div id="division" class="group-2 group-division">';
                $htmlContent .=  matchContent($divisionMatches, $json, 'division');
                $htmlContent .= '</div>';
                

                //championship
                $htmlContent .= '<div id="championship" class="group-3 group-championship">';
                $htmlContent .=  matchContent($championshipMatches, $json, 'championship');
                $htmlContent .= '</div>';

              $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //match-group    

            /** **************************
            * Getting Center 
            ************************** */
        $htmlContent .= '<div id="worldSeries" class="group-center">';
            //worldseries
          $htmlContent .= '<div class="group-4 group-worldseries">';
            $htmlContent .=  '<img width="269px" class="logo" src="'. $worldseries_logo . '">';

            //worldseries
            $htmlContent .='<div class="worldseries">';
              $htmlContent .='<div class="title">World Series</div>';
              $htmlContent .='<div class="worldseries-wrap">';
              $htmlContent .=  matchContent($worldseriesMatches, $json, 'worldseries');
              $htmlContent .='</div>';
            $htmlContent .='</div>';

            //champ
            $htmlContent .='<div class="match-row">';
              $htmlContent .='<div class="matchBox champ">';
                $htmlContent .='<div class="title">CHAMPION</div>';
                $htmlContent .='<div class="champ-wrap">';
                  $htmlContent .='<img class="thumb" src="'.teamDestructur($championid, $json , 'thumb'). '">';
                  $htmlContent .='<div class="name">'.teamDestructur($championid, $json , 'name').'</div>';
                $htmlContent .='</div> ';
              $htmlContent .='</div>';
            $htmlContent .='</div>';
            //champ ./
          $htmlContent .= '</div>';
        $htmlContent .= '</div>'; //group-center

        /** **************************
        * Getting Right League 
        ************************** */
        $htmlContent .= '<div class="group-right">';
        $htmlContent .= '<section class="group-stages">';
          $htmlContent .= '<div> <a href="#wildcard_R" class="stages-link">WILDCARD</a>  <div class="date"> '.$wildDat_R.'</div> </div>';
          $htmlContent .= '<div> <a href="#division_R" class="stages-link division">DIVISION</a> <div class="date"> '.$divisionDate_R.'</div> </div>';
          $htmlContent .= '<div> <a href="#championship_R" class="stages-link championship">CHAMPIONSHIP</a> <div class="date"> '.$championshipDate_R.'</div> </div>';
          $htmlContent .= '<div> <a href="#worldSeries" class="stages-link worldSeries">World Series</a></div>';
        $htmlContent .= '</section>';
    
        $htmlContent .= '<section class="group-match">';
          //wildcard
          $htmlContent .= '<div id="wildcard_R" class="group-1 group-wildcard">';
          $htmlContent .=  '<img class="logo" src="'.$legue_logo_R . '">';
          $htmlContent .=  matchContent($wildMatches_R, $json, 'wildcard');
          $htmlContent .= '</div>';
          //division
          $htmlContent .= '<div id="division_R" class="group-2 group-division">';
          $htmlContent .=  matchContent($divisionMatches_R, $json, 'division');
          $htmlContent .= '</div>';
          

          //championship
          $htmlContent .= '<div id="championship_R" class="group-3 group-championship">';
          $htmlContent .=  matchContent($championshipMatches_R, $json, 'championship');
          $htmlContent .= '</div>';
        $htmlContent .= '</section>'; //match-group
      $htmlContent .= '</div>'; //match-group    


        $htmlContent .= '</section>'; //match-group
        $htmlContent .= '</main>';
        echo $htmlContent;
        echo '</main>';
        } else {
          echo '<section class="match-nothing">No results</section>';
        }
        break; 
    endwhile;

endif;
