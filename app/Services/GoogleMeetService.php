<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;

class GoogleMeetService
{
    protected $client;

    public function __construct()
    {
        $user = auth()->user();
        // dd($user);
        $this->client = new \Google\Client();
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->setAccessType('offline');
        $this->client->setScopes([\Google\Service\Calendar::CALENDAR]);

        $this->client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => 3600,
        ]);

    }

    public function createMeet($summary, $start, $end)
    {
        // dd($this->client);
        $service = new \Google\Service\Calendar($this->client);

        $event = new \Google\Service\Calendar\Event([
            'summary' => 'Reunión',
            'start' => [
                'dateTime' => $start,
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'end' => [
                'dateTime' => $end,
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        $event = $service->events->insert(
            'primary',
            $event,
            ['conferenceDataVersion' => 1]
        );

        return $event->getHangoutLink();

    }
}
