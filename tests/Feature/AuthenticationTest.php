<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Simuler le disque de stockage 'public' pour tous les tests de cette classe
        Storage::fake('public');

        // S'assurer qu'il y a au moins une ville pour les factories si nécessaire
        // Bien que City::factory() dans UserFactory devrait s'en charger.
        if (City::count() === 0) {
            City::factory()->create();
        }
    }

    /**
     * Test 1 : Vérifier si la page d'inscription est accessible.
     */
    public function test_registration_form_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register'); // Assurez-vous que la vue s'appelle bien 'auth.register'
    }

    /**
     * Test 2 : Vérifier si un nouvel utilisateur (client) peut s'inscrire correctement avec toutes les données.
     */
    public function test_user_can_register_as_client_with_valid_data_and_images()
    {
        $city = City::factory()->create();
        $password = 'UnMotDePasseFort123!';

        $userData = [
            'username' => $this->faker->unique()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'phone_number' => '+33612345678', // Format valide pour votre regex
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            'image' => UploadedFile::fake()->image('profil.jpg', 100, 100)->size(100), // image, width, height, size in KB
            'cin_recto' => UploadedFile::fake()->image('recto.jpg', 200, 150)->size(150),
            'cin_verso' => UploadedFile::fake()->image('verso.jpg', 200, 150)->size(150),
            'city_id' => $city->id,
            'terms' => true,
            'contract' => true,
            'is_subscribed' => $this->faker->boolean,
            // 'role' n'est pas envoyé, donc il devrait être 'client' par défaut
        ];

        $response = $this->post(route('register'), $userData);

        // dd($response->content()); // Décommenter pour voir la réponse en cas d'erreur

        $response->assertRedirect(route('HomeClient'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'email' => $userData['email'],
            'role' => 'client'
        ]);

        $user = User::where('email', $userData['email'])->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check($password, $user->password));

        // Vérifier que les images sont stockées (les chemins peuvent varier légèrement)
        // Exemple: $user->avatar_url pourrait être 'storage/profile_images/random_name.jpg'
        Storage::disk('public')->assertExists(str_replace('storage/', '', $user->avatar_url));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $user->cin_recto));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $user->cin_verso));
    }

    /**
     * Test : Vérifier si un utilisateur (partenaire) peut s'inscrire.
     */
    public function test_user_can_register_as_partner_with_valid_data()
    {
        $city = City::factory()->create();
        $password = 'PartnerPass123$';

        $userData = [
            'username' => $this->faker->unique()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'phone_number' => '+33712345678',
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            'image' => UploadedFile::fake()->image('partner_avatar.png'),
            'cin_recto' => UploadedFile::fake()->image('partner_cin_recto.png'),
            'cin_verso' => UploadedFile::fake()->image('partner_cin_verso.png'),
            'city_id' => $city->id,
            'terms' => true,
            'contract' => true,
            'is_subscribed' => $this->faker->boolean,
            'role' => 'partner', // Explicitement défini comme partenaire
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect(route('HomePartenaie'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'role' => 'partner'
        ]);
    }


    /**
     * Test : Vérifier l'inscription sans image de profil (devrait utiliser l'avatar par défaut).
     */
    public function test_user_can_register_without_profile_image_and_gets_default_avatar()
    {
        $city = City::factory()->create();
        $password = 'DefaultAvatarPass123!';

        $userData = [
            'username' => $this->faker->unique()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'phone_number' => '+33600000001',
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            // 'image' n'est pas envoyé
            'cin_recto' => UploadedFile::fake()->image('recto_default.jpg'),
            'cin_verso' => UploadedFile::fake()->image('verso_default.jpg'),
            'city_id' => $city->id,
            'terms' => true,
            'contract' => true,
            'is_subscribed' => false,
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect(route('HomeClient'));
        $this->assertAuthenticated();

        $user = User::where('email', $userData['email'])->first();
        $this->assertNotNull($user);
        $this->assertEquals('images/avatar-default.jpg', $user->avatar_url); // Vérifie l'avatar par défaut
    }

    /**
     * Test 3 : Vérifier qu'on ne peut pas s'inscrire avec un email qui existe déjà.
     */
    public function test_user_cannot_register_with_existing_email()
    {
        $existingUser = User::factory()->create(); // UserFactory s'occupe du city_id
        $city = City::factory()->create(); // Une ville pour le formulaire actuel
        $password = 'TestPass123!';

        $userData = [
            'username' => $this->faker->unique()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'phone_number' => '+33611111111',
            'email' => $existingUser->email, // Email qui existe déjà
            'password' => $password,
            'password_confirmation' => $password,
            'image' => UploadedFile::fake()->image('profil_dup.jpg'),
            'cin_recto' => UploadedFile::fake()->image('recto_dup.jpg'),
            'cin_verso' => UploadedFile::fake()->image('verso_dup.jpg'),
            'city_id' => $city->id,
            'terms' => true,
            'contract' => true,
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertSessionHasErrors('email');
        $this->assertGuest(); // Corrigé de $this.
    }

    /**
     * Test pour les champs requis lors de l'inscription.
     */
    public function test_registration_requires_necessary_fields()
    {
        $response = $this->post(route('register'), []); // Envoi de données vides

        $response->assertSessionHasErrors([
            'username',
            'first_name',
            'last_name',
            'address',
            'phone_number',
            'email',
            'password',
            'cin_recto',
            'cin_verso',
            'city_id',
            'terms',
            'contract',
        ]);
    }


    /**
     * Test 4 : Vérifier si la page de connexion est accessible.
     */
    public function test_login_form_can_be_rendered()
    {
        $response = $this->get(route('login.form'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login'); // Assurez-vous que la vue s'appelle bien 'auth.login'
    }

    /**
     * Test 5 : Vérifier qu'un utilisateur client existant et actif peut se connecter.
     */
    public function test_existing_active_client_user_can_login()
    {
        $password = 'monSuperMotDePasse';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'role' => 'client',
            'is_active' => true
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('HomeClient'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test : Vérifier qu'un utilisateur partenaire existant et actif peut se connecter.
     */
    public function test_existing_active_partner_user_can_login()
    {
        $password = 'partnerLoginPass123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'role' => 'partner',
            'is_active' => true
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('HomePartenaie'));
        $this->assertAuthenticatedAs($user);
    }


    /**
     * Test 6 : Vérifier qu'un utilisateur ne peut pas se connecter avec un mauvais mot de passe.
     */
    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('vraiMotDePasse'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'mauvaisMotDePasse',
        ]);

        $response->assertSessionHasErrors('email'); // Votre AuthController retourne une erreur sur 'email'
        $this->assertGuest();
    }

    /**
     * Test 7 : Vérifier qu'un utilisateur inactif ne peut pas se connecter.
     */
    public function test_inactive_user_cannot_login()
    {
        $password = 'motDePasseInactif';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'is_active' => false,
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email'); // Votre AuthController retourne une erreur sur 'email'
        $this->assertGuest(); // Corrigé de $this.
    }

    /**
     * Test 8 : Vérifier qu'un utilisateur connecté peut se déconnecter.
     */
    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertAuthenticated();

        $response = $this->post(route('logout'));

        // Votre AuthController redirige vers 'login' qui est la route POST
        // Mais la route pour afficher le formulaire est 'login.form'
        // Après logout, on devrait aller vers la page de formulaire
        // Si votre route 'login' redirige vers 'login.form' en GET, c'est ok.
        // Sinon, il vaut mieux rediriger explicitement vers 'login.form' dans AuthController@logout
        $response->assertRedirect(route('login.form')); // Ajusté pour correspondre à la logique attendue après logout
        $this->assertGuest();
    }
}