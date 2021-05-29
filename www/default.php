<?php
  date_default_timezone_set('UTC');
  setlocale(LC_TIME, 'en_US');

  class supylogs
  {
    // configuration
    public $botname = 'ltsp';  // name of the bot making the logs is highlighted.  leave empty for none
    public $channel = '#ltsp';  // name of the channel
    public $network = 'irc.libera.chat';  // name of the network or server
    public $link_website = 'https://ltsp.org/';
    public $link_webchat = 'https://ts.sch.gr/repo/irc';
    public $searchlimit = 1000;
    private $logdir = '/srv/bot/logs/ChannelLogger/libera/#ltsp/';  // logdir must end with slash
    // end configuration

    private $dates = array();
    private $usercolors = array();

    function __construct()
    {
      if (!is_dir($this->logdir))
        die('Log directory cannot be opened.  Check configuration.');

      if ($handle = opendir($this->logdir))
        while (false !== ($file = readdir($handle)))
          // filename must be: #channel.yyyy-mm-dd.log
          if (strlen($file) == (strlen($this->channel) + 15))
            if (substr($file, 0, strlen($this->channel)) == $this->channel)
              if (substr($file, -4) == '.log')
                $this->dates[substr($file, strlen($this->channel) + 1, 10)] = $file;
      closedir($handle);

      arsort($this->dates);

      include '_header.php';

    }
    function __destruct()
    {
      include '_footer.php';
    }

    function getUserColor($user)
    {
      if (!isset($this->usercolors[$user]))
      {
        srand(crc32($user));
        $r=rand(0, 200);
        $rgb = array($r, 200-$r, 0);
        shuffle($rgb);
        $this->usercolors[$user] = sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
      }
      return $this->usercolors[$user];
    }

    function formatUsername($user, $action = false)
    {
      if ($action)
        return '* <FONT COLOR="'.$this->getUserColor($user).'">'.$user.'</FONT>';
      return '&lt;<FONT COLOR="'.$this->getUserColor($user).'">'.$user.'</FONT>&gt;';
    }

    function formatDateSelector()
    {
      echo '<SELECT ONCHANGE="document.location.href = \'?d=\' + this.value;">';
      echo '<OPTION VALUE="">...';
      foreach ($this->dates as $date => $file)
      {
        echo '<OPTION VALUE="'.$date.'">'.strftime("%e %B %Y", strtotime($date));
      }
      echo '</SELECT>';
      echo '<DIV STYLE="display: none;"><!-- This hidden DIV is here to make the javascript links accessible for search engines.  It is not an SEO trick. -->';
      foreach ($this->dates as $date => $file)
      {
        echo '<A HREF="?d='.$date.'">'.strftime("%e %B %Y", strtotime($date)).'</A>';
      }
      echo '</DIV>';
    }

    function formatLog($date)
    {
      // prevent people from haxxing around with $_GET parameters
      if (!isset($this->dates[$date]))
      {
        echo '<H2>Cannot show log</H2>Invalid date specified.';
        return;
      }

      echo '<H2>Channel log from '.strftime("%e %B %Y", strtotime($date)).' &nbsp; <SPAN>(all times are UTC)</SPAN></H2>';
      echo '<TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="0">'."\n";
      $log = file_get_contents($this->logdir.$this->dates[$date]);
      $log = explode("\n", $log);
      $lastuser = '';
      foreach ($log as $line)
      {
        $curuser = '';

        // extract HH:MM time)
        $time = substr($line, 11, 5);
        // extract IRC line
        $msg = substr($line, 21);

        echo '<TR><TD CLASS="time">'.$time;
        if (preg_match('/^<([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31})> (.*)$/', $msg, $matches))
        {
          // channel message
          $curuser = $matches[1];
          if ($curuser == $lastuser) echo '<TD>';
          else echo '<TD CLASS="username"><DIV STYLE="width: 100px; float: left;">'.$this->formatUsername($matches[1]).'</DIV>';

	  echo ' <DIV STYLE="padding-left: 100px;">';
          if ($matches[1] == $this->botname)
		echo '<SPAN CLASS="botmsg">';
          echo ' '.htmlentities($matches[2], ENT_COMPAT, 'UTF-8');
          if ($matches[1] == $this->botname)
		echo '</SPAN>';
	  echo '</DIV>';
        }
        else if (preg_match('/^\* ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31}) (.*)$/', $msg, $matches))
        {
          // channel action
          echo '<TD CLASS="username">'.$this->formatUsername($matches[1], true).' '.htmlentities($matches[2], ENT_COMPAT, 'UTF-8');
        }
        else if (substr($msg, 0, 4) == '*** ')
        {
          // IRC notifications
          if (preg_match('/^\*\*\* ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31}) is now known as ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31})$/', $msg, $matches))
          {
            echo '<TD CLASS="nickchange"><STRONG>'.$matches[1].'</STRONG> is now known as <STRONG>'.$matches[2].'</STRONG>';
          }
          else if (preg_match('/^\*\*\* ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31}) \<(.*)\> has joined (.*)$/', $msg, $matches))
          {
            echo '<TD CLASS="joined"><STRONG>'.$matches[1].' has joined IRC</STRONG> ('.$matches[2].')';
          }
          else if (preg_match('/^\*\*\* ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31}) \<(.*)\> has left (.*)$/', $msg, $matches))
          {
            echo '<TD CLASS="left"><STRONG>'.$matches[1].' has left IRC</STRONG> ('.$matches[2].')';
          }
          else if (preg_match('/^\*\*\* ([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31}) \<(.*)\> has quit IRC \((.*)\)$/', $msg, $matches))
          {
            echo '<TD CLASS="left"><STRONG>'.$matches[1].' has left IRC</STRONG> ('.$matches[2].', '.$matches[3].')';
          }
          else
          {
            echo '<TD>'.htmlentities(substr($msg, 4), ENT_COMPAT, 'UTF-8');
          }
        }
        else
        {
          // unrecognized message, just print it
          echo '<TD CLASS="unknown" COLSPAN="2">'.$msg;
        }
        $lastuser = $curuser;
        echo "\n";
      }
      echo '</TABLE>';
    }
    function formatLogMostRecent()
    {
      reset($this->dates);
      $this->formatLog(key($this->dates));
    }

    function formatSearchResults($user, $keyword)
    {
      if ($user && $keyword)
        echo '<H2>Search results for messages with keyword "'.htmlentities($keyword, ENT_COMPAT, 'UTF-8').'" by user "'.htmlentities($user, ENT_COMPAT, 'UTF-8').'" &nbsp; <SPAN>(all times are UTC)</SPAN></H2>';
      if ($user && !$keyword)
        echo '<H2>Search results for messages by user "'.htmlentities($user, ENT_COMPAT, 'UTF-8').'" &nbsp; <SPAN>(all times are UTC)</SPAN></H2>';
      if (!$user && $keyword)
        echo '<H2>Search results for messages with keyword "'.htmlentities($keyword, ENT_COMPAT, 'UTF-8').'" &nbsp; <SPAN>(all times are UTC)</SPAN></H2>';

      echo '<TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="0">'."\n";
      $lines = 0;
      foreach ($this->dates as $date => $file)
      {
        $output = false;
        $log = file_get_contents($this->logdir.$this->dates[$date]);
        $log = explode("\n", $log);
        foreach ($log as $line)
        {
          // extract YYYY-MM-DD date
          $date = substr($line, 0, 10);
          // extract HH:MM time)
          $time = substr($line, 11, 5);
          // extract IRC line
          $msg = substr($line, 21);

          if (preg_match('/^\<([a-zA-Z\[\]\\`_\^\{\|\}][a-zA-Z0-9\[\]\\`_\^\{\|\}-]{1,31})\> (.*)$/', $msg, $matches))
          {
            if (($user && $keyword && !strcasecmp($matches[1], $user) && stripos($matches[2], $keyword) !== false)
             || ($user && !$keyword && !strcasecmp($matches[1], $user))
             || (!$user && $keyword && stripos($matches[2], $keyword) !== false))
            {
              $output = true;
              echo '<TR><TD NOWRAP>'.strftime("%e %B %Y", strtotime($date));
              echo ' (<A HREF="?d='.$date.'">view log</A>)';
              echo '<TD CLASS="time">'.$time;
              echo '<TD CLASS="username">'.$this->formatUsername($matches[1]);
              echo '<TD>'.str_ireplace($keyword, '<B>'.$keyword.'</B>', htmlentities($matches[2], ENT_COMPAT, 'UTF-8'));
              $lines++;
              if ($lines > $this->searchlimit) break;
            }
          }
        }
        if ($output == true)
          echo '<TR><TD COLSPAN="4" HEIGHT="3">';
        if ($lines > $this->searchlimit) break;
      }
      if ($lines > $this->searchlimit)
        echo '<TR><TD COLSPAN="4"><B>Search limited to '.$this->searchlimit.' lines.  If you want the full results, <A HREF="?u='.$user.'&k='.$keyword.'&nolimit">click here</A>.';
      echo '</TABLE>';
    }
  }
?>
