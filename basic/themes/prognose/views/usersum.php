<h3>Чемпионат</h3>
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
    <?php $i=0; foreach ($user_sum as $user) : $i++; ?>
    <tr>
        <td><?= $i ?></td>
        <td><?= $user->user->name ?></td>
        <td><?= $user->sum ?></td>
        <td><?= ((isset($users_status['good'][$user->user->id-1]->cnt)) ? $users_status['good'][$user->user->id-1]->cnt : 0) ?></td>
        <td><?= ((isset($users_status['middle'][$user->user->id-1]->cnt)) ? $users_status['middle'][$user->user->id-1]->cnt : 0) ?></td>
        <td><?= ((isset($users_status['bad'][$user->user->id-1]->cnt)) ? $users_status['bad'][$user->user->id-1]->cnt : 0) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
