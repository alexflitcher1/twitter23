<div class="page_body">
  <div class="page_content">
    Вы уверены, что хотите забанить навсегда <?=$banuser->name?> @<?=$banuser->username?> (ID: <?=$banuser->id?>)
    (процесс необратим)?
    <a href="/admin/ban?mode=<?=$mode?>&id=<?=$banuser->id?>&sure=1"><button>Да</button></a>
    <a href="/admin/index"><button>Нет</button></a>
</div>
</div>