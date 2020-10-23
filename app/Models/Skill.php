<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Skill
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Skill extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'skills';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_fr',
        'subname_en',
        'subname_fr',
        'author_id',
    ];

    /**
     * Attributes list
     *
     * @return array
     */
    public function getAttrs()
    {
        return $this->fillable;
    }

	/**
     * Get the author who create/update this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules() {
        return $this->belongsToMany('App\Models\Module', 'module_skill', 'skill_id', 'module_id');
    }

}
