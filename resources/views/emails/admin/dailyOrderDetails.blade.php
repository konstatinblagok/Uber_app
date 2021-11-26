<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Admin Order Details</title>
    <meta name="description" content="Admin Order Details">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="{{ route('index') }}" title="logo" target="_blank">
                              <img width="120" height="120" src="{{ asset('public/site-asset/images/logo.webp') }}" title="logo" alt="logo">
                            </a>
                          </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 35px 35px 0px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                                        <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Total Orders ({{ count($orderObject) }}) </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> Order details regarding cook and customer are given below.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="10%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Delivery Number</td>
                                                <td width="20%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Cook Name</td>
                                                <td width="20%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Phone number of the cook</td>
                                                <td width="30%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Address of the cook</td>
                                                <td width="20%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Food Name + Portions</td>
                                            </tr>
                                            @forelse ($orderObject as $obj)
                                                <tr>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $loop->iteration }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->meal->user->name }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->meal->user->country_code.' '.$obj->meal->user->phone }} </td>
                                                    <td width="30%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ isset($obj->meal->cookBillingInfo) && isset($obj->meal->cookBillingInfo->address) ? $obj->meal->cookBillingInfo->address : 'Not Found!' }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->meal->title.' + '.$obj->quantity }} </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="30%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                </tr>
                                            @endforelse
                                            
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <hr>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 15px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">

                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="15%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Delivery Number</td>
                                                <td width="15%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Delivery Time</td>
                                                <td width="15%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Name of customer</td>
                                                <td width="25%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Address of customer</td>
                                                <td width="15%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Phone number of customer</td>
                                                <td width="15%" text-align="center" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">Food Name + Portions</td>
                                            </tr>
                                            @forelse ($orderObject as $obj)
                                                <tr>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $loop->iteration }} </td>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ date('H:i', strtotime($obj->delivery_time)) }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->user->name }} </td>
                                                    <td width="30%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ isset($obj->billingInfo) && isset($obj->billingInfo->address) ? $obj->billingInfo->address : 'Not Found!' }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->user->country_code.' '.$obj->user->phone }} </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ $obj->meal->title.' + '.$obj->quantity }} </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="10%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="30%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                    <td width="20%" text-align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; color: #333333; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> --- </td>
                                                </tr>
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <hr>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="height:30px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:40px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>