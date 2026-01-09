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
                                                                        We appreciate your participation in our recent
                                                                        survey, and we are pleased to present you with
                                                                        your Certificate of Survey Completion.</p>

                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        This certifies that
                                                                        <b>{{ $details['name'] }}</b> has
                                                                        successfully completed the
                                                                        <b>{{ $details['survey_name'] }}</b>
                                                                        conducted by APBA. Your valuable insights and
                                                                        feedback contribute significantly to our ongoing
                                                                        efforts to enhance our services.
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Survey Details:</b>
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Survey Name:</b>
                                                                        {{ $details['survey_name'] }}
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        <b>Completion Date:</b>
                                                                        {{ $details['date'] }}
                                                                    </p>
                                                                    <p
                                                                        style="font-family: 'Poppins', sans-serif !important; font-size: 14px; line-height: 20px;color: #4a4a4a;">
                                                                        Thank you for taking the time to share your
                                                                        thoughts with us. If you have any further
                                                                        comments or suggestions, please feel free to
                                                                        reach out to us.
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
                                    You're recieving this email because you had participated in the event of APBA.</td>
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
