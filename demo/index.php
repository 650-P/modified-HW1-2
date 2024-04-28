<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Online multi-tools</title>
</head>
<body>
  <h1>Online multi-tools</h1>
  <p>Introducing the online multi-tools service!</p>
  <p>Read flag.txt (it is in the same directory as index.php)</p>
  <p>The work "flag" and the following characters are banned: $;"'|&/(`)</p>
<?php
  $tool = @$_POST['tool'];
  $hostname = @$_POST['hostname'];

  if (isset($hostname)) {

    if ($tool !== "dig" && $tool !== "nslookup" && $tool !== "traceroute" && $tool !== "env") {
      die("tool is incorrect");
    }
    if ($tool === "env" && !empty($hostname)) {
      die("When using env, you should leave hostname empty.");
    }

    // stop the program if special char detected, prevent injection attacks
    if (strpos($hostname, '$') !== false) die("attack attempt detected! '$', try harder.");
    if (strpos($hostname, ';') !== false) die("attack attempt detected! semicolon, try harder.");
    if (strpos($hostname, '"') !== false) die("attack attempt detected! quote, try harder.");
    if (strpos($hostname, "'") !== false) die("attack attempt detected! singlequote, try harder.");
    if (strpos($hostname, '|') !== false) die("attack attempt detected! '|', try harder.");
    if (strpos($hostname, '&') !== false) die("attack attempt detected! '&', try harder.");
    if (strpos($hostname, '/') !== false) die("attack attempt detected! '/', try harder.");
    if (strpos($hostname, '(') !== false) die("attack attempt detected! '(', try harder.");
    if (strpos($hostname, '`') !== false) die("attack attempt detected! '`', try harder.");
    if (strpos($hostname, ')') !== false) die("attack attempt detected! ')', try harder.");
    if (strpos($hostname, '*') !== false) die("attack attempt detected! '*', try harder.");
    
    if (strpos($hostname, 'flag') !== false) die("attack attempt detected! 'flag', try harder.");
    echo "<pre>";
    echo "$tool $hostname \n";
    passthru("bash +o noglob -c \"$tool $hostname\"");
    echo "</pre>";
  }
?>

<form method="post">
  <select name="tool">
    <option value="dig">Dig: Convert domain to IP</option>
    <option value="nslookup">Nslookup: Convert domain to IP</option>
    <option value="traceroute">Traceroute: Check the route inbetween</option>
    <option value="env">ENV: Show environment variables</option>
  </select>
  <input type="text" name="hostname" placeholder="(e.g. google.com)" />
  <input type="submit" value="Run!" />
</form>

</body>
</html>
