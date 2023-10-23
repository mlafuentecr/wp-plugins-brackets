<?php
function findTeamByID($jsonTeams, $teamID) {
  if (!is_null($jsonTeams)) {
      foreach ($jsonTeams as $team) {
          if ($team['teamID'] === $teamID) {
              return $team;
          }
      }
  }
  return null;
}

function teamRender($matches, $jsonTeams, $key) {
  $teamID = $matches['team_name'];
  $rank = $matches['team_rank'] ?? 0;
  $foundTeam = findTeamByID($jsonTeams, $teamID);
  $box = '';

  if ($foundTeam) {
      $teamName = $foundTeam['teamFirstName'];
      $teamNickname = $foundTeam['teamShortName'];
      $teamLogo = $foundTeam['teamImageURL'];
      $teamThumb = $foundTeam['thumbNailURL'];

      $box .= '<div class="matchBox-team">';
      $box .= '<img class="matchBox-logo" src="' . $teamThumb . '" alt="' . $teamName . '">';
      $box .= '<div class="matchBox-nickname">' . $teamNickname . '</div>';
      if ($rank) {
          $box .= '<div class="matchBox-rank">#' . $rank . '</div>';
      }
      $box .= '</div>';
  } else {
      $teamThumb = esc_url(plugins_url('/images/shield.png', __FILE__));
      $box .= '<div class="matchBox-team deactivate">';
      $box .= '<img class="matchBox-logo" src="' . $teamThumb . '" alt="Team Logo">';
      $box .= '<div class="matchBox-nickname"></div>';
      $box .= '<div class="matchBox-teamName"></div>';
      $box .= '</div>';
  }

  return $box;
}

function matchValues($matchesValue, $jsonTeams, $matchKey, $class) {
  $box = '';

  $box .= $matchesValue['url'] !== '' ? '<a target="_blank" class="match-row ' . $matchKey . '" href="' . $matchesValue['url'] . '">' : '<div class="match-row ' . $matchKey . '">';
  $box .= '<div class="matchBox ' . $class . '">';

  foreach ($matchesValue as $key => $matches) {
      if ($key !== 'url') {
          $box .= teamRender($matches, $jsonTeams, $key);
      }
  }
  $box .= '</div>';
  $box .= $matchesValue['url'] ? '</a>' : '</div>';

  return $box;
}

function matchContent($acfMatches, $jsonTeams, $class) {
  $box = '';

  foreach ($acfMatches as $matchKey => $matchesValue) {
      if ($matchKey !== 'date' && $matchKey !== 'logo') {
          $box .= matchValues($matchesValue, $jsonTeams, $matchKey, $class);
      }
  }

  return $box;
}

function teamDestructur($teamID, $jsonTeams, $logoType) {
  $foundTeam = findTeamByID($jsonTeams, $teamID);

  if (!is_null($foundTeam)) {
      if ($logoType === 'logo') {
          return $foundTeam['teamImageURL'];
      } elseif ($logoType === 'thumb') {
          return $foundTeam['thumbNailURL'];
      } else {
          return $foundTeam['teamFirstName'];
      }
  }

  return '';
}
