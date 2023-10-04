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
      if($matchKey !== 'date'){
        $box .= '<div class="match-row">';
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
 
  function logoContent($teamID, $jsonTeams) {
 
    $foundTeam  = findTeamByID($jsonTeams, $teamID);
    if ($foundTeam) {
        return  $foundTeam['teamImageURL'];
    } else {
        return 'No team found';
    }

   
   return $box; 
  }
 
    if (have_rows('create_a_bracket', 'option')):
      echo '<main class="bracketContest bracket-mlb">';
        while (have_rows('create_a_bracket', 'option')) : the_row();

            //Get Subfield
            $data               = get_sub_field('lista_de_teams_json');
            $json               = json_decode($data, true);
            $league             = get_sub_field('select_a_league')['value'];
            $bracket_title      = get_sub_field('bracket_title');
            

            $mlbObj             = get_sub_field('MLB');
            $stages             = $mlbObj['league_left'];
            //WILDCARD
            $wildDate           = $mlbObj['league_left']['teams_wildcard']['date'];
            $wildMatches        = $mlbObj['league_left']['teams_wildcard'];
            //division
            $divisionDate       = $mlbObj['league_left']['teams_division']['date'];
            $divisionMatches    = $mlbObj['league_left']['teams_division'];
            //Championship
            $championshipDate    = $mlbObj['league_left']['teams_championship']['date'];
            $championshipMatches = $mlbObj['league_left']['teams_championship'];

            //worldseries
            $worldseriesDate    = $mlbObj['teams_worldseries']['date'];
            $worldseriesMatches = $mlbObj['teams_worldseries'];
        
           //Champion
            $champion           = $mlbObj['team_champion'];

            if ($league === 'MLB') {
          
              $htmlContent = '<h2>'.$bracket_title.'</h2>';
              $htmlContent .= '<main class="bracketContest-wrap">';
                $htmlContent .= '<section class="group">';

                  //LEFT
                  $htmlContent .= '<div class="group-left">';
                    $htmlContent .= '<section class="group-stages">';
                      $htmlContent .= '<div> <a href="#" class="stages-link">WILDCARD</a>  <div class="date"> '.$wildDate.'</div> </div>';
                      $htmlContent .= '<div> <a href="#" class="stages-link division">DIVISION</a> <div class="date"> '.$divisionDate.'</div> </div>';
                      $htmlContent .= '<div> <a href="#" class="stages-link championship">CHAMPIONSHIP</a> <div class="date"> '.$championshipDate.'</div> </div>';
                      $htmlContent .= '<div class="stages-link series">----</div>';
                    $htmlContent .= '</section>';
                
                    $htmlContent .= '<section class="group-match">';
                      //wildcard
                      $htmlContent .= '<div class="group-1 group-wildcard">';
                      $htmlContent .=  '<img class="logo" src="'.logoContent('3483', $json ). '">';
                      $htmlContent .=  matchContent($wildMatches, $json, 'wildcard');
                      $htmlContent .= '</div>';
                      //division
                      $htmlContent .= '<div class="group-2 group-division">';
                      $htmlContent .=  matchContent($divisionMatches, $json, 'division');
                      $htmlContent .= '</div>';
                      

                      //championship
                      $htmlContent .= '<div class="group-3 group-championship">';
                      $htmlContent .=  matchContent($championshipMatches, $json, 'championship');
                      $htmlContent .= '</div>';

                    $htmlContent .= '</section>'; //match-group
                  $htmlContent .= '</div>'; //match-group    

//CENTER
$htmlContent .= '<div class="group-center">';
                //worldseries
                $htmlContent .= '<div class="group-4 group-worldseries">';
                $htmlContent .=  'logo';
                $htmlContent .=  matchContent($worldseriesMatches, $json, 'worldseries');
                $htmlContent .=  'xxx'.matchContent($champion, $json, 'division');
                $htmlContent .= '</div>';
$htmlContent .= '</div>'; //match-group    

              //RIGHT
              $htmlContent .= '<div class="group-right">';
              $htmlContent .= '<section class="group-stages">';
                $htmlContent .= '<div> <a href="#" class="stages-link">WILDCARD</a>  <div class="date"> '.$wildDate.'</div> </div>';
                $htmlContent .= '<div> <a href="#" class="stages-link division">DIVISION</a> <div class="date"> '.$divisionDate.'</div> </div>';
                $htmlContent .= '<div> <a href="#" class="stages-link championship">CHAMPIONSHIP</a> <div class="date"> '.$championshipDate.'</div> </div>';
                $htmlContent .= '<div class="stages-link series">----</div>';
              $htmlContent .= '</section>';
          
              $htmlContent .= '<section class="group-match">';
                //wildcard
                $htmlContent .= '<div class="group-1 group-wildcard">';
                $htmlContent .=  '<img class="logo" src="'.logoContent('3483', $json ). '">';
                $htmlContent .=  matchContent($wildMatches, $json, 'wildcard');
                $htmlContent .= '</div>';
                //division
                $htmlContent .= '<div class="group-2 group-division">';
                $htmlContent .=  matchContent($divisionMatches, $json, 'division');
                $htmlContent .= '</div>';
                

                //championship
                $htmlContent .= '<div class="group-3 group-championship">';
                $htmlContent .=  matchContent($championshipMatches, $json, 'championship');
                $htmlContent .= '</div>';
              $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //match-group    


              $htmlContent .= '</section>'; //match-group
              $htmlContent .= '</main>';
              echo $htmlContent;
              var_dump($champion);
            } else {
              echo '<section class="match-nothing">No results</section>';
            }
            break; 
        endwhile;
        echo '</main>';
    endif;
   