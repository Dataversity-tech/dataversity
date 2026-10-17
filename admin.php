<?php
require __DIR__.'/inc.php';
$T = [
 'courses' => ['Courses', ['title'=>'Title','summary'=>'Summary','duration'=>'Duration','level'=>'Level']],
 'work' => ['Past work and trainings', ['title'=>'Title','type'=>'Type (Training or Project)','year'=>'Year','description'=>'Description','link'=>'Link (optional)']],
 'testimonials' => ['Testimonials', ['name'=>'Name','role'=>'Role','quote'=>'Quote']],
];
$big = ['summary','description','quote'];
if (isset($_GET['out'])) { session_destroy(); header('Location: admin.php'); exit; }
$err = '';
if (isset($_POST['login'])) { check();
  $s = $pdo->prepare('SELECT * FROM admins WHERE username=?'); $s->execute([$_POST['u']]); $a = $s->fetch();
  if ($a && password_verify($_POST['p'], $a['pass'])) { session_regenerate_id(true); $_SESSION['a'] = $a['id']; header('Location: admin.php'); exit; }
  $err = 'Wrong username or password.';
}
if (!isset($_SESSION['a'])) { head('Admin sign in'); ?>
<main class="narrow"><h1>Admin sign in</h1><p class="err"><?= e($err) ?></p>
<form method="post"><input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="login" value="1">
<label>Username<input name="u" required autofocus></label><label>Password<input type="password" name="p" required></label>
<button>Sign in</button></form></main></body></html><?php exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check(); $tb = $_POST['tb'] ?? '';
  if (isset($_POST['del']) && ($tb === 'enrollments' || isset($T[$tb]))) {
    $pdo->prepare("DELETE FROM $tb WHERE id=?")->execute([(int)$_POST['del']]);
  } elseif (isset($T[$tb])) {
    $f = array_keys($T[$tb][1]); $v = array_map(fn($k) => trim($_POST[$k] ?? ''), $f); $id = (int)($_POST['id'] ?? 0);
    if ($id) $pdo->prepare("UPDATE $tb SET ".implode(',', array_map(fn($k) => "$k=?", $f))." WHERE id=?")->execute([...$v, $id]);
    else $pdo->prepare("INSERT INTO $tb (".implode(',', $f).") VALUES (".implode(',', array_fill(0, count($f), '?')).")")->execute($v);
  }
  header('Location: admin.php?t='.urlencode($tb)); exit;
}
$t = $_GET['t'] ?? 'courses'; if ($t !== 'enrollments' && !isset($T[$t])) $t = 'courses';
head('Dataversity admin'); ?>
<header class="bar"><a class="brand" href="index.php"><img src="mark.svg" alt="">Dataversity admin</a>
<nav><?php foreach ($T as $k => $d) echo '<a '.($t===$k?'aria-current="page" ':'').'href="?t='.$k.'">'.e($d[0]).'</a>'; ?>
<a <?= $t==='enrollments'?'aria-current="page" ':'' ?>href="?t=enrollments">Enrolments</a><a href="?out=1">Sign out</a></nav></header>
<main class="wrap">
<?php if ($t === 'enrollments'):
  $rows = $pdo->query('SELECT * FROM enrollments ORDER BY id DESC')->fetchAll(); ?>
  <h1>Enrolment requests</h1><?php if (!$rows) echo '<p>No requests yet. They appear here when someone fills in the form on your site.</p>'; ?>
  <?php foreach ($rows as $r): ?><article class="row"><div><strong><?= e($r['name']) ?></strong> · <?= e($r['course']) ?><br>
  <a href="mailto:<?= e($r['email']) ?>"><?= e($r['email']) ?></a> · <?= e($r['phone']) ?> · <?= e($r['created']) ?><p><?= nl2br(e($r['message'])) ?></p></div>
  <form method="post" onsubmit="return confirm('Delete this request?')"><input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="tb" value="enrollments"><button name="del" value="<?= $r['id'] ?>" class="ghost">Delete</button></form></article><?php endforeach; ?>
<?php else:
  [$label, $fields] = $T[$t]; $edit = null;
  if (isset($_GET['edit'])) { $s = $pdo->prepare("SELECT * FROM $t WHERE id=?"); $s->execute([(int)$_GET['edit']]); $edit = $s->fetch(); }
  $rows = $pdo->query("SELECT * FROM $t ORDER BY id DESC")->fetchAll(); ?>
  <h1><?= e($label) ?></h1>
  <form method="post" class="card"><h2><?= $edit ? 'Edit entry' : 'Add an entry' ?></h2>
  <input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="tb" value="<?= $t ?>"><input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">
  <?php foreach ($fields as $k => $l): ?><label><?= e($l) ?>
  <?php if (in_array($k, $big)): ?><textarea name="<?= $k ?>" rows="4"><?= e($edit[$k] ?? '') ?></textarea>
  <?php else: ?><input name="<?= $k ?>" value="<?= e($edit[$k] ?? '') ?>"><?php endif; ?></label><?php endforeach; ?>
  <button><?= $edit ? 'Save changes' : 'Add entry' ?></button><?php if ($edit) echo ' <a href="?t='.$t.'">Cancel</a>'; ?></form>
  <?php if (!$rows) echo '<p>Nothing here yet. Add your first entry above.</p>'; ?>
  <?php foreach ($rows as $r): ?><article class="row"><div><strong><?= e($r[array_key_first($fields)]) ?></strong><p><?= e(mb_strimwidth($r[array_keys($fields)[1]] ?? '', 0, 140, '…')) ?></p></div>
  <div class="acts"><a href="?t=<?= $t ?>&edit=<?= $r['id'] ?>">Edit</a>
  <form method="post" onsubmit="return confirm('Delete this entry?')"><input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="tb" value="<?= $t ?>"><button name="del" value="<?= $r['id'] ?>" class="ghost">Delete</button></form></div></article><?php endforeach; ?>
<?php endif; ?></main></body></html>
