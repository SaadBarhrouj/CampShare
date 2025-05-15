<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre avis compte - CampShare</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #4a5568; margin: 0; padding: 0; background-color: #f7fafc; }
        .email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .email-header { background-color: #166534; /* Forest Green */ color: #ffffff; padding: 25px 20px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .email-content { padding: 30px; }
        .email-content h2 { color: #166534; /* Forest Green */ margin-top: 0; font-size: 20px; }
        .email-content p { margin-bottom: 15px; font-size: 16px; }
        .button-container { text-align: center; margin-top: 20px; margin-bottom: 15px; }
        .button { background-color: #FFAA33; /* Sunlight */ color: #ffffff !important; padding: 12px 25px; text-decoration: none !important; border-radius: 5px; font-size: 16px; font-weight: bold; display: inline-block; margin: 5px 0; }
        .button:hover { background-color: #dd8e23; /* Darker Sunlight */ }
        .email-footer { background-color: #edf2f7; padding: 20px; text-align: center; font-size: 12px; color: #718096; border-top: 1px solid #e2e8f0; }
        .email-footer a { color: #166534; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>CampShare - Partagez votre expérience !</h1>
        </div>
        <div class="email-content">
            <h2>Bonjour {{ $clientName }},</h2>

            <p>Votre réservation #{{ $reservationId }} pour l'équipement <strong>"{{ $itemName }}"</strong> avec le partenaire <strong>{{ $partnerName }}</strong> s'est récemment terminée.</p>

            <p>Pour nous aider à améliorer CampShare et à guider les autres membres, nous vous serions reconnaissants de prendre quelques instants pour partager votre avis :</p>

            @if($needsObjectReview && $reviewObjectUrl)
            <div class="button-container">
                <a href="{{ $reviewObjectUrl }}" class="button">Évaluer l'équipement "{{ $itemName }}"</a>
            </div>
            @endif

            @if($needsPartnerReview && $reviewPartnerUrl)
            <div class="button-container" style="margin-top: {{ $needsObjectReview ? '10px' : '20px' }};">
                <a href="{{ $reviewPartnerUrl }}" class="button">Évaluer le partenaire {{ $partnerName }}</a>
            </div>
            @endif

            <p>Vos retours sont précieux !</p>
        </div>
        <div class="email-footer">
            Ceci est un e-mail automatique, merci de ne pas y répondre.<br>
            © {{ date('Y') }} CampShare. Tous droits réservés. <br>
            CampShare est un service de ParentCo.
        </div>
    </div>
</body>
</html>