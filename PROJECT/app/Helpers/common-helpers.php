<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;





function ___($key = null, $replace = [], $locale = null)
{
    $input = explode('.', $key);
    $file = $input[0];
    $term = $input[1] ?? '';
    $app_local = Session::get('locale');
    $file_path = base_path('lang/' . $app_local . '/' . $file . '.json');
    $term = str_replace('_', ' ', $term);

    if (!is_dir(dirname($file_path))) {
        mkdir(dirname($file_path), 0777, true);
    }
    if (!file_exists($file_path)) {
        $data = [];
        file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    $jsonString = file_get_contents($file_path);
    $data = json_decode($jsonString, true);

    if (@$data[$term]) {
        return $data[$term];
    } else {
        $data[$term] = $term;
        file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    return $term;
}



