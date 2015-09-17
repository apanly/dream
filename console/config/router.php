<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
        // ...

       // '/<module:(queue)>/<controller>/<id:\w+>' => '<module>/<controller>/start',
       '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
       '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ],
];