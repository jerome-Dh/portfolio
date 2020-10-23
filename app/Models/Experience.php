<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Experience
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Experience extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'experiences';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'name_en',
        'name_fr',
        'description_en',
        'description_fr',
        'image',
        'source',
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
    public function technologies() {
        return $this->belongsToMany('App\Models\Technologie', 'experience_technologie', 'experience_id', 'technologie_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function illustrations() {
        return $this->hasMany('App\Models\Illustration', 'experience_id', 'id');
    }

}
