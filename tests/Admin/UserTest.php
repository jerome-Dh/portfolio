<?php

namespace Tests\Admin;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{User};

/**
 * Class UserTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class UserTest extends TestCase
{
    /**
     * @trait CommonForTest
     */
    use CommonForTest;

	/**
	 * Refresh database
	 */
	use RefreshDatabase;

    /**
     * @var string - Table name
     */
	protected $table = 'users';

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Test the controller
	 *
     * @return void
     * @throws \Exception
     */
    public function testWorkingController()
    {
        $user = $this->createAdmin();
        $response = $this->actingAs($user)
            ->get($this->base_url.'/testUser');
        $response->assertStatus(200);

        // $response->dumpHeaders();
		// $response->dump();

    }

    /**
     * Test index
	 *
     * @return void
     * @throws \Exception
     */
    public function testIndex()
    {
        $admin = $this->createAdmin();

		// Corrects datas : Empty User/Only admin
        $response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users');
		$response->assertViewIs('admin.users.index');
        $response->assertStatus(200);
		$this->assertTrue(User::count() == 1);

		// Corrects datas : One data onto user
		$user = User::create($this->getUser());
		$response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($user->name));

		// $response->dumpHeaders();
		// $response->dump();

    }

	/**
     * Test create
	 *
     * @return void
     * @throws \Exception
     */
	public function testCreate()
	{
		// Corrects datas
        $admin = $this->createAdmin();

		$response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users/create');

		$response->assertViewIs('admin.users.create');
		$response->assertStatus(200);
		$response->assertSee('name="name"', false);

		// $response->dumpHeaders();
		// $response->dump();

	}

	/**
     * Test store
	 *
     * @return void
     * @throws \Exception
     */
	public function testStore()
	{
        $admin = $this->createAdmin();

		// Wrong datas : name absent
		$d = $this->getUser();
		$d['name'] = null;
        $response = $this->actingAs($admin, 'web')
            ->post($this->base_url.'/users', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/users/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Email double
		$exists = User::create($this->getUser());

		$d = $this->getUser();
		$d['email'] = $exists->email;
        $response = $this->actingAs($admin, 'web')
            ->post($this->base_url.'/users', $d);
		$response->assertRedirect($this->base_url.'/users/create');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Email_verified_at vide
		$d = $this->getUser();
		$d['email_verified_at'] = null;
        $response = $this->actingAs($admin, 'web')
            ->post($this->base_url.'/users', $d);
		$response->assertRedirect($this->base_url.'/users/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, array_slice($d, 0, count($d) - 3));

		// Corrects datas
		$d = $this->getUser();

        $response = $this->actingAs($admin, 'web')
            ->post($this->base_url.'/users', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/users/create');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d) - 2));

		// $response->dumpHeaders();
		// $response->dump();

	}

	 /**
     * Test edit
	 *
     * @return void
     * @throws \Exception
     */
	public function testEdit()
	{
        $admin = $this->createAdmin();

		// Wrong datas :  inexistant Id
        $response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getUser();
		$user = User::create($d);

		$response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users/'. $user->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
		$response->assertSee('name="name"', false);

		// $response->dumpHeaders();
		// $response->dump();

	}

	/**
     * Test store
	 *
     * @return void
     * @throws \Exception
     */
	public function testUpdate()
	{
        $admin = $this->createAdmin();

		// Wrong datas : Inexistant Id
		$d = $this->getUser();
        $response = $this->actingAs($admin, 'web')
            ->put($this->base_url.'/users/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Name
		$user = User::create($this->getUser());

		$d = $this->getUser();
		$d['name'] = null;
        $response = $this->actingAs($admin, 'web')
            ->put($this->base_url.'/users/'.$user->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/users/'.$user->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, array_slice($d, 0, count($d) - 2));

        // Wrong datas : Email double
		$exists = User::create($this->getUser());

		$d = $this->getUser();
		$d['email'] = $exists->email;
		$user = User::create($this->getUser());

        $response = $this->actingAs($admin, 'web')
            ->put($this->base_url.'/users/'.$user->id, $d);
		$response->assertRedirect($this->base_url.'/users/'.$user->id.'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Email_verified_at vide
		$d = $this->getUser();
		$d['email_verified_at'] = null;
		$user = User::create($this->getUser());

        $response = $this->actingAs($admin, 'web')
            ->put($this->base_url.'/users/'.$user->id, $d);
		$response->assertRedirect($this->base_url.'/users/'.$user->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, array_slice($d, 0, count($d) - 3));

		// Corrects datas
		$user = User::create($this->getUser());
		$d = $this->getUser();

        $response = $this->actingAs($admin, 'web')
            ->put($this->base_url.'/users/'.$user->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/users/'.$user->id.'/edit');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d) - 2));

		// $response->dumpHeaders();
		// $response->dump();

	}

	 /**
     * Test show
	 *
     * @return void
     * @throws \Exception
     */
	public function testShow()
	{
        $admin = $this->createAdmin();

		// Wrong datas : Id inexistant
        $response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getUser();
		$user = User::create($d);

		$response = $this->actingAs($admin, 'web')
            ->get($this->base_url.'/users/'. $user->id);

		$response->assertViewIs('admin.users.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($user->name));

		// $response->dumpHeaders();
		// $response->dump();

	}

	/**
     * Test destroy
	 *
     * @return void
     * @throws \Exception
     */
	public function testDestroy()
	{
        $admin = $this->createAdmin();

		// Wrong datas : Id inexistant
        $response = $this->actingAs($admin, 'web')
            ->delete($this->base_url.'/users/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getUser();
		$user = User::create($d);

		$response = $this->actingAs($admin, 'web')
            ->delete($this->base_url.'/users/'. $user->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/users');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);

        // $response->dumpHeaders();
		// $response->dump();

	}

}
