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
              // $box .= '<div class="matchBox-teamName">' .   $teamName . '</div>';
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
     
      if($league === 'NBA'):
        $data               = $row['lista_de_teams_json'];
        $json               = json_decode($data, true);
        $mlbObj             = $row['NBA'];
        $bracket_title      = $row['bracket_title'];

       
        /** **************************
        * Getting Left League
        ************************** */
        $stages             = $mlbObj['league_left'];
        $legue_logo_L       = $mlbObj['league_left']['logo'];


        //divisiona
        $divisionaDate      = $mlbObj['league_left']['teams_divisional']['date'];
        $divisionalMatches  = $mlbObj['league_left']['teams_divisional'];
        //Round1st
        $round1stDate       = $mlbObj['league_left']['teams_1st_round']['date'];
        $round1stMatches    = $mlbObj['league_left']['teams_1st_round'];
        //semifinals
        $semifinalsDate     = $mlbObj['league_left']['teams_seminals']['date'];
        $semifinalsMatches  = $mlbObj['league_left']['teams_seminals'];
        //finals
        $finalsDate         = $mlbObj['league_left']['teams_finals']['date'];
        $finalsMatches      = $mlbObj['league_left']['teams_finals'];
        /** **************************
        * Getting Center worldseries
        ************************** */
        //Championship
        
        $championshipMatches = $mlbObj['teams_championship'];
        $championship_logo   = $mlbObj['teams_championship']['logo'];
        $championid          = $mlbObj['team_champion']['team_name'];
 
        /** **************************
        * Getting RIGHT League
        ************************** */
        $legue_logo_R         = $mlbObj['league_right']['logo'];


        //divisiona
        $divisionaDate_R      = $mlbObj['league_right']['teams_divisional']['date'];
        $divisionalMatches_R  = $mlbObj['league_right']['teams_divisional'];
        //Round1st
        $round1stDate_R       = $mlbObj['league_right']['teams_1st_round']['date'];
        $round1stMatches_R    = $mlbObj['league_right']['teams_1st_round'];
        //semifinals
        $semifinalsDate_R     = $mlbObj['league_right']['teams_seminals']['date'];
        $semifinalsMatches_R  = $mlbObj['league_right']['teams_seminals'];
        //finals
        $finalsDate_R         = $mlbObj['league_right']['teams_finals']['date'];
        $finalsMatches_R      = $mlbObj['league_right']['teams_finals'];

        /** **************************
        * HTML 
        ************************** */
        $htmlContent =  '<main class="bracket_container bracket-nba">';

        $htmlContent .=  '<section class="bracket-mobile">';
          $htmlContent .=  '<div class="menu"> ';
          $htmlContent .=  '<h2>'.$bracket_title.'</h2>';
            $htmlContent .=  '<div class="logos"> ';
            $htmlContent .=  '<div  class="logo legue_logo_L active" > <img width="269px" src="'. $legue_logo_L . '"></div>';
            $htmlContent .=  '<div  class="logo legue_logo_R"        > <img width="269px" src="'. $legue_logo_R . '"></div>';
            $htmlContent .= '</div>';
      
            $htmlContent .=  '<div class="series"> ';
              $htmlContent .=  '<div data-type="group-1" class="serie active" >Play-In</div>';
              $htmlContent .=  '<div data-type="group-2" class="serie "       >1ST Round</div>';
              $htmlContent .=  '<div data-type="group-3" class="serie "   >Semifinals </div>';
              $htmlContent .=  '<div data-type="group-4" class="serie "    >FINALS </div>';
              $htmlContent .=  '<div data-type="group-5" class="serie "    >Championship </div>';
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
                      $htmlContent .= '<div><div class="stages-link">Divisional </div>  <div class="date"> '.$divisionaDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link">1st Round </div> <div class="date"> '.$round1stDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link">Semifinals </div> <div class="date"> '.$semifinalsDate.'</div> </div>';
                      $htmlContent .= '<div><div class="stages-link">Finals </div> <div class="date"> '.$finalsDate.'</div></div>';
                    $htmlContent .= '</section>';
                
                    $htmlContent .= '<section class="group-match">';
                      //wildcard
                      $htmlContent .= '<div id="group-1" class="group-1 group-divisional">';
                      $htmlContent .=  matchContent($divisionalMatches, $json, 'divisional');
                      $htmlContent .= '</div>';
                      //division
                      $htmlContent .= '<div id="group-2" class="group-2 group-round1st">';
                      $htmlContent .=  matchContent($round1stMatches, $json, 'round1st');
                      $htmlContent .= '</div>';
                      
      
                      //championship
                      $htmlContent .= '<div id="group-3" class="group-3 group-semifinals">';
                      $htmlContent .=  matchContent($semifinalsMatches, $json, 'semifinals');
                      $htmlContent .= '</div>';
      
                      //finals
                      $htmlContent .= '<div id="group-4" class="group-4 group-finals">';
                      $htmlContent .=  matchContent($finalsMatches, $json, 'finals');
                      $htmlContent .= '</div>';
                    $htmlContent .= '</section>'; //match-group

                  $htmlContent .= '</div>'; //group-left
      
                  /** **************************
                  * Getting Center 
                  ************************** */
              $htmlContent .= '<div id="group-5" class="group-center">';
                  //CHAMPIONSHIP
                $htmlContent .= '<div class="group-5 group-worldseries  group-championship">';
                  $htmlContent .=  '<img width="165px" class="logo" src="'. $championship_logo . '">';
                  //CHAMPIONSHIP
                $htmlContent .='<div class="worldseries CHAMPIONSHIP">';
                    $htmlContent .='<div class="title">CHAMPIONSHIP<br>GAME</div>';
                    $htmlContent .='<div class="worldseries-wrap">';
                    $htmlContent .=  matchContent($championshipMatches, $json, 'worldseries');
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
                $htmlContent .= '</div>';//CHAMPIONSHIP ./
              $htmlContent .= '</div>'; //group-center
              $htmlContent .= '</div>'; //
      
              /** **************************
              * Getting Right League 
              ************************** */
              $htmlContent .= '<div class="group-right">';
              $htmlContent .=  '<img class="logo_league"  width="269px" src="'. $legue_logo_L . '">';

                $htmlContent .= '<section class="group-stages">';
                  $htmlContent .= '<div><div class="stages-link">Divisional </div>  <div class="date"> '.$divisionaDate.'</div> </div>';
                  $htmlContent .= '<div><div class="stages-link">1st Round </div> <div class="date"> '.$round1stDate.'</div> </div>';
                  $htmlContent .= '<div><div class="stages-link">Semifinals </div> <div class="date"> '.$semifinalsDate.'</div> </div>';
                  $htmlContent .= '<div><div class="stages-link">Finals </div> <div class="date"> '.$finalsDate.'</div></div>';
                $htmlContent .= '</section>';
            
                $htmlContent .= '<section class="group-match">';
                  //wildcard
                  $htmlContent .= '<div id="group-1_R" class="group-1 group-1_R group-divisional">';
                  $htmlContent .=  matchContent($divisionalMatches, $json, 'divisional');
                  $htmlContent .= '</div>';
                  //division
                  $htmlContent .= '<div id="group-2_R" class="group-2 group-2_R  group-round1st">';
                  $htmlContent .=  matchContent($round1stMatches, $json, 'round1st');
                  $htmlContent .= '</div>';
                  
  
                  //championship
                  $htmlContent .= '<div id="group-3_R" class="group-3 group-3_R  group-semifinals">';
                  $htmlContent .=  matchContent($semifinalsMatches, $json, 'semifinals');
                  $htmlContent .= '</div>';
  
                  //finals
                  $htmlContent .= '<div id="group-4_R" class="group-4  group-4_R group-finals">';
                  $htmlContent .=  matchContent($finalsMatches, $json, 'finals');
                  $htmlContent .= '</div>';
  

                $htmlContent .= '</section>'; //match-group
              $htmlContent .= '</div>'; //group-right
      
              $htmlContent .= '</section>'; //match-group
          $htmlContent .= '</div>'; //bracketContest-wrap
      
          $htmlContent .= '</div>';
          $htmlContent .= '</div>';
          $htmlContent .=  '</main>';
          echo $htmlContent;


      endif;
    }
  }


 
