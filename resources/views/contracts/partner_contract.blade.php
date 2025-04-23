
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat Propriétaire d'Équipement - CampShare</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Contrat de Location d'Équipement - CampShare</h1>
    <p><strong>Nom du Propriétaire :</strong> {{ $user->name }}</p>
    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Date :</strong> {{ $date }}</p>
    <hr>
    <p>Ce contrat confirme que {{ $user->name }} accepte les conditions de partenariat avec la plateforme CampShare en tant que propriétaire d'équipement.</p>

    <h3>Engagements du Propriétaire :</h3>
    <ul>
        <li>Le propriétaire s'engage à respecter toutes les normes et conditions d'entretien des équipements mises en place par CampShare.</li>
        <li>Le propriétaire garantit que les équipements mis à disposition sont sûrs, fonctionnels, et en bon état de marche.</li>
        <li>Le propriétaire doit s'assurer que les équipements respectent les normes de sécurité en vigueur dans la région où ils sont utilisés.</li>
        <li>Le propriétaire accepte que CampShare puisse vérifier régulièrement les équipements et leur conformité aux normes.</li>
        <li>Le propriétaire s'engage à maintenir une communication ouverte avec CampShare pour toute mise à jour ou maintenance nécessaire sur les équipements.</li>
    </ul>

    <h3>Conditions Générales :</h3>
    <ul>
        <li>Les équipements seront mis à disposition via la plateforme CampShare pour une période définie, avec un accord de location préalable signé par l'utilisateur.</li>
        <li>En cas de non-respect des normes ou de défauts de sécurité, CampShare se réserve le droit de suspendre ou de retirer les équipements de la plateforme.</li>
    </ul>

    <p>Merci de faire partie de notre réseau de propriétaires d'équipements !</p>
</body>
</html>
