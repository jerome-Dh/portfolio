<?php

namespace Tests\Admin;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Module_skill, User, Module, Skill};

/**
 * Class Module_skillTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class Module_skillTest extends TestCase
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
	protected $table = 'module_skill';

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Module_skill::truncate();
		User::truncate();
        Module::truncate();
        Skill::truncate();
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
            ->get($this->base_url.'/testModule_skill');
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

		// Corrects datas : Empty Module_skill
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/module_skills');
		$response->assertViewIs('admin.module_skills.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto module_skill
		$module_skill = Module_skill::create($this->getModule_skill());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/module_skills');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($module_skill->module_id));

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
            ->get($this->base_url.'/module_skills/create');

		$response->assertViewIs('admin.module_skills.create');
		$response->assertStatus(200);
		$response->assertSee('name="module_id"', false);

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

		// Wrong datas : module_id absent
		$d = $this->getModule_skill();
		$d['module_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/module_skills', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/module_skills/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);


		// Corrects datas
		$d = $this->getModule_skill();

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/module_skills', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/module_skills/create');
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
            ->get($this->base_url.'/module_skills/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule_skill();
		$module_skill = Module_skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/module_skills/'. $module_skill->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.module_skills.edit');
		$response->assertSee('name="module_id"', false);

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
		$d = $this->getModule_skill();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/module_skills/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Module_id
		$module_skill = Module_skill::create($this->getModule_skill());

		$d = $this->getModule_skill();
		$d['module_id'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/module_skills/'.$module_skill->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/module_skills/'.$module_skill->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);


		// Corrects datas
		$module_skill = Module_skill::create($this->getModule_skill());
		$d = $this->getModule_skill();

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/module_skills/'.$module_skill->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/module_skills/'.$module_skill->id.'/edit');
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
            ->get($this->base_url.'/module_skills/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule_skill();
		$module_skill = Module_skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/module_skills/'. $module_skill->id);

		$response->assertViewIs('admin.module_skills.show');
		$response->assertStatus(200);
		$response->assertSee($module_skill->module_id);

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
            ->delete($this->base_url.'/module_skills/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getModule_skill();
		$module_skill = Module_skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/module_skills/'. $module_skill->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/module_skills');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);

        // $response->dumpHeaders();
		// $response->dump();

	}

}
