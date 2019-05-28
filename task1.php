<?php
$example = [
    "name" => "Software",
    "properties" => [
        "version" => "",
        "size" => 195,
        "param" => 0
    ],
    "author" => [
        [
            "name" => "",
            "email" => ""
        ],
        [
            "name" => "Ivan",
            "email" => "mail@example.com"
        ]
    ]
];

function recursive_array_filter($array) {
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = recursive_array_filter($value);
        }
    }
    //Если 0 считается за пустое значение, то можно просто убрать callback-функцию
    return array_filter($array, function ($var) {
        return ($var !== false && $var !== null && $var !== '' && $var !== []);
    });
}

echo '<pre>';
print_r($example);
echo '</pre>';
echo '<hr/>';
$example = recursive_array_filter($example);
echo 'Обработанный массив';
echo '<pre>';
print_r($example);
echo '</pre>';
