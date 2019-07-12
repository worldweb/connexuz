<?php

namespace App\Models\Group\Traits\Attribute;

/**
 * Trait UserAttribute.
 */
trait GroupAttribute {

	/**
	 * @return string
	 */
	public function getShowButtonAttribute() {
		return '<a href="' . route('admin.group.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getEditButtonAttribute() {
		return '<a href="' . route('admin.group.edit', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getDeleteButtonAttribute() {

		return '<a href="' . route('admin.group.destroy', $this) . '" class="btn btn-danger" name="confirm_item"><i class="fas fa-trash" title="' . __('buttons.general.crud.delete') . '" data-toggle="tooltip" data-placement="top" ></i></a>';
		
	}

	/**
	 * @return string
	 */
	public function getActionButtonsAttribute() {

		return '
    	<div class="btn-group" role="group" aria-label="' . __('labels.backend.groups.group_actions') . '">
		  ' . $this->edit_button . '
          ' . $this->delete_button . '
		</div>';
	}
}
