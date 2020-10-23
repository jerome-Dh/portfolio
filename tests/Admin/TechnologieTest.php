<?php

namespace Tests\Admin;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Technologie, User};

/**
 * Class TechnologieTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class TechnologieTest extends TestCase
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
	protected $table = 'technologies';

    public function setUp(): void
    {
        parent::setUp();

		Technologie::truncate();
		User::truncate();
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
            ->get($this->base_url.'/testTechnologie');
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

		// Corrects datas : Empty Technologie
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/technologies');
		$response->assertViewIs('admin.technologies.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto technologie
		$technologie = Technologie::create($this->getTechnologie());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/technologies');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($technologie->name_en));

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
            ->get($this->base_url.'/technologies/create');

		$response->assertViewIs('admin.technologies.create');
		$response->assertStatus(200);
		$response->assertSee('name="name_en"',false);

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
		$d = $this->getTechnologie();
		$d['name_en'] = null;
		$d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/technologies', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/technologies/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Technologie::create($this->getTechnologie());

		$d = $this->getTechnologie();
		$d['name_en'] = $exists->name_en;
        $d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/technologies', $d);
		$response->assertRedirect($this->base_url.'/technologies/create');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Image vide
		$d = $this->getTechnologie();
		$d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/technologies', $d);
		$response->assertRedirect($this->base_url.'/technologies/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$d = $this->getTechnologie();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/technologies', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/technologies/create');
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
            ->get($this->base_url.'/technologies/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getTechnologie();
		$technologie = Technologie::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/technologies/'. $technologie->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.technologies.edit');
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
		$d = $this->getTechnologie();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Name_en
		$technologie = Technologie::create($this->getTechnologie());

		$d = $this->getTechnologie();
		$d['name_en'] = null;
        $d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.$technologie->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/technologies/'.$technologie->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Technologie::create($this->getTechnologie());

		$d = $this->getTechnologie();
		$d['name_en'] = $exists->name_en;
        $d['image'] = null;
		$technologie = Technologie::create($this->getTechnologie());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.$technologie->id, $d);
		$response->assertRedirect($this->base_url.'/technologies/'.$technologie->id.'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Image vide
		$d = $this->getTechnologie();
		$d['image'] = null;
		$technologie = Technologie::create($this->getTechnologie());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.$technologie->id, $d);
		$response->assertRedirect($this->base_url.'/technologies/'.$technologie->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$technologie = Technologie::create($this->getTechnologie());
		$d = $this->getTechnologie();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.$technologie->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/technologies/'.$technologie->id.'/edit');
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
            ->get($this->base_url.'/technologies/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getTechnologie();
		$technologie = Technologie::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/technologies/'. $technologie->id);

		$response->assertViewIs('admin.technologies.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($technologie->name_en));

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
            ->delete($this->base_url.'/technologies/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getTechnologie();
		$technologie = Technologie::create($d);

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;
        $this->actingAs($user, 'web')
            ->put($this->base_url.'/technologies/'.$technologie->id, $d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/technologies/'. $technologie->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/technologies');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);
        Storage::disk('public')->assertMissing($file->hashName());

        // $response->dumpHeaders();
		// $response->dump();

	}

}
