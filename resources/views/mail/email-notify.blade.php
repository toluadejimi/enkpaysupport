<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template.">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f1f0ff;" leftmargin="0">
<!-- 100% body table -->
<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
       style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
    <tr>
        <td>
            <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto; " width="100%" border="0"
                   align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="{{env('APP_URL')}}" title="logo" target="_blank">
                            <img src="{{getFileUrl(getGeneralSetting('app_logo'))}}"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                               style="max-width:670px; background:#fff; border-radius:8px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="padding:0 35px;">
                                    {!! getEmailTemplate($templeate, 'body', '', $ticketData, $userData) !!}
                                    <br>
                                    @if($templeate != 'email-verification')
                                        @if($userData->role == USER_ROLE_CUSTOMER)
                                            <a href="{{env('APP_URL').'/ticket/ticket-view/'.encrypt($ticketData->id)}}"
                                               style="background:#6659FF;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px; display:inline-block; border-radius:50px;">Open
                                                Your Ticket</a>
                                        @elseif($userData->role == USER_ROLE_AGENT)
                                            <a href="{{env('APP_URL').'/agent/ticket/view-ticket/'.$ticketData->id}}"
                                               style="background:#6659FF;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px; display:inline-block; border-radius:50px;">Open
                                                Your Ticket</a>
                                        @else
                                            <a href="{{env('APP_URL').'/admin/ticket/view-ticket/'.$ticketData->id}}"
                                               style="background:#6659FF;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px; display:inline-block; border-radius:50px;">Open
                                                Your Ticket</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        @if(getGeneralSetting('app_copyright') !=null)
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0; text-align: center;">
                                <strong>{{getGeneralSetting('app_copyright')}}</strong></p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--/100% body table-->
</body>

</html>
