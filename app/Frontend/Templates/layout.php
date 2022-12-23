<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <title><?= $title ?? 'Mon super site' ?></title>
    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" href="/css/Envision.css" type="text/css"
    />
</head>
<body>
<div id="wrap">
    <div id="header">
        <h1 id="logo-text"><a href="/">Mon super site</a></h1>
        <p id="slogan">Comment ça « il n'y a presque rien » ?</p>
    </div>
    <div id="menu">
        <ul>
            <li><a href="/">Accueil</a></li>
            <?php if ($user->isAuthenticated()): ?>
                <li><a href="/admin">Admin</a></li>
                <li><a href="/admin/news-insert.html">Ajouter une news</a></li>
                <li><a href="/admin/logout.html">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/admin/login.html">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div id="content-wrap">
        <div id="main">
            <?php if ($user->hasFlash()): ?>
                <p style="text-align:center;"><?= $user->getFlash() ?></p>
            <?php endif ?>
            <?= $content ?>
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>