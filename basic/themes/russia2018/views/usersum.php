<h3>Чемпионат прогнозистов</h3>
<table class="table">
    <tbody>
    <tr>
        <td>м</td>
        <td>имя</td>
        <td>блс</td>
        <td>счт</td>
        <td>исх</td>
        <td>нет</td>
    </tr>
    <?php $i=0;  foreach ($user_sum as $user) : $i++;
        if($user->id == $user_id) $color = 'red'; else $color = 'white'; ?>
    <tr>
        <td style="color:<?=$color?>"><?= $i ?></td>
        <td style="color:<?=$color?>"><?= $user->name ?></td>
        <td style="color:<?=$color?>"><?= $user->balance ?></td>
        <td style="color:<?=$color?>"><?= $user->precise ?></td>
        <td style="color:<?=$color?>"><?= $user->result ?></td>
        <td style="color:<?=$color?>"><?= $user->no_goal ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
