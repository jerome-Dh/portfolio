<?php

namespace Tests\Admin;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Experience_technologie, User, Experience, Technologie};

/**
 * Class Experience_technologieTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class Experience_technologieTest extends TestCase
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
	protected $table = 'experience_technologie';

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Experience_technologie::truncate();
		User::truncate();
        Experience::truncate();
        Technologie::truncate();
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
            ->get($this->base_url.'/testExperience_technologie');
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

		// Corrects datas : Empty Experience_technologie
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experience_technologies');
		$response->assertViewIs('admin.experience_technologies.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto experience_technologie
		$experience_technologie = Experience_technologie::create($this->getExperience_technologie());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experience_technologies');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(($experience_technologie->experience_id));

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
            ->get($this->base_url.'/experience_technologies/create');

		$response->assertViewIs('admin.experience_technologies.create');
		$response->assertStatus(200);
		$response->assertSee('name="experience_id"', false);

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
		$d = $this->getExperience_technologie();
		$d['experience_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experience_technologies', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experience_technologies/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Corrects datas
		$d = $this->getExperience_technologie();

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/experience_technologies', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/experience_technologies/create');
        $this->assertDatabaseHas($this->table, $d);

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
            ->get($this->base_url.'/experience_technologies/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience_technologie();
		$experience_technologie = Experience_technologie::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experience_technologies/'. $experience_technologie->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.experience_technologies.edit');
		$response->assertSee('name="experience_id"', false);

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
		$d = $this->getExperience_technologie();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experience_technologies/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Experience_id
		$experience_technologie = Experience_technologie::create($this->getExperience_technologie());

		$d = $this->getExperience_technologie();
		$d['experience_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experience_technologies/'.$experience_technologie->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experience_technologies/'.$experience_technologie->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Corrects datas
		$experience_technologie = Experience_technologie::create($this->getExperience_technologie());
		$d = $this->getExperience_technologie();

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/experience_technologies/'.$experience_technologie->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/experience_technologies/'.$experience_technologie->id.'/edit');
        $this->assertDatabaseHas($this->table, $d);

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
            ->get($this->base_url.'/experience_technologies/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience_technologie();
		$experience_technologie = Experience_technologie::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/experience_technologies/'. $experience_technologie->id);

		$response->assertViewIs('admin.experience_technologies.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($experience_technologie->experience_id));

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
            ->delete($this->base_url.'/experience_technologies/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getExperience_technologie();
		$experience_technologie = Experience_technologie::create($d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/experience_technologies/'. $experience_technologie->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/experience_technologies');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);

        // $response->dumpHeaders();
		// $response->dump();

	}

}
