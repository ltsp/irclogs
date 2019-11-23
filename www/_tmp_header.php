                 <div class="row">
                      <div class="twelve columns">
                           <h1>IRC chat logs for #ltsp on irc.freenode.net

(<A CLASS="webchatlink" TARGET="_blank" HREF="<?php echo $this->link_webchat; ?>">webchat</A>)</h1>

<FORM ACTION="" METHOD="get">
<DIV CLASS="searchbox" STYLE="width: 220px; float: left;">
  Request log from specific day: <BR>
  <?php $this->formatDateSelector(); ?>
</DIV>
<DIV CLASS="searchbox" STYLE="float: left;">
  Search all logs by username and/or keyword (will take a few minutes): <BR>
  <INPUT TYPE="text" NAME="u" CLASS="username novalue" ONFOCUS="if (this.value == 'username') {this.value = ''; this.className = 'username';}" VALUE="username"><INPUT TYPE="text" NAME="k" CLASS="keyword novalue" ONFOCUS="if (this.value == 'keyword') {this.value = ''; this.className = 'keyword';}" VALUE="keyword"><INPUT TYPE="submit" VALUE="Go">
</DIV>
</FORM>
</DIV>
<BR STYLE="clear: both;">
<DIV CLASS="irclogs">
