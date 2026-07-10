<!doctype html>
<html lang="en" >
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>We've Received Your Message!</title>
<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->
<style>
  /* ---------- Client resets ---------- */
  body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
  table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
  img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; display:block; }
  body { margin:0; padding:0; width:100% !important; height:100% !important; }

  /* ---------- Mobile styles ---------- */
  @media only screen and (max-width:600px) {
    .email-container { width:100% !important; max-width:100% !important; }
    .fluid-padding { padding-left:20px !important; padding-right:20px !important; }
    .cta-button { width:100% !important; }
    .cta-button a { display:block !important; width:100% !important; box-sizing:border-box !important; }
    .stack-col { display:block !important; width:100% !important; }
    .detail-label { width:100% !important; display:block !important; padding-bottom:2px !important; }
    .detail-value { width:100% !important; display:block !important; padding-left:0 !important; padding-bottom:14px !important; }
    h1.headline { font-size:22px !important; line-height:28px !important; }
  }

  @media (prefers-color-scheme: dark) {
    .email-bg { background-color:#F7F3E9 !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#EFEAD9; font-family:Arial, Helvetica, sans-serif;">

  <!-- ============ PREHEADER (hidden inbox preview text) ============ -->
  <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#EFEAD9;">
    Thanks for reaching out to {{ $companyInfo->organisation_name }} — we've received your message and will reply within 2 working days.
  </div>
  <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>

  <center class="email-bg" style="width:100%; background-color:#EFEAD9;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#EFEAD9;">
      <tr>
        <td align="center" style="padding:24px 12px;">

          <!-- ================================================= -->
          <!-- EMAIL CONTAINER (600px)                            -->
          <!-- ================================================= -->
          <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px; background-color:#F7F3E9; border-radius:12px; overflow:hidden; box-shadow:0 4px 18px rgba(27,58,47,0.08);">

            <!-- =============== SECTION: HEADER =============== -->
            <tr>
              <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#1B3A2F;">
                  <tr>
                    <td align="center" style="padding:32px 24px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                       
                          <td valign="middle" style="padding-right:10px;">
                            <!--[if !mso]><!-->
                            <img src="" width="34" height="34" alt="{{$companyInfo->organisation_name}}" style="display:block; border-radius:6px; background-color:#D4AF37;">
                     
                          </td>
                          <td valign="middle">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                <td style="font-family:Georgia, 'Times New Roman', serif; font-size:20px; line-height:22px; color:#FFFFFF; letter-spacing:1px; font-weight:bold;">
                                  MERIT
                                </td>
                              </tr>
                              <tr>
                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:9px; line-height:12px; color:#D4AF37; letter-spacing:2px; text-transform:uppercase;">
                                  Education Foundation
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== GOLD ACCENT STRIP =============== -->
            <tr>
              <td style="background-color:#D4AF37; height:4px; line-height:4px; font-size:1px;">&nbsp;</td>
            </tr>

            <!-- =============== SECTION: SUCCESS HERO =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:44px 40px 8px 40px;">
                <!-- Checkmark badge -->
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="64" height="64" align="center" valign="middle" style="background-color:#E4F0E7; border-radius:50%;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td width="40" height="40" align="center" valign="middle" style="background-color:#1B3A2F; border-radius:50%; font-family:Arial, sans-serif; font-size:20px; color:#D4AF37; font-weight:bold;">
                            &#10003;
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== HEADLINE =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:18px 40px 0 40px;">
                <h1 class="headline" style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:28px; line-height:34px; color:#1B3A2F; font-weight:bold;">
                  We've Received Your <span style="color:#C9A24B; font-style:italic;">Message</span>
                </h1>
              </td>
            </tr>

            <!-- =============== SECTION: GREETING + BODY COPY =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:16px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  Hi {{$data->first_name}},
                </p>
              </td>
            </tr>
            <tr>
              <td align="center" class="fluid-padding" style="padding:10px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  Thank you for contacting <strong style="color:#1B3A2F;">{{$companyInfo->organisation_name}}</strong>. We've successfully
                  received your enquiry and our team will review it as soon as possible. We aim to respond within
                  <strong style="color:#1B3A2F;">2 working days</strong>.
                </p>
              </td>
            </tr>

            <!-- =============== SECTION: SUBMITTED DETAILS CARD =============== -->
            <tr>
              <td class="fluid-padding" style="padding:32px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; border:1px solid #E5DEC8; border-radius:10px;">
                  <tr>
                    <td style="padding:22px 24px 8px 24px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td style="border-top:2px solid #D4AF37; width:22px; font-size:1px; line-height:1px;">&nbsp;</td>
                        </tr>
                      </table>
                      <p style="margin:10px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:10px; letter-spacing:1.5px; color:#B8933B; text-transform:uppercase; font-weight:bold;">
                        Your Submitted Details
                      </p>
                    </td>
                  </tr>

                  <!-- Name -->
                  <tr>
                    <td style="padding:12px 24px 0 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td class="detail-label" width="110" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#8A8D82; font-weight:bold;">Name</td>
                          <td class="detail-value" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1B3A2F;">{{$data->first_name}} {{$data->last_name}}</td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr><td style="padding:12px 24px 0 24px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-top:1px solid #F0EBDA; font-size:1px; line-height:1px;">&nbsp;</td></tr></table></td></tr>

                  <!-- Email -->
                  <tr>
                    <td style="padding:12px 24px 0 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td class="detail-label" width="110" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#8A8D82; font-weight:bold;">Email</td>
                          <td class="detail-value" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1B3A2F;">
                            <a href="mailto:{{$data->email}}" style="color:#1B6E4F; text-decoration:underline;">{{$data->email}}</a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr><td style="padding:12px 24px 0 24px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-top:1px solid #F0EBDA; font-size:1px; line-height:1px;">&nbsp;</td></tr></table></td></tr>

                  <!-- Phone -->
                  <tr>
                    <td style="padding:12px 24px 0 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td class="detail-label" width="110" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#8A8D82; font-weight:bold;">Phone</td>
                          <td class="detail-value" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1B3A2F;">{{$data->phone}}</td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr><td style="padding:12px 24px 0 24px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-top:1px solid #F0EBDA; font-size:1px; line-height:1px;">&nbsp;</td></tr></table></td></tr>

                  <!-- Subject -->
                  <tr>
                    <td style="padding:12px 24px 0 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td class="detail-label" width="110" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#8A8D82; font-weight:bold;">Subject</td>
                          <td class="detail-value" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1B3A2F;">{{$data->enquiry_type}}</td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr><td style="padding:12px 24px 0 24px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-top:1px solid #F0EBDA; font-size:1px; line-height:1px;">&nbsp;</td></tr></table></td></tr>

                  <!-- Message -->
                  <tr>
                    <td style="padding:14px 24px 22px 24px;">
                      <p style="margin:0 0 8px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#8A8D82; font-weight:bold;">Message</p>
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F7F3E9; border-radius:6px;">
                        <tr>
                          <td style="padding:14px 16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:21px; color:#4A4E44;">
                            {{	$data->message}}
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== NOTE: REPLY TO ADD INFO =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:24px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#6B6E63; text-align:center; font-style:italic;">
                  If you need to provide additional information, simply reply to this email.
                </p>
              </td>
            </tr>

            <!-- =============== SECTION: PRIMARY CTA =============== -->
            <tr>
              <td align="center" style="padding:32px 40px 8px 40px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" class="cta-button">
                  <tr>
                    <td align="center" style="border-radius:30px; background-color:#1B3A2F;">
                   
                      <a href="{{ url('/') }}" target="_blank" style="display:inline-block; padding:16px 44px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#FFFFFF; text-decoration:none; border-radius:30px; letter-spacing:0.3px;">
                        Visit Our Website &nbsp;&rarr;
                      </a>
                      <!--<![endif]-->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== SECTION: SECONDARY CTA (text link) =============== -->
            <tr>
              <td align="center" style="padding:12px 40px 8px 40px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
                  <a href="mailto:{{$companyInfo->email}}" style="color:#1B6E4F; text-decoration:underline; font-weight:bold;">Contact Us Again</a>
                </p>
              </td>
            </tr>

            <!-- =============== DIVIDER =============== -->
            <tr>
              <td style="padding:28px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr><td style="border-top:1px solid #E1DAC4; font-size:1px; line-height:1px;">&nbsp;</td></tr>
                </table>
              </td>
            </tr>

            <!-- =============== SECTION: SIGN-OFF =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:24px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#4A4E44; text-align:center;">
                  Thank you for choosing {{$companyInfo->organisation_name}}.
                </p>
                <p style="margin:6px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#4A4E44; text-align:center;">
                  Best regards,<br>
                  <strong style="color:#1B3A2F;">{{$companyInfo->organisation_name}} Team</strong>
                </p>
              </td>
            </tr>

            <!-- =============== SECTION: SAFEGUARDING / TRUST BANNER =============== -->
            <tr>
              <td align="center" style="padding:28px 40px 40px 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#1B3A2F; border-radius:10px;">
                  <tr>
                    <td align="center" style="padding:22px 24px;">
                      <p style="margin:0 0 4px 0; font-family:Arial, Helvetica, sans-serif; font-size:10px; letter-spacing:1.5px; color:#D4AF37; text-transform:uppercase; font-weight:bold;">
                        Safeguarding Commitment
                      </p>
                      <p style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:15px; line-height:22px; color:#FFFFFF;">
                        Your Child's Safety is Our <span style="color:#D4AF37; font-style:italic;">Top Priority</span>
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== SECTION: FOOTER =============== -->
            <tr>
              <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#14302A;">
                  <tr>
                    <td align="center" style="padding:32px 24px 8px 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:480px;">

                        <!-- Company name -->
                        <tr>
                          <td align="center" style="font-family:Georgia, 'Times New Roman', serif; font-size:16px; color:#FFFFFF; font-weight:bold; padding-bottom:4px;">
                           {{$companyInfo->organisation_name}}
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:Georgia, 'Times New Roman', serif; font-size:13px; color:#FFFFFF; font-style:italic; padding-bottom:14px;">
                            "Education for All, Opportunity for Every Child"
                          </td>
                        </tr>

                        <!-- Website / support email / phone -->
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:22px; color:#A9BDB2; padding-bottom:6px;">
                            <a href="{{url('/')}}" style="color:#D4AF37; text-decoration:none;">{{url('/')}}</a><br>
                            <a href="mailto:{{$companyInfo->email}}" style="color:#D4AF37; text-decoration:none;">{{$companyInfo->email}}</a><br>
                            <a href="tel:{{$companyInfo->phone}}" style="color:#A9BDB2; text-decoration:none;">{{$companyInfo->phone}}</a>
                          </td>
                        </tr>

                        <!-- Social icons -->
                        <tr>
                          <td align="center" style="padding:14px 0 16px 0;">
                            <a href="{{ $social->facebook }}" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Facebook</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="{{ $social->instagram }}" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Instagram</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="{{ $social->twitter }}" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Twitter</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="{{ $social->linkedin }}" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">LinkedIn</a>
                          </td>
                        </tr>

                        <!-- Legal links -->
                        <tr>
                          <td align="center" style="padding:0 0 6px 0;">
                            <a href="{{ url('/privacy-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Privacy Policy</a>
                            <a href="{{ url('/terms-and-conditions') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Terms &amp; Conditions</a>
                            <a href="{{ url('/safeguarding-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Safeguarding Policy</a>
                          </td>
                        </tr>

                        <!-- Copyright -->
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#5E756A; padding-top:12px;">
                            &copy; {{ now()->year }} {{$companyInfo->organisation_name}}. All Rights Reserved.
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          </table>
          <!-- ============ END EMAIL CONTAINER ============ -->

          <!-- Email-client footnote -->
          <table role="presentation" width="600" class="email-container" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td align="center" style="padding:18px 24px; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:16px; color:#9B9C8F;">
                This is an automated confirmation from {{$companyInfo->organisation_name}} in response to a Contact Us submission.
                Simply reply to this email if anything above needs correcting.
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </center>

</body>
</html>
