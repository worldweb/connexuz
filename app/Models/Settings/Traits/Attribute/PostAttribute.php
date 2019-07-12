<?php

namespace App\Models\Post\Traits\Attribute;

/**
 * Trait UserAttribute.
 */
trait PostAttribute {

	/**
	 * @return string
	 */
	public function getShowButtonAttribute() {
		return '<a href="' . route('admin.post.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getEditButtonAttribute() {
		return '<a href="' . route('admin.post.edit', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getDeleteButtonAttribute() {

		return '<a href="' . route('admin.post.destroy', $this) . '" class="btn btn-danger" name="confirm_item"><i class="fas fa-trash" title="' . __('buttons.general.crud.delete') . '" data-toggle="tooltip" data-placement="top" ></i></a>';
		
	}

	/**
	 * @return string
	 */
	public function getActionButtonsAttribute() {

		return '
    	<div class="btn-group" role="group" aria-label="' . __('labels.backend.posts.post_actions') . '">
		  ' . $this->show_button . '
          ' . $this->delete_button . '
		</div>';
	}
}
