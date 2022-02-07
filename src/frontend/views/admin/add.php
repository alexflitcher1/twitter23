<div class="page_body">
  <div class="page_content">
    Вы уверены что хотите <?=$mode == 1 ? "поставить на пост администратора" : "снять с поста администратора" ?>
    <?=$simadmin->name?> @<?=$simadmin->username?> (ID: <?=$simadmin->id?>)
    <a href="/admin/add?mode=<?=$mode?>&id=<?=$simadmin->id?>&sure=1"><button>Да</button></a>
    <a href="/admin/users"><button>Нет</button></a>
</div>
</div>