<div class="email-wrapper" style="font-family: Calibri, Arial, sans-serif; padding: 20px; max-width: 600px; margin: 2rem auto; border-radius: 10px;">
    <div class="email-item email-announcer" style="background-color: #1DA1F2; color: #ffffff; padding: 15px; text-align: center; border-radius: 5px;">
        <h2 style="margin: 0; font-size: 24px;">You received an email</h2>
    </div>
    <div class="email-item email-object-item email-sender-name" style="background-color: #ffffff; margin: 10px 0; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <span style="font-weight: 900; font-size: 1.2rem;">Name :</span>
        <p style="margin: 0; font-size: 1.2rem; color: #333333;">{{ $name }}</p>
    </div>
    <div class="email-item email-object-item email-sender-email" style="background-color: #ffffff; margin: 10px 0; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <span style="font-weight: 900; font-size: 1.2rem;">Email :</span>
        <p style="margin: 0; font-size: 1.2rem; color: #333333;">{{ $email }}</p>
    </div>
    <div class="email-item email-object-item email-body" style="background-color: #ffffff; margin: 10px 0; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <span style="font-weight: 900; font-size: 1.2rem;">Message :</span><br/>
        <p style="margin-top: 10px; line-height: 1.6; white-space: pre-line; font-size: 1.2rem; color: #333333;">{{ $body }}</p>
    </div>
</div>
