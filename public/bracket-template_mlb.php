<?php 
  include 'utils.php';
  
  $brackets = get_field('create_a_bracket', 'option');
  if( $brackets ) {
    foreach( $brackets as $row ) {
    $league             = $row['select_a_league']['value'];
    if($league === 'MLB'):

    //ACF VARIABLES    
        $data               = $row['lista_de_teams_json'];
        $json               = json_decode($data, true);
        $mlbObj             = $row['MLB'];
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
        $worldseries_link   = $mlbObj['teams_worldseries']['logo']['link'];
        $championid         = $mlbObj['team_champion']['team_name'];
        $championurl        = $mlbObj['team_champion']['url'];

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
    //ACF VARIABLES \
      
 
  /** **************************
  * HTML 
  ************************** */
  $htmlContent =  '<main class="bracket_container bracket-mlb">';

  $htmlContent .=  '<section class="bracket-mobile">';
    $htmlContent .=  '<div class="menu"> ';
    $htmlContent .=  '<h2>'.$bracket_title.'</h2>';
      $htmlContent .=  '<div class="logos"> ';
      $htmlContent .=  '<div  class="logo legue_logo_L active" > <img alt="'. $legue_logo_R['url'] . '" width="269px" src="'. $legue_logo_L['url'] . '"></div>';
      $htmlContent .=  '<div  class="logo legue_logo_R"        > <img alt="'. $legue_logo_R['url'] . '"width="269px" src="'. $legue_logo_R['url'] . '"></div>';
      $htmlContent .= '</div>';

      $htmlContent .=  '<div class="series"> ';
        $htmlContent .=  '<div data-type="group-1" class="serie active" >WILDCARD <span>Series</span> </div>';
        $htmlContent .=  '<div data-type="group-2" class="serie "       >DIVISION <span>Series</span> </div>';
        $htmlContent .=  '<div data-type="group-3" class="serie "   >CHAMPIONSHIP<span>Series</span> </div>';
        $htmlContent .=  '<div data-type="group-4" class="serie "    >WORLD<span>Series</span> </div>';
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
                $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div></div>';
              $htmlContent .= '</section>';
          
              $htmlContent .= '<section class="group-match">';
                //wildcard
                $htmlContent .= '<div id="group-1" class="group-1 group-wildcard">';
                $htmlContent .=  '<img class="logo_league"  width="269px" src="'. $legue_logo_L['url'] . '">';
                $htmlContent .=  matchContent($wildMatches, $json, 'wildcard');
                $htmlContent .= '</div>';
                //division
                $htmlContent .= '<div id="group-2" class="group-2 group-division">';
                $htmlContent .=  matchContent($divisionMatches, $json, 'division');
                $htmlContent .= '</div>';
                

                //championship
                $htmlContent .= '<div id="group-3" class="group-3 group-championship">';
                $htmlContent .=  matchContent($championshipMatches, $json, 'championship');
                $htmlContent .= '</div>';

              $htmlContent .= '</section>'; //match-group
            $htmlContent .= '</div>'; //match-group    

            /** **************************
            * Getting Center 
            ************************** */
        $htmlContent .= '<div id="group-4" class="group-center">';
            //worldseries
          $htmlContent .= '<div  id="group-4_R" class="group-4 group-worldseries">';
            $htmlContent .=  '<img width="269px" class="logo" alt="'.$legue_logo_R['alt'] . '" src="'. $worldseries_logo['url'] . '">';

            //worldseries
            $htmlContent .=  $worldseries_link !=='' ? '<a href="'. $worldseries_link .'" class="worldseries">' : '<a class="worldseries">';
              $htmlContent .='<div class="title">World Series</div>';
              $htmlContent .='<div class="worldseries-wrap">';
              $htmlContent .=  matchContent($worldseriesMatches, $json, 'worldseries');
              $htmlContent .='</div>';
            $htmlContent .=  $worldseries_link ? '</a>' : '</div>';

            //champ
            $htmlContent .=  $worldseries_link !=='' ? '<a href="'. $championurl  .'" class="match-row">' : '<a class="match-row">';
              $htmlContent .='<div class="matchBox champ">';
                $htmlContent .='<div class="title">CHAMPION</div>';
                $htmlContent .='<div class="champ-wrap">';
                  $htmlContent .='<img class="thumb" src="'.teamDestructur($championid, $json , 'thumb'). '">';
                  $htmlContent .='<div class="name">'.teamDestructur($championid, $json , 'name').'</div>';
                $htmlContent .='</div> ';
              $htmlContent .='</div>';
            $htmlContent .=  $worldseries_link ? '</a>' : '</div>';
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
            $htmlContent .= '<div><div class="stages-link worldSeries">World <span>Series</span></div></div>';
          $htmlContent .= '</section>';
      
        $htmlContent .= '<section class="group-match">';
          //wildcard
          $htmlContent .= '<div id="group-1_R" class="group-1 group-wildcard">';
          $htmlContent .=  '<img class="logo_league" alt="'.$legue_logo_R['alt'] . '" src="'.$legue_logo_R['url'] . '">';
          $htmlContent .=  matchContent($wildMatches_R, $json, 'wildcard');
          $htmlContent .= '</div>';
          //division
          $htmlContent .= '<div id="group-2_R" class="group-2 group-division">';
          $htmlContent .=  matchContent($divisionMatches_R, $json, 'division');
          $htmlContent .= '</div>';
          

          //championship ESTA METIENDO MAS ELEMNTOS DEL URL ARRAY
          $htmlContent .= '<div id="group-3_R" class="group-3 group-championship">';
          $htmlContent .=  matchContent($championshipMatches_R, $json, 'championship');
          $htmlContent .= '</div>';
        $htmlContent .= '</section>'; //match-group
      $htmlContent .= '</div>'; //match-right
          
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
