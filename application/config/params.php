<?php

return [
    'adminEmail' => $parameters['adminEmail'],
    'classyCampaignId' => $parameters['classy_campaign_id'],
    'cacheTTL' => (array_key_exists('cacheTTL', $parameters) ? $parameters['cacheTTL'] : 3600),
    'pageSize' => '100',
];
