<?php
$url = 'http://' . $_SERVER['SERVER_ADDR'] . '/task2.php';
$data = [
    'number' => [
        1,
        2.0
    ],
    'date' => [
        '11.05.1995',
        '11.05.1996',
    ],
    'price' => [
        '890.9856',
        '890.9856',
        '5432144684.823',
        5423.546,
        8012.15,
        1890.9856,
        890.56

    ],
    'string' => [
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium at beatae dolorem eveniet explicabo itaque iure laborum libero maiores minima nam odit optio, praesentium quaerat quam vel. Deleniti, ipsa.',
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus accusantium blanditiis consequatur distinctio dolore dolores doloribus eligendi et facilis libero minus modi nostrum omnis quae, recusandae repellendus suscipit tenetur.',
    ]
];

echo '<pre>';
var_dump($data);
echo '</pre>';
echo 'Отправка POST-запроса с данными';

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);