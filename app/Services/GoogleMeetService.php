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

    public function createMeet($summary, $start, $end, array $attendees = [])
    {
        $service = new \Google\Service\Calendar($this->client);

        $attendeeList = array_map(fn($email) => ['email' => $email], $attendees);

        $event = new \Google\Service\Calendar\Event([
            'summary' => $summary,
            'start' => [
                'dateTime' => $start->toRfc3339String(),
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'end' => [
                'dateTime' => $end->toRfc3339String(),
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'attendees' => $attendeeList,
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
            [
                'conferenceDataVersion' => 1,
                'sendUpdates' => 'all',
            ]
        );

        return $event->getHangoutLink();
    }
}
