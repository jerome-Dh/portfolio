<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Work
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Work extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'works';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_fr',
        'title_en',
        'title_fr',
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
    
}