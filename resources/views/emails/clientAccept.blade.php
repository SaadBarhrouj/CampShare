<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre réservation CampShare est acceptée !</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #4a5568; margin: 0; padding: 0; background-color: #f7fafc; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #2D5F2B; color: #ffffff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .content h2 { color: #2D5F2B; margin-top: 0; font-size: 20px; }
        .content p { margin-bottom: 15px; }
        .info-section { margin-top: 25px; padding-top: 15px; border-top: 1px solid #e2e8f0; }
        .info-section h3 { color: #4F7942; margin-bottom: 10px; font-size: 16px; }
        .info-list { list-style: none; padding: 0; margin: 0; }
        .info-list li { margin-bottom: 8px; }
        .info-list strong { color: #4a5568; min-width: 100px; display: inline-block; }
        .footer { background-color: #edf2f7; padding: 20px; text-align: center; font-size: 12px; color: #718096; }
        a { color: #2D5F2B; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Réservation Acceptée !</h1>
        </div>
        <div class="content">
            <h2>Bonjour {{ $client->first_name ?? $client->username ?? 'Client' }},</h2> 

            <p>Bonne nouvelle ! Votre demande de réservation pour l'équipement suivant a été acceptée par le partenaire :</p>

            <ul>
                <li><strong>Équipement :</strong> {{ optional($reservation->listing)->item?->title ?? 'Non spécifié' }}</li>
                <li><strong>Dates :</strong> Du {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</li>
            </ul>

            <div class="info-section">
                <h3>Coordonnées du Partenaire</h3>
                <p>Vous pouvez maintenant contacter le partenaire pour organiser les détails de la location (récupération, livraison, etc.) :</p>
                <ul class="info-list">
                    <li><strong>Nom Complet:</strong> {{ $partner->first_name ?? 'N/A' }} {{ $partner->last_name ?? '' }}</li>
                    <li><strong>Nom d'utilisateur :</strong> {{ $partner->username ?? 'N/A' }}</li>
                    <li><strong>Téléphone :</strong> <a href="tel:{{ $partner->phone_number ?? '' }}">{{ $partner->phone_number ?? 'N/A' }}</a></li>
                    <li><strong>Email :</strong> <a href="mailto:{{ $partner->email ?? '' }}">{{ $partner->email ?? 'N/A' }}</a></li>
                    <li><strong>Ville :</strong> {{ optional($partner->city)->name ?? 'Non spécifiée' }}</li>
                    <li><strong>Adresse (indicative) :</strong> {{ $partner->address ?? 'Non spécifiée' }}</li>
                </ul>
            </div>

            <p style="margin-top: 25px;">Nous vous souhaitons une excellente expérience avec CampShare !</p>
        </div>
        <div class="footer">
            Ceci est un e-mail automatique, merci de ne pas y répondre.<br>
            © {{ date('Y') }} CampShare. Tous droits réservés.
        </div>
    </div>
</body>
</html>