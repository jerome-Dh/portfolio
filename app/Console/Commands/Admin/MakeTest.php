<?php

namespace App\Console\Commands\Admin;

use App\Console\Commands\Core\Helpers;
use App\Console\Commands\Core\Reader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class MakeTest
 *
 * @package App\Console\Commands\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 07/02/2020
 */
class MakeTest extends Command
{
    /**
     * Trait Helpers
     */
    use Helpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:test
                            {--c|classe=all : To generated the units tests for classe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create units testing classes for admin';

    /**
     * Array of all classes
     *
     * @var array
     */
    protected $tabClasses = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $output_dir = base_path('tests/Admin');

        $dirname = database_path('migrations');
        try {
            //Retrieve the argument value
            $classe = $this->option('classe');
            $reader = new Reader($dirname);

            if ($classe == 'all') {
                $tabClasses = $reader->getAllClasses();
            } else {
                $tabClasses = $reader->getOnlyClasses([$classe]);
            }

            $this->checkAndCreateTheOutputDir($output_dir);

            //Write all datas in DatabaseSeeder file
            if ($classe == 'all') {
                $output_file = $output_dir . '/CommonForTest.php';
                $this->info('En cours ...');
                $this->checkBeforeWrite($output_file, $this->getContentCommonForTest());
                $this->info('Operations terminées avec succes');
            }

            $this->tabClasses = $reader->getAllClasses();
            $this->traitement($tabClasses, $output_dir, 'test');

        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());
        }

        return true;
    }

    /**
     * Get content CommonForTest
     * @return string
     */
    protected function getContentCommonForTest() {

        return '<?php

namespace Tests\Admin;

use Database\Seeders\CommonForSeeders;
use App\Models\{User};

 /**
 * Trait CommonForTest
 * Share methods to all tests
 *
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
trait CommonForTest
{
    /**
     * @Trait CommonForSeeders
     */
    use CommonForSeeders;

	/**
	 * Base url
	 *
	 * @var String
	 */
	protected $base_url = \'http://127.0.0.1:8000/admin\';

	/**
	 * Print an response
	 *
	 * @param $response
	 */
	protected function printResponse($response)
	{
		print_r($response->baseResponse->original);
	}

    /**
     * Insert some users in the DB
     * @throws \Exception
     */
	protected function insertUsers()
	{
		//Raser la table
		User::truncate();

		//Insérer 10 données
		for($i = 0; $i<10; ++$i)
		{
            User::create($this->getUserSmall());
		}
	}

    /**
     * Create an admin
     *
     * @return mixed
     * @throws \Exception
     */
    protected function createAdmin()
    {
        $user = $this->getUser();
        $user[\'role\'] = config(\'custum.user_role.admin\');
        return User::create($user);
    }

}';
    }

    /**
     * The content for specific test classe
     *
     * @param $name
     * @param array $datas
     * @return string
     */
    protected function getContent($name, array $datas)
    {
        $lowerName = strtolower($name);
        $upperName = ucfirst($name);
        $pluralName = $lowerName.'s';

        $relationnalModelsNames = $this->getRelationalTableName($datas);
        $relationnalModelsNames = $relationnalModelsNames ? ', ' . $relationnalModelsNames : '';

        return '<?php

namespace Tests\Admin;

use Tests\TestCase;'
.$this->getImportUploadedImage($datas).'
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\\{'.$upperName.', User'.$relationnalModelsNames.'};

/**
 * Class '.$upperName.'Test
 *
 * @package Tests\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date '.$this->now().'
 */
class '.$upperName.'Test extends TestCase
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
	protected $table = \''.$pluralName.'\';

    public function setUp(): void
    {
        parent::setUp();

		'.$upperName.'::truncate();
		User::truncate();'.$this->getRelationalTruncate($datas).'
    }

    /**
     * Test the controller
	 *
     * @return void
     * @throws \Exception
     */
    public function testWorkingController()
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)
            ->get($this->base_url.\'/test'.$upperName.'\');
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

		// Corrects datas : Empty '.$upperName.'
        $response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'\');
		$response->assertViewIs(\'admin.'.$pluralName.'.index\');
        $response->assertStatus(200);
		$response->assertSee(\'Not item were found !\');

		// Corrects datas : One data onto '.$lowerName.'
		$'.$lowerName.' = '.$upperName.'::create($this->get'.$upperName.'());
		$response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'\');
        $response->assertStatus(200);
		$response->assertSee(\'<th class="uk-text-success uk-text-center">Illustration</th>\', false);
		$response->assertSee(ucfirst($'.$lowerName.'->'.$this->getFirstKeyName($datas).'));

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

		$response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'/create\');

		$response->assertViewIs(\'admin.'.$pluralName.'.create\');
		$response->assertStatus(200);
		$response->assertSee(\'name="'.$this->getFirstKeyName($datas).'"\', false);

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

		// Wrong datas : '.$this->getFirstKeyName($datas).' absent
		$d = $this->get'.$upperName.'();
		$d[\''.$this->getFirstKeyName($datas).'\'] = null;
        $response = $this->actingAs($admin, \'web\')
            ->post($this->base_url.\'/'.$pluralName.'\', $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/create\');
		$response->assertSessionHas(\'errors\');
		$this->assertDatabaseMissing($this->table, $d);
        '.$this->getRequiredDataCheck($name, $datas, true)
		.$this->getOptionalField($datas, $name, true).'

		// Corrects datas
		$d = $this->get'.$upperName.'();'
	    .$this->getImageField($datas, false).'

        $response = $this->actingAs($admin, \'web\')
            ->post($this->base_url.\'/'.$pluralName.'\', $d);
        $response->assertStatus(302);
        $response->assertSessionHas(\'info\');
		$response->assertSessionHasNoErrors();

		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/create\');'
		.$this->getDatabaseCheck($datas)
        .$this->getImageField($datas, true).'

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
        $response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'/\'. 99999 .\'/edit\');
        $response->assertStatus(302);
		$response->assertSessionHas(\'info\');

		// Corrects datas
		$d = $this->get'.$upperName.'();
		$'.$lowerName.' = '.$upperName.'::create($d);

		$response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'/\'. $'.$lowerName.'->id .\'/edit\');

        $response->assertStatus(200);
        $response->assertViewIs(\'admin.'.$pluralName.'.edit\');
		$response->assertSee(\'name="'.$this->getFirstKeyName($datas).'"\', false);

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
		$d = $this->get'.$upperName.'();
        $response = $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.(99999), $d);
        $response->assertStatus(302);
		$response->assertSessionHas(\'errors\');
		$this->assertDatabaseMissing($this->table, $d);

		// Wrong datas : Missing '.ucfirst($this->getFirstKeyName($datas)).'
		$'.$lowerName.' = '.$upperName.'::create($this->get'.$upperName.'());

		$d = $this->get'.$upperName.'();
		$d[\''.$this->getFirstKeyName($datas).'\'] = null;
        $response = $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id, $d);
        $response->assertStatus(302);
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id.\'/edit\');
		$response->assertSessionHas(\'errors\');
		$this->assertDatabaseMissing($this->table, $d);
		'.$this->getRequiredDataCheck($name, $datas, false)
        .$this->getOptionalField($datas, $name, false).'

		// Corrects datas
		$'.$lowerName.' = '.$upperName.'::create($this->get'.$upperName.'());
		$d = $this->get'.$upperName.'();'
        .$this->getImageField($datas, false).'

        $response = $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id, $d);
        $response->assertStatus(302);
		$response->assertSessionHas(\'info\');
		$response->assertSessionHasNoErrors();
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id.\'/edit\');'
        .$this->getDatabaseCheck($datas)
        .$this->getImageField($datas, true).'

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
        $response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'/\'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas(\'info\');

		// Corrects datas
		$d = $this->get'.$upperName.'();
		$'.$lowerName.' = '.$upperName.'::create($d);

		$response = $this->actingAs($admin, \'web\')
            ->get($this->base_url.\'/'.$pluralName.'/\'. $'.$lowerName.'->id);

		$response->assertViewIs(\'admin.'.$pluralName.'.show\');
		$response->assertStatus(200);
		$response->assertSee(ucfirst($'.$lowerName.'->'.$this->getFirstKeyName($datas).'));

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
        $response = $this->actingAs($admin, \'web\')
            ->delete($this->base_url.\'/'.$pluralName.'/\'. 99999);
        $response->assertStatus(302);
		$response->assertSessionHas(\'info\');

		// Corrects datas
		$d = $this->get'.$upperName.'();
		$'.$lowerName.' = '.$upperName.'::create($d);'
        .$this->getImageField($datas, false)
        .$this->getUpdateForDestroy($name, $datas).'

		$response = $this->actingAs($admin, \'web\')
            ->delete($this->base_url.\'/'.$pluralName.'/\'. $'.$lowerName.'->id);

		$response->assertStatus(302);
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'\');
		$response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing($this->table, $d);'
        .$this->getImageField( $datas, true, true).'

        // $response->dumpHeaders();
		// $response->dump();

	}

}';

    }

    /**
     * Get imports statements for image
     *
     * @param array $datas
     * @return string
     */
    protected function getImportUploadedImage(array $datas) {

        $ret = '';

        if(array_key_exists('image', $datas)) {
            $ret = '
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;';
        }

        return $ret;
    }

    /**
     * Get Required check field
     *
     * @param $name
     * @param array $datas
     * @param $post
     * @return string
     */
    protected function getRequiredDataCheck($name, array $datas, $post) {

        $lowerName = strtolower($name);
        $upperName = ucfirst($name);
        $pluralName = $lowerName.'s';
        $ret = '';

        if($this->getFirstUniqueName($datas)) {

            $ret = '
        // Wrong datas : ' . ucfirst($this->getFirstUniqueName($datas)) . ' double
		$exists = ' . $upperName . '::create($this->get' . $upperName . '());

		$d = $this->get' . $upperName . '();
		$d[\'' . $this->getFirstUniqueName($datas) . '\'] = $exists->' . $this->getFirstUniqueName($datas) . ';';

            if($post) {
                $ret .= '
        $response = $this->actingAs($admin, \'web\')
            ->post($this->base_url.\'/' . $pluralName . '\', $d);
		$response->assertRedirect($this->base_url.\'/' . $pluralName . '/create\');';
            }
            else {
                $ret .= '
		$'.$lowerName.' = '.$upperName.'::create($this->get'.$upperName.'());

        $response = $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id, $d);
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id.\'/edit\');';
            }

            $ret .= '
        $response->assertStatus(302);
		$response->assertSessionHas(\'errors\');
		$this->assertDatabaseMissing($this->table, $d);';

        }

        return $ret;
    }

    /**
     * Get Test for optional field
     *
     * @param array $datas
     * @param $name
     * @param $post
     * @return string
     */
    protected  function getOptionalField(array $datas, $name, $post) {

        $lowerName = strtolower($name);
        $upperName = ucfirst($name);
        $pluralName = $lowerName.'s';

        $ret = '';

        if($this->getFirstOptionalName($datas)) {

            $ret = '

         //Données valides: ' . ucfirst($this->getFirstOptionalName($datas)) . ' vide
		$d = $this->get' . $upperName . '();
		$d[\'' . $this->getFirstOptionalName($datas) . '\'] = null;';

            if($post) {
                $ret .= '
        $response = $this->actingAs($admin, \'web\')
            ->post($this->base_url.\'/' . $pluralName . '\', $d);
		$response->assertRedirect($this->base_url.\'/' . $pluralName . '/create\');';
            }
            else {
                $ret .= '
		$'.$lowerName.' = '.$upperName.'::create($this->get'.$upperName.'());

        $response = $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id, $d);
		$response->assertRedirect($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id.\'/edit\');';
            }

            $ret .= '
        $response->assertStatus(302);
        $response->assertSessionHas(\'info\');
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas($this->table, $d);';

        }

        return $ret;

    }

    /**
     * Get image field to upload
     *
     * @param array $datas
     * @param $check
     * @param bool $missing
     * @return string
     */
    protected function getImageField(array $datas, $check, $missing = false) {
        $ret = '';
        if(array_key_exists('image', $datas)) {

            if( ! $check) {
                $ret = '

        // Add an image
		Storage::fake(\'avatars\');
        $file = UploadedFile::fake()->image(\'avatar.jpg\');
		$d[\'image\'] = $file;';
            }
            elseif( ! $missing) {
                $ret = '
        Storage::disk(\'public\')->assertExists($file->hashName());
		Storage::disk(\'public\')->delete($file->hashName());';
            }
            else {
                $ret = '
        Storage::disk(\'public\')->assertMissing($file->hashName());';
            }

        }

        return $ret;
    }

    /**
     * Check the database
     *
     * @param array $datas
     * @return string
     */
    protected function getDatabaseCheck(array $datas) {

        $ret = '';

        if(array_key_exists('image', $datas)) {
            $ret = '
        $this->assertDatabaseHas($this->table, array_slice($d, 0, count($d)-1));';
        }
        else {
            $ret = '
        $this->assertDatabaseHas($this->table, $d);';
        }

        return $ret;
    }

    /**
     * Get additional update content for destroy
     *
     * @param $name
     * @param array $datas
     * @return string
     */
    protected function getUpdateForDestroy($name, array $datas) {

        $lowerName = strtolower($name);
        $pluralName = $lowerName.'s';
        $ret = '';

        if(array_key_exists('image', $datas)) {
            $ret = '
        $this->actingAs($admin, \'web\')
            ->put($this->base_url.\'/'.$pluralName.'/\'.$'.$lowerName.'->id, $d);';
        }

        return $ret;
    }

}
