
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
</head>
<body>
<?php
require_once 'src/apiClient.php';
require_once 'src/apiAnalyticsService.php';
session_start();

$client = new apiClient();
$client->setApplicationName("Google Analytics PHP Starter Application");

// Visit https://code.google.com/apis/console?api=analytics to generate your
// client id, client secret, and to register your redirect uri.

// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_oauth2_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');


$client->setClientId('430863924509.apps.googleusercontent.com');
$client->setClientSecret('072QryIsTOOrBqeenZZxoW_x');
$client->setRedirectUri('http://localhost:8888/gap/examples/analytics/simple.php');
$client->setDeveloperKey('AIzaSyBmrnwCC2I2fI7kk_PpP4SDtego_JtXay0');
$service = new apiAnalyticsService($client);

if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
/*  $props = $service->management_webproperties->listManagementWebproperties("~all");
  print "<h1>Web Properties</h1><pre>" . print_r($props, true) . "</pre>";

  $accounts = $service->management_accounts->listManagementAccounts();
  print "<h1>Accounts</h1><pre>" . print_r($accounts, true) . "</pre>";

  $segments = $service->management_segments->listManagementSegments();
  print "<h1>Segments</h1><pre>" . print_r($segments, true) . "</pre>";

  $goals = $service->management_goals->listManagementGoals("~all", "~all", "~all");
  print "<h1>Goals</h1><pre>" . print_r($goals, true) . "</pre>";
*/
  $profiles = $service->management_profiles->listManagementProfiles("~all", "~all");
//  print "<h1>profiler</h1><pre>" . print_r($profiles, true) . "</pre>";
  print "<h1>profiler du kan velge mellom</h1>";
  
  print "<ul>";
  $count = count($profiles[items]);
for ($i = 0; $i < $count; $i++) {
    print "<li>" . $profiles[items][$i][name] . " - " .  $profiles[items][$i][id] . "</li>\n";
}
  print "</ul>";
  print "<select>";
for ($i = 0; $i < $count; $i++) {
    print "<option value='".  $profiles[items][$i][id] . "'>"  . $profiles[items][$i][name] . "</option>\n";
}
  print "</select>";
  
  
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}

?>
</body>
</html>