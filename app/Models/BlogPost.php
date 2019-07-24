<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 12 Jul 2019 15:47:22 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BlogPost
 * 
 * @property int $id
 * @property string $blog_data
 * @property string $img
 * @property string $title
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $isActive
 * @property string $category
 *
 * @package App\Models
 */
class BlogPost extends Eloquent
{
	protected $table = 'blog_post';

	protected $casts = [
		'isActive' => 'bool'
	];

	protected $fillable = [
		'blog_data',
		'img',
		'title',
		'text',
		'isActive',
		'category'
	];
}
