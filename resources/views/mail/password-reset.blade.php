<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Reset Your {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} Password</title>
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
  body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
  table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
  img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
  body { margin:0; padding:0; width:100% !important; height:100% !important; }

  @media only screen and (max-width:600px) {
    .email-container { width:100% !important; max-width:100% !important; }
    .fluid-padding { padding-left:20px !important; padding-right:20px !important; }
    .cta-button { width:100% !important; }
    .cta-button a { display:block !important; width:100% !important; box-sizing:border-box !important; }
    h1.headline { font-size:22px !important; line-height:28px !important; }
  }

  @media (prefers-color-scheme: dark) {
    .email-bg { background-color:#F7F3E9 !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#EFEAD9; font-family:Arial, Helvetica, sans-serif;">

  <!-- Preheader -->
  <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#EFEAD9;">
    A request was made to reset your {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} password. This link expires soon — if this wasn't you, no action is needed.
  </div>
  <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>

  <center class="email-bg" style="width:100%; background-color:#EFEAD9;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#EFEAD9;">
      <tr>
        <td align="center" style="padding:24px 12px;">

          <!-- ============ EMAIL CONTAINER (600px) ============ -->
          <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px; background-color:#F7F3E9; border-radius:12px; overflow:hidden; box-shadow:0 4px 18px rgba(27,58,47,0.08);">

            <!-- =============== HEADER =============== -->
            <tr>
              <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#1B3A2F;">
                  <tr>
                    <td align="center" style="padding:32px 24px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td valign="middle" style="padding-right:10px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                <td width="34" height="34" align="center" valign="middle" style="background-color:#D4AF37; border-radius:6px; font-family:Georgia, 'Times New Roman', serif; font-size:16px; color:#1B3A2F; font-weight:bold;">
                                  M
                                </td>
                              </tr>
                            </table>
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

            <!-- =============== HERO / BADGE (security icon) =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:40px 40px 8px 40px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="56" height="56" align="center" valign="middle" style="background-color:#EFE6C9; border-radius:50%; font-family:Arial, sans-serif; font-size:24px; color:#8A6D1B;">
                      &#128274;
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== HEADLINE =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:16px 40px 0 40px;">
                <h1 class="headline" style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:28px; line-height:34px; color:#1B3A2F; font-weight:bold;">
                  Reset Your <span style="color:#C9A24B; font-style:italic;">Password</span>
                </h1>
              </td>
            </tr>

            <!-- =============== BODY COPY =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:16px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  Hi {{ $user->name }}, we received a request to reset the password for your {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} account.
                  For your security, this request was logged along with the time and general location it came from.
                </p>
              </td>
            </tr>
            <tr>
              <td align="center" class="fluid-padding" style="padding:12px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  Click the button below to choose a new password. If you didn't request this, you can safely
                  ignore this email — your password will remain unchanged.
                </p>
              </td>
            </tr>

            <!-- =============== CTA BUTTON =============== -->
            <tr>
              <td align="center" style="padding:32px 40px 8px 40px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" class="cta-button">
                  <tr>
                    <td align="center" style="border-radius:30px; background-color:#1B3A2F;">
                    
                      <a href="{{ url('reset-password/'.$token) }}" target="_blank" style="display:inline-block; padding:16px 40px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#FFFFFF; text-decoration:none; border-radius:30px; letter-spacing:0.3px;">
                        Reset My Password &nbsp;&rarr;
                      </a>
                      <!--<![endif]-->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== FALLBACK LINK =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:8px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#8A8D82; text-align:center;">
                  Button not working? Copy and paste this link into your browser:
                </p>
                <p style="margin:6px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; word-break:break-all;">
                  <a href="{{ url('reset-password/'.$token) }}" style="color:#1B6E4F; text-decoration:underline;">{{ url('reset-password/'.$token) }}</a>
                </p>
              </td>
            </tr>

            <!-- =============== EXPIRY NOTICE =============== -->
            <tr>
              <td align="center" style="padding:28px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FBF3DC; border-left:4px solid #D4AF37; border-radius:6px;">
                  <tr>
                    <td style="padding:14px 18px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:19px; color:#6B551A;">
                      <strong>&#9201; This link expires in 60 minutes</strong> for your security. After that,
                      you'll need to request a new password reset link.
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== "DIDN'T REQUEST THIS" WARNING =============== -->
            <tr>
              <td align="center" style="padding:16px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FDECEC; border-left:4px solid #B5484A; border-radius:6px;">
                  <tr>
                    <td style="padding:14px 18px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:19px; color:#7A2E2F;">
                      <strong>&#9888; Didn't request a password reset?</strong> No changes have been made to your
                      account. You can safely ignore this email, though we recommend contacting our support
                      team if this happens again.
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== DIVIDER =============== -->
            <tr>
              <td style="padding:32px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr><td style="border-top:1px solid #E1DAC4; font-size:1px; line-height:1px;">&nbsp;</td></tr>
                </table>
              </td>
            </tr>

            <!-- =============== SECURITY TIPS =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:28px 40px 0 40px;">
                <p style="margin:0 0 4px 0; font-family:Arial, Helvetica, sans-serif; font-size:11px; letter-spacing:1.5px; color:#B8933B; text-transform:uppercase; font-weight:bold;">
                  Keeping Your Account Safe
                </p>
                <h2 style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:19px; color:#1B3A2F;">
                  A Few Quick Tips
                </h2>
              </td>
            </tr>
            <tr>
              <td class="fluid-padding" style="padding:20px 40px 8px 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="30" valign="top" style="padding-bottom:14px; font-family:Arial, sans-serif; font-size:14px; color:#D4AF37;">&#9679;</td>
                    <td valign="top" style="padding-bottom:14px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      Choose a password you don't use anywhere else.
                    </td>
                  </tr>
                  <tr>
                    <td width="30" valign="top" style="padding-bottom:14px; font-family:Arial, sans-serif; font-size:14px; color:#D4AF37;">&#9679;</td>
                    <td valign="top" style="padding-bottom:14px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      Never share your password or reset link with anyone, including {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} staff.
                    </td>
                  </tr>
                  <tr>
                    <td width="30" valign="top" style="font-family:Arial, sans-serif; font-size:14px; color:#D4AF37;">&#9679;</td>
                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      Contact support immediately if you notice unfamiliar account activity.
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== SAFEGUARDING BANNER =============== -->
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

            <!-- =============== SUPPORT LINE =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:0 40px 36px 40px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#4A4E44; text-align:center;">
                  Concerned about your account's security? Reach our support team any time at
                  <a href="mailto:{{ $companyInfo ? $companyInfo->primary_email : 'support@website.com' }}" style="color:#1B6E4F; text-decoration:underline;">
                    {{ $companyInfo ? $companyInfo->primary_email : 'support@website.com' }}
                  </a>
                </p>
              </td>
            </tr>

            <!-- =============== FOOTER =============== -->
            <tr>
              <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#14302A;">
                  <tr>
                    <td align="center" style="padding:32px 24px 8px 24px;">
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:480px;">
                        <tr>
                          <td align="center" style="font-family:Georgia, 'Times New Roman', serif; font-size:15px; color:#FFFFFF; font-style:italic; padding-bottom:10px;">
                            "Education for All, Opportunity for Every Child"
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#A9BDB2; padding-bottom:16px;">
                            {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} is a UK-based education charity combining expert online Quran teaching
                            with a global mission to fund education for disadvantaged children.
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="padding-bottom:16px;">
                            <a href="#" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Facebook</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="#" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Instagram</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="#" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">Twitter</a>
                            <span style="color:#3E5B4F;">&bull;</span>
                            <a href="#" style="display:inline-block; margin:0 6px; font-family:Arial, sans-serif; font-size:11px; color:#D4AF37; text-decoration:none;">LinkedIn</a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:16px; color:#7E9689; padding-bottom:6px;">
                            Need help? Contact us at
                            <a href="mailto:{{ $companyInfo ? $companyInfo->primary_email : 'support@website.com' }}" style="color:#D4AF37; text-decoration:underline;">
                                {{ $companyInfo ? $companyInfo->primary_email : 'support@website.com' }}
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="padding:14px 0 6px 0;">
                            <a href="{{ url('/privacy-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Privacy Policy</a>
                            <a href="{{ url('/terms-and-conditions') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Terms &amp; Conditions</a>
                            <a href="{{ url('/safeguarding-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Safeguarding Policy</a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#5E756A; padding-top:12px;">
                            &copy; {{ Carbon\Carbon::now()->year }} {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }}. Registered Charity. All Rights Reserved.
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

          <table role="presentation" width="600" class="email-container" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td align="center" style="padding:18px 24px; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:16px; color:#9B9C8F;">
                This is an automated security email from {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }}. Please do not reply directly to this message.
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </center>

</body>
</html>
