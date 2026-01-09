<?php

namespace App\Exports;

use App\Models\EventRegistration;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportEventRegDetails implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $event_id;
    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }
    public function collection()
    {
        $temp_data = [];
        $event_reg = EventRegistration::with(['getEventDetails', 'getEventProgram', 'getEventRegistrationOptional'])->where('event_id', $this->event_id)->where('payment_status', 'success')->get();
        if (count($event_reg)) {
            $count = 1;
            foreach ($event_reg as $value) {
                $temp_sub_program = [];
                if (isset($value->getEventProgram)) {
                    if (count($value->getEventProgram)) {
                        $count_sub_program = 1;
                        foreach ($value->getEventProgram as $event_program) {
                            $program_name = null;
                            $program_name .= $count_sub_program . '. ' . $event_program->getProgramDetails->program_name . '(S$ ';
                            if ($value->customer_id == null)
                                $program_name .= $event_program->getProgramDetails->price_guest;
                            else
                                $program_name .= $event_program->getProgramDetails->price_member;

                            $program_name .= ')';
                            $temp_sub_program[] = $program_name;
                            $count_sub_program++;
                        }
                    }
                }
                $temp_optional = [];
                if (isset($value->getEventRegistrationOptional)) {
                    if (count($value->getEventRegistrationOptional)) {
                        $count_optional = 1;
                        foreach ($value->getEventRegistrationOptional as $optional) {
                            $event_optional = null;
                            $event_optional .= $count_optional . '. ' . $optional->getOptionalDetails->activity_optional_name . '(S$ ';
                            if ($value->customer_id == null)
                                $event_optional .= $optional->getOptionalDetails->price_guest;
                            else
                                $event_optional .= $optional->getOptionalDetails->price_member;

                            $event_optional .= ')';
                            $temp_optional[] = $event_optional;
                            $count_optional++;
                        }
                    }
                }
                $temp_data[] = [$count, $value->first_name, $value->last_name, $value->email, $value->contact_number, Carbon::parse($value->created_at)->format('d F Y h:i a'), $value->getEventDetails->event_name, Carbon::parse($value->getEventDetails->start_date)->format('d F Y') . ' - ' . Carbon::parse($value->getEventDetails->end_date)->format('d F Y'), $value->getEventDetails->event_location, implode(" ", $temp_sub_program), implode(" ", $temp_optional), 'S$ ' . $value->total_amount];
                $count++;
            }
        }
        return collect($temp_data);
    }
    public function headings(): array
    {
        return ['Sl.No.', 'First Name', 'Last Name', 'Email Id', 'Contact Number', 'Registration Date & Time', 'Event Name', 'Event Date', 'Location', 'Registration for sub-activities', 'Other Services', 'Total Amount'];
    }
}
