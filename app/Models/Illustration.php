<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Illustration
 *
 * @package App
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:37
 */
class Illustration extends Model
{
    /**
     * Associated table name.
     *
     * @var string
     */
    protected $table = 'illustrations';

    /**
     * Mass assignables attributes.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'experience_id',
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
     * Get the experience relational
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function experience() {
        return $this->belongsTo('App\Models\Experience', 'experience_id', 'id');
    }

}