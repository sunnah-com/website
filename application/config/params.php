<?php

return [
    'adminEmail' => $parameters['adminEmail'],
    'cacheTTL' => (array_key_exists('cacheTTL', $parameters) ? $parameters['cacheTTL'] : 3600),
    'pageSize' => '100',
];
