<?php
require __DIR__.'/inc.php';
$has = false; try { $has = (bool)$pdo->query('SELECT 1 FROM admins LIMIT 1')->fetch(); } catch (Exception $x) {}
if ($has) die('Setup is already done. Delete setup.php from your server.');
$msg = ''; $done = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check();
  if (strlen($_POST['p']) < 10 || trim($_POST['u']) === '') $msg = 'Enter a username and a password of at least 10 characters.';
  else {
    $c = ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
    foreach ([
      "CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(60) UNIQUE, pass VARCHAR(255))$c",
      "CREATE TABLE IF NOT EXISTS courses (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(160), summary TEXT, duration VARCHAR(60), level VARCHAR(60))$c",
      "CREATE TABLE IF NOT EXISTS work (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(160), type VARCHAR(40), year VARCHAR(10), description TEXT, link VARCHAR(255))$c",
      "CREATE TABLE IF NOT EXISTS testimonials (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), role VARCHAR(120), quote TEXT)$c",
      "CREATE TABLE IF NOT EXISTS enrollments (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120), email VARCHAR(160), phone VARCHAR(40), course VARCHAR(160), message TEXT, created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)$c"
    ] as $q) $pdo->exec($q);
    $pdo->prepare('INSERT INTO admins (username, pass) VALUES (?, ?)')->execute([trim($_POST['u']), password_hash($_POST['p'], PASSWORD_DEFAULT)]);
    $done = true;
  }
}
head('Set up Dataversity'); ?>
<main class="narrow"><h1>Set up Dataversity</h1>
<?php if ($done): ?><p>Done. <strong>Delete setup.php from your server now</strong>, then <a href="admin.php">sign in to the admin panel</a>.</p>
<?php else: ?><p class="err"><?= e($msg) ?></p>
<form method="post"><input type="hidden" name="t" value="<?= csrf() ?>">
<label>Admin username<input name="u" required></label>
<label>Admin password<input type="password" name="p" minlength="10" required></label>
<button>Create tables and admin</button></form><?php endif; ?></main></body></html>
