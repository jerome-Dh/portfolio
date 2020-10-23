<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Technologie
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Technologie extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'technologies';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_fr',
        'image',
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
    public function experiencies() {
        return $this->belongsToMany('App\Models\Experience', 'experience_technologie', 'technologie_id', 'experience_id');
    }

}
