<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Module_skill
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Module_skill extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'module_skill';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'skill_id',
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
     * Get the module relational
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module() {
        return $this->belongsTo('App\Models\Module', 'module_id', 'id');
    }

    /**
     * Get the skill relational
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skill() {
        return $this->belongsTo('App\Models\Skill', 'skill_id', 'id');
    }

}
