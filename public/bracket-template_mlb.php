
    <?php 
    $create_a_bracket = get_field('create_a_bracket', 'option');


    function findTeamByID($teams, $teamID) {
      foreach ($teams as $team) {
          if ($team['teamID'] === $teamID) {
              return $team;
          }
      }
      return null; 
  }
  
  function matchContent($wildMatches, $jsonTeams) {
    $box = '';
    $count = 0;
    foreach ($wildMatches as $matchKey => $matchesValue) {
      if($matchKey !== 'date'){
        $box .= '<div class="matchBox">';
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
              $box .= '<img class="matchBox-logo" src="' . $teamThumb . '" alt="Team Logo">';
              $box .= '<div class="matchBox-nickname">' . $teamNickname . '</div>';
              $box .= '<div class="matchBox-teamName">' . $teamName . '</div>';
              $box .= '<div class="matchBox-rank">#' . $rank . '</div>';
              $box .= '</div>';
              $count++;
          
          } else {
              return 'No team found';
          }
        }
        $box .= '</div>';
      }
    }

   
   return $box; 
}

 
    if (have_rows('create_a_bracket', 'option')):
      echo '<main class="bracketContest bracket-mlb">';
        while (have_rows('create_a_bracket', 'option')) : the_row();

            //Get Subfield
            $jsonData     = get_sub_field('lista_de_teams_json');
            $json         = json_decode($jsonData, true);
            $league       = get_sub_field('select_a_league')['value'];
           
            $mlbObj       = get_sub_field('MLB');
            $stages       = $mlbObj['stages_for_American'];
            //WILDCARD
            $wildcards    = $mlbObj['stages_for_American']['teams_wildcard'];
            $wildDate     = $mlbObj['stages_for_American']['teams_wildcard']['date'];
            $wildMatches  = $mlbObj['stages_for_American']['teams_wildcard'];
           
            //var_dump($wildMatches);

            if ($league === 'MLB') {
              $htmlContent = '<main class="bracketContest-wrap">';
              //wildcard
              $htmlContent .= '<section class="match-left">';
              $htmlContent .=  matchContent($wildMatches, $json);
              $htmlContent .= '</section>';
              $htmlContent .= '<section class="match-left">Content for MLB Match 2</section>';
              $htmlContent .= '<div class="match-championship">Championship</div>';
              $htmlContent .= '</main>';
              echo $htmlContent;
              
            } else {
              echo '<section class="match-nothing">No results</section>';
            }
            break; 
        endwhile;
        echo '</main>';
    endif;
   