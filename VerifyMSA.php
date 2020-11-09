<html>
  <head>
    <title>Microsoft Account Test</title>

    <style>
    .userInput {
      margin: 1px;
      padding: 1px;
      width: 300px;
      height: 150px;
      resize: none;
    }
  </style>
  </head>
  <body>

<?php
if($_POST['submit']) {

  $content = explode("\r\n", trim($_POST['content']));

  foreach ($content as $email) {
    $email_encoded = urlencode($email);

    $url = "https://odc.officeapps.live.com/odc/emailhrd/getidp?hm=0&emailAddress=$email_encoded";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);

    echo "<p>$email - ";
    switch ($output) {
      case "Both":
        echo "Microsoft Personal *and* Work Accounts";
        break;
      case "MSAccount":
        echo "Microsoft Personal Account";
        break;
      case "Neither":
        echo "Neither Personal or Work Accounts";
        break;
      case "OrgId,Placeholder":
        echo "Microsoft Work Domain with no Personal Account";
        break;
      case "Error":
        echo "Error (no detail)";
        break;
      default:
        echo "Invalid response from Microsoft";
    }
    echo "</p>";

  }
}
?>

    <form method="post">
    <p>Use one email per line</br>
    <textarea name="content" class="userInput"></textarea></p>
    <p><input type="submit" name="submit"/></p>
    </form>

  </body>
</html>
