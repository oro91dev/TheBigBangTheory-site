<div class="footer">
  <?php
    $validurl = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    echo "<a class='left' href='http://validator.w3.org/check?uri=".$validurl."'><img alt='valider siden' src='style/img/html_valid.png' /></a>
          <div class='split left'></div>
          <div class='left'>Kontakt:<br/><strong>hioagruppe13@gmail.com</strong></div>
          <div class='right'><a class='linker' href='index.php?name=Opphavsrett'>Opphavsrett</a></div>
    ";
  ?>
</div>