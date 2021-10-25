<div>
    <p>Ваш текущий баланс: <?=$param['balance']?></p>
    <p><?=$param['error']?></p>
    <?if(isset($param['drop_access'])){?>
        <p>Успешно списано с баланса: <?=$param['drop_access']?></p>
    <?}?>
    <form action="drop_money">
        <input type="number" step="0.01" name="count"><br>
        <input type="submit" value="Вывести">
    </form>
</div>
