<?php

function getUserActivities ($user) {
    $query = "http://runkeeper.com/user/" . $user . "/activity";
    $html = executeQuery($query);
    $startChar = strpos($html, "id=\"activityHistoryMenu\"") + (strlen("id=\"activityHistoryMenu\"") + 1);
    $endChar = strpos($html, "id=\"mainColumn\"");
    return substr($html, $startChar, $endChar - $startChar);
}

function getUserActivity ($user, $activityId) {
    $query = 'http://runkeeper.com/user/' . $user . '/activity/' . $activityId;
    $html = executeQuery($query);
    return $html;
}

function executeQuery ($query) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $html = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $html;
}

function getActivityDate ($username, $activity_id) {
    $activity_html = getUserActivity($username, $activity_id);
    preg_match_all('~<span class="secondary">(.*?)</span>~is', $activity_html, $am);
    foreach ($am[1] as $date) {
        $date = explode('-', $date);
        $date = strtotime(trim(strip_tags($date[1])));
        return $date;
    }
}

function getCompetitionTotalMiles ($username, $html, $numberOfJunkMonths) {

    $monthActivityCounts = array();
    preg_match_all('~<div class="bubble-text">(.*?)</div>~is', $html, $monthCounts);
    foreach ($monthCounts[1] as $monthCount) {
        $monthActivityCounts[] = $monthCount;
    }
    $monthActivityCounts = array_slice($monthActivityCounts, 0, sizeof($monthActivityCounts) - $numberOfJunkMonths);

    $activityDistances = array();
    $activityIds = array();
    preg_match_all('~<div class="distance">(.*?)</div>~is', $html, $distances);
    preg_match_all('~.*?link="(/user/' . $username . '/activity/(\d+))".*?~', $html, $aIds);
    foreach ($distances[1] as $i => $distance) {
        $activityDistances[] = $distance;
        $activityIds[] = $aIds[2][$i];
    }

    $monthActivities = array();

    $activitiesTotal = (float) 0;


    $compActivityIds = array();

    $activityIndex = 0;
    foreach ($monthActivityCounts as $i => $monthActivityCount) {
        $monthActivities[$i] = array();
        for ($j = 0; $j < $monthActivityCount; $j++) {
            $monthActivities[$i][] = $activityDistances[$activityIndex];
            $activitiesTotal += $activityDistances[$activityIndex];
            $compActivityIds[] = $activityIds[$activityIndex];
            $activityIndex++;
        }
    }

    return $activitiesTotal;
}

function getCompetitionActivityData ($username, $html, $numberOfJunkMonths) {

    $monthActivityCounts = array();
    preg_match_all('~<div class="bubble-text">(.*?)</div>~is', $html, $monthCounts);
    foreach ($monthCounts[1] as $monthCount) {
        $monthActivityCounts[] = $monthCount;
    }
    $monthActivityCounts = array_slice($monthActivityCounts, 0, sizeof($monthActivityCounts) - $numberOfJunkMonths);

    $activityDistances = array();
    $activityIds = array();
    preg_match_all('~<div class="distance">(.*?)</div>~is', $html, $distances);
    preg_match_all('~.*?link="(/user/' . $username . '/activity/(\d+))".*?~', $html, $aIds);
    foreach ($distances[1] as $i => $distance) {
        $activityDistances[] = $distance;
        $activityIds[] = $aIds[2][$i];
    }

    $monthActivities = array();

    $activitiesTotal = (float) 0;

    $data = array();


    $compActivityIds = array();

    $activityIndex = 0;
    foreach ($monthActivityCounts as $i => $monthActivityCount) {
        $monthActivities[$i] = array();
        for ($j = 0; $j < $monthActivityCount; $j++) {
            $monthActivities[$i][] = $activityDistances[$activityIndex];
            $activitiesTotal += $activityDistances[$activityIndex];
            $compActivityIds[] = $activityIds[$activityIndex];


            $data[$activityIds[$activityIndex]] = array('date' => //date("m/d/Y H:i:s A", getActivityDate($username, $activityIds[$activityIndex])), //11/6/2011  12:00:00 AM
                                                        getActivityDate($username, $activityIds[$activityIndex]),
                                                        'distance' => $activityDistances[$activityIndex]);

            $activityIndex++;
        }
        //break;
    }

    return $data;
}



/*
$benMiles = $rk->get('miles', array(
                                    'username' => "tigerkitten",
                                    'min_date' => '09/22/2011',
                                    'max_date' => '01/01/2012',
                                    'type'     => 'run'
                                    ));

$crisMiles = $rk->get('miles', array(
                                     'username' => "DaddyRoundRound",
                                     'min_date' => '09/22/2011',
                                     'max_date' => '01/01/2012',
                                     'type'     => 'cycling'
                                     ));
*/

?>
