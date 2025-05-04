<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Réservation CampShare</title>
     <style>
        body { font-family: sans-serif; line-height: 1.6; color: #4a5568; margin: 0; padding: 0; background-color: #f7fafc; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #FFAA33; color: #ffffff; padding: 20px; text-align: center; } /* Couleur Sunlight */
        .header h1 { margin: 0; font-size: 24px; color: #4a5568; } /* Texte plus foncé sur fond clair */
        .content { padding: 30px; }
        .content h2 { color: #2D5F2B; margin-top: 0; font-size: 20px; }
        .content p { margin-bottom: 15px; }
        .footer { background-color: #edf2f7; padding: 20px; text-align: center; font-size: 12px; color: #718096; }
        a { color: #2D5F2B; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
     <div class="container">
        <div class="header">
            <h1>Information sur votre demande</h1>
        </div>
        <div class="content">
            <h2>Bonjour {{ optional($reservation->client)->first_name ?? 'Client' }},</h2> {{-- Accès via la relation --}}

            <p>Nous sommes désolés de vous informer que votre demande de réservation pour l'équipement suivant n'a malheureusement pas pu être acceptée par le partenaire :</p>

             <ul>
                <li><strong>Équipement :</strong> {{ optional($reservation->listing)->item?->title ?? 'Non spécifié' }}</li>
                <li><strong>Demandé pour les dates :</strong> Du {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</li>
            </ul>

            <p style="margin-top: 25px;">Nous vous encourageons à rechercher d'autres équipements similaires qui pourraient être disponibles pour vos dates sur CampShare.</p>

            <p><a href="{{ url('/') }}">Retourner sur CampShare</a></p> 
        </div>
        <div class="footer">
            Ceci est un e-mail automatique, merci de ne pas y répondre.<br>
            © {{ date('Y') }} CampShare. Tous droits réservés.
        </div>
    </div>
</body>
</html>
