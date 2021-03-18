<?php
const roomDataFileUrl = "../!roomdata.txt";

$roomname = $_POST["roomname"];
$roomId = $_POST["roomId"];

// (check data - implement in future)

// read file
$roomDataStr = file_get_contents(roomDataFileUrl);

// do check for null
if ($roomDataStr !== null) {
    // if data file is empty, then just make empty array for data instead of reading file
    if (strlen($roomDataStr) <= 0) {
        $roomData = [];
    }
    else { // otherwise parse data
        $roomData = json_decode($roomDataStr);
    }

    // check if there is another room with that id, don't proceed if there is
    $roomIdUnique = getRoom($roomData, $roomId) === null;
    if ($roomIdUnique) {
        // make room
        $room = new stdClass();
        $room->name = $roomname;
        $room->id = $roomId;
        $room->whiteboardData = [];
        $room->chatMessages = [];

        // add message to room, stringify data
        array_push($roomData, $room);
        $roomDataStr = json_encode($roomData);
        // check if json_encode died, put in file
        if (strlen($roomDataStr) > 0) {
            file_put_contents(roomDataFileUrl, $roomDataStr);
        }
        file_put_contents(roomDataFileUrl, $roomDataStr);
        echo "success";
    }
    else {
        echo "||roomIdDuplicated";
    }
}
else {
    echo "**roomFileEmpty";
}

function getRoom($roomData, $roomId) {
    $room = null;
    for ($i = 0; $i < count($roomData); $i ++) {
        $currentRoom = $roomData[$i];
        if ($currentRoom->id === $roomId) {
            $room = $currentRoom;
            break;
        }
    }
    return $room;
}
?>