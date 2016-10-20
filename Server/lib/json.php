<?php

Class JsonGenerator {

    public static function getJson($array) {
        return json_encode($array);
    }

    public static function getArray($json) {
        return json_decode($json, true);
    }

}
