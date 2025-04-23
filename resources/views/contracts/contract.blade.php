<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat de Location CampShare</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            padding: 30px;
            color: #2c3e50;
        }
        h1 {
            text-align: center;
            color: #1a202c;
            margin-bottom: 30px;
        }
        h2 {
            margin-top: 25px;
            color: #1a202c;
        }
        p {
            margin-bottom: 10px;
        }
        ul {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Contrat de Location - CampShare</h1>
    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Date :</strong> {{ $date }}</p>

    <hr>

    <h2>Engagement de l'utilisateur</h2>
    <p>
        Ce contrat confirme que <strong>{{ $user->name }}</strong> accepte les conditions générales d'utilisation de la plateforme <strong>CampShare</strong>, et s'engage à respecter les normes suivantes lors de la location d'outils de camping :
    </p>

    <ul>
        <li>Utiliser les équipements loués avec soin, dans un cadre respectueux et conforme à leur usage prévu.</li>
        <li>Restituer les outils dans un état propre et fonctionnel, équivalent à celui dans lequel ils ont été reçus.</li>
        <li>Informer immédiatement CampShare ou le propriétaire de tout dommage, perte ou problème survenu lors de l’utilisation du matériel.</li>
        <li>Ne pas sous-louer, prêter ou céder les équipements à une tierce personne sans autorisation préalable.</li>
        <li>Respecter les délais de retour prévus pour éviter toute pénalité.</li>
    </ul>

    <p>
        En acceptant ce contrat, l'utilisateur reconnaît avoir pris connaissance des règles de la communauté CampShare et s'engage à les respecter dans l'intérêt de tous.
    </p>

    <h2>Remerciements</h2>
    <p>
        Merci de faire partie de notre communauté ! Ensemble, rendons le camping accessible, sécurisé et agréable pour tous les membres.
    </p>
</body>
</html>
