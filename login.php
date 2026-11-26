<?php
require_once __DIR__.'/config.php';
if (logged_in()) { header('Location: admin.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 check_csrf();
 try {
  $s=db()->prepare("SELECT * FROM users WHERE username=? AND active=1 LIMIT 1"); $s->execute([trim($_POST['username']??'')]); $u=$s->fetch();
  if ($u && password_verify($_POST['password']??'', $u['password_hash'])) {
   session_regenerate_id(true); $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'username'=>$u['username'],'role'=>$u['role']];
   db()->prepare("INSERT INTO activity_logs(user_id,action,details) VALUES(?,?,?)")->execute([$u['id'],'Login','Successful administrator login']);
   header('Location: admin.php'); exit;
  }
  $error='Incorrect username or password.';
 } catch(Throwable $e) { $error='Database not ready. Run install.php first.'; }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin sign in · Laundry Shop</title><link rel="stylesheet" href="assets/style.css"></head><body class="auth-page"><div class="auth-layout"><section class="auth-story"><div class="brand"><span class="brand-mark">✦</span><span>Laundry Shop<small>CARE IN EVERY CYCLE</small></span></div><span class="eyebrow">ADMIN WORKSPACE</span><h1>Everything in<br><em>its right cycle.</em></h1><p>Welcome back. Keep every laundry order moving smoothly, every customer informed, and every detail in its place.</p><ul><li>Clear order tracking</li><li>Real-time business overview</li><li>A calmer, cleaner workflow</li></ul></section><section class="auth-card"><div class="tiny-icon">✦</div><span class="eyebrow">ADMIN ACCESS</span><h2>Welcome back</h2><p class="muted">Sign in to manage your laundry shop.</p><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf())?>"><label>Username</label><input name="username" required autocomplete="username" placeholder="Enter your username"><label>Password</label><div class="password-wrap"><input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"><button type="button" class="show-pass" onclick="togglePassword()">Show</button></div><button class="btn primary full">Sign in →</button></form><div class="auth-foot">Thoughtfully built for better laundry days.</div></section></div><script>function togglePassword(){let p=document.getElementById('password');p.type=p.type==='password'?'text':'password'}</script></body></html>
