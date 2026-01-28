<?php
session_start();
header("Content-Type: application/json");

$file = "state.json";

if (!file_exists($file)) {
    $state = [
        "board" => array_fill(0,15,array_fill(0,15,0)),
        "turn" => 1
    ];
    file_put_contents($file, json_encode($state));
}

$state = json_decode(file_get_contents($file), true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $x = $data["x"];
    $y = $data["y"];

    if ($state["board"][$y][$x] === 0) {
        $state["board"][$y][$x] = $state["turn"];
        $state["turn"] = $state["turn"] === 1 ? 2 : 1;
        file_put_contents($file, json_encode($state));
    }
}

echo json_encode($state);
