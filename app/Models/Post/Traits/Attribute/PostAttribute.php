<?php

namespace App\Models\Post\Traits\Attribute;

/**
 * Trait UserAttribute.
 */
trait PostAttribute {

	/**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<span class='badge badge-success'>".__('labels.general.active').'</span>';
        }

        return "<span class='badge badge-danger'>".__('labels.general.inactive').'</span>';
    }

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
		return '<a href="'.route('admin.post.edit', $this).'" class="btn green btn-outline btn-xs tooltips"><i class="fa fa-pencil-square-o fa-6" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
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
    public function getStatusButtonAttribute()
    {
        $st = ($this->status)?'checked="checked"':'';
        if($this->status == 1){
            $s = 0;
        }else{
            $s =1;
        }
        return '<div class="switch warning-switch" id="status_'.$this->id.'">
                    <label>
                        Inactive <input type="checkbox" '.$st.' onclick="changePostStatus('.$this->id.','.$s.',1)"><span class="lever"></span> Active
                    </label>
                </div>';
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
