<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Welcome to {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }}</title>
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
  /* Client resets */
  body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
  table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
  img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
  body { margin:0; padding:0; width:100% !important; height:100% !important; }

  /* Mobile styles */
  @media only screen and (max-width:600px) {
    .email-container { width:100% !important; max-width:100% !important; }
    .fluid-padding { padding-left:20px !important; padding-right:20px !important; }
    .stack-col { display:block !important; width:100% !important; }
    .mobile-center { text-align:center !important; }
    .cta-button { width:100% !important; }
    .cta-button a { display:block !important; width:100% !important; box-sizing:border-box !important; }
    h1.headline { font-size:22px !important; line-height:28px !important; }
  }

  /* Dark mode friendliness (supported clients only) */
  @media (prefers-color-scheme: dark) {
    .email-bg { background-color:#F7F3E9 !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#EFEAD9; font-family:Arial, Helvetica, sans-serif;">

  <!-- Preheader (hidden preview text) -->
  <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#EFEAD9;">
    Welcome to {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} — please verify your account to get started. This link expires soon, so don't wait.
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

            <!-- =============== HERO / BADGE =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:40px 40px 8px 40px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="center" style="background-color:#EFE6C9; border-radius:20px; padding:6px 16px; font-family:Arial, Helvetica, sans-serif; font-size:11px; letter-spacing:1px; color:#8A6D1B; text-transform:uppercase; font-weight:bold;">
                      &#10003; Account Registration
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- =============== HEADLINE =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:18px 40px 0 40px;">
                <h1 class="headline" style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:28px; line-height:34px; color:#1B3A2F; font-weight:bold;">
                  Welcome to {{$companyInfo ? $companyInfo->organisation_name : 'the website'}}, <span style="color:#C9A24B; font-style:italic;">{{ $user->name }}</span>
                </h1>
              </td>
            </tr>

            <!-- =============== BODY COPY =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:16px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  We're delighted you've joined our community. {{$companyInfo ? $companyInfo->organisation_name : 'the website'}} connects your child with qualified,
                  DBS-checked tutors for 1-to-1 online Quran learning — and every step you take with us helps fund
                  a free place for a child who cannot afford one.
                </p>
              </td>
            </tr>
            <tr>
              <td align="center" class="fluid-padding" style="padding:12px 48px 0 48px;">
                <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:24px; color:#4A4E44; text-align:center;">
                  To activate your account and start booking lessons, please verify your email address below.
                </p>
              </td>
            </tr>

            <!-- =============== CTA BUTTON =============== -->
            <tr>
              <td align="center" style="padding:32px 40px 8px 40px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" class="cta-button">
                  <tr>
                    <td align="center" style="border-radius:30px; background-color:#1B3A2F;">
                     
                      <a href="{{ url('/register-verify-email?code=' . $user->code . '&email=' . urlencode($user->email)) }}" target="_blank" style="display:inline-block; padding:16px 40px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#FFFFFF; text-decoration:none; border-radius:30px; letter-spacing:0.3px;">
                        Verify My Account &nbsp;&rarr;
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
                  <a href="{{ url('/register-verify-email?code=' . $user->code . '&email=' . urlencode($user->email)) }}" style="color:#1B6E4F; text-decoration:underline;">{{ url('/register-verify-email?code=' . $user->code . '&email=' . urlencode($user->email)) }}</a>
                </p>
              </td>
            </tr>

            <!-- =============== EXPIRY NOTICE =============== -->
            <tr>
              <td align="center" style="padding:28px 40px 0 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FBF3DC; border-left:4px solid #D4AF37; border-radius:6px;">
                  <tr>
                    <td style="padding:14px 18px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:19px; color:#6B551A;">
                      <strong>&#9201; This link expires in 24 hours.</strong> If it expires, simply return to
                      {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }} and request a new verification email.
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

            <!-- =============== WHAT'S NEXT =============== -->
            <tr>
              <td align="center" class="fluid-padding" style="padding:28px 40px 0 40px;">
                <p style="margin:0 0 4px 0; font-family:Arial, Helvetica, sans-serif; font-size:11px; letter-spacing:1.5px; color:#B8933B; text-transform:uppercase; font-weight:bold;">
                  What Happens Next
                </p>
                <h2 style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:19px; color:#1B3A2F;">
                  Getting Started Is Easy
                </h2>
              </td>
            </tr>
            <tr>
              <td class="fluid-padding" style="padding:20px 40px 8px 40px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="40" valign="top" style="padding-bottom:16px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr><td width="26" height="26" align="center" valign="middle" style="background-color:#EFE6C9; border-radius:50%; font-family:Georgia, serif; font-size:12px; color:#8A6D1B; font-weight:bold;">1</td></tr>
                      </table>
                    </td>
                    <td valign="top" style="padding-bottom:16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      <strong style="color:#1B3A2F;">Verify your email</strong> using the button above.
                    </td>
                  </tr>
                  <tr>
                    <td width="40" valign="top" style="padding-bottom:16px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr><td width="26" height="26" align="center" valign="middle" style="background-color:#EFE6C9; border-radius:50%; font-family:Georgia, serif; font-size:12px; color:#8A6D1B; font-weight:bold;">2</td></tr>
                      </table>
                    </td>
                    <td valign="top" style="padding-bottom:16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      <strong style="color:#1B3A2F;">Book a free trial lesson</strong> with a qualified, DBS-checked tutor.
                    </td>
                  </tr>
                  <tr>
                    <td width="40" valign="top">
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr><td width="26" height="26" align="center" valign="middle" style="background-color:#EFE6C9; border-radius:50%; font-family:Georgia, serif; font-size:12px; color:#8A6D1B; font-weight:bold;">3</td></tr>
                      </table>
                    </td>
                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#4A4E44;">
                      <strong style="color:#1B3A2F;">Begin learning</strong> and watch your child's confidence grow.
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
                  Questions about your account? Our team is happy to help at
                  <a href="mailto:{{ $companyInfo ? $companyInfo->primary_email : 'support@meriteducation.com' }}" style="color:#1B6E4F; text-decoration:underline;">{{ $companyInfo ? $companyInfo->support_email : 'support@meriteducation.com' }}</a>
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
                            <a href="mailto:{{ $companyInfo ? $companyInfo->primary_email : 'support@meriteducation.com' }}" style="color:#D4AF37; text-decoration:underline;">{{ $companyInfo ? $companyInfo->primary_email : 'support@meriteducation.com' }}</a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="padding:14px 0 6px 0;">
                            <a href="{{ url('/privacy-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Privacy Policy</a>
                            <a href="{{ url('/terms-conditions') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Terms &amp; Conditions</a>
                            <a href="{{ url('/safeguarding-policy') }}" style="font-family:Arial, sans-serif; font-size:10px; color:#7E9689; text-decoration:underline; margin:0 6px;">Safeguarding Policy</a>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#5E756A; padding-top:12px;">
                            &copy; {{Carbon\Carbon::now()->year}} {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }}. Registered Charity. All Rights Reserved.
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
                You're receiving this email because an account was created with this address at {{ $companyInfo ? $companyInfo->organisation_name : 'the website' }}.
                If you didn't create this account, you can safely ignore this email.
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </center>

</body>
</html>
