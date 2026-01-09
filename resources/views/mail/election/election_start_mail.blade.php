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
                                                                        We are thrilled to announce that the elections
                                                                        for our A-PBA are now officially open!</p>

                                                                    <span
                                                                        style="color:#4a4a4a; font-size: 14px; font-family: 'Poppins', sans-serif !important; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">Election
                                                                        Start Date: {{ $details['start_date'] }}
                                                                    </span><br>
                                                                    <span
                                                                        style="color:#4a4a4a; font-size: 14px; font-family: 'Poppins', sans-serif !important; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">Election
                                                                        Portal: <a href="{{ url('/') }}/election"
                                                                            target="_blank">{{ url('/') . '/election' }}</a>
                                                                    </span><br>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        We invite you to take a few moments to nominate
                                                                        deserving. Your elections play a vital role in
                                                                        high lighting the hard work and contributions of
                                                                        our fellow members.</p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        To submit your elections, please follow these
                                                                        simple steps:
                                                                    </p>
                                                                    <span
                                                                        style="color:#4a4a4a; font-size: 14px; font-family: 'Poppins', sans-serif !important; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">Visit
                                                                        the <a href="{{ url('/') }}/election"
                                                                            target="_blank">{{ url('/') . '/election' }}</a>
                                                                        using the link provided above.
                                                                    </span><br>
                                                                    <span
                                                                        style="color:#4a4a4a; font-size: 14px; font-family: 'Poppins', sans-serif !important; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">Log
                                                                        in using your member credentials.
                                                                    </span><br>
                                                                    <span
                                                                        style="color:#4a4a4a; font-size: 14px; font-family: 'Poppins', sans-serif !important; margin-bottom: 15px; margin-top: 0px; line-height: 20px;">Access
                                                                        the election form and carefully follow the
                                                                        instructions provided & fill in the required
                                                                        details.
                                                                    </span>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        We look forward to receiving your elections by
                                                                        {{ $details['end_date'] }}.
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
