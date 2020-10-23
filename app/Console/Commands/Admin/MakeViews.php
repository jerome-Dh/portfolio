<?php

namespace App\Console\Commands\Admin;

use App\Console\Commands\Core\Helpers;
use App\Console\Commands\Core\Reader;
use Illuminate\Console\Command;

/**
 * Class MakeViews
 *
 * @package App\Console\Commands\Admin
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 07/02/2020
 */
class MakeViews extends Command
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
    protected $signature = 'admin:views
                            {--c|classe=all : To generated the views for all classes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make all view for admins controllers';

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
        $output_dir = resource_path('views/admin');

        $dirname = database_path('migrations');
        try {
            $classe = $this->option('classe');
            $reader = new Reader($dirname);

            if($classe == 'all') {
                $tabClasses = $reader->getAllClasses();
            } else {
                $tabClasses = $reader->getOnlyClasses([$classe]);
            }

            $this->tabClasses = $reader->getAllClasses();
            $this->traitementView($tabClasses, $output_dir);

        }
        catch (\RuntimeException $e) {
            $this->error($e->getMessage());
        }

        return true;

    }

    /**
     * Get the create content of classe
     *
     * @param $name
     * @param array $datas
     * @return string
     */
    protected function getCreateContent($name, array $datas) : string
    {
        $lowerNom = strtolower($name);
        $upperNom = ucfirst($name);

        return '{{-- Create a '.$lowerNom.' --}}

@extends(\'layouts.admin\')

@section(\'title\', \'Save a '.$this->getDisplayName($lowerNom).'\')

@section(\'contenu\')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:file-edit; ratio:1.7"></span>
            New '.$this->getDisplayName($upperNom).'
        </h3>

        @component(\'admin.'.$lowerNom.'s.form_create\', [
            \'url\' => route(\'admin.'.$lowerNom.'s.store\'),
            \'type\' => 0,
            '.$this->getSelectTableForForm($datas).'
        ])

            <strong>Oop\'s!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection';
    }

    /**
     * The the edit content of table
     *
     * @param $name
     * @param array $datas
     * @return string
     */
    protected function getEditContent($name, array $datas) : string
    {
        $lowerName = strtolower($name);
        $pluralName = strtolower($name).'s';

        return '
{{-- Edit form --}}

@extends(\'layouts.admin\')

@section(\'title\', \'Update of \'.$'.$lowerName.'->'.$this->getFirstKeyName($datas).')

@section(\'contenu\')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($'.$lowerName.'->'.$this->getFirstKeyName($datas).') }}
        </h3>

        @component(\'admin.'.$pluralName.'.form_create\', [
            \'url\' => route(\'admin.'.$pluralName.'.update\', $'.$lowerName.'->id),
            \'type\' => 1,'
            .$this->getFieldData($lowerName, $datas).'
            '.$this->getSelectTableForForm($datas).'
         ]);

            <strong>Oop\'s!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection';
    }

    /**
     * Get enumerated file data
     *
     * @param $lowerName
     * @param $data
     * @return string
     */
    private function getFieldData($lowerName, array $data)
    {
        $ret = '';
        foreach($data as $field => $attrs) {
            if( ! empty($field) and $field != 'id') {
                $ret .= '
                    \''.$field.'\' => $'.$lowerName.'->'.$field.',';
            }
        }
        return $ret;
    }

    /**
     * Get form create content of table
     *
     * @param $name
     * @param array $datas
     * @return string
     */
    protected function getFormCreateContent($name, array $datas) : string
    {
        $htmlElts = '';
        foreach ($datas as $fieldName => $attrs) {

            if($fieldName != 'id') {

                if(\Str::endsWith($fieldName, '_id')) {
                    $otherClass = substr($fieldName, 0, stripos($fieldName, '_id'));
                    $htmlElts .= $this->createSelectComponent($fieldName, $attrs, $otherClass);
                }
                else {

                    $htmlAttrType = $this->getHtmlType($attrs['type']);
                    switch ($htmlAttrType) {
                        case 'text':
                        case 'date':
                        case 'number':
                        case 'email':
                            $htmlElts .= $this->createInputComponent($fieldName, $attrs, $htmlAttrType);
                            break;
                        case 'file':
                            $htmlElts .= $this->createFileComponent($fieldName, $attrs);
                            break;
                        case 'textarea':
                            $htmlElts .= $this->createTextareaComponent($fieldName, $attrs);
                            break;
                        case 'radio':
                            $htmlElts .= $this->createRadioComponent($fieldName, $attrs);
                            break;
                        default :
                            $htmlElts .= $this->createInputComponent($fieldName, $attrs, $htmlAttrType);
                    }
                }
            }
        }

        return '{{-- Form --}}
@if ($errors->any())
	<div class="uk-alert uk-alert-danger">
		<ul class="uk-list uk-list-bullet">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@component(\'components.info\', [])
@endcomponent

@component(\'components.alert\', [])
@endcomponent

<form method="POST" action="{{ $url }}" id="form_create" enctype="multipart/form-data"  class="uk-grid-small" uk-grid>

    @if($type == 1)
        @method(\'PUT\')
    @endif

    @csrf
    '.$htmlElts.'
    @component(\'components.submit-buttons\', [
		\'name\' => \'Save\',
		\'back_button\' => true,
		\'others\' => \'\',
	])
    @endcomponent

</form>';

    }

    /**
     * Create select component for form
     *
     * @param $name
     * @param $attrs
     * @param $values
     * @return string
     */
    private function createSelectComponent($name, $attrs, $values) : string
    {
        $upperName = ucfirst($values);

        return '
    @component(\'components.select\', [
       \'name\' => \''.$name.'\',
       \'value\' => old(\''.$name.'\') ?? ($'.$name.' ?? \'\'),
       \'optional\' => '.($attrs['nullable'] ? 'true' : 'false').',
       \'taille\' => 1,
       \'label\' => \''.$this->getDisplayName($upperName).'\',
       \'values\' => $'.$values.'s,
       \'adds\' => [],
       \'others\' => \'\',
    ])
    @endcomponent
    ';

    }

    /**
     * Get the html matched of database type
     *
     * @param $type
     * @return string
     */
    private function getHtmlType($type) {

        switch ($type) {
            case 'integer';
            case 'numeric':
                $ret = 'number';
                break;
            case 'dateTime':
            case 'date':
                $ret = 'date';
                break;
            case 'char':
            case 'string':
                $ret = 'text';
                break;
            case 'text':
                $ret = 'textarea';
                break;
            case 'boolean':
                $ret = 'radio';
                break;
            case 'image':
                $ret = 'file';
                break;
            case 'email':
                $ret = 'email';
                break;
            default:
                $ret = 'text';
        }

        return $ret;
    }

    /**
     * Create componnent for input text
     *
     * @param $name
     * @param $attrs
     * @param $htmlAttrType
     * @return string
     */
    private function createInputComponent($name, $attrs, $htmlAttrType) : string
    {
        $upperName = ucfirst($name);

        $value = $htmlAttrType == 'date' ?
            'old(\''.$name.'\') ?? (isset($'.$name.') ?  substr($'.$name.', 0, 10) : date(\'Y-m-d\'))':
            'old(\''.$name.'\') ?? ($'.$name.' ?? \'\')';

        $adds = stristr($name, 'phone')  ? '\'pattern="^((\+)?([0-9]){3})?([0-9- ]){9,}$"\'' :  '';

        $ret = '
    @component(\'components.input\', [
        \'type\' => \''.$this->getHtmlType($attrs['type']).'\',
        \'name\' => \''.$name.'\',
        \'value\' => '.$value.',
        \'optional\' => '.($attrs['nullable'] ? 'true' : 'false').',
        \'taille\' => 1,
        \'label\' => \''.$this->getDisplayName($upperName).'\',
        \'placeholder\' => \''.$this->getDisplayName($upperName).'\',
        \'adds\' => ['.$adds.'],
    ])
    @endcomponent
    ';

        return $ret;

    }

    /**
     * Create a file input html form
     *
     * @param $name
     * @param $attrs
     * @return string
     */
    private function createFileComponent($name, $attrs) : string
    {
        $upperName = ucfirst($name);
        return '
    @component(\'components.file\', [
        \'name\' => \''.$name.'\',
        \'value\' => old(\''.$name.'\') ?? ($'.$name.' ?? \'\'),
        \'optional\' => '.($attrs['nullable'] ? 'true' : 'false').',
        \'taille\' => 1,
        \'label\' => \''.$this->getDisplayName($upperName).'\',
        \'others\' => \'\',
        \'adds\' => [],
    ])
    @endcomponent
    ';

    }

    /**
     * Create Textarea component Html
     *
     * @param $name
     * @param $attrs
     * @return string
     */
    protected function createTextareaComponent($name, $attrs) : string {

        $upperName = ucfirst($name);
        return '
    @component(\'components.textarea\', [
        \'name\' => \''.$name.'\',
        \'value\' => old(\''.$name.'\') ?? ($'.$name.' ?? \'\'),
        \'optional\' => '.($attrs['nullable'] ? 'true' : 'false').',
        \'taille\' => 1,
        \'label\' => \''.$this->getDisplayName($upperName).'\',
        \'placeholder\' => \''.$this->getDisplayName($upperName).'\',
        \'adds\' => [],
    ])
    @endcomponent
    ';

    }

    /**
     * Create radio component for form
     *
     * @param $name
     * @param $attrs
     * @return string
     */
    private function createRadioComponent($name, $attrs) : string
    {
        $upperName = ucfirst($name);

        return '
     @component(\'components.checkbox\', [
        \'name\' => \''.$name.'\',
        \'value\' => old(\''.$name.'\') ?? ($'.$name.' ?? \'\'),
        \'optional\' => '.($attrs['nullable'] ? 'true' : 'false').',
        \'taille\' => 1,
        \'label\' => \''.$this->getDisplayName($upperName).'\',
        \'placeholder\' => \'\',
        \'values\' => [\'0\' => \'Non\', \'1\' => \'Oui\'],
        \'adds\' => [],
    ])
    @endcomponent
    ';

    }

    /**
     * Get index content of table
     *
     * @param $name
     * @param array $data
     * @return string
     */
    protected function getIndexContent($name, array $data) : string
    {
        $lowerName = strtolower($name);
        $upperName = ucfirst($name);

        return '{{-- List --}}
@extends(\'layouts.admin\')

@section(\'title\', \'List of '.formatDisplayName($lowerName.'s').'\')

@section(\'contenu\')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of '.formatDisplayName($lowerName.'s').'
	</h2>

	<div class="uk-float-right">
        <a href="{{ route(\'admin.'.$lowerName.'s.create\') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
    </div>

    @if(isset($info))
        <div class="uk-alert uk-alert-primary" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p>
				{{ $info }}
			</p>
        </div>
    @endif

	  <!-- Information zone -->
    @component(\'components.alert\', [])
    @endcomponent

    @if( ! count($'.$lowerName.'s))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $'.$lowerName.'s->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>'
                        .$this->getHeaderTable($data, 2).'
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($'.$lowerName.'s as $'.$lowerName.')

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($'.$lowerName.'->image)
                                <img src="{{ asset(\'storage/\'.$'.$lowerName.'->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>
                        '.$this->getTdTable($name, $data, 2).'

                        <td>

                            @component(\'components.update-buttons\', [
                               \'id\' => $'.$lowerName.'->id,
                               \'edit_route\' => \'admin.'.$lowerName.'s.edit\',
                               \'destroy_route\' => \'admin.'.$lowerName.'s.destroy\',
                               \'name\' => \''.$lowerName.'\',
                               \'buttons\' => false,
                               \'back_button\' => false,
							   \'others\' => \'\',
                            ])
                            @endcomponent

                        </td>

                    </tr>

                @endforeach
                </tbody>

            </table>

        </div>

        {!! $'.$lowerName.'s->links() !!}

    @endif

@endsection';

    }

    /**
     * Get Html show contents of table
     *
     * @param $name
     * @param array $data
     * @return string
     */
    protected function getShowContent($name, array $data) : string
    {
        $lowerName = strtolower($name);

        return '
{{-- Page Showing --}}

@extends(\'layouts.admin\')

@section(\'title\', ucfirst($'.$lowerName.'->'.$this->getFirstKeyName($data).'))

@section(\'contenu\')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($'.$lowerName.'->'.$this->getFirstKeyName($data).') }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($'.$lowerName.'->image)
                    <img src="{{ asset(\'storage/\'.$'.$lowerName.'->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">
                '.$this->getContentShowTable($name, $data).'

                <div class="uk-text-right">
                    @component(\'components.update-buttons\', [
                        \'id\' => $'.$lowerName.'->id,
                        \'edit_route\' => \'admin.'.$lowerName.'s.edit\',
                        \'destroy_route\' => \'admin.'.$lowerName.'s.destroy\',
                        \'name\' => \''.$lowerName.'\',
                        \'buttons\' => true,
                        \'back_button\' => false,
                        \'others\' => \'\',
                    ])
                    @endcomponent
                </div>

            </div>

        </div>

    </div>

@endsection';

    }

    /**
     * @param $name
     * @param $data
     * @return string
     */
    private function getContentShowTable($name, $data) : string
    {
        $lowerName = strtolower($name);
        $ret = '';
        foreach($data as $field => $attrs) {

            if( ! empty($field) and $field != 'id' and $field != 'image') {

                if(\Str::endsWith($field, '_id')) {

                    $otherClass = $title = substr($field, 0, stripos($field, '_id'));
                    $otherDatas = $this->getDatasForClassName(ucfirst($otherClass).'s', $this->tabClasses);
                    $otherFirstKey = $otherDatas ? $this->getFirstKeyName($otherDatas) : 'name';

                    $cont = '
                            @if($'.$lowerName.'->'.$otherClass.')
                                <a href="{{ route(\'admin.'.$otherClass.'s.show\', [$'.$lowerName.'->'.$otherClass.'->id])}}" uk-tooltip="View">
                                    {{ ucfirst($'.$lowerName.'->'.$otherClass.'->'.$otherFirstKey.') }}
                                </a>
                            @endif';
                }
                else {
                    $cont = '{{ ucfirst($'.$lowerName.'->'.$field.') }}';
                    $title = $field;
                }

                $ret .= '
                        <p>
                            <strong>'.$this->getDisplayName(ucfirst($title)).'</strong> : '.$cont.'
                        </p>

                        <hr class="uk-divider-small">';


            }
        }

        return $ret;

    }

}

