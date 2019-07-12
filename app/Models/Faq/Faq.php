<?php

namespace App\Models\Faq;

use App\Models\Faq\Traits\Attribute\FaqAttribute;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model {

	use FaqAttribute;

	protected $table = 'help';
	protected $fillable = ['title', 'description', 'status', 'create_at', 'update_at'];

}
