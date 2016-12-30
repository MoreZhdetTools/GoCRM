<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<h3>СПИСОК ФРЕНДОВ</h3>
<a href="/">Вернутся назад</a>

<div class="table-responsive">
<table class="table">
  <thead>
    <th>Аватарка</th>
    <th>ФИО ВК</th>
    <th>id ВК</th>
    <th>email из БД</th>
    <th>телефон из БД</th>
    <th>ФИО из БД</th>
  </thead>
  <? foreach($friends as $friend) { ?>
  <form action="/friends/update" method="POST">
  <input type="hidden" name="vk_friend_id" value="<? echo $friend['vk_friend_id']?>">
  <tr>
    <th><img src="<? echo $friend['vk_photo']?>"></th>
    <th><? echo $friend['vk_fio'] ?></th>
    <th><? echo 'id'.$friend['vk_friend_id']?></th>
    <th><input type="text" name="email" value="<? echo $friend['email']?>"></th>
    <th><input type="text" name="phone" value="<? echo $friend['phone']?>"></th>
    <th><input type="text" name="fio" value="<? echo $friend['fio']?>"></th>
    <th><a href="<? echo 'https://vk.com/id'.$friend['vk_friend_id']?>" target="_blank">Перейти</a></th>
    <th><a href="<? echo 'https://vk.com/write'.$friend['vk_friend_id']?>" target="_blank">Чат</a></th>
    <th><button type="submit">Изменить</button></th>
  </tr>
  </form>
  <? } ?>
</table>
</div>