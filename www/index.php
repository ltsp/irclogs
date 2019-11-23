<?php
  include 'default.php';
  $supylogs = new supylogs();

  if (isset($_GET['d']) && $_GET['d'])
  {
    $supylogs->formatLog($_GET['d']);
  }
  elseif (isset($_GET['u']) && isset($_GET['k']))
  {
    if ($_GET['u'] == 'username') $_GET['u'] = '';
    if ($_GET['k'] == 'keyword')  $_GET['k'] = '';
    if (isset($_GET['nolimit'])) $supylogs->searchlimit = 1000000000000000000;

    if (!$_GET['u'] && !$_GET['k'])
      echo '<H1>Search failed</H1>No search parameters specified.';
    if (!$_GET['u'] && strlen($_GET['k']) < 4)
      echo '<H1>Search failed</H1>Without username specified, keyword needs to be at least four characters long.';
    else
      $supylogs->formatSearchResults($_GET['u'], $_GET['k']);
  }
  else
  {
    $supylogs->formatLogMostRecent();
  }
?>