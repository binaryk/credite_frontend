<?php namespace Libs;

class ParinteMateriielevGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~libs.parinte.materii-elev.index';
		$this->icon           =  NULL;
		$this->caption        = 'Matrii elev';
		$this->toolbar        = '~libs.parinte.materii-elev.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = '~libs/customs/js/parinte-materii-elev.js';
		$this->row_source     = 'index-parinte-note-elev-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT
                subject_teacher_group.*,
                subjects.name as materia, subjects.grading_system,
                teachers.id as teacher_id, teachers.firstname, teachers.lastname, teachers.image
            FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN users
                LEFT JOIN teachers 
                ON users.userable_id = teachers.id
            ON subject_teacher_group.user_id = users.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN users
                LEFT JOIN teachers 
                ON users.userable_id = teachers.id
            ON subject_teacher_group.user_id = users.id
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group 
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
				'id'        => 'materia',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Materia', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.materii-elev.materia',
			],
			'3' => [
				'id'        => 'note',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Note', 'style'   => 'width:48%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.materii-elev.note',
			],
			'4' => [
				'id'        => 'activitate',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Activitate', 'style'   => 'width:17%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.materii-elev.activitate',
			],
			'5' => [
				'id'        => 'medie',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Medie', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.materii-elev.medie',
			],
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => '',
			'orderables'  => [
				1 => 'subjects.name'
			],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new ParinteMateriielevGridrecord('parinte-materii-elev');
	}
	
}