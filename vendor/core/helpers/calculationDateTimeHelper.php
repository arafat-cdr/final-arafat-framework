<?php
function num_of_nights($day1, $day2){
    $date1 = new DateTime($day1);
    $date2 = new DateTime($day2);
    // this calculates the diff between two dates,
    //which is the number of nights
    $numberOfNights = $date2->diff($date1)->format("%a");

    return $numberOfNights;
}

#################################################################
## Return true or false if a date in a given range or not
## accept date formates are below
## date is 12/12/2019
## date is 13/12/2019
## or date is 12-12-2019
#################################################################
function check_in_range($start_date, $end_date, $date_from_user) {
  // Convert to timestamp
  $start_ts = strtotime(str_replace("/", "-", $start_date));
  $end_ts = strtotime(str_replace("/", "-", $end_date));
  $user_ts = strtotime(str_replace("/", "-", $date_from_user));

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

# This function return all the date in a date range
function get_all_date_in_range($begin, $end, $interval = "1 day", $include_end = true, $date_format = "d/m/Y") {
    $all_dates_in_range =  array();

    $begin = new DateTime($begin);
    $end = new DateTime($end);

    if($include_end) {
        // this is include the end
        $end = $end->modify( '+1 day' );
    }

    $interval = DateInterval::createFromDateString($interval);
    $period = new DatePeriod($begin, $interval, $end);

    foreach ($period as $dt) {
      $all_dates_in_range[] = $dt->format($date_format);
    }

    return $all_dates_in_range;
}