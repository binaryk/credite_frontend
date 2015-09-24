<?php namespace Libs;

class ProfesorClasaGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~libs.profesor.clasa.index';
		$this->icon           =  NULL;
		$this->caption        = 'Clasa';
		$this->toolbar        = '~libs.profesor.clasa.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = '~libs/customs/js/ctmodal.js, ~libs/customs/js/profesor-clasa.js, ~libs/customs/js/profesor-clasa-absente-toata-clasa.js, ~libs/customs/js/profesor-clasa-note-toata-clasa.js, ~libs/customs/js/profesor-clasa-mesaje-toata-clasa.js';
		$this->row_source     = 'index-profesor-clasa-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT
				CONCAT(students.lastname, ' ', students.firstname) as nume_elev,
				group_student.*,
				students.firstname, students.lastname, students.image, students.parents_initials
			FROM group_student
			LEFT JOIN students ON group_student.student_id = students.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM group_student 
			LEFT JOIN students ON group_student.student_id = students.id
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM group_student 
			";
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => '#', 'style'   => 'width:5%; text-align:center',],
				'type'      => 'row-number',
				'source'    => 'row-number',
			],
			'2' => [
				'id'        => 'name',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Elev', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.elev',
			],
			'3' => [
				'id'        => 'activitate',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Activitate', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.activitate',
			],
			'4' => [
				'id'        => 'absente',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Absenţe', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.absente',
			],
			'5' => [
				'id'        => 'note',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Note', 'style'   => 'width:25%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.note',
			],
			'6' => [
				'id'        => 'mesaje',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Mesaje', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.mesaje',
			],
			'7' => [
				'id'        => 'medii',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Medii', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasa.medii',
			],
			
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'students.firstname, students.lastname',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new ProfesorClasaGridrecord('profesor-clasa');
	}
	
}