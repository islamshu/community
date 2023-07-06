<?php

namespace App;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventAttendee;
use Google_Service_Calendar_EventDateTime;
use Google\Apis\Meet\v1\MeetService;
use Google_Service_HangoutsMeet;
use Google_Service_HangoutsMeet_Meeting;
use Google_Service_Calendar_EventOrganizer;

class GoogleMeetService
{
    private $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Google Meet Integration');
        // $this->client->setScopes(Google_Service_Calendar::CALENDAR);
        $this->client->addScope([\Google_Service_Calendar::CALENDAR, \Google_Service_Calendar::CALENDAR_EVENTS]);

        $this->client->setAuthConfig(config_path('google_api_credentials.json'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setSubject('hello@arabicreators.com');
    }

    public function getClient()
    {
        return $this->client;
    }
    public function authenticate()
    {
        $this->client->authenticate($_GET['code']);
        $accessToken = $this->client->getAccessToken();
        $this->client->setAccessToken($accessToken);
    }
    public function createMeet($summary, $description, $startTime, $endTime,$emails)
    {
        // dd($startTime,$endTime);
        $calendarId = env('GOOGLE_CALENDAR_ID');

        $calendarService = new Google_Service_Calendar($this->client);
        $attendees = [
            [
                'email' => 'islamshu12@gmail.com',
                'responseStatus' => 'accepted'
            ],
        ];

        $event = new Google_Service_Calendar_Event([
            'summary' => $summary,
            'location' => 'Online',
            'description' => $description,
            'start' => [
                'dateTime' => $startTime,
                'timeZone' =>  'Asia/Riyadh',
            ],
            'end' => [
                'dateTime' =>  $endTime,
                'timeZone' =>  'Asia/Riyadh',
            ],
            'attendees' => [
                [
                    'email' => 'islamshu12@gmail.com',
                    'self' => true,
                ],
                [
                    'email' => 'islamshublaq@hotmail.com',
                    'self' => true,
                ],
            ],




            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet'
                    ],
                    'requestId' => 'randomString123'
                ]
            ],

            // 'attendees' => $attendees,
            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 10],
                ],
            ],
        ]);
        $newOwnerEmail = "islamshublaq@hotmail.com";

        $organizer = new Google_Service_Calendar_EventOrganizer();
        $organizer->setEmail($newOwnerEmail);
        $organizer->setDisplayName('New Owner');
        $event->setOrganizer($organizer);
        // dd($event,$calendarId);
        $event = $calendarService->events->insert($calendarId, $event);

        $conference = new \Google_Service_Calendar_ConferenceData();
        $conferenceRequest = new \Google_Service_Calendar_CreateConferenceRequest();
        $conferenceRequest->setRequestId('randomString123');
        $conference->setCreateRequest($conferenceRequest);
        $event->setConferenceData($conference);


        $optParams = ['conferenceDataVersion' => 1];

        $calendarId = env('GOOGLE_CALENDAR_ID');
        $event = $calendarService->events->patch($calendarId, $event->id, $event, ['conferenceDataVersion' => 1]);
        $eventId =  $event->id;
        $event = $calendarService->events->get($calendarId, $eventId);
        

        // Update the meeting details
        $calendarService->events->update($calendarId, $eventId, $event);
        
        return $event;
    }
    public function delete($event_id){
    

        $calendarId = env('GOOGLE_CALENDAR_ID');

        $calendarService = new Google_Service_Calendar($this->client);
        $event = $calendarService->events->delete($calendarId, $event_id);
    }
}


    // public function list(){
    //     $calendarId = env('GOOGLE_CALENDAR_ID');
    //     // $now =  now()->addDay();
    //     $now = new \DateTime();

    //     $optParams = array(
    //         'maxResults' => 1000, // Limit the number of results returned
    //         'orderBy' => 'startTime', // Sort events by start time
    //         'singleEvents' => true, // Treat recurring events as separate instances
    //         'timeMin' => $now->format(\DateTime::RFC3339), // Only return events starting from now
    //     );     
    //     // dd($optParams);
    //     $calendarService = new Google_Service_Calendar($this->client);
    //     $events = $calendarService->events->listEvents($calendarId, $optParams);
    //     foreach ($events->getItems() as $key =>$event) {
    //         // Process each event...
         
    //         echo $event->getSummary() . '<br>';
    //     }
    // }

