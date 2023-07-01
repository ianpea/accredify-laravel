<?php

namespace App\Utilities;

class JsonPathUtility {

    // Recursive functions to find all paths of the end node of a json.
    public static function findAll($obj, $path): array {
        // Final array of paths to return to caller
        $final = array();

        // If $obj is of string type, convert it to JSON
        if (gettype($obj) == 'string') {
            $obj = json_decode($obj);
        }

        // Check if $obj is not null from json_decode
        if ($obj != null) {
            // For each key value pair, compute the path of each kvp:
            // If type of value == array or value == object,
            //  end node not found yet, proceed to findAll paths under this value.
            // Else type of value == string, 
            //  end node found, return final path + key.
            foreach ($obj as $key => $value) {
                if (gettype($value) == "array" || gettype($value) == "object") {
                    $array = JsonPathUtility::findAll(json_encode($value), $key);
                    foreach ($array as $key2 => $value2) {
                        // empty path == root path, no need to add '.' separator
                        if (empty($path)) {
                            $final[$key2] = $value2;
                        } else {
                            $final[$path . '.' . $key2] = $value2;
                        }
                    }
                } else {
                    if (empty($path)) {
                        $final[$key] = $value;
                    } else {
                        $final[$path . '.' . $key] = $value;
                    }
                }
            }
        }


        return $final;
    }
}
