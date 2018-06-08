<?php


/**
 * Match function
 *
 * @param int $c1 team1  
 * @param int $c2 team2
 * 
 * @return array $arr goals
 */
function match($c1, $c2)
{
    $c1_goals = 0;
    $c2_goals = 0;
    include 'data.php';
    $team1 = $data[$c1];
    $team2 = $data[$c2];
    $lid = lid($data);
    $nlgskip1 = perc($team1);
    $nlgskip2 = perc($team2);

    $c1_goals = round(mt_rand(0, $nlgskip1['scorerate']) * 1+($team1['win']/$lid + $nlgskip1['luck']));
    $c2_goals = round(mt_rand(0, $nlgskip2['scorerate']) * 1+($team2['win']/$lid + $nlgskip1['luck']));

    $arr = [$c1_goals, $c2_goals];
    return $arr;
}

/**
 * Function lid($dat)
 *
 * @param array $dat is array $data
 * 
 * @return int $maxwin
 */
function lid($dat)
{
    $maxwin = 0;
    foreach ($dat as $value) {
        if ($maxwin < $value['win']) {
            $maxwin = $value['win']; 
        }
    }
    return $maxwin;
}

function perc($datateam)
{

    $l = (
            (
                (
                    $datateam['win']/$datateam['games']
                )
                +
                (
                    $datateam['draw']/$datateam['games']
                )
                -
                (
                    $datateam['defeat']/$datateam['games']
                )
            )  // / 3
                );  // * 100;
    $luck = round($l, 2);
    $scorerate = $datateam["goals"]["scored"]/$datateam['games'];  // Среднее количество голов за игру
    $skiprate = $datateam["goals"]["skiped"]/$datateam['games'];  // Среднее количество пропущенных за игру
    return ['name' => $datateam["name"], 'luck' => $luck, 'scorerate' => $scorerate, 'skiprate' => $skiprate];
}

$result = match(0, 2);
echo $result[0], ' ', $result[1], '<br>';