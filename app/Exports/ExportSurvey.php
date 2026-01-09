<?php

namespace App\Exports;

use App\Models\SurveyActivity;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportSurvey implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $uuid;
    public $survey_list;
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->survey_list = SurveyActivity::where('uuid', $this->uuid)->with('getEventProgram', 'getSurveyRegistration', 'getEventOptional')->first();
    }
    public function collection()
    {
        $temp_data = [];

        if ($this->survey_list != null) {
            $survey_list = $this->survey_list;
            if (count($survey_list->getSurveyRegistration) > 0) {
                foreach ($survey_list->getSurveyRegistration as $survey_report) {
                    $member_type = null;
                    $certificate_status = null;
                    if ($survey_report->type == 'Guest') {
                        $member_type = "Guest";
                    } elseif ($survey_report->type == 'Member') {
                        $member_type = "Member";
                    } elseif ($survey_report->type == 'Non Member') {
                        $member_type = "Non Member";
                    }

                    $certificate_status = $survey_report->certificate_sent == 'no' ? "No" : "Yes";

                    $temp_data[] = [
                        $survey_report->fullname, $survey_report->email, $survey_report->organization, $member_type, $survey_report->survey_url, $survey_report->content_material, $survey_report->speaker_knowledge, $survey_report->trainer_presentation, $survey_report->q_a_session, $survey_report->overall_delivery, $survey_report->conference_content, $survey_report->conference_relevant, $survey_report->future_conference, $survey_report->feedback, $certificate_status
                    ];
                }
            }

            return collect($temp_data);
        }
    }
    public function headings(): array
    {
        if ($this->survey_list != null) {
            $survey_list = $this->survey_list;
            $eventname = isset($survey_list->getEventOptional->getEvent->event_name) ? $survey_list->getEventOptional->getEvent->event_name : '';
            $programdate = isset($survey_list->getEventOptional->getEvent->start_date) ? Carbon::parse($survey_list->getEventOptional->getEvent->start_date)->format('d F Y') . ' - ' . Carbon::parse($survey_list->getEventOptional->getEvent->end_date)->format('d F Y') : '';
            $location = isset($survey_list->getEventOptional->getEvent->event_location) ? $survey_list->getEventOptional->getEvent->event_location : '';

            $title = "Event Name: ";
            if (isset($survey_list->getEventProgram->getEventDetails->event_name)) {
                $title .= $survey_list->getEventProgram->getEventDetails->event_name;
            } else {
                $title .= $eventname;
            }

            $title .= "\n Survey Name: ";
            $title .= $survey_list->name;
            $title .= "\n Date: ";
            if (isset($survey_list->getEventProgram->program_date)) {
                $title .= Carbon::parse($survey_list->getEventProgram->program_date)->format('d F Y');
            } else {
                $title .= $programdate;
            }

            $title .= "\n Location: ";
            if (isset($survey_list->getEventProgram->getEventDetails->event_location)) {
                $title .= $survey_list->getEventProgram->getEventDetails->event_location;
            } else {
                $title .= $location;
            }
        } else {
            $title = ' ';
        }

        return [
            [$title, ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            ['Salutation with Full Name', 'Email', 'Organization', 'Member Type', 'Survey Link', 'Course content and material', 'Speakers\' knowledge and competency', 'Trainer\'s presentation skill', 'Q&A session - Effectiveness', 'Overall delivery and effectiveness', 'Conference content and material', 'Is the content of the Conference/Workshop relevant to your area(s) of work? Why?', 'What other area(s) or topic(s) would you like to see being included in future Conference/Workshop?', 'Any additional comments or feedback on the Conference/Workshop or speakers?', 'Certificate Sent Status'],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:O1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:O2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells('A1:O1');
            },
        ];
    }
}
