<?php
/**
  * This script is for easily deploying updates to Github repos to your local server. It will automatically git clone or
  * git pull in your repo directory every time an update is pushed to your $BRANCH (configured below).
  *
  * INSTRUCTIONS:
  * 1. Edit the variables below
  * 2. Upload this script to your server somewhere it can be publicly accessed
  * 3. Make sure the apache user owns this script (e.g., sudo chown www-data:www-data webhook.php)
  * 4. (optional) If the repo already exists on the server, make sure the same apache user from step 3 also owns that
  *    directory (i.e., sudo chown -R www-data:www-data)
  * 5. Go into your Github Repo > Settings > Service Hooks > WebHook URLs and add the public URL
  *    (e.g., http://example.com/webhook.php)
  *
**/

// Set Variables
$LOCAL_ROOT         = "/var/www/html_mene";
$LOCAL_REPO_NAME    = "mattiamaneghin.tk";
$LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$REMOTE_REPO        = "git@github.com:Mattiamene1/mattiameneghin.tk.git";
$REMOTE_REPO_URL    = "https://github.com/Mattiamene1/mattiameneghin.tk.git";
$BRANCH             = "main";

$date = date('Y/m/d H:i:s', time());
shell_exec("echo \"$date - PHP Start HERE\" >> " . $LOCAL_ROOT . "log.txt");
shell_exec("echo \"         Local repo: _ $LOCAL_REPO _\" >> " . $LOCAL_ROOT . "log.txt");
// shell_exec("echo \"         Is_dir: " . is_dir($LOCAL_REPO) . " \" >> " . $LOCAL_ROOT . "log.txt");

if ( $_POST['payload'] ) {
  // Only respond to POST requests from Github

  if( is_dir($LOCAL_REPO) ) {

    shell_exec("echo \"         GIT PULL\" >> " . $LOCAL_ROOT . "log.txt");
    // If there is already a repo, just run a git pull to grab the latest changes
    shell_exec("cd {$LOCAL_REPO} && git pull");

    // die("done " . mktime());
  } else {

    shell_exec("echo \"         GIT CLONE\" >> " . $LOCAL_ROOT . "log.txt");
    // If the repo does not exist, then clone it into the parent directory
    shell_exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO_URL}");

    // die("done " . mktime());
  }
}

shell_exec("echo \"PHP END\" >> " . $LOCAL_ROOT . "log.txt");
shell_exec("echo \" ---------------------------------------- \" >> " . $LOCAL_ROOT . "log.txt");
?>