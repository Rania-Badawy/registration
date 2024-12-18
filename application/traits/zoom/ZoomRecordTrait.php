<?php
require_once APPPATH . '/traits/VistorTrait.php';

trait ZoomRecordTrait {
    use VistorTrait;

    protected $baseUrl = 'https://api.zoom.us/v2';
    protected $token  ;
    public function getMeetingRecordings($meetingId ,$token) {
        $this->token = $token;
        $meetingInfo = $this->getMeetingInfo($meetingId ,$token);
        if (!$meetingInfo) {
            return [];
        }

        $userEmail = $meetingInfo['host_email'];
        $meetingStartTime = $meetingInfo['start_time'];
        $meetingduration = $meetingInfo['duration']+2;

       
        $mettingId = $meetingInfo['uuid'];
        $startTimeStamp = strtotime($meetingStartTime);
        $endTimeStamp = $startTimeStamp + $meetingduration*60; 

    // Convert both timestamps back to the Y-m-d format for the Zoom API call
        $fromDate = date('Y-m-d', $startTimeStamp);
        $toDate = date('Y-m-d', $endTimeStamp);
        $userMeeting = $this->getUserRecordings($userEmail, $fromDate,$toDate,$meetingId);
        $userRecordings = $this->getUserRecords($userMeeting['recording_files']);
         $filteredRecordings = $this->filterRecordingsByMeetingTime($userRecordings, $startTimeStamp,$endTimeStamp, $meetingInfo['uuid']);
        // Assuming GetToken() retrieves a valid token for API usage
        return $filteredRecordings;
    }

    private function getMeetingInfo($meetingId ,$token) {
        $url = "{$this->baseUrl}/meetings/{$meetingId}";
        // Assuming getAPIData makes a correct API call and returns data
        $meetingInfo = $this->getAPIData($url ,$token);
        return $meetingInfo;
    }

    private function getUserRecordings($userEmail, $fromDate ,$toDate,$meetingId) {
       
        // $url = "{$this->baseUrl}/users/{$userEmail}/recordings?from={$fromDate}&to={$fromDate}";
        $url = "{$this->baseUrl}/meetings/{$meetingId}/recordings";
        // Assuming getAPIData makes a correct API call and returns data
        $recordings = $this->getAPIData($url,$this->token);
        return $recordings;
    }
    private function filterRecordingsByMeetingTime($recordings, $fromDate,$toDate ,$mettingId) {
        $filteredRecordings = [];
        $videoFormats = ['MP4', 'MOV', 'AVI']; 

    foreach ($recordings as $recording) {
        $recordMettingId = $recording['meeting_id'];
         // $recordingStartTimeStamp = strtotime($recording['recording_start']);
        // $recordingEndTimeStamp = strtotime($recording['recording_end']);
        // $fromTimeStamp = $fromDate;
        // $toTimeStamp = $toDate;
        $recordingStartTimeStamp = date('Y-m-d', strtotime($recording['recording_start']));
        $recordingEndTimeStamp   = date('Y-m-d', strtotime($recording['recording_end']));
        $fromTimeStamp           = date('Y-m-d', strtotime($fromDate));
        $toTimeStamp             = date('Y-m-d', strtotime($toDate));
     
        if (($recordingStartTimeStamp = $fromTimeStamp && $recordingEndTimeStamp = $toTimeStamp) or $recordMettingId == $mettingId) {
                if (in_array($recording['file_type'], $videoFormats)) {
                    $filteredRecordings[] = $recording;
                }
            
        }
    }

    return $filteredRecordings;
    }
    private function getUserRecords($zoomRecordings){
        $recordings = [];

        // foreach ($zoomRecordings as $key => $record) {

            foreach ($zoomRecordings as $key => $record) {
                $recordings[] = $record;
            }
        // }
        return $recordings;
    }
    // Assuming getAPIData is defined elsewhere in the traits or base class
}
