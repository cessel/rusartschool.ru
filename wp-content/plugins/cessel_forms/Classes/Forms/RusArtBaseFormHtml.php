<?php
namespace Classes\Forms;
use Classes\RusArtForm;
abstract class RusArtBaseFormHtml extends RusArtForm{

	const DEFAULT_FIELDS = [];

	protected $fields;

	public function __construct(){
		parent::__construct();
	}
	abstract public function getForm();
	abstract public function getMessageTemplate();
	public function setMessageFields(array $filledFields = []) {

		$filledFields = array_merge(self::DEFAULT_FIELDS,$filledFields);

		$this->fields  = $filledFields;
	}
	public function getMessage($filledFields){
		$this->setMessageFields($filledFields);
		$html = $this->getMessageTemplate();

		foreach ( $this->fields as $fieldKey => $fieldValue ) {
			$html = str_replace('['.$fieldKey.']',$fieldValue,$html);
		}

		return $html;
	}

}