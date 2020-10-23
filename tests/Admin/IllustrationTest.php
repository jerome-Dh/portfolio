<?php

namespace Tests\Admin;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Illustration, User, Experience};

/**
 * Class IllustrationTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class IllustrationTest extends TestCase
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
	protected $table = 'illustrations';

    public function setUp(): void
    {
        parent::setUp();

		Illustration::truncate();
		User::truncate();
        Experience::truncate();
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
            ->get($this->base_url.'/testIllustration');
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

		// Corrects datas : Empty Illustration
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/illustrations');
		$response->assertViewIs('admin.illustrations.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto illustration
		$illustration = Illustration::create($this->getIllustration());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/illustrations');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee($illustration->image);

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
            ->get($this->base_url.'/illustrations/create');

		$response->assertViewIs('admin.illustrations.create');
		$response->assertStatus(200);
		$response->assertSee('name="image"', false);

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

		// Wrong datas : experience_id absent
		$d = $this->getIllustration();
		$d['experience_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/illustrations', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/illustrations/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Image vide
		$d = $this->getIllustration();
		$d['image'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/illustrations', $d);
		$response->assertRedirect($this->base_url.'/illustrations/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$d = $this->getIllustration();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/illustrations', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/illustrations/create');
        $this->assertDatabaseHas($this->table, array_slice($d, 1, count($d)-1));
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
            ->get($this->base_url.'/illustrations/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getIllustration();
		$illustration = Illustration::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/illustrations/'. $illustration->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.illustrations.edit');
		$response->assertSee('name="image"', false);

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
		$d = $this->getIllustration();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/illustrations/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing experience_id
		$illustration = Illustration::create($this->getIllustration());

		$d = $this->getIllustration();
		$d['experience_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/illustrations/'.$illustration->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/illustrations/'.$illustration->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);


         //Données valides: Image vide
		$d = $this->getIllustration();
		$d['image'] = null;
		$illustration = Illustration::create($this->getIllustration());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/illustrations/'.$illustration->id, $d);
		$response->assertRedirect($this->base_url.'/illustrations/'.$illustration->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$illustration = Illustration::create($this->getIllustration());
		$d = $this->getIllustration();

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/illustrations/'.$illustration->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/illustrations/'.$illustration->id.'/edit');
        $this->assertDatabaseHas($this->table, array_slice($d, 1, count($d)-1));
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
            ->get($this->base_url.'/illustrations/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getIllustration();
		$illustration = Illustration::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/illustrations/'. $illustration->id);

		$response->assertViewIs('admin.illustrations.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($illustration->image));

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
            ->delete($this->base_url.'/illustrations/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getIllustration();
		$illustration = Illustration::create($d);

        // Add an image
		Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
		$d['image'] = $file;
        $this->actingAs($user, 'web')
            ->put($this->base_url.'/illustrations/'.$illustration->id, $d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/illustrations/'. $illustration->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/illustrations');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);
        Storage::disk('public')->assertMissing($file->hashName());

        // $response->dumpHeaders();
		// $response->dump();

	}

}
