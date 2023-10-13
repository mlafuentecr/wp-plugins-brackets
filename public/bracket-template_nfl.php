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
              $box .= '<div class="xxxxxx $teamID='.$teamName.'"></div>';

              // Build the HTML for each match
              $box .= '<div class="matchBox-team">';
              $box .= '<img class="matchBox-logo" src="' .  $teamThumb . '" alt="Team Logo">';
              $box .= '<div class="matchBox-nickname">' .   $teamNickname . '</div>';
              $box .= '<div class="matchBox-teamName">' .   $teamName . '</div>';
             if($rank) {$box .= '<div class="matchBox-rank">#' .      $rank . '</div>';}
              $box .= '</div>';
          
          } else {
              // Build the HTML for each match
              $teamThumb = esc_url( plugins_url( '/images/shield.png', __FILE__ ) );
    
              
              $box .= '<div class="matchBox-team deactivate">';
              $box .= '<img class="matchBox-logo" src="'.$teamThumb .'" alt="Team Logo">';
              $box .= '<div class="matchBox-nickname"></div>';
              $box .= '<div class="matchBox-teamName"></div>';
              $box .= '</div>';
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
 

  $brackets = get_field('create_a_bracket', 'option');
  if( $brackets ) {
    foreach( $brackets as $row ) {
      $league             = $row['select_a_league']['value'];
      if($league === 'NFL'):
        $data               = $row['lista_de_teams_json'];
        $json               = json_decode($data, true);
        $mlbObj             = $row['NFL'];
        $bracket_title      = $row['bracket_title'];

       
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
  
        /** **************************
        * HTML 
        ************************** */
        $htmlContent =  '<main class="bracket_container bracket-nfl">';

        $htmlContent .=  '<section class="bracket-mobile">';
          $htmlContent .=  '<div class="menu"> ';
          $htmlContent .=  '<h2>'.$bracket_title.'</h2>';
            $htmlContent .=  '<div class="logos"> ';
            $htmlContent .=  '<div  class="logo legue_logo_L active" > <img width="269px" src="'. $legue_logo_L . '"></div>';
            $htmlContent .=  '<div  class="logo legue_logo_R"        > <img width="269px" src="'. $legue_logo_R . '"></div>';
            $htmlContent .= '</div>';
      
            $htmlContent .=  '<div class="series"> ';
              $htmlContent .=  '<div data-type="wildcard" class="serie active" >WILDCARD</div>';
              $htmlContent .=  '<div data-type="division" class="serie "       >DIVISION</div>';
              $htmlContent .=  '<div data-type="championship" class="serie "   >CONFERENCE </div>';
              $htmlContent .=  '<div data-type="worldseries" class="serie "    >SUPERBOWL </div>';
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
                  $htmlContent .=  '<img class="logo_league"  width="269px" src="'. $legue_logo_L . '">';
                    $htmlContent .= '<section class="group-stages">';
                      $htmlContent .= '<div><div class="stages-link">WILDCARD </div>  <div class="date"> '.$wildDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link division">DIVISION </div> <div class="date"> '.$divisionDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link championship">CONFERENCE </div> <div class="date"> '.$championshipDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link worldSeries">SUPERBOWL </div>';
                    $htmlContent .= '</section>';
                
                    $htmlContent .= '<section class="group-match">';
                      //wildcard
                      $htmlContent .= '<div id="wildcard" class="group-1 group-wildcard">';
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
                  $htmlContent .=  '<img width="165px" class="logo" src="'. $worldseries_logo . '">';
      
                  //worldseries
                  $htmlContent .='<div class="worldseries">';
                    $htmlContent .='<div class="title">SUPERBOWL</div>';
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
              $htmlContent .=  '<img class="logo_league" src="'.$legue_logo_R . '">';
              $htmlContent .= '<section class="group-stages">';
                $htmlContent .= '<div><div class="stages-link">WILDCARD </div>  <div class="date"> '.$wildDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link division">DIVISION </div> <div class="date"> '.$divisionDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link championship">CONFERENCE </div> <div class="date"> '.$championshipDate.'</div> </div>';
                $htmlContent .= '<div><div class="stages-link worldSeries">SUPERBOWL </div>';
              $htmlContent .= '</section>';
          
              $htmlContent .= '<section class="group-match">';
                //wildcard
                $htmlContent .= '<div id="wildcard_R" class="group-1 group-wildcard">';
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


      endif;
    }
  }


 
