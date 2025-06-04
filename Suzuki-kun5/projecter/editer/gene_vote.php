  <div class="main">
    <form class="form" method="post" action="vote_write.php">
      <div class="motion">
        <fieldset>
          <legend<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>動議</legend>
            <div class="motion-in">
              <input type="radio" name="motion" id="motion-s" value="saiketsu" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1']) and preg_match("/^saiketsu$/",$_SESSION['motion'])){ echo "checked=\"checked\" "; }} ?>/><label for="motion-s">採決</label>
              <input type="radio" name="motion" id="motion-k" value="kyukai"<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1']) and preg_match("/^kyukai$/",$_SESSION['motion'])){ echo "checked=\"checked\" "; }} ?>/><label for="motion-k">休会動議</label>
              <input type="radio" name="motion" id="motion-h" value="horyu" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1']) and preg_match("/^horyu$/",$_SESSION['motion'])){ echo "checked=\"checked\" "; }} ?>/><label for="motion-h">保留動議</label>
              <input type="radio" name="motion" id="motion-y" value="yokyu" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1']) and preg_match("/^yokyu$/",$_SESSION['motion'])){ echo "checked=\"checked\" "; }} ?>/><label for="motion-y">採決要求動議</label>
            </div>
        </fieldset>
      </div>
      <div class="vote">
        <fieldset>
          <legend>票数</legend>
            <div class="vote-in">
              賛成：<input type="text" name="ok" class="num<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error2'])){ echo " error2"; }} ?>" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['ok'])){ echo "value=\"" . $_SESSION['ok'] . "\" "; }} ?>onkeypress="return submitStop(event);" />
              反対：<input type="text" name="ng" class="num<?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error3'])){ echo " error2"; }} ?>" <?php if (preg_match("/^vote_re$/",$_SESSION['status'])) { if (!empty($_SESSION['ng'])){ echo "value=\"" . $_SESSION['ng'] . "\" "; }} ?>onkeypress="return submitStop(event);" />
            </div>
        </fieldset>
      </div>
      <div class="submit">
        <input type="submit" name="vote" value="　採決入力　" />
      </div>
    </form>
  </div><!--main:end-->