<?php

namespace Tests\Admin;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Experience, User};

/**
 * Class ExperienceTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class ExperienceTest extends TestCase
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
	protected $table = 'experiences';

    public function setUp(): void
    {
        parent::setUp();

		Experience::truncate();
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
            ->get($this->base_url.'/testExperience');
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

		// Corrects datas : Empty Experience
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experiences');
		$response->assertViewIs('admin.experiences.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto experience
		$experience = Experience::create($this->getExperience());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experiences');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($experience->year));

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
            ->get($this->base_url.'/experiences/create');

		$response->assertViewIs('admin.experiences.create');
		$response->assertStatus(200);
		$response->assertSee('name="year"', false);

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

		// Wrong datas : year absent
		$d = $this->getExperience();
		$d['year'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experiences', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experiences/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Experience::create($this->getExperience());

		$d = $this->getExperience();
		$d['name_en'] = $exists->name_en;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experiences', $d);
		$response->assertRedirect($this->base_url.'/experiences/create');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Description_en vide
		$d = $this->getExperience();
		$d['image'] = null;
		$d['description_en'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experiences', $d);
		$response->assertRedirect($this->base_url.'/experiences/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$d = $this->getExperience();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experiences', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/experiences/create');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d)-2));
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
            ->get($this->base_url.'/experiences/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience();
		$experience = Experience::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experiences/'. $experience->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.experiences.edit');
		$response->assertSee('name="year"', false);

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
		$d = $this->getExperience();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Year
		$experience = Experience::create($this->getExperience());

		$d = $this->getExperience();
		$d['year'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.$experience->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experiences/'.$experience->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Experience::create($this->getExperience());

		$d = $this->getExperience();
		$d['name_en'] = $exists->name_en;
		$experience = Experience::create($this->getExperience());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.$experience->id, $d);
		$response->assertRedirect($this->base_url.'/experiences/'.$experience->id.'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Description_en vide
		$d = $this->getExperience();
		$d['image'] = null;
		$d['description_en'] = null;
		$experience = Experience::create($this->getExperience());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.$experience->id, $d);
		$response->assertRedirect($this->base_url.'/experiences/'.$experience->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$experience = Experience::create($this->getExperience());
		$d = $this->getExperience();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.$experience->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/experiences/'.$experience->id.'/edit');
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d)-2));
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
            ->get($this->base_url.'/experiences/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience();
		$experience = Experience::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experiences/'. $experience->id);

		$response->assertViewIs('admin.experiences.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($experience->year));

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
            ->delete($this->base_url.'/experiences/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience();
		$experience = Experience::create($d);

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;
        $this->actingAs($user, 'web')
            ->put($this->base_url.'/experiences/'.$experience->id, $d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/experiences/'. $experience->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experiences');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);
        Storage::disk('public')->assertMissing($file->hashName());

        // $response->dumpHeaders();
		// $response->dump();

	}

}
