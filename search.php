<?php

$jsonurl = "hotels.json";
$json = file_get_contents( $jsonurl );
$hotelList = json_decode( $json, true );
$searchQuery = $_POST[ 'search' ];
$nr = $_POST['nr'];

if ( isset( $_POST[ 'search' ] ) )
{
    echo melding($searchQuery, "fromme");
    if( $nr == "0" ) {
        $words = explode(" ", $searchQuery);
        foreach ($words as $word) {
            $word = clean($word);
            $city = dive($hotelList, $word, 0);

        }
        if(is_string($city)) {
            $hotels = listHotelsByCity($city, $hotelList);
            foreach ($hotels as $hotelname => $hotelProperties){
                $reply =  buildMessage(
                    $city,
                    $hotelname,
                    $hotelProperties['area'],
                    $hotelProperties['attractions'],
                    $hotelProperties['rate']
                );
            }
        }
        echo melding($reply, "fromyou");
        echo showProfile("Alexander", "Los Angeles", "Film producer, techie and yogi.", "alexander.jpeg", "basicinfocopy.svg");
        echo showProfile("Daniel", "London", "Write stuff, make stuff, eat stuff.", "daniel.jpg", "basicinfocopy2.svg");
        echo showProfile("Jason", "New York City", "Management consultant.", "jason.jpeg", "basiccopy1.svg");
        echo melding("Would you like to stay with Alexander, Daniel or Jason?", "fromyou");
    }
    else if( $nr == "1") {
        $msg = "Meet Emily (28). She is an artist, just like you.
        Emily is seeking a roommate for  <a href='images/Hotellboble.png'>Clarion Collection Hotel
        Folketeateret</a>. You’ll each pay 90 EUR per night (45% discount).
        The hotel is located at Youngstorget, with a wide range of bars
        and restaurants in the area.";
        echo melding($msg, "fromyou");
        echo showProfile("Emily", "Los Angeles", "Model and actress. @emrata.", "emilie.jpg", "basicinfocopy3.svg");
        echo melding("Would you like to stay with her?", "fromyou");
    }
    else if( $nr == "2") {
        $msgs = ["All right. I’ll let Emily know you’re interested, but
        she will have to accept you as well. Stay tuned, and cross your
        fingers.", "Quick response. Emily likes you as well and your room
        is booked. You can get may talk to her using the chat in the top
        right corner.", "Press (y) and I’ll charge 90 EUR on your payment
        card."];
        foreach($msgs as $msg) echo melding($msg, "fromyou");
    }

}

function buildMessage($city, $hotelname, $area, $attractions, $rate) {
    return "I love $city! Three people are looking for a roommate at <a href='image/Hotellboble.png'>$hotelname</a>.
    It’s located in the $area, only a quick walk from the $attractions. At $rate
    EUR per night (49% discount), it’s a good rate, however all of them are male.
    Check out their profiles below.";
}

function dive ($array, $search, $layer) {

    $return = "";
    foreach($array as $arraykey => $arrayvalue) {

        if (strtolower($arraykey) == strtolower($search)) {
            $return .= $arraykey;
        }

        if(is_array( $arrayvalue )) {
            $return .= dive($arrayvalue, $search, ($layer+1));
        }
        else if (strtolower($arrayvalue) == strtolower($search)) {
            $return .= $arrayvalue;
        }
    }
    if(strlen($return) > 2) return $return;

}

function listHotelsByCity( $cityName, $list) {
    $return = "";
    foreach ($list[0] as $countries )
    {
        foreach ( $countries as $city => $hotels )
        {
            if ( strtolower( $city ) == strtolower( $cityName ) )
            {
                $return = $hotels;
            }
        }
    }
    if(is_array($return)) return $return;
}

function melding($text, $me) {
    return '<div class="to"><div class="'.$me.'"><p>'.$text.'</p></div></div>';
}

function clean( $word ) {

    $notallowed = [",", ".", "?", "!", "\""];

    $lastchar = substr($word, -1);
    foreach($notallowed as $joker) {
        if ($lastchar == $joker) {
            return substr($word, 0, -1);
        }
    }
    return $word;
}

function showProfile($name, $location, $bio, $imagelink, $info) {
    return "
    <div class='from'>
            <div class='imagewrapper'>
                <div class='profile'>
                    <img src='image/$imagelink' class='profilepic'>
                    <div class='basicinfo'>
                        <img src='image/$info' class='info'>
                    </div>
                    <div class='white'>

                    </div>
                    <h3>$name</h3>
                    <h4>$location</h4>
                    <h5>$bio</h5>
                </div>
            </div>
        </div>";
}
?>