    <?php 
 
  function findTeamByID($jsonTeams, $teamID) {
   
    if(!is_null($jsonTeams)){
    foreach ($jsonTeams as $team) {
        if ($team['teamID'] === $teamID) {
            return $team;
        }
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
          $rank       = $matches['team_rank']  ?? 0;
     
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
              return 'No team found Check json';
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
    if(!is_null( $foundTeam )){
      if ( $logoType === 'logo') {
        return  $foundTeam['teamImageURL'];
      }elseif ( $logoType === 'thumb'){
        return  $foundTeam['thumbNailURL'];
      }else {
        return  $foundTeam['teamFirstName'];
      }
      return $box; 
    }
   
  }
 
    if (have_rows('create_a_bracket', 'option')):

        while (have_rows('create_a_bracket', 'option')) : the_row();
        $variable = get_field('create_a_bracket', 'option');
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
  $htmlContent =  '<main class="bracket-mlb">';

  $htmlContent .=  '<section class="bracket-mobile">';
    $htmlContent .=  '<div class="menu"> ';
    $htmlContent .=  '<h2>'.$bracket_title.'</h2>';
      $htmlContent .=  '<div class="logos"> ';
      $htmlContent .=  '<div  class="logo legue_logo_L active" > <img width="269px" src="'. $legue_logo_L . '"></div>';
      $htmlContent .=  '<div  class="logo legue_logo_R"        > <img width="269px" src="'. $legue_logo_R . '"></div>';
      $htmlContent .= '</div>';

      $htmlContent .=  '<div class="series"> ';
        $htmlContent .=  '<div data-type="wildcard" class="serie active" >WILDCARD <span>Series</span> </div>';
        $htmlContent .=  '<div data-type="division" class="serie "       >DIVISION <span>Series</span> </div>';
        $htmlContent .=  '<div data-type="championship" class="serie "   >CHAMPIONSHIP<span>Series</span> </div>';
        $htmlContent .=  '<div data-type="worldseries" class="serie "    >WORLD<span>Series</span> </div>';
      $htmlContent .= '</div>';
    $htmlContent .= '</div>';
  $htmlContent .=  '</section>';

  $htmlContent .=  '<div class="bracket-contest">';
        $htmlContent .= '<h2>'.$bracket_title.'</h2>';
    $htmlContent .= '<div class="bracketContest-wrap">';
      $htmlContent .= '<div class="scroll-wrap">';
          $htmlContent .= '<section class="group">';

            /** **************************
            * Getting Left League
            ************************** */
            $htmlContent .= '<div class="group-left">';
              $htmlContent .= '<section class="group-stages">';
                $htmlContent .= '<div><div class="stages-link">WILDCARD <span>Series</span></div>  <div class="date"> '.$wildDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link division">DIVISION <span>Series</span></div> <div class="date"> '.$divisionDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link championship">CHAMPIONSHIP <span>Series</span></div> <div class="date"> '.$championshipDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div>';
              $htmlContent .= '</section>';
          
              $htmlContent .= '<section class="group-match">';
                //wildcard
                $htmlContent .= '<div id="wildcard" class="group-1 group-wildcard">';
                $htmlContent .=  '<img class="logo"  width="269px" src="'. $legue_logo_L . '">';
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
        $htmlContent .= '<div id="worldseries" class="group-center">';
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
          $htmlContent .= '<div><div class="stages-link">WILDCARD <span>Series</span></div>  <div class="date"> '.$wildDate.'</div> </div>';
          $htmlContent .= '<div><div class="stages-link division">DIVISION <span>Series</span></div> <div class="date"> '.$divisionDate.'</div> </div>';
          $htmlContent .= '<div><div class="stages-link championship">CHAMPIONSHIP <span>Series</span></div> <div class="date"> '.$championshipDate.'</div> </div>';
          $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div>';
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
      $htmlContent .= '</div>'; //scroll-wrap    

        $htmlContent .= '</section>'; //match-group
    $htmlContent .= '</div>'; //bracketContest-wrap

    $htmlContent .= '</div>';
    $htmlContent .= '</div>';
    $htmlContent .=  '</main>';
    echo $htmlContent;
        } else {
          echo '<section class="match-nothing">No results</section>';
        }
        break; 
    endwhile;

endif;
