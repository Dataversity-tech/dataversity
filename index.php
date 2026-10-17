<?php
require __DIR__.'/inc.php';
$sent = false; $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check();
  if (($_POST['website'] ?? '') !== '') { $sent = true; }
  elseif (trim($_POST['name']) === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $msg = 'Enter your name and a valid email address.';
  else { $pdo->prepare('INSERT INTO enrollments (name,email,phone,course,message) VALUES (?,?,?,?,?)')
    ->execute([trim($_POST['name']), trim($_POST['email']), trim($_POST['phone']), trim($_POST['course']), trim($_POST['message'])]); $sent = true; }
}
$courses = $pdo->query('SELECT * FROM courses ORDER BY id')->fetchAll();
$work = $pdo->query('SELECT * FROM work ORDER BY year DESC, id DESC')->fetchAll();
$says = $pdo->query('SELECT * FROM testimonials ORDER BY id DESC')->fetchAll();
head('Dataversity Tech Academy'); ?>
<header class="bar"><a class="brand" href="#top"><img src="mark.svg" alt="">Dataversity <span>Tech Academy</span></a>
<nav><a href="#courses">Courses</a><a href="#work">Our work</a><a href="#enrol">Enrol</a></nav></header>
<main id="top">
<section class="hero"><div><h1>Learn to work with data, from your first spreadsheet to production pipelines.</h1>
<p>Practical training in data analysis, data science, AI and machine learning, data engineering and data storytelling.</p>
<a class="btn" href="#enrol">Enrol now</a></div>
<div class="bars" aria-hidden="true"><i></i><i></i><i></i></div></section>
<?php if ($courses): ?><section class="wrap" id="courses"><h2>Courses</h2><div class="grid">
<?php foreach ($courses as $c): ?><article class="card"><h3><?= e($c['title']) ?></h3><p><?= nl2br(e($c['summary'])) ?></p><p class="meta"><?= e(trim($c['duration'].'  '.$c['level'])) ?></p></article><?php endforeach; ?></div></section><?php endif; ?>
<?php if ($work): ?><section class="wrap" id="work"><h2>Our work and past trainings</h2>
<?php foreach ($work as $w): ?><article class="row"><div><h3><?= e($w['title']) ?></h3><p><?= nl2br(e($w['description'])) ?></p>
<?php if ($w['link']): ?><a href="<?= e($w['link']) ?>" rel="noopener" target="_blank">View details</a><?php endif; ?></div><p class="meta"><?= e($w['type'].' '.$w['year']) ?></p></article><?php endforeach; ?></section><?php endif; ?>
<?php if ($says): ?><section class="wrap"><h2>What learners say</h2><div class="grid">
<?php foreach ($says as $s): ?><blockquote class="card"><p><?= nl2br(e($s['quote'])) ?></p><footer><?= e($s['name']) ?>, <?= e($s['role']) ?></footer></blockquote><?php endforeach; ?></div></section><?php endif; ?>
<section class="wrap narrow" id="enrol"><h2>Enrol</h2>
<?php if ($sent): ?><p class="ok">Thank you. We have your request and will contact you by email.</p>
<?php else: ?><p class="err"><?= e($msg) ?></p><form method="post"><input type="hidden" name="t" value="<?= csrf() ?>">
<input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
<label>Full name<input name="name" required></label><label>Email<input type="email" name="email" required></label><label>Phone<input name="phone"></label>
<label>Course<select name="course"><option value="">Not sure yet</option><?php foreach ($courses as $c) echo '<option>'.e($c['title']).'</option>'; ?></select></label>
<label>Message<textarea name="message" rows="4"></textarea></label><button>Send enrolment request</button></form><?php endif; ?></section>
</main><footer class="foot">Dataversity Tech Academy</footer></body></html>
