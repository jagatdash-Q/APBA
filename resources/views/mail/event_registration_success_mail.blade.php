<!DOCTYPE HTML>
<html style="background-color: #ebebeb;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body
    style="font-family: Calibri,sans-serif; margin: 0; padding: 0; text-align: left; color: #333333; background: #f5f5f5; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table"
        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0 auto; background-color: #ebebeb; font-size: 12px;">
        <tbody>
            <tr style="font-family: 'Poppins', sans-serif;">
                <td valign="top" class="container-td" align="center"
                    style="padding-top: 40px !important; font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 0; margin: 0; width: 100%;">
                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="container-table"
                        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0 auto; width: 630px;">
                        <tbody>
                            <tr style="font-family: 'Poppins', sans-serif;">
                                <td
                                    style="font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 0; margin: 0;">
                                    <table cellpadding="0" cellspacing="0" border="0" class="logo-container"
                                        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0; width: 100%;">
                                        <tbody>
                                            <tr style="font-family: 'Poppins', sans-serif;">
                                                <td
                                                    style="text-align: center; padding: 15px 0 10px 0; background: #fff; font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; margin: 0;">
                                                    <img style="width: 200px;height: auto; -ms-interpolation-mode: bicubic;margin-top: 15px;margin-bottom: 15px;"
                                                        src="{{ url('/') }}/assets/frontend/images/logo.png"
                                                        alt="APBA Logo" border="0">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="font-family: 'Poppins', sans-serif;">
                                <td valign="top" class="top-content"
                                    style="border: 0px solid #ebebeb; font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 5px; margin: 0; background: #FFF;">
                                    <table cellpadding="0" cellspacing="0" border="0"
                                        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0; width: 100%; font-size: 14px;">
                                        <tbody>
                                            <tr style="font-family: 'Poppins', sans-serif;">
                                                <td
                                                    style="font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 0; margin: 0;">
                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0;">
                                                        <tbody>
                                                            <tr style="font-family: 'Poppins', sans-serif;">
                                                                <td class="action-content"
                                                                    style="font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 10px 20px; margin: 0;">
                                                                    <h1
                                                                        style="color:#005599; font-size: 18px; font-family: 'Poppins', sans-serif !important; font-weight: bold; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">
                                                                        Dear {{ $details['name'] }},</h1>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        We are happy to inform you that your upcoming event 
                                                                        <b>"{{ $details['event_name'] }}"</b> registration payment has
                                                                        been
                                                                        successfully processed. Your participation is
                                                                        now confirmed.
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Event Details:</b>
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Event Name:</b> {{ $details['event_name'] }}
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Date:</b> {{ $details['event_start_date'] }} -
                                                                        {{ $details['event_end_date'] }}
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Venue:</b> {{ $details['event_venue'] }}
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Here’s your booking details:</b>
                                                                    </p>
                                                                    <center>
                                                                        @if (count($details['event_program']))
                                                                            @foreach ($details['event_program'] as $event_program)
                                                                                <table
                                                                                    style="width:100%;border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Workshop Name: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            {{ isset($event_program['getWorkshopDetails']['workshop_name']) ? $event_program['getWorkshopDetails']['workshop_name'] : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Program Name: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            Room
                                                                                            {{ isset($event_program['getProgramDetails']['program_name]']) ? $event_program['getProgramDetails']['program_name'] : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Date: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            {{ isset($event_program['getProgramDetails']['program_date']) ? Carbon\Carbon::parse($event_program['getProgramDetails']['program_date'])->format('d F Y') : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Room: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            {{ isset($event_program['getProgramDetails']['room_no']) ? $event_program['getProgramDetails']['room_no'] : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Workshop: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            {{ isset($event_program['getProgramDetails']['workshop_number']) ? $event_program['getProgramDetails']['workshop_number'] : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Time: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            {{ isset($event_program['getProgramDetails']['start_time']) ? Carbon\Carbon::parse($event_program['getProgramDetails']['start_time'])->format('h:i a') : '' }}
                                                                                            -
                                                                                            {{ isset($event_program['getProgramDetails']['end_time']) ? Carbon\Carbon::parse($event_program['getProgramDetails']['end_time'])->format('h:i a') : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            <b>Price: </b>
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: 1px solid #4a4a4a;border-collapse: collapse;">
                                                                                            @if ($details['customer_id'] == null)
                                                                                                {{ isset($event_program['getProgramDetails']['price_guest']) ? 'S$ ' . $event_program['getProgramDetails']['price_guest'] : '' }}
                                                                                            @else
                                                                                                {{ isset($event_program['getProgramDetails']['price_member']) ? 'S$ ' . $event_program['getProgramDetails']['price_member'] : '' }}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <br>
                                                                            @endforeach
                                                                        @endif
                                                                    </center>
                                                                    @if (count($details['event_program_optional']))
                                                                        @foreach ($details['event_program_optional'] as $optional)
                                                                            <p
                                                                                style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                                {{ $optional['getOptionalDetails']['activity_optional_name'] }}:
                                                                                <b>S$
                                                                                    @if ($details['customer_id'] == null)
                                                                                        {{ $optional['getOptionalDetails']['price_guest'] }}
                                                                                    @else
                                                                                        {{ $optional['getOptionalDetails']['price_member'] }}
                                                                                    @endif
                                                                                </b>
                                                                            </p>
                                                                        @endforeach
                                                                    @endif
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Total Amount: S$
                                                                            {{ $details['total_amount'] }}</b>
                                                                    </p>

                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        If you have any questions or require further
                                                                        assistance, please do not hesitate to contact
                                                                        our support team.
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        Thank you for choosing to be a part of this
                                                                        event. We look forward to seeing you and making
                                                                        this event a memorable experience for you.
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        Best regards,</p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        Team APBA.</p>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="container-table"
                        style="font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0 auto; width: 630px;">
                        <tbody>
                            <tr style="font-family: 'Poppins', sans-serif;">
                                <td
                                    style="font-family: Calibri,sans-serif; border-collapse: collapse; vertical-align: top; padding: 0; margin: 0;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0" align="center"
                        class="container-table copyrights"
                        style="width: 630px; margin-bottom: 12px; border-collapse: collapse font-family: 'Poppins', sans-serif !important; font-family: Calibri,sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0; margin: 0 auto; text-align: center; color: #333333;">
                        <tbody>
                            <tr style="font-family: 'Poppins', sans-serif;">
                                <td
                                    style="font-family: 'Poppins', sans-serif !important; border-collapse: collapse; vertical-align: top; padding: 8px 5px!important; margin: 0;">
                                    You're recieving this email because you signed up with APBA.</td>
                            </tr>
                            <tr style="font-family: 'Poppins', sans-serif;">
                                <td
                                    style="font-family: 'Poppins', sans-serif !important; border-collapse: collapse; vertical-align: top; padding: 8px 5px!important; margin: 0;">
                                    © APBA. All rights reserved <?php echo date('Y'); ?>.</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
