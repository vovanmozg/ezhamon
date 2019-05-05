<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
		@import "style.css";
		
	</style>
</head>
<body>
<? require('topmenu.php'); ?>
<div id="box">

  <b class="v1"></b><b class="v2"></b><b class="v3"></b><b class="v4"></b><b class="v5"></b>
  <div class="text">
  <h2>О скрипте</h2>
  	<p>Ежамон — это система мониторинга SEO-параметров сайта, таких как индекс цитирования, Google PageRank и прочих. Скрипт позволяет отслеживать параметры сразу нескольких сайтов. </p>
<p>Стандартный комплект проверяет следующие параметры:</p>
	<ul>
		<li>Индекс цитирования;</li>
		<li>Google PageRank;</li>
		<li>количество страниц в индексе Яндекса, Google, Рабмлера, Yahoo;</li>
		<li>количество ссылок на сайт по данным Google, Yahoo;</li>
		<li>количество упоминаний сайта по данным Яндекса.</li>
	</ul>
	
	<h2>Стандартная схема работы</h2>
	<p>Основное назначение скрипта — получение параметров списка сайтов с&nbsp;заданной периодичностью.</p>
	<p>В общем случае настройка сводится к выполнению двух пунктов:</p>
	<ol>
		<li>Вы <a href="manage_sites.php">добавляете</a> сайты, которые хотите отслеживать.</li>
		<li>Настриваете периодический запуск скрипта refresh.php (например с помощью crontab, если он есть на вашем хостинге).</li>
	</ol>
	
	<h2>Почему не обновляются параметры?</h2>
	<p>Если с момента предыдущего получения параметров сайта прошло меньше суток, то скрипт не будет выполнять эту процедуру.</p>
	<p>Это сделано для того, чтобы лишний раз не получать одни и те же параметры. Ведь в течение суток, мало что изменяется в поисковиках.</p>
	
	
	<h2>Как удалить сайт?</h2>
	<p>Пока есть только один способ — напрямую редактировать базу данных, например с помощью PhpMyAdmin.</p>
	
	
	<p></p>
	
  </div>
  <b class="v5"></b><b class="v4"></b><b class="v3"></b><b class="v2"></b><b class="v1"></b>


	</div>
<? require('footer.php'); ?>
</body>
</html>