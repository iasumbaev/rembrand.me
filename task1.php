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

function deleteEmptyFields($input)
{
    if (!is_array($input)) {
        return $input;
    }
    $notEmptyItems = array();

    foreach ($input as $key => $value) {
        if ($value || is_numeric($value)) {
            $temp = deleteEmptyFields($value);
            if ($temp || is_numeric($temp)) {
                $notEmptyItems[$key] = $temp;
            }
        }
    }

    return $notEmptyItems;
}

echo '<pre>';
print_r($example);
echo '</pre>';
echo '<hr/>';
$example = deleteEmptyFields($example);
echo 'Обработанный массив';
echo '<pre>';
print_r($example);
echo '</pre>';
