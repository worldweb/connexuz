<?php

namespace App\Models\Invite\Traits\Attribute;

/**
 * Trait UserAttribute.
 */
trait InviteAttribute {

	/**
	 * @return string
	 */
	public function getShowButtonAttribute() {
		return '<a href="' . route('admin.invite.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getEditButtonAttribute() {
		return '<a href="' . route('admin.invite.edit', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getDeleteButtonAttribute() {

		return '<a href="' . route('admin.invite.destroy', $this) . '" class="btn btn-danger" name="confirm_item"><i class="fas fa-trash" title="' . __('buttons.general.crud.delete') . '" data-toggle="tooltip" data-placement="top" ></i></a>';
		
	}

	/**
	 * @return string
	 */
	public function getActionButtonsAttribute() {

		return '
    	<div class="btn-invite" role="invite" aria-label="' . __('labels.backend.invites.invite_actions') . '">
		  ' . $this->edit_button . '
          ' . $this->delete_button . '
		</div>';
	}
}
