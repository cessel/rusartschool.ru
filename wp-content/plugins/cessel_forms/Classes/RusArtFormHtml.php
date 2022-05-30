<?php
namespace classes;
class rusArtFormHtml {
	public $formClass;
	public function __constructor($formClass) {
		$this->setFormClass($formClass);
	}

	/**
	 * @param mixed $formClass
	 */
	public function setFormClass( $formClass ): void {
		$this->formClass = $formClass;
	}

	public function getForm() {
		return $this->formClass->getForm();
	}
	public function theForm() {
		echo $this->formClass->getForm();
	}
}