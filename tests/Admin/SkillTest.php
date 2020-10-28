<?php

namespace Tests\Admin;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\{Skill, User};

/**
 * Class SkillTest
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 22:42
 */
class SkillTest extends TestCase
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
	protected $table = 'skills';

    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Skill::truncate();
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
            ->get($this->base_url.'/testSkill');
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

		// Corrects datas : Empty Skill
        $response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/skills');
		$response->assertViewIs('admin.skills.index');
        $response->assertStatus(200);
		$response->assertSee('Not item were found !');

		// Corrects datas : One data onto skill
		$skill = Skill::create($this->getSkill());
		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/skills');
        $response->assertStatus(200);
		$response->assertSee('<th class="uk-text-success uk-text-center">Illustration</th>', false);
		$response->assertSee(ucfirst($skill->name_en));

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
            ->get($this->base_url.'/skills/create');

		$response->assertViewIs('admin.skills.create');
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
		$d = $this->getSkill();
		$d['name_en'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/skills', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/skills/create');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Skill::create($this->getSkill());

		$d = $this->getSkill();
		$d['name_en'] = $exists->name_en;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/skills', $d);
		$response->assertRedirect($this->base_url.'/skills/create');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Subname_en vide
		$d = $this->getSkill();
		$d['subname_en'] = null;
        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/skills', $d);
		$response->assertRedirect($this->base_url.'/skills/create');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$d = $this->getSkill();

        $response = $this->actingAs($user, 'web')
            ->post($this->base_url.'/skills', $d);
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.'/skills/create');
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
            ->get($this->base_url.'/skills/'. 99999 .'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getSkill();
		$skill = Skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/skills/'. $skill->id .'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.skills.edit');
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
		$d = $this->getSkill();
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/skills/'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing Name_en
		$skill = Skill::create($this->getSkill());

		$d = $this->getSkill();
		$d['name_en'] = null;
        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/skills/'.$skill->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/skills/'.$skill->id.'/edit');
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

        // Wrong datas : Name_en double
		$exists = Skill::create($this->getSkill());

		$d = $this->getSkill();
		$d['name_en'] = $exists->name_en;
		$skill = Skill::create($this->getSkill());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/skills/'.$skill->id, $d);
		$response->assertRedirect($this->base_url.'/skills/'.$skill->id.'/edit');
        $response->assertStatus(302);
		$response->assertSessionHas('errors');
		$this->assertDatabaseMissing($this->table, $d);

         //Données valides: Subname_en vide
		$d = $this->getSkill();
		$d['subname_en'] = null;
		$skill = Skill::create($this->getSkill());

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/skills/'.$skill->id, $d);
		$response->assertRedirect($this->base_url.'/skills/'.$skill->id.'/edit');
        $response->assertStatus(302);
        $response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);

		// Corrects datas
		$skill = Skill::create($this->getSkill());
		$d = $this->getSkill();

        $response = $this->actingAs($user, 'web')
            ->put($this->base_url.'/skills/'.$skill->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas('info');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.'/skills/'.$skill->id.'/edit');
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
            ->get($this->base_url.'/skills/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getSkill();
		$skill = Skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->get($this->base_url.'/skills/'. $skill->id);

		$response->assertViewIs('admin.skills.show');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($skill->name_en));

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
            ->delete($this->base_url.'/skills/'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas('info');

		// Corrects datas
		$d = $this->getSkill();
		$skill = Skill::create($d);

		$response = $this->actingAs($user, 'web')
            ->delete($this->base_url.'/skills/'. $skill->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.'/skills');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);

        // $response->dumpHeaders();
		// $response->dump();

	}

}
