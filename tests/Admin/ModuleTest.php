<?php

namespace Tests\Admin;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Module, User};

/**
 * Class ModuleTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class ModuleTest extends TestCase
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
	protected $table = 'modules';

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Module::truncate();
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
            ->get($this->base_url.'/testModule');
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
        $user = $this->createAdmin();

		// Corrects datas : Empty Module
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules');
		$response->assertViewIs('admin.modules.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto module
		$module = Module::create($this->getModule());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($module->name_en));

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
        $user = $this->createAdmin();

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules/create');

		$response->assertViewIs('admin.modules.create');
		$response->assertStatus(200);
		$response->assertSee('name="name_en"', false);

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
        $user = $this->createAdmin();

		// Wrong datas : name_en absent
		$d = $this->getModule();
		$d['name_en'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/modules', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/modules/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Module::create($this->getModule());

		$d = $this->getModule();
		$d['name_en'] = $exists->name_en;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/modules', $d);
		$response->assertRedirect($this->base_url.'/modules/create');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Leved vide
		$d = $this->getModule();
		$d['leved'] = null;
		$d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/modules', $d);
		$response->assertRedirect($this->base_url.'/modules/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$d = $this->getModule();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/modules', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/modules/create');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d)-1));
        Storage::disk('public')->assertExists($file->hashName());
		Storage::disk('public')->delete($file->hashName());

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
        $user = $this->createAdmin();

		// Wrong datas :  inexistant Id
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule();
		$module = Module::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules/'. $module->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.modules.edit');
		$response->assertSee('name="name_en"', false);

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
        $user = $this->createAdmin();

		// Wrong datas : Inexistant Id
		$d = $this->getModule();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Name_en
		$module = Module::create($this->getModule());

		$d = $this->getModule();
		$d['name_en'] = null;
		$d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.$module->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/modules/'.$module->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Module::create($this->getModule());

		$d = $this->getModule();
		$d['name_en'] = $exists->name_en;
		$d['image'] = $exists->name_en;
		$module = Module::create($this->getModule());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.$module->id, $d);
		$response->assertRedirect($this->base_url.'/modules/'.$module->id.'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Leved vide
		$d = $this->getModule();
		$d['leved'] = null;
		$d['image'] = null;
		$module = Module::create($this->getModule());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.$module->id, $d);
		$response->assertRedirect($this->base_url.'/modules/'.$module->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$module = Module::create($this->getModule());
		$d = $this->getModule();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.$module->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/modules/'.$module->id.'/edit');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d)-1));
        Storage::disk('public')->assertExists($file->hashName());
		Storage::disk('public')->delete($file->hashName());

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
        $user = $this->createAdmin();

		// Wrong datas : Id inexistant
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule();
		$module = Module::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/modules/'. $module->id);

		$response->assertViewIs('admin.modules.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($module->name_en));

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
        $user = $this->createAdmin();

		// Wrong datas : Id inexistant
        $response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/modules/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule();
		$module = Module::create($d);

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;
        $this->actingAs($user, 'web')
            ->put($this->base_url.'/modules/'.$module->id, $d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/modules/'. $module->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/modules');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);
        Storage::disk('public')->assertMissing($file->hashName());

        // $response->dumpHeaders();
		// $response->dump();

	}

}
